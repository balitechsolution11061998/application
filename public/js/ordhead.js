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
        const date = document.getElementById("date").value;
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
            }
        }
    });

    async function syncData(apiUrl, storeUrl, syncTitle, date) {
        const progressContainer = document.createElement("div");
        progressContainer.id = "progressContainer";

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
                    icon: "success",
                    showConfirmButton: false, // Hide the confirmation button
                    customClass: {
                        popup: "swal2-popup-custom",
                        title: "swal2-title-custom",
                        content: "swal2-content-custom",
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
                    popup: "swal2-popup-custom",
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
                    let badgeClass = "";
                    let iconClass = "";
                    let iconTitle = "";
                    let badgeText = "";

                    switch (row.status) {
                        case "Progress":
                            badgeClass = "badge-warning";
                            iconClass = "fas fa-spinner fa-spin";
                            iconTitle = "In Progress";
                            badgeText = "In Progress";
                            break;
                        case "Completed":
                            badgeClass = "badge-success";
                            iconClass = "fas fa-check-circle";
                            iconTitle = "Completed";
                            badgeText = "Completed";
                            break;
                        case "Expired":
                            badgeClass = "badge-danger";
                            iconClass = "fas fa-times-circle";
                            iconTitle = "Expired";
                            badgeText = "Expired";
                            break;
                        case "Reject":
                            badgeClass = "badge-danger";
                            iconClass = "fas fa-times-circle";
                            iconTitle = "Reject";
                            badgeText = "Reject";
                            break;
                        case "Confirmed":
                            badgeClass = "badge-info";
                            iconClass = "fas fa-thumbs-up";
                            iconTitle = "Confirmed";
                            badgeText = "Confirmed";
                            break;
                        default:
                            badgeClass = "badge-secondary";
                            iconClass = "fas fa-file-alt";
                            iconTitle = "Status";
                            badgeText = data;
                            break;
                    }

                    return `
                        <span class="badge badge-button ${badgeClass}" style="color: white; font-weight: bold; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; cursor: pointer;">
                            <i class="${iconClass}" style="color: white; margin-right: 0.5rem;" title="${iconTitle}"></i> ${badgeText}
                        </span>
                    `;
                },
            },
            {
                data: "approval_date",
                name: "approval_date",
                render: function (data) {
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
                render: function (data) {
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

                    const textColor =
                        isExpired || isExpiringTomorrow ? "red" : "black";

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
                data: "estimated_delivery_date",
                name: "estimated_delivery_date",
                render: function (data) {
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

                    const textColor =
                        isExpired || isExpiringTomorrow ? "black" : "black";

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
                data: "receive_date",
                name: "receive_date",
                render: function (data) {
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

                    const textColor =
                        isExpired || isExpiringTomorrow ? "red" : "black";

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
            }

            ,
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
    // Apply hover effect to change color to black
    $("#po_table").on("mouseenter", ".dropdown-item", function () {
        $(this).css("color", "black");
    });

    $("#po_table").on("mouseleave", ".dropdown-item", function () {
        $(this).css("color", "");
    });
}

function searchOrderNo() {
    poTable();
}

// Function to handle the 'Order No' status
function detailPo(rowData) {
    const modalBody = document.getElementById("mdlFormContent");
    const modalTitle = document.getElementById("mdlFormTitle");
    const spinner = document.getElementById("modalSpinner");
    const detailModal = new bootstrap.Modal(document.getElementById("mdlForm"));
    spinner.innerHTML = "";
    modalBody.innerHTML = ""; // Clear previous content
    spinner.style.display = "block"; // Show spinner
    modalTitle.textContent = "Order Details"; // Set the modal title

    // Fetch the details based on rowData (e.g., order_no)
    fetch(`/po/getOrderDetails?order_no=${rowData.order_no}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            // Hide the spinner
            spinner.style.display = "none";

            if (data && data.details) {
                const details = data.details;

                // Generate the details HTML
                modalBody.innerHTML = generateOrderDetailsHTML(details);
            } else {
                modalBody.innerHTML = "<p>No details available.</p>";
            }
        })
        .catch((error) => {
            console.error("Error fetching order details:", error);
            spinner.style.display = "none";
            modalBody.innerHTML = "<p>Error fetching details. Please try again later.</p>";
        });

    // Show the modal
    detailModal.show();
}

// Function to generate the HTML content for order details
function generateOrderDetailsHTML(details) {
    return `
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-lg-20">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                        <!--begin::Order details-->
                        <div class="mt-n1">
                            <!--begin::Top-->
                            <div class="d-flex flex-stack pb-10">
                                <!--begin::Logo-->
                                <a href="#">
                                    <img alt="Logo" src="/metronic8/demo1/assets/media/svg/brand-logos/code-lab.svg">
                                </a>
                                <!--end::Logo-->
                                <!--begin::Action-->
                                <a href="#" class="btn btn-sm btn-success">Pay Now</a>
                                <!--end::Action-->
                            </div>
                            <!--end::Top-->
                            <!--begin::Wrapper-->
                            <div class="m-0">
                                <!--begin::Label-->
                                <div class="fw-bold fs-3 text-gray-800 mb-8">Order No: ${details.order_no || 'N/A'}</div>
                                <!--end::Label-->
                                <!--begin::Row-->
                                <div class="row g-5 mb-11">
                                    <div class="col-sm-6">
                                        <div class="fw-semibold fs-7 text-gray-600 mb-1">Approval Date:</div>
                                        <div class="fw-bold fs-6 text-gray-800">${details.approval_date || 'N/A'}</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="fw-semibold fs-7 text-gray-600 mb-1">Estimated Delivery Date:</div>
                                        <div class="fw-bold fs-6 text-gray-800">${details.estimated_delivery_date || 'N/A'}</div>
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row g-5 mb-12">
                                    <div class="col-sm-6">
                                        <div class="fw-semibold fs-7 text-gray-600 mb-1">Ship To:</div>
                                        <div class="fw-bold fs-6 text-gray-800">${details.ship_to || 'N/A'}</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="fw-semibold fs-7 text-gray-600 mb-1">Status:</div>
                                        <div class="fw-bold fs-6 text-gray-800">
                                            ${getStatusBadgeClass(details.status)}
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Table-->
                                <div class="table-responsive border-bottom mb-9">
                                    <table class="table mb-3">
                                        <thead>
                                            <tr class="border-bottom fs-6 fw-bold text-muted">
                                                <th class="min-w-300px pb-2">Description</th>
                                                <th class="min-w-100px text-end pb-2">Quantity</th>
                                                <th class="min-w-100px text-end pb-2">Unit Price</th>
                                                <th class="min-w-120px text-end pb-2">Subtotal</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${generateOrderItemsHTML(details.ord_detail)}
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                                <!--begin::Container-->
                                <div class="d-flex justify-content-end">
                                    <div class="mw-300px">
                                        ${generateOrderSummaryHTML(details)}
                                    </div>
                                </div>
                                <!--end::Container-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Order details-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Sidebar-->
                    <div class="m-0">
                        <div class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">
                            <div class="mb-8">
                                <span class="badge badge-light-success me-2">${details.order_status || 'N/A'}</span>
                            </div>
                            <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">PAYMENT DETAILS</h6>
                            <div class="mb-6">
                                <div class="fw-semibold text-gray-600 fs-7">Paypal:</div>
                                <div class="fw-bold text-gray-800 fs-6">${details.paypal || 'N/A'}</div>
                            </div>
                            <div class="mb-6">
                                <div class="fw-semibold text-gray-600 fs-7">Account:</div>
                                <div class="fw-bold text-gray-800 fs-6">${details.account || 'N/A'}</div>
                            </div>
                            <div class="mb-15">
                                <div class="fw-semibold text-gray-600 fs-7">Payment Term:</div>
                                <div class="fw-bold fs-6 text-gray-800">${details.payment_term || 'N/A'}</div>
                            </div>
                            <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">PROJECT OVERVIEW</h6>
                            <div class="mb-6">
                                <div class="fw-semibold text-gray-600 fs-7">Description:</div>
                                <div class="fw-bold text-gray-800 fs-6">${details.description || 'N/A'}</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Sidebar-->
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Body-->
        </div>
    `;
}

function getStatusBadgeClass(status) {
    switch (status) {
        case 'Completed':
            return `
                <span class="badge badge-light-success text-white fw-bold">
                    <i class="fas fa-check-circle me-2"></i> Completed
                </span>
            `;
        case 'Pending':
            return `
                <span class="badge badge-light-warning text-white fw-bold">
                    <i class="fas fa-hourglass-half me-2"></i> Pending
                </span>
            `;
        case 'Cancelled':
            return `
                <span class="badge badge-light-danger text-white fw-bold">
                    <i class="fas fa-times-circle me-2"></i> Cancelled
                </span>
            `;
        case 'Printed':
            return `
                <span class="badge badge-light-primary text-white fw-bold">
                    <i class="fas fa-print me-2"></i> Printed
                </span>
            `;
        default:
            return `
                <span class="badge badge-light-secondary text-white fw-bold">
                    <i class="fas fa-question-circle me-2"></i> Unknown
                </span>
            `;
    }
}


function generateOrderItemsHTML(ordskus) {
    return ordskus.map(sku => {
        // Calculate the total amount including VAT
        const totalAmount = (sku.unit_cost * sku.qty_ordered) + (sku.qty_ordered * sku.vat_cost) ;
        return `
            <tr class="fw-bold text-gray-800 fs-6 text-end border-bottom">
                <td class="d-flex align-items-center pt-4 pb-4">
                    <i class="fa fa-box text-primary fs-3 me-3"></i>
                    ${sku.sku_desc} (${sku.sku})
                </td>
                <td class="pt-4 pb-4">${sku.qty_ordered}</td>
                <td class="pt-4 pb-4">${formatCurrency(sku.unit_cost)}</td>
                <td class="pt-4 pb-4">${formatCurrency(totalAmount)}</td>
            </tr>
        `;
    }).join('');
}

// Helper function to format currency
function formatCurrency(value) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
}

// Function to generate the HTML content for order summary
// Function to generate the HTML content for order summary
function generateOrderSummaryHTML(details) {
    console.log(details.ord_detail);

    // Calculate subtotal and total VAT
    const { subtotal, totalVat } = details.ord_detail.reduce((acc, item) => {
        const itemTotal = item.unit_cost * item.qty_ordered;
        const itemVat = item.vat_cost * item.qty_ordered;

        acc.subtotal += itemTotal;
        acc.totalVat += itemVat;

        return acc;
    }, { subtotal: 0, totalVat: 0 });

    // Calculate total
    const total = subtotal + totalVat;

    // Log calculated values for debugging
    console.log('Subtotal:', subtotal);
    console.log('Total VAT:', totalVat);
    console.log('Total:', total);

    // Return the formatted HTML for the order summary
    return `
        <div class="d-flex flex-stack mb-3">
            <div class="fw-semibold pe-10 text-gray-600 fs-7">Subtotal:</div>
            <div class="text-end fw-bold fs-6 text-gray-800">${formatCurrency(subtotal)}</div>
        </div>
        <div class="d-flex flex-stack mb-3">
            <div class="fw-semibold pe-10 text-gray-600 fs-7">VAT:</div>
            <div class="text-end fw-bold fs-6 text-gray-800">${formatCurrency(totalVat)}</div>
        </div>
        <div class="d-flex flex-stack mb-3">
            <div class="fw-semibold pe-10 text-gray-600 fs-7">Total:</div>
            <div class="text-end fw-bold fs-6 text-gray-800">${formatCurrency(total)}</div>
        </div>
    `;
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

function confirmPo(event) {
    // Get the order number from the clicked element
    let orderNo = event.order_no; // Assuming order number is within the clicked element

    // Store event data in local storage
    localStorage.setItem("orderData", JSON.stringify(event));

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
    }).then((result) => {
        if (result.isConfirmed) {
            // Close the current SweetAlert modal
            Swal.close();

            // Retrieve data from local storage
            let storedData = JSON.parse(localStorage.getItem("orderData"));
            let subtotal = 0;
            let ppn = 0;

            // Populate the modal content using jQuery
            $("#mdlFormTitle").html(
                '<i class="fas fa-file-alt"></i> Confirm PO - ' +
                    storedData.order_no
            );

            let cartHtml = storedData.ord_detail
                .map((item) => {
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
                                    <button type="button" class="qty-decrease" onclick="decreaseQty(${
                                        item.upc
                                    })">-</button>
                                    <input type="number" id="qty-fulfillable-${
                                        item.upc
                                    }" class="qty-fulfillable-input" name="qty_fulfillable" value="${qtyOrdered}" min="0" max="${qtyOrdered}" style="max-width: 200px;" data-unit-cost:"${qtyOrdered}"/>
                                    <button type="button" class="qty-increase" onclick="increaseQty(${
                                        item.upc
                                    })">+</button>
                                </div>
                                <span class="item-price" id="subtotal-${
                                    item.upc
                                }">${formatRupiah(unitCost)}</span>
                            </div>
                            <i class="fas fa-trash-alt item-delete"></i>
                        </div>
                    </div>
                `;
                })
                .join("");

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

            console.log(storedData, "result.data");

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
            $("#mdlForm").modal("show");

            // Set delivery and expiration dates
            let notAfterDate = new Date(storedData.not_after_date);
            let options = { year: "numeric", month: "long", day: "numeric" };
            let formattedDate = notAfterDate.toLocaleDateString(
                "id-ID",
                options
            );
            document.getElementById("expiredDate").value = formattedDate;

            let releaseDate = new Date(storedData.release_date);
            let minDeliveryDate = new Date(notAfterDate);
            minDeliveryDate.setDate(notAfterDate.getDate() - 2);

            document.getElementById("delivery_date").min = releaseDate
                .toISOString()
                .slice(0, 10);
            document.getElementById("delivery_date").max = minDeliveryDate
                .toISOString()
                .slice(0, 10);

            // Initialize the map
            var senderCoords = [51.505, -0.09];
            var receiverCoords = [55.9533, -3.1883];
            var map = L.map("map").setView(
                [
                    (senderCoords[0] + receiverCoords[0]) / 2,
                    (senderCoords[1] + receiverCoords[1]) / 2,
                ],
                6
            );
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution:
                    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            }).addTo(map);
            L.marker(senderCoords)
                .addTo(map)
                .bindPopup("Sender: Valera Meladze<br>Linkoln st. 34/a, London")
                .openPopup();
            L.marker(receiverCoords)
                .addTo(map)
                .bindPopup("Receiver: Tom Hardy<br>Milton st. 104, Edinburgh")
                .openPopup();

            handleScheduleTypeChange();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Cancelled", "The confirmation was cancelled.", "info");
        }
    });
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
