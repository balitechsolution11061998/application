document.addEventListener("DOMContentLoaded", function () {
    // Initialize Flatpickr
    const datePicker = flatpickr("#datePicker", {
        dateFormat: "Y-m-d",
        onChange: function (selectedDates, dateStr, instance) {
            // Handle the date change if needed
            console.log("Selected date:", dateStr);
        },
    });

    // Store the Flatpickr instance for later use
    window.datePickerInstance = datePicker;

    const syncActionButton = document.getElementById("syncActionButton");
    const checkboxes = document.querySelectorAll(
        '.dropdown-menu input[type="checkbox"]'
    );

    // Show or hide the sync action button based on checkbox selections
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            let anyChecked = Array.from(checkboxes).some((cb) => cb.checked);
            syncActionButton.classList.toggle("show", anyChecked);
            syncActionButton.classList.toggle("hide", !anyChecked);
        });
    });

    // Handle click event on the sync action button
    syncActionButton.addEventListener("click", async () => {
        const date = document.getElementById("filterDate").value;
        if (!date) {
            Swal.fire({
                title: "Error!",
                text: "Please select a date before syncing.",
                icon: "error",
                confirmButtonText: "OK",
            });
            return;
        }

        const selectedOptions = [];
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                selectedOptions.push(checkbox.id);
            }
        });

        if (selectedOptions.length === 0) {
            Swal.fire({
                title: "Error!",
                text: "Please select at least one option to sync.",
                icon: "error",
                confirmButtonText: "OK",
            });
            return;
        }

        for (const option of selectedOptions) {
            switch (option) {
                case "syncPO":
                    await syncData(
                        "https://supplier.m-mart.co.id/api/po/getData",
                        "/po/store",
                        "Syncing Data PO",
                        date,
                        "/po/progress"
                    );
                    break;
                case "syncRcv":
                    await syncData(
                        "https://supplier.m-mart.co.id/api/rcv/getData",
                        "/rcv/store",
                        "Syncing Data Receiving",
                        date,
                        "/rcv/progress"
                    );
                    break;

                case "syncStore":
                    await syncData(
                        "https://supplier.m-mart.co.id/api/stores/get",
                        "/store/store",
                        "Syncing Store Data",
                        date,
                        "/store/progress"
                    );
                    break;
                case "syncSupplier":
                    await syncData(
                        "https://supplier.m-mart.co.id/api/supplier/get",
                        "/supplier/store",
                        "Syncing Supplier Data",
                        date,
                        "/supplier/progress"
                    );
                    break;
                case "syncTt":
                    await syncData(
                        "https://supplier.m-mart.co.id/api/tandaterima/getData",
                        "/tandaterima/store",
                        "Syncing Data Tanda Terima",
                        date,
                        "/tandaterima/progress"
                    );
                    break;
            }
        }
    });

    async function syncData(apiUrl, storeUrl, syncTitle, date) {
        const progressContainer = document.createElement("div");
        progressContainer.id = "progressContainer";

        progressContainer.innerHTML = `
            <div class="progress" style="height: 20px; background-color: #e0e0e0; border-radius: 10px; overflow: hidden; margin-top: 20px;">
                <div class="progress-bar" role="progressbar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #4caf50, #81c784); transition: width 0.5s ease-in-out;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div id="progressText" style="margin-top: 10px; font-weight: bold; text-align: center; color: #333;">Inserting data... 0%</div>
        `;

        const swalLoading = Swal.fire({
            title: `<div class="swal-title">${syncTitle}</div>`,
            html: `
                <div class="swal-text">Please wait while data is being synced...</div>
                ${progressContainer.outerHTML}
            `,
            icon: "info",
            allowOutsideClick: false,
            showConfirmButton: false,
            customClass: {
                popup: "swal-popup",
                title: "swal-title",
                content: "swal-content",
            },
            didOpen: () => {
                Swal.showLoading();
            },
        });

        try {
            // Fetch data from apiUrl
            const response = await new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", `${apiUrl}?filterDate=${date}`);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.setRequestHeader(
                    "X-CSRF-TOKEN",
                    document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content")
                );

                xhr.onload = () => {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        resolve(JSON.parse(xhr.responseText));
                    } else {
                        reject(
                            new Error(`Error: ${xhr.status} ${xhr.statusText}`)
                        );
                    }
                };

                xhr.onerror = () =>
                    reject(new Error("Network error occurred."));
                xhr.send();
            });

            if (response.success) {
                const dataToInsert = response.data;
                if (!dataToInsert || dataToInsert.length === 0) {
                    throw new Error("No data to sync for the selected date.");
                }

                const progressBar =
                    Swal.getHtmlContainer().querySelector(".progress-bar");
                const progressText =
                    Swal.getHtmlContainer().querySelector("#progressText");

                let processedCount = 0;
                const totalData = dataToInsert.length;

                // Helper function to send a chunk of data and update progress
                const sendChunk = async (chunk) => {
                    return new Promise((resolve, reject) => {
                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", storeUrl);
                        xhr.setRequestHeader(
                            "Content-Type",
                            "application/json"
                        );
                        xhr.setRequestHeader(
                            "X-CSRF-TOKEN",
                            document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")
                        );

                        xhr.onload = () => {
                            if (xhr.status >= 200 && xhr.status < 300) {
                                resolve();
                            } else {
                                reject(
                                    new Error(
                                        `Error: ${xhr.status} ${xhr.statusText}`
                                    )
                                );
                            }
                        };

                        xhr.onerror = () =>
                            reject(new Error("Network error occurred."));
                        xhr.send(JSON.stringify({ data: chunk }));
                    });
                };

                // Process data in chunks
                const chunkSize = 10; // Number of records per chunk
                for (let i = 0; i < totalData; i += chunkSize) {
                    const chunk = dataToInsert.slice(i, i + chunkSize);
                    await sendChunk(chunk);

                    processedCount += chunk.length;
                    const percentage = Math.round(
                        (processedCount / totalData) * 100
                    );
                    progressBar.style.width = `${percentage}%`;
                    progressBar.setAttribute("aria-valuenow", percentage);
                    progressText.textContent = `Inserting data... ${percentage}%`;
                }

                // Show success Swal with a confirmation button and set timer
                Swal.fire({
                    title: '<div class="swal-title success">Success!</div>',
                    html: `
                        <ul class="swal-success-list">
                            <li><strong class="success-text">Success Count:</strong> ${response.data.length}</li>
                            <li><strong class="success-text">Processed Count:</strong> ${response.data.length}</li>
                            <li><strong class="success-text">Total Count:</strong> ${response.data.length}</li>
                        </ul>
                        <p class="swal-text">Data has been successfully synced.</p>
                        <div id="countdown" class="swal-countdown">Closing in <span id="timer">5</span> seconds...</div>
                    `,
                    icon: "success",
                    showConfirmButton: false,
                    customClass: {
                        popup: "swal-popup",
                        title: "swal-title",
                        content: "swal-content",
                    },
                    didOpen: () => {
                        let timer = 5;
                        const timerElement = document.getElementById("timer");

                        const interval = setInterval(() => {
                            timer--;
                            timerElement.textContent = timer;

                            if (timer <= 0) {
                                clearInterval(interval);
                                Swal.close(); // Close Swal after countdown ends
                                poTable(); // Refresh table or perform other success actions
                            }
                        }, 1000);
                    },
                });
            } else {
                throw new Error(
                    response.message || "An error occurred while fetching data"
                );
            }
        } catch (error) {
            Swal.close();
            await Swal.fire({
                title: "Error!",
                text: error.message,
                icon: "error",
                confirmButtonText: "OK",
                customClass: {
                    popup: "swal-popup",
                },
            });
        }
    }
});

function openDatePicker(date) {
    const datePickerElement = document.getElementById("datePicker");

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
const style = document.createElement("style");
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

function filterDatePo() {
    poTable();
}
function filterDatePoByStatus() {
    poTable();
}

function poTable() {
    // Check if the DataTable is already initialized
    if ($.fn.DataTable.isDataTable("#po_table")) {
        // Destroy the existing instance before reinitializing
        $("#po_table").DataTable().clear().destroy();
    }

    // Initialize the DataTable
    $("#po_table").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "/po/data",
            type: "GET",
            data: function (d) {
                d.filterDate = $("#filterDate").val(); // Assuming you have a date filter input
                d.filterSupplier = $("#filterSupplier").val();
                d.filterOrderNo = $("#orderNoFilter").val();
                d.filterStatus = $("#statusFilter").val();
            },
        },
        order: [[0, "desc"]],
        columns: [
            {
                data: "id",
                name: "id",
                orderable: false,
                searchable: false,
                render: function (data) {
                    return `
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" value="${data}" />
                        </div>`;
                },
            },
            {
                data: "order_no",
                name: "order_no",
                render: function (data, type, row) {
                    let icon = "";
                    let onclickAction = "";

                    if (row.status === "Progress") {
                        icon = '<i class="fas fa-eye" title="In Progress"></i>';
                        onclickAction = `onclick='confirmPo(${JSON.stringify(
                            row
                        )})'`;
                    } else {
                        icon =
                            '<i class="fas fa-file-alt" title="Order No"></i>';
                        onclickAction = `onclick='detailPo(${JSON.stringify(
                            row
                        )})'`;
                    }

                    return `
                        <span class="custom-font" data-intro="This is the order number" data-step="1" style="color: black; font-weight: bold; margin-left: 8px;">
                            ${icon}
                            <span style="margin-left: 8px;" ${onclickAction}>${data}</span>
                        </span>`;
                },
            },
            {
                data: "receive_no",
                name: "receive_no",
                render: function (data, type, row) {
                    let receive_no = row.receive_no
                        ? row.receive_no
                        : "Data Not Found";
                    return `
                        <span class="custom-font receiving" data-intro="This is the receive number" data-step="2" style="color: black; font-weight: bold; padding-left: 8px;">
                            <i class="fas fa-truck-loading" title="Receiving"></i>
                            <span style="margin-left: 8px;">${receive_no}</span>
                            <i class="fas fa-info-circle ms-1 text-info" title="Info" onclick="showInfo(event)" style="margin-left: 8px;"></i>
                        </span>`;
                },
            },
            {
                data: "supp_name",
                name: "supp_name",
                render: function (data) {
                    return data
                        ? `<span style="color: black; font-weight: bold;">${data}</span>`
                        : `<span style="color: black; font-weight: bold;">Not Found Data</span>`;
                },
            },
            {
                data: "store", // Ensure this matches the key in your data
                name: "store",
                render: function (data, type, row) {
                    if (row.store === 40) {
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
                },
            },
            {
                data: "status",
                name: "status",
                render: function (data, type, row) {
                    const statusConfig = {
                        Progress: {
                            badgeClass: "badge-warning",
                            iconClass: "fas fa-spinner fa-spin",
                            iconTitle: "In Progress",
                            badgeText: "In Progress",
                        },
                        Completed: {
                            badgeClass: "badge-success",
                            iconClass: "fas fa-check-circle",
                            iconTitle: "Completed",
                            badgeText: "Completed",
                        },
                        Expired: {
                            badgeClass: "badge-danger",
                            iconClass: "fas fa-times-circle",
                            iconTitle: "Expired",
                            badgeText: "Expired",
                        },
                        Reject: {
                            badgeClass: "badge-danger",
                            iconClass: "fas fa-times-circle",
                            iconTitle: "Rejected",
                            badgeText: "Rejected",
                        },
                        Confirmed: {
                            badgeClass: "badge-info",
                            iconClass: "fas fa-thumbs-up",
                            iconTitle: "Confirmed",
                            badgeText: "Confirmed",
                        },
                        default: {
                            badgeClass: "badge-secondary",
                            iconClass: "fas fa-file-alt",
                            iconTitle: "Status",
                            badgeText: data,
                        },
                    };

                    const config =
                        statusConfig[row.status] || statusConfig["default"];

                    return `
                        <span class="badge badge-button ${config.badgeClass}" style="color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; cursor: pointer;">
                            <i class="${config.iconClass}" style="color: white; margin-right: 0.5rem;" title="${config.iconTitle}"></i> ${config.badgeText}
                        </span>
                    `;
                },
            },
            {
                data: "approval_date",
                name: "approval_date",
                render: function (data, type, row) {
                    // Parse the date to a JavaScript Date object
                    const date = new Date(data);

                    // Define options for formatting the date in the desired style
                    const options = {
                        day: "numeric",
                        month: "long",
                        year: "numeric",
                    };

                    // Format the date according to the locale
                    const formattedDate = date.toLocaleDateString(
                        "id-ID",
                        options
                    );

                    // Return the formatted date with the calendar icon
                    return `
                        <i class="fas fa-calendar" style="color: black; margin-right: 8px;"></i>
                        <span style="color: black; font-weight: bold;">${formattedDate}</span>
                    `;
                },
            },
            {
                data: "not_after_date",
                name: "not_after_date",
                render: function (data, type, row) {
                    const currentDate = new Date();
                    const notAfterDate = new Date(data);
                    const tomorrow = new Date();
                    tomorrow.setDate(currentDate.getDate() + 1);

                    const isExpired = notAfterDate < currentDate;
                    const isExpiringTomorrow =
                        notAfterDate.toDateString() === tomorrow.toDateString();

                    const formattedDate = notAfterDate.toLocaleDateString(
                        "id-ID",
                        {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                        }
                    );

                    const textColor =
                        row.status === "Completed"
                            ? "black"
                            : isExpired || isExpiringTomorrow
                            ? "red"
                            : "black";

                    return `
                        <i class="fas fa-calendar" style="color: ${textColor}; font-weight: bold; cursor: pointer;" onclick="openDatePicker('${data}')"></i>
                        <span style="color: ${textColor}; font-weight: bold;">${formattedDate}</span>
                    `;
                },
            },
            {
                data: "estimated_delivery_date",
                name: "estimated_delivery_date",
                render: function (data, type, row) {
                    // Check if data is null or empty
                    if (!data) {
                        return `
                            <span style="color: black; font-weight: bold;">No data available</span>
                        `;
                    }

                    const currentDate = new Date();
                    const notAfterDate = new Date(data);
                    const tomorrow = new Date();
                    tomorrow.setDate(currentDate.getDate() + 1);

                    const isExpired = notAfterDate < currentDate;
                    const isExpiringTomorrow =
                        notAfterDate.toDateString() === tomorrow.toDateString();

                    const formattedDate = notAfterDate.toLocaleDateString(
                        "id-ID",
                        {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                        }
                    );

                    const textColor =
                        row.status === "Completed"
                            ? "black"
                            : isExpired || isExpiringTomorrow
                            ? "red"
                            : "black";

                    return `
                        <i class="fas fa-calendar" style="color: ${textColor}; font-weight: bold; cursor: pointer;" onclick="openDatePicker('${data}')"></i>
                        <span style="color: ${textColor}; font-weight: bold;">${formattedDate}</span>
                    `;
                },
            },
            {
                data: "receive_date",
                name: "receive_date",
                render: function (data, type, row) {
                    // Check if data is null or empty
                    if (!data) {
                        return `
                            <span style="color: black; font-weight: bold;">
                                No data available
                            </span>
                        `;
                    }

                    const currentDate = new Date();
                    const notAfterDate = new Date(data);
                    const tomorrow = new Date();
                    tomorrow.setDate(currentDate.getDate() + 1);

                    const isExpired = notAfterDate < currentDate;
                    const isExpiringTomorrow =
                        notAfterDate.toDateString() === tomorrow.toDateString();

                    const formattedDate = notAfterDate.toLocaleDateString(
                        "id-ID",
                        { day: "numeric", month: "long", year: "numeric" }
                    );

                    // Check the status field to determine the color
                    const status = row.status; // Assuming the status field is in the same row object
                    const textColor =
                        status === "Completed" ||
                        (!isExpired && !isExpiringTomorrow)
                            ? "black"
                            : "red";

                    return `
                        <i class="fas fa-calendar"
                           style="color: ${textColor}; font-weight: bold; cursor: pointer;"
                           onclick="openDatePicker('${data}')">
                        </i>
                        <span style="color: ${textColor}; font-weight: bold;">
                            ${formattedDate}
                        </span>
                    `;
                },
            },
            {
                data: "average_service_level",
                name: "average_service_level",
                render: function (data, type, row) {
                    // If the data is null or undefined, set it to 0%
                    const serviceLevel = data ? data : 0;
                    const percentage = `${serviceLevel}%`;

                    // Set the progress bar color based on the percentage
                    let progressBarClass = "bg-success"; // Default color
                    if (serviceLevel < 50) {
                        progressBarClass = "bg-danger"; // Red for less than 50%
                    } else if (serviceLevel >= 50 && serviceLevel < 75) {
                        progressBarClass = "bg-warning"; // Yellow for 50% to 74%
                    } // Green for 75% and above remains as default

                    // Return the custom progress bar HTML with animation
                    return `
                        <div class="custom-progress-bar">
                            <div class="progress-bar progress-bar-animated ${progressBarClass}" role="progressbar" style="width: ${percentage};" aria-valuenow="${serviceLevel}" aria-valuemin="0" aria-valuemax="100">
                                ${percentage}
                            </div>
                        </div>`;
                },
            },

            {
                data: "actions",
                name: "actions",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="confirmPo('${row.order_no}')">Confirm</a></li>
                                <li><a class="dropdown-item" href="#" onclick="printPdf('${row.order_no}')">Print PDF</a></li>
                                <li><a class="dropdown-item" href="#" onclick="viewDetails('${row.order_no}')">Details</a></li>
                            </ul>
                        </div>`;
                },
            },
        ],
    });
    // Apply hover effect to change text color to black for specific cells
    $("#po_table tbody")
        .on("mouseover", "td", function () {
            $(this).css("color", "black");
        })
        .on("mouseout", "td", function () {
            $(this).css("color", ""); // Reset color on mouseout
        });
}

function searchOrderNo() {
    poTable();
}

function confirmPo(event) {
    // Get the order number from the clicked element
    let orderNo = event.order_no;
    // Get the modal element using jQuery
    let modal = $("#mdlForm");

    // Inject content into the modal body
    modal.find(".modal-body").html(""); // Clear previous content

    // Show SweetAlert modal with confirmation question
    Swal.fire({
        title: "Confirm Order",
        html: `Are you sure you want to confirm order ${orderNo}?`,
        icon: "question",
        showCancelButton: true,
        cancelButtonText: "Cancel",
        confirmButtonText: "Confirm",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        focusConfirm: false,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve) => {
                // Simulate API call or any asynchronous operation
                setTimeout(resolve, 2000); // Simulated 2 seconds delay
            });
        },
        didOpen: () => {
            // Add a custom class to the modal
            Swal.getPopup().classList.add("custom-modal");
        },
    }).then((result) => {
        if (result.isConfirmed) {
            // Fetch order details from the server
            fetch(`/po/getOrderDetails?order_no=${orderNo}`)
                .then((response) => response.json())
                .then((data) => {
                    let subtotal = 0;
                    let ppn = 0;

                    // Populate the modal content using jQuery
                    $("#mdlFormTitle").html(
                        `<i class="fas fa-file-alt"></i> Confirm PO - ${data.details.order_no}`
                    );

                    let cartHtml = data.details.ord_detail
                        .map((item) => {
                            let qtyOrdered = item.qty_ordered || 0;
                            let unitCost = item.unit_cost || 0;
                            let vatCost = item.vat_cost || 0;

                            let itemSubtotal = qtyOrdered * unitCost;
                            subtotal += itemSubtotal;

                            let itemPpn = qtyOrdered * vatCost;
                            ppn += itemPpn;

                            return `
<div class="cart-item d-flex flex-column flex-md-row justify-content-between align-items-center border-bottom py-2 bg-white text-black rounded mb-3">
    <div class="item-details d-flex flex-column justify-content-center align-items-center align-items-md-start text-center text-md-left mb-2 mb-md-0">
        <p class="mb-1 font-weight-bold">Descriptions : ${item.sku_desc}</p>
        <small class="text-muted">UPC: ${item.upc}</small><br>
        <small class="text-muted">Quantity Ordered: ${qtyOrdered}</small>
    </div>
    <div class="item-cost-fulfillable d-flex flex-column flex-md-row align-items-center justify-content-center">
        <div class="form-group qty-fulfillable-group d-flex align-items-center justify-content-center mr-0 mr-md-3 mb-2 mb-md-0">
            <button type="button" class="btn btn-sm btn-secondary rounded-circle" onclick="decreaseQty(${
                item.upc
            })">-</button>
            <input type="number" id="qty-fulfillable-${
                item.upc
            }" class="form-control form-control-sm mx-2 text-center rounded" name="qty_fulfillable" value="${qtyOrdered}" min="0" max="${qtyOrdered}" data-unit-cost="${qtyOrdered}" style="width: 60px;"/>
            <button type="button" class="btn btn-sm btn-secondary rounded-circle" onclick="increaseQty(${
                item.upc
            })">+</button>
        </div>
        <span class="item-price font-weight-bold text-success">${formatsRupiah(
            unitCost
        )}</span>
    </div>
    <i class="fas fa-trash-alt item-delete text-danger ml-0 ml-md-3 mt-3 mt-md-0" style="cursor: pointer;"></i>
</div>




                            `;
                        })
                        .join("");

                    let totalAfterPPN = subtotal + ppn;

                    let cardDetailsHtml = `
                        <div class="card-details">
                            <form>
                                <table class="table table-sm">
                                    <tr>
                                        <th><label for="deliveryDate" class="form-label" style="color:black">Delivery Date</label></th>
                                        <td><input type="date" class="form-control" id="delivery_date" name="delivery_date" placeholder="Delivery Date ..."></td>
                                    </tr>
                                    <tr>
                                        <th><label for="scheduleType" class="form-label" style="color:black">Schedule Type</label></th>
                                        <td>
                                            <select class="form-select" id="schedule_type" name="schedule_type" onchange="handleScheduleTypeChange()">
                                                <option value="">Choose Schedule Type</option>
                                                <option value="full">Full Delivery</option>
                                                <option value="partials">Partials Delivery</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="expiredDate" class="form-label" style="color:black">Expired Date</label></th>
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

                    let modalBodyHtml = `
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <section class="main-banner card">
                                        <h1>Purchase Order</h1>
                                        <div class="illustration text-center">
                                            <img src="/image/truck.jpg" alt="Parcel" class="img-fluid">
                                        </div>
                                        <h6>List Item PO</h6>
                                        <div id="cart-items">${cartHtml}</div>
                                    </section>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="shipping-info">
                                        <h2>Shipping</h2>
                                        <img src="/image/store.png" alt="Parcel" class="img-fluid">
                                        <div class="sender-receiver">
                                            <div class="sender">
                                                <h3>Sender</h3>
                                                <p>${data.details.suppliers.supp_name}</p>
                                                <p>${data.details.suppliers.address_1}</p>
                                            </div>
                                            <div class="receiver">
                                                <h3>Receiver</h3>
                                                <p>${data.details.stores.store_name}</p>
                                                <p>${data.details.stores.store_add1}</p>
                                            </div>
                                        </div>
                                        ${cardDetailsHtml}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    $("#mdlFormContent").html(modalBodyHtml);
                    $("#mdlForm").modal("show");

                    // Set delivery and expiration dates
                    let notAfterDate = new Date(data.details.not_after_date);
                    let approvalDate = new Date(data.details.approval_date);
                    let releaseDate = new Date(data.details.release_date);

                    let minDeliveryDate = new Date(approvalDate);
                    minDeliveryDate.setDate(minDeliveryDate.getDate() + 1);

                    let maxDeliveryDate = new Date(notAfterDate);
                    maxDeliveryDate.setDate(maxDeliveryDate.getDate() - 2);

                    let formattedMaxDate = maxDeliveryDate
                        .toISOString()
                        .split("T")[0];
                    let formattedMinDate = minDeliveryDate
                        .toISOString()
                        .split("T")[0];
                    let formattedExpiryDate = notAfterDate.toLocaleDateString(
                        "id-ID",
                        {
                            year: "numeric",
                            month: "long",
                            day: "numeric",
                        }
                    );

                    document.getElementById("delivery_date").min =
                        formattedMinDate;
                    document.getElementById("delivery_date").max =
                        formattedMaxDate;
                    document.getElementById("expiredDate").value =
                        formattedExpiryDate;
                })
                .catch((error) => {
                    console.error("Error fetching order details:", error);
                    $("#mdlFormContent").html(
                        "<p>Error fetching details. Please try again later.</p>"
                    );
                });
        }
    });
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
        icon: "info",
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: {
            popup: "swal2-popup-custom",
            title: "swal2-title-custom",
            content: "swal2-content-custom",
        },
        didOpen: () => {
            Swal.showLoading();

            // Simulate a short delay to mimic loading process
            setTimeout(() => {
                // Update SweetAlert content with the full calendar and hide buttons
                Swal.fire({
                    title: `<div style="font-size: 24px; font-weight: bold; color: #333;">Select a Date</div>`,
                    html: '<input type="text" id="datePicker" class="form-control">',
                    showCancelButton: false, // Hide the Cancel button
                    showConfirmButton: false, // Hide the Save button
                    customClass: {
                        popup: "swal2-popup-custom",
                        title: "swal2-title-custom",
                        content: "swal2-content-custom",
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
                                document.getElementById("datePicker").focus();
                            },
                            onChange: function (
                                selectedDates,
                                dateStr,
                                instance
                            ) {
                                instance.input.value = dateStr; // Update the input value when the date changes
                            },
                        });
                    },
                });
            }, 500); // Adjust the delay as needed (500ms is an example)
        },
    });

    return swalLoading;
}

function showInfo(event) {
    event.preventDefault(); // Prevent default action of the event

    // Get the element that triggered the event
    const element = event.currentTarget.closest(".receiving");

    // Retrieve detailed data if needed
    const detailedInfo = `
        <div class="info-content">
            <strong>Receive Number:</strong> ${
                element.querySelector("span").innerText
            }<br>
            <strong>Additional Information:</strong> The receiving date is not available for this entry. Please check other details or contact support for more information.
        </div>
    `;

    // Initialize Intro.js
    introJs()
        .setOptions({
            tooltipClass: "custom-intro-tooltip", // Apply custom tooltip class
            tooltipPosition: "auto", // Position of the tooltip
            steps: [
                {
                    element: element, // Target the clicked element
                    title: "Information",
                    intro: detailedInfo, // Set the detailed content here
                    tooltipClass: "custom-intro-tooltip",
                    position: "top",
                },
            ],
        })
        .start();
}

function handleScheduleTypeChange() {
    let scheduleType = document.getElementById("schedule_type").value;
    let qtyDecreaseButtons = document.querySelectorAll(".qty-decrease");
    let qtyIncreaseButtons = document.querySelectorAll(".qty-increase");
    let qtyInputs = document.querySelectorAll(".qty-fulfillable-input");

    if (scheduleType === "full") {
        qtyDecreaseButtons.forEach((button) => (button.style.display = "none"));
        qtyIncreaseButtons.forEach((button) => (button.style.display = "none"));
        qtyInputs.forEach((input) => (input.readOnly = true));
    } else if (scheduleType === "partials") {
        qtyDecreaseButtons.forEach(
            (button) => (button.style.display = "inline-block")
        );
        qtyIncreaseButtons.forEach(
            (button) => (button.style.display = "inline-block")
        );
        qtyInputs.forEach((input) => (input.readOnly = false));
    } else {
        qtyDecreaseButtons.forEach((button) => (button.style.display = "none"));
        qtyIncreaseButtons.forEach((button) => (button.style.display = "none"));
        qtyInputs.forEach((input) => (input.readOnly = true));
    }
}

function increaseQty(upc) {
    let input = document.getElementById(`qty-fulfillable-${upc}`);
    let maxQty = parseInt(input.max, 10);
    let currentQty = parseInt(input.value, 10);

    if (currentQty < maxQty) {
        input.value = currentQty + 1;
    } else {
        showToast("Quantity cannot exceed the ordered quantity");
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
            background: "#FF0000",
        },
        stopOnFocus: true,
        escapeMarkup: false,
        className: "custom-toast",
    }).showToast();
}

// Call the fetchData function to load data when the page loads
document.addEventListener("DOMContentLoaded", poTable);
