// Handle screen size change
// $(window).resize(function () {
//     if ($(window).width() == 1035 && $(window).height() == 846) {
//         $("*").hide();
//         alert("masuk sini");
//     }else{
//         alert("masuk sini1");
//     }
// });

// Function to populate the table with fetched data
document.getElementById('syncButton').addEventListener('click', async function () {
    // Create the progressContainer element with enhanced styling
    const progressContainer = document.createElement('div');
    progressContainer.id = 'progressContainer';

    progressContainer.innerHTML = `
        <div class="progress" style="height: 20px; background-color: #f3f3f3; border-radius: 10px; overflow: hidden; margin-top: 20px;">
            <div class="progress-bar" role="progressbar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #4caf50, #81c784); transition: width 0.5s ease-in-out;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div id="progressText" style="margin-top: 10px; font-weight: bold; text-align: center; color: #555;">Inserting data... 0%</div>
    `;

    // Show loading spinner with progress bar in Swal
    const swalLoading = Swal.fire({
        title: '<div style="font-size: 24px; font-weight: bold; color: #333;">Syncing Data</div>',
        html: `
            <div style="font-size: 16px; color: #666;">Please wait while data is being synced...</div>
            ${progressContainer.outerHTML}
        `,
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: {
            popup: 'swal2-popup-custom'
        },
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        // Perform AJAX request to fetch data from API
        const response = await fetch('https://supplier.m-mart.co.id/api/po/getData', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // For Laravel CSRF token
            }
        });

        const result = await response.json();
        console.log(result, 'data');

        if (response.ok && result.success) {
            const dataToInsert = result.data;

            // Show progress bar by updating the Swal content
            const progressBar = Swal.getHtmlContainer().querySelector('.progress-bar');
            const progressText = Swal.getHtmlContainer().querySelector('#progressText');

            // Insert data into the database via Laravel endpoint
            const insertResponse = await fetch('/po/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // For Laravel CSRF token
                },
                body: JSON.stringify({ data: dataToInsert })
            });

            const insertResult = await insertResponse.json();

            if (insertResponse.ok) {
                // Periodically fetch progress from the server
                const progressInterval = setInterval(async () => {
                    const progressResponse = await fetch('/po/progress', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // For Laravel CSRF token
                        }
                    });

                    const progress = await progressResponse.json();
                    const percentage = Math.round(progress.processed_count / result.data.length * 100);

                    // Update the progress bar with smooth animation
                    progressBar.style.width = `${percentage}%`;
                    progressBar.setAttribute('aria-valuenow', percentage);

                    // Update the progress text
                    progressText.textContent = `Inserting data... ${percentage}%`;

                    if (percentage >= 100) {
                        clearInterval(progressInterval);

                        // Close the loading spinner
                        Swal.close();

                        // Show success message with detailed counts and animation
                        await Swal.fire({
                            title: '<div style="font-size: 24px; font-weight: bold; color: #4caf50;">Success!</div>',
                            html: `
                                <ul style="list-style: none; padding: 0; font-size: 16px; color: #555;">
                                    <li><strong style="color: #4caf50;">Success Count:</strong> ${progress.success_count}</li>
                                    <li><strong style="color: #4caf50;">Processed Count:</strong> ${progress.processed_count}</li>
                                    <li><strong style="color: #f44336;">Failed Count:</strong> ${progress.fail_count}</li>
                                    <li><strong style="color: #333;">Total Count:</strong> ${progress.total_count}</li>
                                </ul>
                                <p style="font-size: 16px; color: #666;">Data has been successfully synced.</p>
                            `,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                popup: 'swal2-popup-custom',
                                title: 'swal2-title-custom'
                            }
                        });

                        // Optionally, refresh your data table or perform any other post-sync actions
                        poTable();
                    }
                }, 1000); // Update every second
            } else {
                throw new Error(insertResult.message || 'An error occurred during data insertion');
            }
        } else {
            throw new Error(result.message || 'An error occurred while fetching data');
        }
    } catch (error) {
        // Close the loading spinner
        Swal.close();

        // Show error message
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
});




function poTable(data) {
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
            data: function (d) {
                d.filterDate = $('#filterDate').val(); // Assuming you have a date filter input
                d.filterSupplier = $('#filterSupplier').val(); // Assuming you have a supplier filter input
            }
        },
        order: [[0, 'desc']],
        columns: [
            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
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
                        onclickAction = 'onclick=\'confirmPo(' + JSON.stringify(row) + ')\'';
                    } else {
                        icon = '<i class="fas fa-file-alt" title="Order No"></i>';
                    }

                    let textColor = row.theme === 'dark' ? 'white' : 'black';

                    return `
                        <span class="custom-font" data-intro="This is the order number" data-step="1">
                            ${icon}
                            <span style="color: ${textColor};" ${onclickAction}>${row.order_no}</span>
                        </span>`;
                }
            },
            {
                data: 'receive_no',
                name: 'receive_no',
                render: function(data, type, row) {
                    let receive_no = row.rcvHead && row.rcvHead.receive_no ? row.rcvHead.receive_no : '';

                    return `
                        <span class="custom-font receiving" data-intro="This is the receive number" data-step="2">
                            <i class="fas fa-truck-loading" title="Receiving"></i>
                            <span style="color: ${row.theme === 'dark' ? 'white' : 'black'};">${receive_no}</span>
                            <i class="fas fa-info-circle ms-1 text-info" title="Info" onclick="showInfo(event)"></i>
                        </span>`;
                }
            },
            {
                data: 'supp_name',
                name: 'supp_name',
                render: function(data, type, row) {
                    return row.suppliers ? row.suppliers.supp_name : "Not Found Data";
                }
            },
            {
                data: 'store_id',
                name: 'store_id',
                render: function(data, type, row) {
                    if (row.stores != null) {
                        return `
                            <i class="fas fa-store" title="Store Found"></i>
                            <span class="ms-2">${row.stores.store_name}</span>`;
                    } else {
                        return `
                            <i class="fas fa-store-alt-slash" title="Store Not Found"></i>
                            <span class="ms-2">Store Not Found</span>`;
                    }
                }
            },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, row) {
                    if (row.status === 'Progress') {
                        return `
                            <span class="badge badge-warning"> <i class="fas fa-spinner fa-spin"></i> In Progress</span>
                        `;
                    } else {
                        return `
                            <i class="fas fa-barcode"></i>
                            <span class="badge badge-warning">${row.status}</span>
                        `;
                    }
                }
            },
            {
                data: 'not_after_date',
                name: 'not_after_date',
                render: function(data, type, row) {
                    const formattedDate = new Date(data).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

                    return `<i class="fas fa-calendar"></i> ${formattedDate}`;
                }
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return '<button class="btn btn-sm btn-primary">Action</button>';
                }
            }
        ]
    });
}

function showInfo(event) {
    // Show Intro.js step for receiving date confirmation
    introJs().setOptions({
        tooltipClass: 'custom-intro-tooltip', // Apply custom tooltip class
        tooltipPosition: 'auto', // Position of the tooltip
        steps: [
            {
                element: document.querySelector('.receiving'),
                title: 'Receiving Not Found',
                intro: 'The receiving date is not available for this entry.',
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
