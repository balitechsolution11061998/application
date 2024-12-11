var hideFromUser = false;
var hideAddItem = false;
var hideItemDesc = false;
var hideSelectSupplier = false;
var hideRowButton = false;
var hideBtnUpload = false;

var hideApproveButton = false;
var hideRejectButton = false;
var hideCheckbox = false;

var readonly = false;

var myUser;
var priceChangeStatus;
var formType;

$(document).ready(async function () {
    setupAjax();
    Swal.showLoading();

    const hasData = await loadPriceChangeTable();

    if (hasData) {
        toastr.success("Data loaded successfully!", "Success");
    } else {
        toastr.warning("No data available in the table.", "Warning");
    }
    Swal.close();

    setupModalEvents();
});

function setupAjax() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
}

async function loadPriceChangeTable() {
    return await tablePriceChange();
}

function setupModalEvents() {
    $("#mdlForm").on("shown.bs.modal", function () {
        $("#submitBtn").prop("disabled", false);
        setupSupplierChangeEvent();
        setupUploadButtonEvent();
        setupBarcodeChangeEvent();
    });
}

function setupSupplierChangeEvent() {
    $("#selectSupplier").on("change", function () {
        clearAllRows();
    });

    $("#selectSupplier").on("select2:open", function () {
        Swal.showLoading();
        setTimeout(Swal.close, 750);
    });

    $("#discardBtn").on("click", function () {
        $("#selectSupplier").val(null).trigger("change");
        clearAllRows();
    });
}

function setupUploadButtonEvent() {
    $("#btnUploadPriceChangeCsv").on("click", async function (e) {
        e.preventDefault();
        if ($("#selectSupplier").val() === "") {
            showAlert("Failed", "Please select a Supplier first!", "warning");
        } else {
            const result = await showConfirmation(
                "Note!",
                "Uploading items will delete previously entered items. Are you sure?"
            );
            if (result.isConfirmed) {
                handleUploadFileCsv();
            }
        }
    });
}

function setupBarcodeChangeEvent() {
    $("#pricelist tbody").on("change", '[name="barcode[]"]', function () {
        const clickedValue = $(this).val();
        const oldCostElement = $(this)
            .closest("tr")
            .find('[name="old_cost[]"]');
        const newCostElement = $(this)
            .closest("tr")
            .find('[name="new_cost[]"]');
        const skuElement = $(this).closest("tr").find('[name="sku[]"]');

        newCostElement.val(null);
        showLoading("Fetching data...");

        generateDataItemSupp(clickedValue)
            .then((dataItem) => {
                oldCostElement.val(formatRupiah(dataItem.data.unit_cost));
                skuElement.val(dataItem.data.sku);
                Swal.close();
            })
            .catch(() => {
                oldCostElement.val("");
                Swal.close();
            });
    });
}

function showLoading(message) {
    Swal.fire({
        title: "Loading",
        html: `<i class="fas fa-spinner fa-spin"></i> ${message}`,
        icon: "info",
        allowOutsideClick: false,
        showConfirmButton: false,
    });
}

function showAlert(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButton: true,
    });
}

async function showConfirmation(title, text) {
    return await Swal.fire({
        title: title,
        text: text,
        icon: "info",
        showConfirmButton: true,
        showCancelButton: true,
    });
}

async function handleUploadFileCsv() {
    $("#mdlForm").modal("hide");
    setTimeout(() => {
        $("#mdlUploadFile").modal("show");
        initializeDropzone();
    }, 500);
}

function initializeDropzone() {
    const myDropzone = new Dropzone("#fileDropzone", {
        url: "/price-change/handleUploadFileCsv",
        paramName: "file",
        maxFilesize: 1,
        maxFile: 1,
        addRemoveLinks: true,
        acceptedFiles: ".csv,.xlsx",
        dictDefaultMessage: "Drop files here or click to upload",
        dictRemoveFile: "Remove file",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        init: function () {
            this.on("addedfile", function (file) {
                if (this.files.length > 1) {
                    showAlert(
                        "Failed",
                        "You can only upload one file at a time.",
                        "warning"
                    );
                    this.removeFile(file);
                } else {
                    showLoading("Processing upload file data to form");
                }
            });

            this.on("sending", function (file, xhr, formData) {
                const supplier = $("#selectSupplier").val();
                formData.append("selectSupplier", supplier);
            });

            this.on("success", function (file, response) {
                handleUploadSuccess(file, response);
            });

            this.on("error", function (file, response) {
                handleUploadError(file, response);
            });
        },
    });
}

function handleUploadSuccess(file, response) {
    addItemFromCsv(response.data)
        .then(() => {
            $("#mdlUploadFile").modal("hide");
            Swal.fire({
                title: response.title,
                text: response.message,
                icon: "success",
                timer: 1000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        })
        .catch((error) => {
            console.error(error);
            showAlert(
                "Error",
                error.message || "An unexpected error occurred.",
                "error"
            );
        });
}

function handleUploadError(file, response) {
    $("#pricelist tbody").empty();
    $("#mdlUploadFile").modal("hide");
    showAlert("Error", response.message || "An error occurred.", response.icon);
}

async function addItemFromCsv(dataBarcode) {
    const tableBody = $("#pricelist tbody");
    tableBody.empty();

    const promises = dataBarcode.data.map(async (data, index) => {
        const newRow = createRowFromData(data, index);
        tableBody.append(newRow);
        await searchSelectBarcode();
    });

    await Promise.all(promises);
}

function createRowFromData(data, index) {
    return `
        <tr id="R${index + 1}">
            <td hidden>
                <input type="number" name="priceChangeDetailId[]" class="form-control" style="width: 100%" value="" readonly>
            </td>
            <td>
                <select name="barcode[]" class="form-control select select-barcode" style="width: 100%">
                    <option value="${data.barcode}">${data.barcode} (${
        data.barcode == null ? "No Description" : data.barcode
    })</option>
                </select>
            </td>
            <td hidden>
                <input type="text" class="form-control" name="sku[]" value="${
                    data.sku
                }" readonly>
            </td>
            <td ${hideItemDesc ? "hidden" : ""}>
                <input type="text" class="form-control" name="item_desc[]" placeholder="Input Item Desc" value="${
                    data.item_desc || ""
                }" ${readonly ? "readonly" : ""}>
            </td>
            <td>
                <input type="text" class="form-control rupiah old-cost" name="old_cost[]" value="${formatRupiah(
                    data.old_cost
                )}" readonly>
            </td>
            <td>
                <input type="text" class="form-control rupiah new-cost" name="new_cost[]" value="${formatRupiah(
                    data.new_cost
                )}" ${readonly ? "readonly" : ""}>
            </td>
            <td style="width: 10%;" class="text-center actionColumn" ${
                hideRowButton ? "hidden" : ""
            }>
                <button class="btn btn-sm btn-danger remove remove-row" type="button"><i class="fas fa-trash"></i></button>
            </td>
        </tr>`;
}

async function tablePriceChange() {
    const table = $("#tablePriceChange");

    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().destroy();
    }

    return table.DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/price-change/data",
            type: "GET",
            data: function (d) {
                d.search = $("#frmSearchRoles").val();
            },
            dataSrc: function (json) {
                return json.data;
            },
            error: function (xhr, error, thrown) {
                console.error("Error fetching data:", error);
            },
        },
        columns: [
            { data: "pricelist_no" },
            { data: "pricelist_desc" },
            {
                data: "active_date",
                render: function (data) {
                    return new Date(data).toLocaleDateString("id-ID", {
                        year: "numeric",
                        month: "long",
                        day: "2-digit",
                    });
                },
            },
            { data: "supplier_id" },
            {
                data: "supplier",
                render: function (data, type, row) {
                    return row.suppliers && row.suppliers.supp_name
                        ? row.suppliers.supp_name
                        : "-";
                },
            },
            {
                data: "user",
                render: function (data, type, row) {
                    return row.users && row.users.name
                        ? `<span class="badge badge-pretty custom-info-badge"><i class="fas fa-user mr-1"></i>${row.users.name}</span>`
                        : '<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>';
                },
            },
            {
                data: "status",
                render: function (data) {
                    const statusClasses = {
                        progress: "custom-progress",
                        approve: "custom-approve",
                        reject: "custom-reject",
                    };
                    return `<span class="badge badge-pretty ${
                        statusClasses[data] || "custom-progress"
                    }"><i class="fas fa-${
                        data === "progress"
                            ? "spinner fa-spin"
                            : data === "approve"
                            ? "check"
                            : "times"
                    } mr-1"></i>${capitalizeFirstLetter(data)}</span>`;
                },
            },
            {
                data: "id",
                render: function (data, type, row) {
                    return `
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdownMenuButton_${data}">
                            Action
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="dropdownMenuButton_${data}">
                            <li>
                                <button class="btn btn-warning btn-sm" onclick="detailPriceChange(${data},'edit')" data-bs-toggle="tooltip" title="Detail Price Change">Detail <i class="fas fa-edit"></i></button>
                                <button class="btn btn-success btn-sm" onclick="detailPriceChange(${data},'approvement')" data-bs-toggle="tooltip" title="Detail Price Change" ${
                        myUser.role == "supplier" ||
                        row.status == "approve" ||
                        row.status == "reject"
                            ? "hidden"
                            : ""
                    }> Approvement <i class="fas fa-edit"></i></button>
                                <button ${
                                    row.status != "progress" ? "hidden" : ""
                                } class="btn btn-danger btn-sm" onclick="deletePriceChange(${data})" data-bs-toggle="tooltip" title="Detail Price Change">Delete <i class="fas fa-trash"></i></button>
                            </li>
                        </ul>
                    </div>`;
                },
            },
        ],
    });
}

function clearAllRows() {
    $("#pricelist tbody").empty();
    $("#submitBtn").prop("disabled", true);
}

function formatRupiah(value) {
    // Implement your currency formatting logic here
    return value; // Placeholder
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
async function tambahPriceList(data = null, type) {
    console.log(data == null, "data");
    if (data == null) {
        // Show loading spinner while preparing the modal
        Swal.fire({
            title: "Loading...",
            html: "Please wait while we prepare the form.",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading(); // Show loading spinner
            },
        });

        // Show the modal after a short delay to simulate loading
        setTimeout(() => {
            $("#modalStorePriceChange").modal("show");
            Swal.close(); // Close the loading spinner
        }, 500);
    }
    readonly = false;

    // Clear previous content
    $("#modalStorePriceChange .modal-body").html(`
        <form id="formStorePriceChange">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <label for="pricelistName" class="form-label">Pricelist Name</label>
                            <input type="text" class="form-control" id="pricelistName" placeholder="Enter a Pricelist name" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="activeDate" class="form-label">Active Date</label>
                            <input type="date" class="form-control" id="activeDate" required />
                        </td>
                        <td>
                            <label for="newSelectSupplier" class="form-label">Supplier</label>
                            <select class="form-select" id="newSelectSupplier" required>
                                <option selected disabled>Select an option</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button class="btn btn-sm btn-primary" type="button" id="btnAddItem">
                                <i class="fas fa-plus me-1"></i> Add Item
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800">
                            <th class="text-center">UPC</th>
                            <th class="text-center">SKU</th>
                            <th class="text-center">OLD COST</th>
                            <th class="text-center">NEW COST</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="tbodyPricelist">
                        <tr>
                            <td colspan="5" class="text-center">
                                <span class="badge bg-danger text-white p-3">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Click "Add Item" to add items for price change.
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    `);

    // Event listener for the "Add Item" button
    $("#btnAddItem").on("click", async function () {
        try {
            // Fetch items using Axios
            const response = await axios.get("/item-suppliers/select/data"); // Adjust the URL to your API endpoint
            const items = response.data; // Assuming the response data is an array of items

            // Check if items are empty
            if (items.length === 0) {
                // Show toastr notification
                toastr.warning(
                    "No items found. Redirecting to the item page...",
                    "Warning"
                );

                // Redirect after a delay
                setTimeout(() => {
                    window.location.href = "/item-suppliers"; // Adjust the URL to your item page
                }, 3000); // Redirect after 3 seconds
                return; // Exit the function
            }

            // Create a modal for item selection
            const itemSelectionModal = `
            <div class="modal fade" id="itemSelectionModal" tabindex="-1" aria-labelledby="itemSelectionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="itemSelectionModalLabel">Select Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" id="itemSearch" class="form-control mb-2" placeholder="Search by SKU or UPC..." oninput="filterItems(this.value)">
                            <table class="table table-bordered" id="itemTable">
                                <thead>
                                    <tr>
                                        <th>UPC</th>
                                        <th>SKU</th>
                                        <th>Cost</th>
                                        <th>Select</th>
                                    </tr>
                                </thead>
                                <tbody id="itemTableBody">
                                    ${items
                                        .slice(0, 10)
                                        .map(
                                            (item) => `
                                        <tr>
                                            <td>${item.upc}</td>
                                            <td>${item.sku}</td>
                                            <td>Rp ${formatRupiah(item.unit_cost)}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary select-item" data-sku="${item.sku}" data-cost="${item.unit_cost}" data-upc="${item.upc}">
                                                    <i class="fas fa-check"></i> Select
                                                </button>
                                            </td>
                                        </tr>
                                    `
                                        )
                                        .join("")}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        `;

            // Append the modal to the body and show it
            $("body").append(itemSelectionModal);
            $("#itemSelectionModal").modal("show");

        } catch (error) {
            console.error("Error fetching items:", error);
            Swal.fire(
                "Error",
                "Failed to fetch items. Please try again later.",
                "error"
            );
        }
    });

    // Function to filter items based on SKU or UPC using AJAX
    window.filterItems = async function (query) {
        try {
            const response = await axios.get(`/item-suppliers/select/data?search=${query}`); // Adjust the URL to your API endpoint
            const items = response.data; // Assuming the response data is an array of items

            const itemTableBody = document.getElementById("itemTableBody");
            itemTableBody.innerHTML = `
            ${items
                .slice(0, 10)
                .map(
                    (item) => `
                <tr>
                    <td>${item.upc}</td>
                    <td>${item.sku}</td>
                    <td>Rp ${formatRupiah(item.unit_cost)}</td>
                    <td>
                        <button class="btn btn-sm btn-primary select-item" data-sku="${item.sku}" data-cost="${item.unit_cost}" data-upc="${item.upc}">
                            <i class="fas fa-check"></i> Select
                        </button>
                    </td>
                </tr>
            `
                )
                .join("")}
        `;
        } catch (error) {
            console.error("Error filtering items:", error);
            Swal.fire("Error", "Failed to filter items. Please try again later.", "error");
        }
    };

    // Function to format numbers as Rupiah
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    // Handle edit and delete actions
    $(document).on("click", ".btn-edit", function () {
        const row = $(this).closest("tr");
        const upc = row.find("td:eq(0)").text();
        const sku = row.find("td:eq(1)").text();
        const oldCost = row.find("td:eq(2)").text();
        const newCostInput = row.find("input[type='number']");
        const newCost = newCostInput.val();

        // Prompt for new values
        const newUPC = prompt("Edit UPC:", upc);
        const newSKU = prompt("Edit SKU:", sku);
        const newOldCost = prompt("Edit Old Cost:", oldCost);
        const newNewCost = prompt("Edit New Cost:", newCost);

        // Update the row if values are provided
        if (newUPC && newSKU && newOldCost && newNewCost) {
            row.find("td:eq(0)").text(newUPC);
            row.find("td:eq(1)").text(newSKU);
            row.find("td:eq(2)").text(newOldCost);
            newCostInput.val(newNewCost);
        }
    });

    $(document).on("click", ".btn-delete", function () {
        const row = $(this).closest("tr");
        const sku = row.find("td:eq(1)").text(); // Get the SKU of the deleted item

        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with deletion
                row.remove();

                // Check if the price list is empty and show the badge message again
                if ($(".tbodyPricelist tr").length === 0) {
                    $(".tbodyPricelist").append(`
                        <tr>
                            <td colspan="5" class="text-center">
                                <span class="badge bg-danger text-white p-3">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Click "Add Item" to add items for price change.
                                </span>
                            </td>
                        </tr>
                    `);
                }

                // Show toastr notification
                toastr.success('Item deleted successfully!', 'Deleted');
            }
        });
    });

    $(document).on('click', '.select-item', function() {
        const sku = $(this).data('sku');
        const cost = $(this).data('cost');
        const upc = $(this).data('upc');

        // Check if the item is already selected
        const isAlreadySelected = $(".tbodyPricelist").find(`td:contains('${sku}')`).length > 0;
        if (isAlreadySelected) {
            toastr.warning('This item has already been selected!', 'Warning');
            return; // Exit the function if the item is already selected
        }

        // Show spinner in the button
        const $button = $(this);
        $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');

        // Add the item to the price list table
        $(".tbodyPricelist").append(`
            <tr>
                <td>${upc}</td>
                <td>${sku}</td>
                <td>Rp ${formatRupiah(cost)}</td>
                <td><input type="number" class="form-control" value="${cost}" /></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-warning btn-edit" type="button">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger btn-delete" type="button">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
        `);

        // Hide the message indicating to click "Add Item" with animation
        $(".tbodyPricelist").find("tr:contains('Click \"Add Item\" to add items for price change.')").fadeOut(300, function() {
            $(this).remove(); // Remove the element from the DOM after fading out
        });

        // Simulate a delay for the loading spinner (optional)
        setTimeout(() => {
            // Show Toastr notification
            toastr.success('Item selected successfully!', 'Success');

            // Update the button to indicate selection
            $button.prop('disabled', true).text('Selected').removeClass('btn-primary').addClass('btn-success');

            // Close the modal
            $('#itemSelectionModal').modal('hide');
            $('#itemSelectionModal').remove(); // Remove the modal from the DOM
        }, 500); // Adjust the delay as needed
    });
}
