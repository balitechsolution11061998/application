$(document).ready(function () {
    $("#frmSearchPO").on("keyup", function () {
        tablePo();
    });
    tablePo();
    // Get the close button element
    const dismissModalButton = document.getElementById("dismissModal");

    // Add event listener to close the modal when the button is clicked
    dismissModalButton.addEventListener("click", function () {
        // Close the modal by removing the 'show' class from its parent modal container
        $("#mdlForm").modal("hide");
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

function saveApiDataToDatabase(data) {
    // Make a POST request using jQuery AJAX
    Swal.fire({
        title: "Loading",
        html: "Please wait...",
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    $.ajax({
        url: "order/store",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function (response) {
            // Handle the response from saving data to the database
            Swal.fire({
                icon: "success",
                title: response.title,
                text: response.message,
                timer: 2000,
                showConfirmButton: false,
            });
            tablePo(); // Call tablePo() after showing the success message
        },
        error: function (xhr, status, error) {
            // Handle any errors that occurred during saving data to the database
            Swal.fire({
                icon: "error",
                title: xhr.responseText,
                text: xhr.responseText,
            });
        },
        complete: function () {
            // Close the loading spinner after the AJAX request is complete
            Swal.close();
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Data saved successfully.",
                timer: 2000,
                showConfirmButton: false,
            });
        },
    });
}

function syncPO() {
    const filterDate = document.getElementById("filterDate").value;
    Swal.fire({
        icon: "question",
        title: "Confirm Sync",
        text: "Are you sure you want to synchronize data?",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
    }).then((result) => {
        // Check if the user clicked the confirm button
        if (result.isConfirmed) {
            // Show loading indicator
            Swal.fire({
                title: "Loading",
                html: "Please wait while fetching Order data...",
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            });

            // Make a GET request to the API endpoint
            // Make a GET request to the API endpoint with the bearer token
            fetch(linkSync + `/api/order/getData?approval_date=${filterDate}`, {
                method: "GET",
                headers: {
                    Authorization:
                        "Bearer 32|SOdQC7qYIwGxZFri74TMYowWcujfpjQRtIZsu1IR293f99cc", // Remove the colon after "Bearer"
                    "Content-Type": "application/json",
                },
            })
                .then((response) => {
                    // Check if the response is successful (status code 200)
                    if (!response.ok) {
                        throw new Error("Failed to fetch data");
                    }
                    // Parse the JSON response
                    return response.json();
                })
                .then((data) => {
                    console.log(data, "data");
                    // Handle the data received from the API
                    Swal.close();

                    saveApiDataToDatabase(data.data);
                })
                .catch((error) => {
                    // Handle any errors that occurred during the fetch
                    console.error("Error fetching data:", error);

                    // Close the loading modal
                    Swal.close();

                    // Show SweetAlert error notification
                    Swal.fire({
                        icon: "error",
                        title: "Sync Failed!",
                        text: "Failed to synchronize data. Please try again later.",
                    });
                });
        }
    });
}

function saveApiDataToDatabase(data) {
    // Make a POST request using jQuery AJAX
    Swal.fire({
        title: "Loading",
        html: "Please wait...",
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });

    $.ajax({
        url: "order/store",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function (response) {
            // Handle the response from saving data to the database
            Swal.fire({
                icon: "success",
                title: response.title,
                text: response.message,
                timer: 2000,
                showConfirmButton: false,
            });
        },
        error: function (xhr, status, error) {
            // Handle any errors that occurred during saving data to the database
            Swal.fire({
                icon: "error",
                title: xhr.responseText,
                text: xhr.responseText,
            });
        },
        complete: function () {
            // Close the loading spinner after the AJAX request is complete
            Swal.close();
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Data saved successfully.",
                timer: 2000,
                showConfirmButton: false,
            });
            tablePo();
        },
    });
}

function filterPo() {
    tablePo();
}

function tablePo() {
    var table = $("#tablePo");
    // Check if DataTable is already initialized
    if ($.fn.DataTable.isDataTable(table)) {
        // If DataTable is already initialized, destroy the existing instance
        table.DataTable().destroy();
    }
    table.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "/order/data",
            type: "GET",
            data: function (d) {
                d.searchParams = {
                    search: $("#frmSearchPO").val(),
                    store: $("#store").val(),
                    supplier: $("#supplierFilter").val(),
                    order_no: $("#order_no").val(),
                    filterDateRange: $("#filterDateRange").val(),
                    status: $("#status").val(),
                };
            },
        },
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    let historyButton = "";
                    if (row.print_po && row.print_po.length > 0) {
                        if (
                            permissions.find(
                                (permission) =>
                                    permission.name === "print-history-po"
                            )
                        ) {
                            historyButton =
                                '<button type="button" class="btn btn-success btn-sm select-button" data-id="' +
                                row.order_no +
                                '" onclick="openHistoryPrint(\'' +
                                row.order_no +
                                '\')"><i class="fas fa-history"></i> History</button>';
                        }
                    }

                    // Conditionally set the detail or confirmed button
                    const detailButton =
                        row.status === "Progress" &&
                        row.estimated_delivery_date == null
                            ? '<button type="button" class="btn btn-warning btn-sm select-button" data-id="' +
                              row.order_no +
                              '" onclick="confirmPo(' +
                              row.order_no +
                              ', \'Progress\')"><i class="fas fa-check"></i> Confirm</button>'
                            : '<button type="button" class="btn btn-primary btn-sm select-button" data-id="' +
                              row.order_no +
                              '" onclick="openDetailPo(' +
                              row.order_no +
                              ')"><i class="fas fa-edit"></i> Detail</button>';

                    return (
                        '<div class="btn-group">' +
                        detailButton +
                        historyButton +
                        "</div>"
                    );
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
                data: "supp_name",
                name: "supp_name",
                render: function (data) {
                    return data
                        ? `<span style="color: black; font-weight: bold;">${data}</span>`
                        : `<span style="color: black; font-weight: bold;">Not Found Data</span>`;
                },
            },
            {
                data: "approval_date",
                render: function (data, type, row, meta) {
                    return moment(row.approval_date).format("DD MMMM YYYY");
                },
            },
            {
                data: "not_after_date",
                render: function (data, type, row, meta) {
                    return moment(row.not_after_date).format("DD MMMM YYYY");
                },
            },
            // { data: "approval_id" },
            // {
            //     data: "total_cost",
            //     render: function (data, type, row, meta) {
            //         return (
            //             '<span class="total-cost">' +
            //             formatRupiah(row.total_cost) +
            //             "</span>"
            //         );
            //     },
            // },
            // {
            //     data: "total_retail",
            //     render: function (data, type, row, meta) {
            //         return (
            //             '<span class="total-retail">' +
            //             formatRupiah(row.total_retail) +
            //             "</span>"
            //         );
            //     },
            // },
            // { data: "comment_desc" },
            // { data: "jumlahPrint" },
            {
                data: "status",
                render: function (data, type, row) {
                    let badgeClass = "";
                    let badgeText = "";
                    let iconClass = "";

                    switch (data.toLowerCase()) {
                        case "confirmed":
                            badgeClass = "badge-success";
                            badgeText = "Confirmed";
                            iconClass = "fas fa-check";
                            break;
                        case "progress":
                            if (row.estimated_delivery_date === null) {
                                badgeClass = "badge-warning";
                                badgeText = "In Progress";
                                iconClass = "fas fa-exclamation-triangle";
                            } else {
                                badgeClass = "badge-success";
                                badgeText = "Confirmed";
                                iconClass = "fas fa-check";
                            }
                            break;
                        case "reject":
                            badgeClass = "badge-danger";
                            badgeText = "Rejected";
                            iconClass = "fas fa-times";
                            break;
                        case "completed":
                            badgeClass = "badge-primary";
                            badgeText = "Completed";
                            iconClass = "fas fa-check-double";
                            break;
                        default:
                            badgeClass = "badge-secondary";
                            badgeText = data;
                            iconClass = "fas fa-info-circle";
                    }

                    return (
                        '<span class="badge ' +
                        badgeClass +
                        '"><i class="' +
                        iconClass +
                        '"></i> ' +
                        badgeText +
                        "</span>"
                    );
                },
            },
        ],
        // language: {
        //     emptyTable:
        //         "<img src='/img/no-data.jpg' class='img-fluid' alt='No data available' style='height:75%;'>",
        // },
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            api.column(1, { page: "current" })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        last = group;
                    }
                });

            // Check for duplicate order_no and highlight them
            var orderNoCount = {};
            api.column(1, { page: "current" })
                .data()
                .each(function (orderNo, i) {
                    if (!orderNoCount[orderNo]) {
                        orderNoCount[orderNo] = 1;
                    } else {
                        orderNoCount[orderNo]++;
                        $(rows).eq(i).addClass("text-danger");
                    }
                });

            // Add delete button for duplicate rows
            $("tr.text-danger", api.table().body()).each(function () {
                var row = $(this);
                var orderNo = row.find("td:eq(1)").text();
                // Get the order_no from the second column
                if (
                    permissions.find(
                        (permission) => permission.name === "po-delete"
                    )
                ) {
                    row.append(
                        '<td><button class="btn btn-danger btn-sm delete-button"><i class="fas fa-trash"></i>Delete</button></td>'
                    );
                }

                // Add onclick event to the delete button
                row.find(".delete-button").on("click", function () {
                    // Show Swal confirmation dialog
                    Swal.fire({
                        title: "Are you sure?",
                        text:
                            "You are about to delete PO " +
                            orderNo +
                            ". This action cannot be undone.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                    }).then((result) => {
                        // If user confirms deletion
                        if (result.isConfirmed) {
                            // Send AJAX request to delete the PO
                            $.ajax({
                                url: "/order/delete",
                                type: "DELETE",
                                data: { order_no: orderNo },
                                success: function (response) {
                                    // Handle success
                                    Toastify({
                                        text: response.message,
                                        duration: 3000, // Adjust the duration as needed
                                        gravity: "top", // Show the toast at the bottom of the screen
                                        position: "right", // Show the toast on the right side of the screen
                                        backgroundColor:
                                            "linear-gradient(to right, #00b09b, #96c93d)",
                                        stopOnFocus: true, // Stop the toast when it receives focus
                                    }).showToast();
                                    tablePo();
                                },
                                error: function (xhr, status, error) {
                                    // Handle error
                                    Toastify({
                                        text: "Failed to delete PO",
                                        duration: 3000, // Adjust the duration as needed
                                        gravity: "top", // Show the toast at the bottom of the screen
                                        position: "right", // Show the toast on the right side of the screen
                                        backgroundColor:
                                            "linear-gradient(to right, #ff416c, #ff4b2b)",
                                        stopOnFocus: true, // Stop the toast when it receives focus
                                    }).showToast();
                                },
                            });
                        }
                    });
                });
            });
        },
    });
}

function confirmPo(value, status) {
    let confirmationMessage =
        status === "Confirmed"
            ? "Do you want to view the confirmed PO details?"
            : status === "Progress"
            ? "Do you want to confirm this PO?"
            : status === "Completed"
            ? "Do you want to view the details of this completed PO?"
            : status === "Expired"
            ? "Do you want to view the details of this expired PO?"
            : "Do you want to confirm this PO?";

    Swal.fire({
        title: "Are you sure?",
        text: confirmationMessage,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirm",
    }).then((result) => {
        // Handle the confirmation result
        if (result.isConfirmed) {
            // Show loading spinner
            Swal.fire({
                title: "Please wait...",
                allowOutsideClick: false,
            });
            Swal.showLoading();

            // Perform AJAX request here
            $.ajax({
                url: "/order/" + value + "/show",
                method: "GET",
                success: function (response) {
                    Swal.close();
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    $("#mdlFormContent").html("");

                    if (status == "Progress") {
                        $("#mdlFormTitle").html(
                            "Confirm PO " + response.data.order_no
                        );
                    } else {
                        $("#mdlFormTitle").html(
                            "Detail PO " + response.data.order_no
                        );
                    }
                    // $("#mdlForm").modal("show");
                    $("#mdlFormContent").html(
                        `
                        <div class="row">
                            <form id="formConfirmPo" action="/order/confirmPo" method="POST">
                                <input type="hidden" name="id" value="` +
                            value +
                            `">
                                <div class="form-group">
                                    <label for="estimatedDeliveryDate">Supplier Name</label>
                                    <span name="supplier_name">` +
                            response.data.suppliers.supp_name +
                            `</span>
                                </div>
                                <div class="form-group">
                                    <label for="estimatedDeliveryDateId">Estimated Delivery Date</label>
                                    <input type="date" class="form-control" id="estimatedDeliveryDateId" name="estimatedDeliveryDate">
                                </div>
                                <table class="table table-border">
                                    <thead>
                                        <tr>
                                            <th>SKU</th>
                                            <th>SKU Description</th>
                                            <th>Qty Order</th>
                                            <th id="qtyFullFilledHeader">Qty Full Fillment</th>
                                            <th id="serviceLevelSupplierHeader" style="display: none;">Service Level Supplier</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ordDetailTableBody">
                                        <!-- Table rows will be dynamically added here -->
                                    </tbody>
                                </table>
                                ` +
                            (status === "Progress"
                                ? `
                                    <div class="form-group" id="reasonField" style="display: none;margin-bottom:20px;">
                                        <label for="reason">Reason</label>
                                        <textarea class="form-control" id="reason" name="reason"></textarea>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                                    <button type="button" class="btn btn-danger" id="btnReject"><i class="fas fa-times"></i> Reject</button>
                                    `
                                : "") +
                            `
                            </form>
                        </div>
                        `
                    );

                    // Show the modal
                    $("#mdlForm").modal("show");

                    const notBeforeDate = new Date(
                        response.data.not_before_date
                    );
                    console.log(notBeforeDate);
                    const notAfterDate = new Date(response.data.not_after_date);

                    // Calculate the date 2 days before notAfterDate
                    const twoDaysBeforeNotAfterDate = new Date(notAfterDate);
                    twoDaysBeforeNotAfterDate.setDate(
                        twoDaysBeforeNotAfterDate.getDate() - 2
                    );

                    // Format the dates to 'YYYY-MM-DD'
                    const formatDate = (date) =>
                        date.toISOString().split("T")[0];

                    var estimatedDeliveryDate =
                        response.data.estimated_delivery_date;
                    console.log("masuk sini", estimatedDeliveryDate == null);

                    if (estimatedDeliveryDate != null) {
                        document.getElementById(
                            "estimatedDeliveryDateId"
                        ).value = estimatedDeliveryDate;
                        document.getElementById(
                            "estimatedDeliveryDateId"
                        ).readOnly = true;
                    } else {
                        dateInput = document.getElementById(
                            "estimatedDeliveryDateId"
                        );
                        // Optionally, you can reapply min and max if needed in this case
                        dateInput.min = formatDate(notBeforeDate);
                        dateInput.max = formatDate(twoDaysBeforeNotAfterDate);
                        console.log(twoDaysBeforeNotAfterDate);
                        dateInput.value = formatDate(twoDaysBeforeNotAfterDate);
                    }

                    // Populate the table with details
                    var tableBody = $("#ordDetailTableBody");

                    response.data.ord_detail.forEach(function (detail, index) {
                        var foundDetail = null;
                        if (response.data.receiving != null) {
                            var detailRcv = response.data.receiving.rcv_detail;

                            for (var i = 0; i < detailRcv.length; i++) {
                                if (detailRcv[i].sku === detail.sku) {
                                    foundDetail = detailRcv[i];
                                    break; // Exit the loop if the SKU is found
                                }
                            }
                        }

                        // Check if qty_fulfilled is null and set it to 0 if it is
                        if (detail.qty_fulfilled === null) {
                            detail.qty_fulfilled = 0;
                        }

                        var row = $("<tr>");
                        row.append(
                            '<td style="display:none;">' +
                                '<input type="hidden" name="order_id[]" value="' +
                                detail.id +
                                '">' +
                                '<input type="hidden" name="order_no[]" value="' +
                                detail.order_no +
                                '">' +
                                "</td>"
                        );
                        row.append("<td>" + detail.sku + "</td>");
                        row.append("<td>" + detail.sku_desc + "</td>");
                        row.append("<td>" + detail.qty_ordered + "</td>");

                        if (
                            status === "Confirmed" ||
                            status === "Expired" ||
                            status === "Completed"
                        ) {
                            // If status is 'confirmed', set qty_fulfilled to span
                            if (detail.qty_fulfilled != 0) {
                                console.log("masuk 1");
                                $("#qtyFullFilledHeader").html(
                                    "Qty Full Filled"
                                );
                                row.append(
                                    "<td><span>" +
                                        detail.qty_fulfilled +
                                        "</span></td>"
                                );
                            } else {
                                console.log("masuk 2");
                                if (foundDetail != null) {
                                    if (
                                        foundDetail.qty_expected ==
                                        foundDetail.qty_received
                                    ) {
                                        $("#qtyFullFilledHeader").html(
                                            "Qty Received"
                                        );
                                        row.append(
                                            "<td><span>" +
                                                foundDetail.qty_received +
                                                "</span></td>"
                                        );
                                    } else {
                                        $("#qtyFullFilledHeader").html(
                                            "Qty Full Filled"
                                        );
                                        row.append(
                                            "<td><span>" +
                                                foundDetail.qty_received +
                                                "</span></td>"
                                        );
                                    }
                                } else {
                                    row.append(
                                        "<td><span>" +
                                            detail.qty_fulfilled +
                                            "</span></td>"
                                    );
                                }
                            }
                        } else {
                            console.log("masuk 3");

                            // Create the input field if status is not 'confirmed'
                            var readonly =
                                detail.qty_ordered ===
                                parseInt(detail.qty_fulfilled);
                            var inputField = $("<input>", {
                                type: "text",
                                name: "qty_fulfilled[]",
                                id: "qty_fulfilled_" + detail.id,
                                class: "form-control",
                                value: detail.qty_ordered, // Use the updated qty_fulfilled value
                                placeholder: "Enter Quantity Fulfilled",
                                readonly: readonly,
                            });
                            var cell = $("<td>").append(inputField);
                            row.append(cell);
                        }

                        if (status === "Completed") {
                            document.getElementById(
                                "serviceLevelSupplierHeader"
                            ).style.display = "table-cell";

                            // Check if service_level is null, if so, set it to 0
                            let serviceLevel = foundDetail.service_level;
                            if (serviceLevel === null) {
                                serviceLevel = 0;
                            }

                            row.append(
                                "<td><span>" + serviceLevel + "%</span></td>"
                            );
                        }

                        tableBody.append(row);

                        // Set the detail ID value when a row is clicked
                        row.find(".edit-btn").click(function (event) {
                            event.preventDefault(); // Prevent default action of the edit button

                            // Remove readonly attribute when clicking the edit button
                            if (status !== "confirmed") {
                                inputField.prop("readonly", false);
                                // Optionally, you can focus on the input field for better user experience
                                inputField.focus();
                            }
                        });
                    });

                    $("#btnReject").click(function () {
                        // Show the reason field when the reject button is clicked
                        $("#reasonField").show();
                    });

                    $("#formConfirmPo").validate({
                        ignore: [],
                        rules: {
                            estimatedDeliveryDate: {
                                required: true,
                            },
                            "qty_fulfilled[]": {
                                required: true,
                            },
                        },
                        messages: {
                            estimatedDeliveryDate: {
                                required:
                                    "Please enter the estimated delivery date",
                            },
                            "qty_fulfilled[]": {
                                required: "Please enter the quantity fulfilled",
                            },
                        },
                        highlight: function (element) {
                            $(element).addClass("is-invalid");
                        },
                        unhighlight: function (element) {
                            $(element).removeClass("is-invalid");
                        },
                        submitHandler: function (form) {
                            // If the form is valid, submit it via AJAX
                            event.preventDefault();
                            swal.fire({
                                title: "Are you sure?",
                                text: "Do you want to confirm this po ?",
                                icon: "question",
                                showCancelButton: true,
                                confirmButtonText: "Yes",
                                cancelButtonText: "No",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // If user confirms, submit the form via AJAX
                                    $.ajax({
                                        url: $(form).attr("action"),
                                        method: $(form).attr("method"),
                                        data: $(form).serialize(),
                                        headers: {
                                            "X-CSRF-TOKEN": $(
                                                'meta[name="csrf-token"]'
                                            ).attr("content"),
                                        },
                                        success: function (response) {
                                            // Check if the response indicates success
                                            if (response.success) {
                                                // Display a success message with SweetAlert
                                                Swal.fire({
                                                    icon: "success",
                                                    title: response.message,
                                                    timer: 2000, // Set the timer for 2 seconds
                                                    showConfirmButton: false, // Hide the confirm button
                                                });
                                                $("#mdlForm").modal("hide");
                                                tablePo();
                                                // Optionally, perform other actions after the success message
                                            } else {
                                                // Display a generic error message with SweetAlert
                                                Swal.fire({
                                                    icon: "error",
                                                    title: "An error occurred",
                                                    text: "The operation could not be completed. Please try again later.",
                                                });
                                            }

                                            // Optionally, perform other actions after handling the response
                                        },
                                        error: function (xhr, status, error) {
                                            console.error("Error:", error);
                                            // Optionally, display an error message or perform other actions
                                        },
                                    });
                                }
                            });
                        },
                    });
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error("Error:", error);
                    // Hide loading spinner
                    Swal.close();
                    // Optionally, display an error message or perform other actions
                },
            });
        }
    });
}

function openHistoryPrint(value) {
    Swal.fire({
        title: "Loading...",
        html: "Please wait while we fetch the data",
        icon: "info",
        showConfirmButton: false,
        allowOutsideClick: false, // Prevent users from clicking outside the Swal modal
    });

    $.ajax({
        url: "/order/" + value + "/print", // URL to fetch data (replace with your actual endpoint)
        type: "GET",
        success: function (response) {
            console.log(response);
            if (response.data.length > 0) {
                Swal.close();
                // Handle success response
                Swal.fire({
                    title: "Success",
                    text: response.message,
                    icon: response.icon,
                    showConfirmButton: false,
                    timer: 1000,
                });
                $("#mdlForm").modal("show");
                $("#mdlFormContent").html("");
                $("#mdlFormTitle").html("History Print");

                // Construct the table
                var table = $('<table class="table"></table>');
                var thead = $(
                    "<thead><tr><th>ID</th><th>Order No</th><th>User ID</th><th>Description</th></tr></thead>"
                );
                var tbody = $("<tbody></tbody>");

                // Append table header to table
                table.append(thead);

                // Iterate through the data array to create table rows
                response.data.forEach(function (entry) {
                    var row = $("<tr></tr>");
                    row.append("<td>" + entry.id + "</td>");
                    row.append("<td>" + entry.order_no + "</td>");
                    row.append("<td>" + entry.user.name + "</td>");
                    row.append("<td>" + entry.description + "</td>");
                    tbody.append(row);
                });

                // Append table body to table
                table.append(tbody);

                // Append the table to #mdlFormContent
                $("#mdlFormContent").append(table);
            } else {
                Swal.close();
                // Handle success response
                Swal.fire({
                    title: "Success",
                    text: "Not found history print this order",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1000,
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: "Error",
                text: "An error occurred while fetching data.",
                icon: "error",
                showConfirmButton: false,
                timer: 1000,
            });
        },
    });
}

function openDetailPo(value) {
    // Show loading state while waiting for the AJAX response
    Swal.fire({
        title: "Loading...",
        html: "Please wait while we fetch the data",
        icon: "info",
        showConfirmButton: false,
        allowOutsideClick: false, // Prevent users from clicking outside the Swal modal
    });

    $.ajax({
        url: "/order/" + value + "/show", // URL to fetch data (replace with your actual endpoint)
        type: "GET",
        success: function (response) {
            Swal.close();
            Swal.fire({
                title: response.title,
                text: response.message,
                icon: "success",
                timer: 1000, // Timer in milliseconds (3 seconds in this example)
                timerProgressBar: true, // Display a progress bar as the timer counts down
                showConfirmButton: false,
            });
            $("#mdlForm").modal("show");
            $("#mdlFormContent").html("");
            $("#mdlFormTitle").html("Detail Order");
            $("#mdlForm .modal-dialog").addClass("modal-lg");
            $("#mdlFormContent").append(
                `
                <div class="fv-row mb-7" id="divPrintPo">
                    <button class="btn btn-primary btn-sm" onclick="printPO(` +
                    response.data.order_no +
                    `)">
                        <i class="fas fa-print"></i> Cetak PO
                    </button>
                </div>
                <form id="showPO" class="form" action="#" style="background-color:white;color:black;">
                    <input type="hidden" class="form-control form-control-solid" placeholder="Enter a permission name" name="id" id="id" />
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            Order No
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <h5 id="order_no_txt" style="color:black;"></h5>
                        <!--end::Input-->
                    </div>
                    <div class="fv-row mb-7">
                        <div class="row">
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Store No
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="store_id" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Store Name
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="store_name" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Store Address
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="store_add1" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Store Address
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="store_add2" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Approval
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="approval_id" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Order Date
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="approval_date" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Delivery Before
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="not_before_date" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Expired Date
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="not_after_date" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Supplier
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="supplier_id" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Supplier Name
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="supplier_name" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Supplier Address
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="address_1" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                            <div class="col-md-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Contact Name
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <h5 id="contact_name" style="color:black;"></h5>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mb-2">
                                    Status
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <span id="statusPoBadge" class="badge"><i id="statusIcon" class=""></i>  <span id="statusPo"></span></span>
                                <!--end::Input-->
                            </div>

                        </div>
                    </div>
                </form>
                <div class="fv-row mb-7">
                    <div class="table-responsive">
                        <table id="detailOrder" class="table table-bordered" style="border-width: 2px;">
                            <thead style="font-wight:bold;text-style:center;">
                                <tr>
                                    <th>ACTION</th>
                                    <th>SKU</th>
                                    <th>UPC</th>
                                    <th>Description</th>
                                    <th>Tag</th>
                                    <th>Qty/Case</th>
                                    <th colspan="2">Unit Order</th>
                                    <th>Total</th>
                                    <th>Unit Cost</th>
                                    <th>Regular</th>
                                    <th>Discount</th>
                                    <th>Total Cost</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Code</th>
                                    <th></th>
                                    <th style="text-align: center;">Qty</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th></th>
                                    <th>Discount (%)</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTable will populate rows here -->
                            </tbody>
                            <tfoot style="color:black;">
                                <tr style="color:black;">
                                    <th colspan="11" style="text-align:right" style="color:black;">TOTAL DISCOUNT :</th>
                                    <th></th>
                                    <th id="totalDiscount"></th>
                                </tr>
                                <tr>
                                    <th colspan="11" style="text-align:right" style="color:black;">TOTAL (before PPN) :</th>
                                    <th></th>
                                    <th id="totalSubtotal"></th>
                                </tr>
                                <tr>
                                    <th colspan="11" style="text-align:right" style="color:black;">PPN :</th>
                                    <th></th>
                                    <th id="totalPpn"></th>
                                </tr>
                                <tr>
                                    <th colspan="11" style="text-align:right" style="color:black;">TOTAL (after PPN - Discount) :</th>
                                    <th></th>
                                    <th id="totalIncludingPpn"></th>
                                </tr>
                            </tfoot>
                        </table>
                        <br>
                        <table style="width: 100%; font-size: 13px">
                            <tbody>
                                <tr>
                                    <td style="width: 5%; vertical-align: top;">Note :</td>
                                    <td><textarea name="" id="po_note" cols="30" rows="10" style="width: 95%; height: auto; border: none;"></textarea></td>
                                </tr>
                                <tr>
                                    <td style="width: 5%; vertical-align: top;"></td>
                                    <td><textarea name="" id="fax_note" cols="30" rows="10" style="width: 95%; height: auto; border: none;"></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                    <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            Comment Desc
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <h5 id="comment_desc" style="color:black;"></h5>
                        <!--end::Input-->
                    </div>
                    <div class="col-md-4">
                    <!--begin::Label-->
                        <label class="fs-6 fw-semibold form-label mb-2">
                            Approved by,
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <h5 id="approved_by" style="color:black;"></h5>
                        <!--end::Input-->
                    </div>

                </div>
            `
            );


            if (response.data.stores != null) {
                $("#store_id").text(response.data.stores.store || "Not Found Data");
                $("#store_name").text(response.data.stores.store_name || "Not Found Data");
                $("#store_add1").text(response.data.stores.store_add1 || "Not Found Data");
                $("#store_add2").text(response.data.stores.store_add2 || "Not Found Data");
            } else {
                $("#store_id").text(response.data.ship_to || "Not Found Data");
                if (response.data.ship_to == "40") {
                    $("#store_name").text("DC MINIMART");
                    $("#store_add1").text("Not Found Data");
                    $("#store_add2").text("Not Found Data");
                } else if (response.data.ship_to == "900") {
                    $("#store_name").text("DC Lombok");
                    $("#store_add1").text("Not Found Data");
                    $("#store_add2").text("Not Found Data");
                } else if (response.data.ship_to == "910") {
                    $("#store_name").text("DC Makasar");
                    $("#store_add1").text("Not Found Data");
                    $("#store_add2").text("Not Found Data");
                } else {
                    $("#store_name").text("Not Found Data");
                    $("#store_add1").text("Not Found Data");
                    $("#store_add2").text("Not Found Data");
                }
            }
            $("#order_no_txt").text(response.data.order_no || "Not Found Data");

            $("#approval_id").text(response.data.approval_id || "Not Found Data");
            $("#approval_date").text(response.data.approval_date ? formatDate(response.data.approval_date) : "Not Found Data");
            $("#supplier_id").text(response.data.suppliers.supp_code || "Not Found Data");
            $("#supplier_name").text(response.data.suppliers.supp_name || "Not Found Data");
            $("#not_after_date").text(response.data.not_after_date ? formatDate(response.data.not_after_date) : "Not Found Data");
            $("#comment_desc").text(response.data.comment_desc || "Not Found Data");
            $("#approved_by").text("PUTU SUSIMADEWI" || "Not Found Data");
              // Set data to the 'po_note' textarea
              if (response.data.system_variable) {
                document.getElementById('po_note').value = response.data.system_variable.po_note;
                document.getElementById('fax_note').value = response.data.system_variable.fax_note;
            } else {
                console.error('system_variable or po_note is undefined.');
            }

            // Set data to the 'fax_note' textarea

            const statusText = response.data.status || "Not Found Data";
            $("#statusPo").text(statusText);

            // Determine the icon class based on the status
            let iconClass = "";
            let badgeClass = "badge"; // base class for badge

            if (statusText === "Completed") {
                iconClass = "fas fa-check-circle";
                badgeClass += " badge-success"; // green badge for completed
            } else if (statusText === "Progress") {
                iconClass = "fas fa-clock";
                badgeClass += " badge-warning"; // yellow badge for pending
            } else if (statusText === "Expired") {
                iconClass = "fas fa-times-circle";
                badgeClass += " badge-danger"; // red badge for rejected
            } else {
                iconClass = "fas fa-exclamation-circle";
                badgeClass += " badge-secondary"; // gray badge for not found or unknown
            }

            // Update the icon and badge classes
            $("#statusIcon").attr("class", iconClass);
            $("#statusPoBadge").attr("class", badgeClass);
            console.log(response.data.not_before_date);
            $("#not_before_date").text(
                formatDate(response.data.not_before_date)
            );

            $("#address_1").text(response.data.suppliers.address_1);
            $("#contact_name").text(response.data.suppliers.contact_name);

            var printPOPermission = $("#printPOPermission").data("print-po");
            if (printPOPermission == false) {
                $("#divPrintPo").hide();
            } else {
                $("#divPrintPo").show();
            }
            $("#detailOrder").DataTable({
                data: response.data.ord_detail, // Provide your data here
                paginate: false,
                responsive: true,
                columns: [
                    {
                        data: "id",
                        render: function (data, type, row) {
                            return `<i class="fas fa-trash delete-btn" title="Delete Detail" onclick="deleteDetail(${data})"></i>`;
                        },
                    },
                    { data: "sku" },
                    { data: "upc" },
                    { data: "sku_desc" },
                    { data: "tag_code" },
                    { data: "supp_pack_size" },
                    {
                        data: null, // This column will display the qty_ordered / supp_pack_size
                        render: function (data, type, row) {
                            var qtyPerPackSize = row.qty_ordered / row.supp_pack_size;
                            return qtyPerPackSize.toFixed(2); // Display result with 2 decimal places
                        },
                    },
                    { data: "purchase_uom" },
                    { data: "qty_ordered" },
                    {
                        data: "unit_cost",
                        render: function (data, type, row) {
                            // Format unit_cost as Rupiah
                            return formatRupiahs(Number(data));
                        },
                    },
                    {
                        data: "permanent_disc_pct",
                        render: function (data, type, row) {
                            // Set default value to 0 if data is null
                            return data !== null ? data : 0;
                        },
                    },
                    { data: null, render: function () { return ""; } },
                    {
                        data: null, // This column will display the subtotal
                        render: function (data, type, row) {
                            // Calculate the subtotal
                            var subtotal = row.unit_cost * row.qty_ordered;
                            // Format the subtotal as Rupiah
                            return formatRupiahs(subtotal);
                        },
                    },
                ],
                createdRow: function (row, data, dataIndex) {
                    // Get the 'order_no' and 'sku' values of the current row
                    var currentOrderNo = data.order_no;
                    var currentSku = data.sku;

                    // Filter the ord_detail data to count rows with the same 'order_no' and 'sku'
                    var duplicateCount = response.data.ord_detail.filter(
                        (item) => item.order_no === currentOrderNo && item.sku === currentSku
                    ).length;

                    // If there are more than one rows with the same 'order_no' and 'sku', set text color to red
                    if (duplicateCount > 1) {
                        $(row).children("td:not(:first-child)").addClass("text-danger"); // Add class to all td except the first one
                    } else {
                        // Add checkmark icon in the first column
                        $(row).children("td:first-child").html('<i class="fas fa-check"></i>');
                    }
                },
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    var totalDiscount = api
                        .column(10, { page: "current" })
                        .data()
                        .reduce(function (a, b) {
                            return a + parseFloat(b) || 0;
                        }, 0);

                    var totalSubtotal = api
                        .column(11, { page: "current" })
                        .data()
                        .reduce(function (a, b) {
                            var subtotal = b.unit_cost * b.qty_ordered;
                            return a + subtotal || 0;
                        }, 0);

                    var totalPpn = data.reduce(function (a, item) {
                        var ppn = item.qty_ordered * item.vat_cost;
                        return a + ppn || 0;
                    }, 0);

                    var totalIncludingPpn = totalSubtotal + totalPpn - totalDiscount;

                    // Update footer with the totals
                    $("#totalDiscount").html(formatRupiahs(totalDiscount)); // Display total discount
                    $("#totalSubtotal").html(formatRupiahs(totalSubtotal));
                    $("#totalPpn").html(formatRupiahs(totalPpn)); // No rounding
                    $("#totalIncludingPpn").html(formatRupiahs(totalIncludingPpn)); // No rounding
                },
                rowCallback: function (row, data, index) {
                    // Check if qty_ordered is 0, and hide the row if it is
                    if (data.qty_ordered === 0) {
                        $(row).hide();
                    }
                },
                responsive: true, // Add this option for responsiveness
                processing: true, // Display processing indicator
                initComplete: function () {
                    var api = this.api();

                    // Calculate and set column widths
                    api.columns().every(function () {
                        var column = this;
                        var maxWidth = 0;

                        $(column.footer()).find('input').each(function () {
                            var input = $(this);
                            var textWidth = input.width();
                            if (textWidth > maxWidth) {
                                maxWidth = textWidth;
                            }
                        });

                        $(column.header()).css('width', maxWidth + 'px');
                        $(column.footer()).css('width', maxWidth + 'px');
                    });
                },
            });




        },
    });
}




function formatDate(dateStr) {
    const options = { year: "numeric", month: "short", day: "numeric" };
    return new Date(dateStr).toLocaleDateString(undefined, options);
}



function formatRupiahs(value) {
    // Ensure the value is a number
    const number = parseFloat(value);

    // Convert the number to a string with a dynamic number of decimal places
    const formattedValue = number.toLocaleString("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        maximumFractionDigits: 4,
    });

    return formattedValue;
}

function deleteDetail(value) {
    console.log(value);
    Swal.fire({
        title: "Delete Detail",
        text: "Are you sure you want to delete this detail?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Call your delete function here or perform delete action
            deleteDetail(value);
        }
    });
}

function deleteDetail(id) {
    // Perform AJAX request to delete detail
    // Example:
    $.ajax({
        url: `order/deleteSku`,
        method: "DELETE",
        data: {
            id: id,
        },
        success: function (response) {
            // Handle success response
            Swal.fire({
                title: response.title,
                text: response.message,
                icon: "success",
                timer: 1000, // Timer in milliseconds (3 seconds in this example)
                timerProgressBar: true, // Display a progress bar as the timer counts down
                showConfirmButton: false,
            });
            $("#mdlForm").modal("hide");
            $("#mdlFormContent").html("");
            openDetailPo(response.data.id);
        },
        error: function (xhr, status, error) {
            // Handle error response
            Swal.fire({
                title: xhr.statusText,
                text: xhr.responseText,
                icon: "error",
                timer: 1000, // Timer in milliseconds (3 seconds in this example)
                showConfirmButton: false,
            });
        },
    });
}

function formatRupiah(angka) {
    var reverse = angka.toString().split("").reverse().join(""),
        ribuan = reverse.match(/\d{1,3}/g);
    ribuan = ribuan.join(".").split("").reverse().join("");
    return ribuan;
}

function printPO(value) {
    Swal.fire({
        title: "Print Purchase Order",
        html: `
            Are you sure you want to print the Purchase Order no: ${value} ?
        `,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Print",
        imageUrl: "img/printer.png", // Replace with the actual path to your image
        imageWidth: 100,
        imageHeight: 100,
    }).then((result) => {
        if (result.isConfirmed) {
            // Initiate AJAX download
            $.ajax({
                url: "order/pdf",
                method: "GET",
                data: {
                    id: value,
                },
                xhrFields: {
                    responseType: "json", // Set response type to JSON
                },
                success: function (data) {
                    if (data != null) {
                        $("#pdfViewer").attr(
                            "src",
                            "data:application/pdf;base64," + data.pdf
                        );
                        $("#pdfModal").modal("show");
                    }

                    var blob = new Blob([data]);
                    var fileName = "po_" + value + ".pdf"; // Specify desired file name

                    // Create a temporary URL and initiate download
                    var link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);
                    link.download = fileName;
                    link.click();

                    var newWindow = window.open(
                        "order/pdf?id=" + value,
                        "_blank"
                    );
                    if (
                        !newWindow ||
                        newWindow.closed ||
                        typeof newWindow.closed == "undefined"
                    ) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Your browser blocked the new window, please allow pop-ups for this site and try again.",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr, status, error);

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Error downloading file. Maximum download limit for PO exceeded.",
                        didOpen: () => {
                            Swal.showLoading(); // Show a spinner when the modal opens
                        },
                    });

                    // Close the modal after 5 seconds (5000 milliseconds)
                    setTimeout(() => {
                        Swal.close();
                        $("#pdfModal").modal("show");
                    }, 2000);
                },
            });
        }
    });
}
