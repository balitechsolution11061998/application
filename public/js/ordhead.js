document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr
    const datePicker = flatpickr("#datePicker", {
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            // Handle the date change if needed
            console.log('Selected date:', dateStr);
        }
    });

    // Store the Flatpickr instance for later use
    window.datePickerInstance = datePicker;

    const syncActionButton = document.getElementById('syncActionButton');
    const checkboxes = document.querySelectorAll('.dropdown-menu input[type="checkbox"]');

    // Show or hide the sync action button based on checkbox selections
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            let anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            syncActionButton.classList.toggle('show', anyChecked);
            syncActionButton.classList.toggle('hide', !anyChecked);
        });
    });

    // Handle click event on the sync action button
    syncActionButton.addEventListener('click', async () => {
        const date = document.getElementById('date').value;
        if (!date) {
            Swal.fire({
                title: 'Error!',
                text: 'Please select a date before syncing.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        const selectedOptions = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedOptions.push(checkbox.id);
            }
        });

        if (selectedOptions.length === 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Please select at least one option to sync.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        for (const option of selectedOptions) {
            switch (option) {
                case 'syncPO':
                    await syncData('https://supplier.m-mart.co.id/api/po/getData', '/po/store', 'Syncing Data PO', date, '/po/progress');
                    break;
                case 'syncRcv':
                    await syncData('https://supplier.m-mart.co.id/api/rcv/getData', '/rcv/store', 'Syncing Data Receiving', date, '/rcv/progress');
                    break;
                case 'syncStore':
                    await syncData('https://supplier.m-mart.co.id/api/stores/get', '/store/store', 'Syncing Store Data', date, '/store/progress');
                    break;
                case 'syncSupplier':
                    await syncData('https://supplier.m-mart.co.id/api/supplier/get', '/supplier/store', 'Syncing Supplier Data', date, '/supplier/progress');
                    break;
            }
        }
    });

    async function syncData(apiUrl, storeUrl, syncTitle, date) {
        const progressContainer = document.createElement('div');
        progressContainer.id = 'progressContainer';

        progressContainer.innerHTML = `
            <div class="progress" style="height: 20px; background-color: #f3f3f3; border-radius: 10px; overflow: hidden; margin-top: 20px;">
                <div class="progress-bar" role="progressbar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #4caf50, #81c784); transition: width 0.5s ease-in-out;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div id="progressText" style="margin-top: 10px; font-weight: bold; text-align: center; color: #555;">Inserting data... 0%</div>
        `;

        const swalLoading = Swal.fire({
            title: `<div style="font-size: 24px; font-weight: bold; color: #333;">${syncTitle}</div>`,
            html: `
                <div style="font-size: 16px; color: #666;">Please wait while data is being synced...</div>
                ${progressContainer.outerHTML}
            `,
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: {
                popup: 'swal2-popup-custom',
                title: 'swal2-title-custom',
                content: 'swal2-content-custom'
            },
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            // Fetch data from apiUrl
            const response = await new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `${apiUrl}?filterDate=${date}`);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                xhr.onload = () => {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        resolve(JSON.parse(xhr.responseText));
                    } else {
                        reject(new Error(`Error: ${xhr.status} ${xhr.statusText}`));
                    }
                };

                xhr.onerror = () => reject(new Error('Network error occurred.'));
                xhr.send();
            });

            if (response.success) {
                const dataToInsert = response.data;
                if (!dataToInsert || dataToInsert.length === 0) {
                    throw new Error('No data to sync for the selected date.');
                }

                const progressBar = Swal.getHtmlContainer().querySelector('.progress-bar');
                const progressText = Swal.getHtmlContainer().querySelector('#progressText');

                let processedCount = 0;
                const totalData = dataToInsert.length;

                // Helper function to send a chunk of data and update progress
                const sendChunk = async (chunk) => {
                    return new Promise((resolve, reject) => {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', storeUrl);
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                        xhr.onload = () => {
                            if (xhr.status >= 200 && xhr.status < 300) {
                                resolve();
                            } else {
                                reject(new Error(`Error: ${xhr.status} ${xhr.statusText}`));
                            }
                        };

                        xhr.onerror = () => reject(new Error('Network error occurred.'));
                        xhr.send(JSON.stringify({ data: chunk }));
                    });
                };

                // Process data in chunks
                const chunkSize = 10; // Number of records per chunk
                for (let i = 0; i < totalData; i += chunkSize) {
                    const chunk = dataToInsert.slice(i, i + chunkSize);
                    await sendChunk(chunk);

                    processedCount += chunk.length;
                    const percentage = Math.round((processedCount / totalData) * 100);
                    progressBar.style.width = `${percentage}%`;
                    progressBar.setAttribute('aria-valuenow', percentage);
                    progressText.textContent = `Inserting data... ${percentage}%`;
                }

                // Show success Swal with a confirmation button and set timer
                Swal.fire({
                    title: '<div style="font-size: 24px; font-weight: bold; color: #4caf50;">Success!</div>',
                    html: `
                        <ul style="list-style: none; padding: 0; font-size: 16px; color: #555;">
                            <li><strong style="color: #4caf50;">Success Count:</strong> ${response.data.length}</li>
                            <li><strong style="color: #4caf50;">Processed Count:</strong> ${response.data.length}</li>
                            <li><strong style="color: #333;">Total Count:</strong> ${response.data.length}</li>
                        </ul>
                        <p style="font-size: 16px; color: #666;">Data has been successfully synced.</p>
                        <div id="countdown" style="font-size: 16px; color: #555; margin-top: 10px;">Closing in <span id="timer">5</span> seconds...</div>
                    `,
                    icon: 'success',
                    showConfirmButton: false, // Hide the confirmation button
                    customClass: {
                        popup: 'swal2-popup-custom',
                        title: 'swal2-title-custom',
                        content: 'swal2-content-custom'
                    },
                    didOpen: () => {
                        let timer = 5;
                        const timerElement = document.getElementById('timer');

                        const interval = setInterval(() => {
                            timer--;
                            timerElement.textContent = timer;

                            if (timer <= 0) {
                                clearInterval(interval);
                                Swal.close(); // Close Swal after countdown ends
                                poTable(); // Refresh table or perform other success actions
                            }
                        }, 1000);
                    }
                });

            } else {
                throw new Error(response.message || 'An error occurred while fetching data');
            }
        } catch (error) {
            Swal.close();
            await Swal.fire({
                title: 'Error!',
                text: error.message,
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'swal2-popup-custom'
                }
            });
        }
    }


});

function openDatePicker(date) {
    const datePickerElement = document.getElementById('datePicker');

    if (datePickerElement) {
        // Set the date in the hidden input field
        datePickerElement.value = date;

        // Use the stored instance to open the Flatpickr date picker
        window.datePickerInstance.open();
    } else {
        console.error("Date picker element not found");
    }
}





// Add custom CSS for Swal popups
const style = document.createElement('style');
style.innerHTML = `
    .swal2-popup-custom {
        background-color: white;
        color: black;
        border-radius: 20px;
        padding: 20px;
    }

    .swal2-title-custom {
        color: black;
    }

    .swal2-content-custom {
        color: black;
    }
`;
document.head.appendChild(style);

function poTable() {
    // Check if the DataTable is already initialized
    if ($.fn.DataTable.isDataTable('#po_table')) {
        // Destroy the existing instance before reinitializing
        $('#po_table').DataTable().clear().destroy();
    }

    // Initialize the DataTable
    $('#po_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/po/data',
            type: 'GET',
            data: function(d) {
                d.filterDate = $('#filterDate').val(); // Assuming you have a date filter input
                d.filterSupplier = $('#filterSupplier').val();
                d.filterOrderNo = $('#orderNoFilter').val();
            }
        },
        order: [[0, 'desc']],
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return `
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" value="${data}" />
                        </div>`;
                }
            },
            {
                data: 'order_no',
                name: 'order_no',
                render: function(data, type, row) {
                    let icon = '';
                    let onclickAction = '';

                    if (row.status === 'Progress') {
                        icon = '<i class="fas fa-eye" title="In Progress"></i>';
                        onclickAction = `onclick='confirmPo(${JSON.stringify(row)})'`;
                    } else {
                        icon = '<i class="fas fa-file-alt" title="Order No"></i>';
                    }

                    return `
                        <span class="custom-font" data-intro="This is the order number" data-step="1" style="color: black; font-weight: bold; margin-left: 8px;">
                            ${icon}
                            <span style="margin-left: 8px;" ${onclickAction}>${data}</span>
                        </span>`;
                }
            },
            {
                data: 'receive_no',
                name: 'receive_no',
                render: function(data, type, row) {
                    let receive_no = row.receive_no ? row.receive_no : 'Data Not Found';
                    return `
                        <span class="custom-font receiving" data-intro="This is the receive number" data-step="2" style="color: black; font-weight: bold; padding-left: 8px;">
                            <i class="fas fa-truck-loading" title="Receiving"></i>
                            <span style="margin-left: 8px;">${receive_no}</span>
                            <i class="fas fa-info-circle ms-1 text-info" title="Info" onclick="showInfo(event)" style="margin-left: 8px;"></i>
                        </span>`;
                }
            },
            {
                data: 'supp_name',
                name: 'supp_name',
                render: function(data) {
                    return data ? `<span style="color: black; font-weight: bold;">${data}</span>` : `<span style="color: black; font-weight: bold;">Not Found Data</span>`;
                }
            },
            {
                data: 'store_id',
                name: 'store_id',
                render: function(data, type, row) {
                    console.log(row.store_id,'store_id');
                    if (row.store_id === 40) {
                        return `
                            <i class="fas fa-warehouse" title="Warehouse"></i>
                            <span class="ms-2" style="color: black; font-weight: bold; margin-left: 8px;">${row.store_name}</span>`;
                    } else if (row.store_name) {
                        return `
                            <i class="fas fa-store" title="Store Found"></i>
                            <span class="ms-2" style="color: black; font-weight: bold; margin-left: 8px;">${row.store_name}</span>`;
                    } else {
                        return `
                            <i class="fas fa-store-alt-slash" title="Store Not Found"></i>
                            <span class="ms-2" style="color: black; font-weight: bold; margin-left: 8px;">Store Not Found</span>`;
                    }
                }
            },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, row) {
                    console.log(row);

                    // Badge and button configurations
                    let badgeClass = '';
                    let iconClass = '';
                    let iconTitle = '';
                    let badgeText = '';
                    let buttonHtml = '';

                    // Set badge and button based on status
                    switch (row.status) {
                        case 'Progress':
                            badgeClass = 'badge-warning';
                            iconClass = 'fas fa-spinner fa-spin';
                            iconTitle = 'In Progress';
                            badgeText = 'In Progress';
                            buttonHtml = `
                                <button class="btn btn-sm btn-primary ms-2" onclick="confirmPo('${data}')" title="Confirm">
                                    <i class="fas fa-check-circle" style="color: white;"></i> Confirm
                                </button>
                            `;
                            break;
                        case 'completed':
                            badgeClass = 'badge-success';
                            iconClass = 'fas fa-check-circle';
                            iconTitle = 'Completed';
                            badgeText = 'Completed';
                            buttonHtml = `
                                <button class="btn btn-sm btn-primary ms-2" onclick="printPdf('${data}')" title="Print PDF">
                                    <i class="fas fa-print" style="color: white;"></i> Print PDF
                                </button>
                            `;
                            break;
                        case 'Expired':
                            badgeClass = 'badge-danger';
                            iconClass = 'fas fa-times-circle';
                            iconTitle = 'Expired';
                            badgeText = 'Expired';
                            buttonHtml = `
                                <button class="btn btn-sm btn-primary ms-2" onclick="printPdf('${data}')" title="Print PDF">
                                    <i class="fas fa-print" style="color: white;"></i> Print PDF
                                </button>
                            `;
                            break;
                        case 'Confirmed':
                            badgeClass = 'badge-info';
                            iconClass = 'fas fa-thumbs-up';
                            iconTitle = 'Confirmed';
                            badgeText = 'Confirmed';
                            buttonHtml = `
                                <button class="btn btn-sm btn-primary ms-2" onclick="printPdf('${data}')" title="Print PDF">
                                    <i class="fas fa-print" style="color: white;"></i> Print PDF
                                </button>
                            `;
                            break;
                        default:
                            badgeClass = 'badge-secondary';
                            iconClass = 'fas fa-file-alt';
                            iconTitle = 'Status';
                            badgeText = data;
                            buttonHtml = `
                                <button class="btn btn-sm btn-primary ms-2" onclick="printPdf('${data}')" title="Print PDF">
                                    <i class="fas fa-print" style="color: white;"></i> Print PDF
                                </button>
                            `;
                            break;
                    }

                    // Return badge with padding and button
                    return `
                        <span class="badge badge-button ${badgeClass}" style="color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; cursor: pointer;">
                            <i class="${iconClass}" style="color: white; margin-right: 0.5rem;" title="${iconTitle}"></i> ${badgeText}
                        </span>
                        ${buttonHtml}
                    `;
                }
            },
            {
                data: 'not_after_date',
                name: 'not_after_date',
                render: function(data) {
                    const currentDate = new Date();
                    const notAfterDate = new Date(data);
                    const tomorrow = new Date();
                    tomorrow.setDate(currentDate.getDate() + 1);

                    const isExpired = notAfterDate < currentDate;
                    const isExpiringTomorrow = notAfterDate.toDateString() === tomorrow.toDateString();

                    const formattedDate = notAfterDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

                    const textColor = isExpired || isExpiringTomorrow ? 'red' : 'black';

                    return `
                        <i class="fas fa-calendar"
                           style="color: ${textColor}; font-weight: bold; cursor: pointer;"
                           onclick="openDatePicker('${data}')">
                        </i>
                        <span style="color: ${textColor}; font-weight: bold;">
                            ${formattedDate}
                        </span>
                    `;
                }
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function() {
                    return '<button class="btn btn-sm btn-primary" style="margin: 5px; color: black; font-weight: bold;">Action</button>';
                }
            }
        ]
    });
}

function searchOrderNo(){
    poTable();
}

function openDatePicker(date) {
    // Use SweetAlert to create a modal with a spinner initially
    const swalLoading = Swal.fire({
        title: `<div style="font-size: 24px; font-weight: bold; color: #333;">Loading Date Picker...</div>`,
        html: `
            <div style="font-size: 16px; color: #666;">Please wait while the date picker is being prepared...</div>
            <div id="spinner" class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `,
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: {
            popup: 'swal2-popup-custom',
            title: 'swal2-title-custom',
            content: 'swal2-content-custom'
        },
        didOpen: () => {
            Swal.showLoading();

            // Simulate a short delay to mimic loading process
            setTimeout(() => {
                // Update SweetAlert content with the full calendar and hide buttons
                Swal.fire({
                    title: `<div style="font-size: 24px; font-weight: bold; color: #333;">Select a Date</div>`,
                    html: '<input type="text" id="datePicker" class="form-control">',
                    showCancelButton: false,  // Hide the Cancel button
                    showConfirmButton: false, // Hide the Save button
                    customClass: {
                        popup: 'swal2-popup-custom',
                        title: 'swal2-title-custom',
                        content: 'swal2-content-custom'
                    },
                    didOpen: () => {
                        // Initialize Flatpickr on the input inside SweetAlert
                        flatpickr("#datePicker", {
                            defaultDate: date,
                            inline: true, // Display the full calendar inline
                            dateFormat: "Y-m-d", // Adjust this format based on your requirements
                            onReady: () => {
                                // Hide the spinner once the date picker is ready
                                Swal.hideLoading();
                                // Focus on the date input to automatically show the calendar
                                document.getElementById('datePicker').focus();
                            },
                            onChange: function(selectedDates, dateStr, instance) {
                                instance.input.value = dateStr; // Update the input value when the date changes
                            }
                        });
                    }
                });
            }, 500); // Adjust the delay as needed (500ms is an example)
        }
    });

    return swalLoading;
}





function showInfo(event) {
    event.preventDefault(); // Prevent default action of the event

    // Get the element that triggered the event
    const element = event.currentTarget.closest('.receiving');

    // Retrieve detailed data if needed
    const detailedInfo = `
        <div class="info-content">
            <strong>Receive Number:</strong> ${element.querySelector('span').innerText}<br>
            <strong>Additional Information:</strong> The receiving date is not available for this entry. Please check other details or contact support for more information.
        </div>
    `;

    // Initialize Intro.js
    introJs().setOptions({
        tooltipClass: 'custom-intro-tooltip', // Apply custom tooltip class
        tooltipPosition: 'auto', // Position of the tooltip
        steps: [
            {
                element: element, // Target the clicked element
                title: 'Information',
                intro: detailedInfo, // Set the detailed content here
                tooltipClass: 'custom-intro-tooltip',
                position: 'top'
            }
        ]
    }).start();
}



function confirmPo(event) {
    // Get the order number from the clicked element
    let orderNo = event.order_no; // Assuming order number is within the clicked element

    // Store event data in local storage
    localStorage.setItem('orderData', JSON.stringify(event));

    // Show SweetAlert modal with confirmation question
    Swal.fire({
        title: 'Confirm Order',
        html: `Are you sure you want to confirm order ${orderNo}?`,
        icon: 'question',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Confirm',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        focusConfirm: false,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve) => {
                // Simulate API call or any asynchronous operation
                setTimeout(resolve, 2000); // Simulated 2 seconds delay
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Close the current SweetAlert modal
            Swal.close();

            // Retrieve data from local storage
            let storedData = JSON.parse(localStorage.getItem('orderData'));
            let subtotal = 0;
            let ppn = 0;

            // Populate the modal content using jQuery
            $("#mdlFormTitle").html('<i class="fas fa-file-alt"></i> Confirm PO - ' + storedData.order_no);

            let cartHtml = storedData.ord_detail.map(item => {
                let qtyOrdered = item.qty_ordered || 0;
                let unitCost = item.unit_cost || 0;
                let vatCost = item.vat_cost || 0;

                let itemSubtotal = qtyOrdered * unitCost;
                subtotal += itemSubtotal;

                let itemPpn = qtyOrdered * vatCost;
                ppn += itemPpn;

                return `
                    <div class="cart-item">
                        <div class="item-details">
                            <div>
                                <p>${item.sku_desc}</p>
                                <span>UPC: ${item.upc}</span><br>
                                <span>Quantity Ordered: ${qtyOrdered}</span>
                            </div>
                            <div class="item-cost-fulfillable">
                                <div class="form-group qty-fulfillable-group" style="padding-right:10px;">
                                    <button type="button" class="qty-decrease" onclick="decreaseQty(${item.upc})">-</button>
                                    <input type="number" id="qty-fulfillable-${item.upc}" class="qty-fulfillable-input" name="qty_fulfillable" value="${qtyOrdered}" min="0" max="${qtyOrdered}" style="max-width: 200px;" data-unit-cost:"${qtyOrdered}"/>
                                    <button type="button" class="qty-increase" onclick="increaseQty(${item.upc})">+</button>
                                </div>
                                <span class="item-price" id="subtotal-${item.upc}">${formatRupiah(unitCost)}</span>
                            </div>
                            <i class="fas fa-trash-alt item-delete"></i>
                        </div>
                    </div>
                `;
            }).join('');

            let totalAfterPPN = subtotal + ppn;
            let subtotalAfterPPNAndDiscount = totalAfterPPN;

            let cardDetailsHtml = `
            <div class="card-details">
                <div class="card-types"></div>
                <form>
                    <table class="table">
                        <tr>
                            <th><label for="deliveryDate" class="form-label">Delivery Date</label></th>
                            <td><input type="date" class="form-control" id="delivery_date" name="delivery_date" placeholder="Delivery Date ..."></td>
                        </tr>
                        <tr>
                            <th><label for="deliveryStatus" class="form-label">Schedule Type</label></th>
                            <td>
                                <select class="form-select" id="schedule_type" name="schedule_type" onchange="handleScheduleTypeChange()">
                                    <option value="">Choose Schedule Type</option>
                                    <option value="full">Full Delivery</option>
                                    <option value="partials">Partials Delivery</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="expiredDate" class="form-label">Expired Date</label></th>
                            <td><input type="text" class="form-control" id="expiredDate" name="expired_date" disabled></td>
                        </tr>

                    </table>
                     <div class="d-flex flex-column">
                            <button type="button" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button type="button" class="btn btn-danger w-100">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </div>
                </form>
            </div>
        `;

            console.log(storedData,'result.data');

            let modalBodyHtml = `
                <body>
                    <nav>
                        <div class="nav-left">
                            <div class="search-group">
                                <i class="fas fa-search"></i>
                                <input type="text" placeholder="Search by track number" class="search-bar">
                            </div>
                        </div>
                        <ul>
                            <li><a href="#"><i class="fas fa-file-alt"></i> Review PO</a></li>
                            <li><a href="#"><i class="fas fa-calendar-check"></i> Schedule PO</a></li>
                            <li><a href="#"><i class="fas fa-truck"></i> Delivery</a></li>
                        </ul>
                        <div class="nav-right">
                            <i class="fas fa-bell icon"></i>
                        </div>
                    </nav>
                    <div class="main-content">
                        <section class="main-banner card">
                            <h1>Purchase Order</h1>
                            <div class="illustration">
                                <img src="/image/truck.jpg" alt="Parcel">
                            </div>
                            <h6>List Item PO</h6>
                            <div id="cart-items">${cartHtml}</div>
                        </section>
                        <aside class="sidebar">
                            <div class="shipping-info">
                                <h2>Shipping</h2>
                                <div id="map" class="map"></div>
                                <div class="sender-receiver">
                                    <div class="sender">
                                        <h3>Sender</h3>
                                        <p>${storedData.suppliers.supp_name}</p>
                                        <p>${storedData.suppliers.address_1}</p>
                                    </div>
                                    <div class="receiver">
                                        <h3>${storedData.stores.store_name}</h3>
                                        <p>${storedData.stores.store_add1}</p>
                                    </div>
                                </div>

                                ${cardDetailsHtml}
                            </div>
                        </aside>
                    </div>

                </body>
            `;

            $("#mdlFormContent").html(modalBodyHtml);
            $("#mdlForm").modal('show');

            // Set delivery and expiration dates
            let notAfterDate = new Date(storedData.not_after_date);
            let options = { year: 'numeric', month: 'long', day: 'numeric' };
            let formattedDate = notAfterDate.toLocaleDateString('id-ID', options);
            document.getElementById('expiredDate').value = formattedDate;

            let releaseDate = new Date(storedData.release_date);
            let minDeliveryDate = new Date(notAfterDate);
            minDeliveryDate.setDate(notAfterDate.getDate() - 2);

            document.getElementById('delivery_date').min = releaseDate.toISOString().slice(0, 10);
            document.getElementById('delivery_date').max = minDeliveryDate.toISOString().slice(0, 10);

            // Initialize the map
            var senderCoords = [51.505, -0.09];
            var receiverCoords = [55.9533, -3.1883];
            var map = L.map('map').setView([(senderCoords[0] + receiverCoords[0]) / 2, (senderCoords[1] + receiverCoords[1]) / 2], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            L.marker(senderCoords).addTo(map).bindPopup('Sender: Valera Meladze<br>Linkoln st. 34/a, London').openPopup();
            L.marker(receiverCoords).addTo(map).bindPopup('Receiver: Tom Hardy<br>Milton st. 104, Edinburgh').openPopup();

            handleScheduleTypeChange();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelled', 'The confirmation was cancelled.', 'info');
        }
    });
}




function handleScheduleTypeChange() {
    let scheduleType = document.getElementById('schedule_type').value;
    let qtyDecreaseButtons = document.querySelectorAll('.qty-decrease');
    let qtyIncreaseButtons = document.querySelectorAll('.qty-increase');
    let qtyInputs = document.querySelectorAll('.qty-fulfillable-input');

    if (scheduleType === 'full') {
        qtyDecreaseButtons.forEach(button => button.style.display = 'none');
        qtyIncreaseButtons.forEach(button => button.style.display = 'none');
        qtyInputs.forEach(input => input.readOnly = true);
    } else if (scheduleType === 'partials') {
        qtyDecreaseButtons.forEach(button => button.style.display = 'inline-block');
        qtyIncreaseButtons.forEach(button => button.style.display = 'inline-block');
        qtyInputs.forEach(input => input.readOnly = false);
    }else{
        qtyDecreaseButtons.forEach(button => button.style.display = 'none');
        qtyIncreaseButtons.forEach(button => button.style.display = 'none');
        qtyInputs.forEach(input => input.readOnly = true);
    }
}


function increaseQty(upc) {
    let input = document.getElementById(`qty-fulfillable-${upc}`);
    let maxQty = parseInt(input.max, 10);
    let currentQty = parseInt(input.value, 10);

    if (currentQty < maxQty) {
        input.value = currentQty + 1;
    } else {
        showToast('Quantity cannot exceed the ordered quantity');
    }


}

function decreaseQty(upc) {
    let input = document.getElementById(`qty-fulfillable-${upc}`);
    let currentQty = parseInt(input.value, 10);

    if (currentQty > 0) {
        input.value = currentQty - 1;
    }
}






function showToast(message) {
    Toastify({
        text: `<i class="fas fa-spinner fa-spin"></i> ${message}`,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        style: {
            background: "#FF0000"
        },
        stopOnFocus: true,
        escapeMarkup: false,
        className: "custom-toast",
    }).showToast();

}

// Call the fetchData function to load data when the page loads
document.addEventListener('DOMContentLoaded', poTable);
