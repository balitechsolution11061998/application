$(document).ready(function () {

    fetchPoData();
    fetchPoDataPerDays();
    fetchTimelineConfirmedData();
    // fetchMataPelajaranData();
    fetchQueryPerformanceLogs();
});
document
    .getElementById("filter-date")
    .addEventListener("change", fetchPoDataPerDays);

    function initializeCalendar(events) {
        var calendarEl = document.getElementById("calendar");

        if (!calendarEl) {
            console.error("Calendar element not found.");
            return;
        }

        if (calendar) {
            calendar.destroy(); // Destroy existing calendar instance if it exists
        }

        try {
            calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
                },
                height: 600,
                nowIndicator: true,
                initialView: "dayGridMonth",
                editable: false,
                dayMaxEvents: true,
                events: events.map(event => {
                    const eventDate = moment(event.start).format('YYYY-MM-DD');
                    const todayDate = moment().format('YYYY-MM-DD');

                    return {
                        ...event,
                        classNames: eventDate === todayDate ? 'bg-warning' : 'bg-purple', // Conditional styling
                        extendedProps: {
                            htmlContent: `
                                <div class="event-content d-flex align-items-center">
                                    <i class="fas fa-truck text-white fs-4 me-2"></i>
                                    <span class="text-black">${event.title}</span>
                                </div>
                            ` // FontAwesome truck icon with title
                        }
                    };
                }),
                eventContent: function(info) {
                    // Render HTML content from extendedProps
                    return { html: info.event.extendedProps.htmlContent };
                },
                eventsSet: function() {
                    // Add any additional logic if needed
                }
            });

            calendar.render();
        } catch (error) {
            console.error("Error initializing calendar:", error);
        }
    }









// Button click to show modal and initialize calendar
$("#deliveryModalBtn").on("click", function () {
    $("#mdlForm").modal("show");
    $("#mdlFormTitle").html("Delivery Schedule");
    $("#mdlFormContent").html(`
            <div class="spinner-container d-flex justify-content-center align-items-center">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            <div id="calendar" style="height: 600px;"></div>
        `);
    fetchTimelineConfirmedData(); // Fetch and display data when modal is shown
});

function fetchHistoryUjian() {
    $.ajax({
        url: '/ujian/fetchHistory',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            let tableBody = $('#historyUjian-table-body');
            tableBody.empty(); // Clear any existing data

            // Iterate over the data and append rows to the table
            data.forEach(function(row) {
                tableBody.append(`
                    <tr>
                        <td>${row.siswa_name}</td>
                        <td>${row.rombel_name} - ${row.kelas_name}</td>
                        <td>${row.jumlah_benar}</td>
                        <td>${row.jumlah_salah}</td>
                        <td>${row.total_nilai}</td>
                    </tr>
                `);
            });

            $('#spinner-detail').hide(); // Hide spinner after data is loaded
        },
        error: function() {
            $('#spinner-detail').hide();
            alert('Failed to load data');
        }
    });
}


function fetchStudentData() {
    document.getElementById('spinner-student').style.display = 'block';

    fetch('/siswa/getStudentData')
        .then(response => response.json())
        .then(data => {
            document.getElementById('spinner-student').style.display = 'none';

            document.getElementById('student-content').textContent = data.total;
            document.getElementById('male-count').textContent = `Laki-laki: ${data.male}`;
            document.getElementById('female-count').textContent = `Perempuan: ${data.female}`;

            // Handle the Rombel and Kelas counts
            let rombelTableBody = document.getElementById('rombel-table-body');

            // Clear existing rows
            rombelTableBody.innerHTML = '';

            for (let [rombelKelas, count] of Object.entries(data.rombelKelasCounts)) {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td>${rombelKelas}</td>
                    <td>${count}</td>
                `;
                rombelTableBody.appendChild(row);
            }
        })
        .catch(error => {
            console.error('Error fetching student data:', error);
            document.getElementById('spinner-student').style.display = 'none';
        });
}




function fetchTimelineConfirmedData() {
    var apiUrl = "/po/delivery";
    var timelineContainer = $(".timeline-container");
    var spinnerContainer = $(".spinner-container");
    var threshold = 10; // Set your threshold value here
    var todayDate = moment().startOf("day");
    var tomorrowDate = todayDate.clone().add(1, "day").format("YYYY-MM-DD");
    var deliveriesForTomorrowCount = 0; // Variable to store count of deliveries for tomorrow

    // Show the spinner
    spinnerContainer.removeClass("d-none");

    $.ajax({
        url: apiUrl,
        method: "GET",
        success: function (response) {
            var totalDeliveries = response.data.length; // Total number of deliveries
            var deliveryTrackingTitle = "Delivery Tracking";
            var deliveriesInProgress =
                totalDeliveries + " deliveries in progress";

            // Update card title and count
            $("#delivery-tracking-title").text(deliveryTrackingTitle);
            $("#deliveries-in-progress").text(deliveriesInProgress);

            // Update confirmed deliveries count
            var confirmedCountElement = $("#confirmed-count");
            confirmedCountElement.text(`Confirmed (${totalDeliveries})`);

            // Add alert-red class if totalDeliveries exceeds the threshold
            if (totalDeliveries > threshold) {
                confirmedCountElement.addClass("alert-red");
            } else {
                confirmedCountElement.removeClass("alert-red");
            }

            timelineContainer.empty(); // Clear previous content

            var events = [];

            response.data.forEach(function (item, index) {
                // Calculate animation delay based on the index
                var delay = index * 100; // Adjust delay as needed

                // Determine which address to use
                var storeAddress = item.stores.store_add1
                    ? item.stores.store_add1
                    : item.stores.store_add2;

                // Add event to the calendar
                events.push({
                    title: "Delivery for " + item.stores.store_name,
                    start: item.estimated_delivery_date,
                    description: `Order No: ${item.order_no}`,
                });

                // Check if delivery is scheduled for tomorrow
                if (item.estimated_delivery_date === tomorrowDate) {
                    deliveriesForTomorrowCount++;
                }

                var timelineItem = `
                        <!--begin::Item-->
                        <div class="timeline-item mb-4 animate-show" style="--i: ${
                            index + 1
                        }; animation-delay: ${delay}ms;">
                            <!--begin::Timeline-->
                            <div class="timeline timeline-border-dashed">
                                <!--begin::Timeline item-->
                                <div class="timeline-item pb-4 text-left">
                                    <!--begin::Timeline line-->
                                    <div class="timeline-line"></div>
                                    <!--end::Timeline line-->
                                    <!--begin::Timeline icon-->
                                    <div class="timeline-icon bg-success text-white">
                                        <i class="ki-outline ki-cd fs-3" style="color:white;"></i>
                                    </div>
                                    <!--end::Timeline icon-->
                                    <!--begin::Timeline content-->
                                    <div class="timeline-content ms-3">
                                        <!--begin::Label-->
                                        <span class="fs-7 fw-bolder text-success text-uppercase">Store</span>
                                        <!--end::Label-->
                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 text-gray-800 fw-bold d-block text-hover-primary">${
                                            item.stores.store_name
                                        }</a>
                                        <!--end::Title-->
                                        <!--begin::Address-->
                                        <span class="fw-semibold text-gray-500">${storeAddress}</span>
                                        <!--end::Address-->

                                        <!--begin::Order Number-->
                                        <span class="fw-semibold text-gray-500">Order No: ${
                                            item.order_no
                                        }</span>
                                        <!--end::Order Number-->
                                    </div>
                                    <!--end::Timeline content-->
                                </div>
                                <!--end::Timeline item-->
                                <!--begin::Timeline item-->
                                <div class="timeline-item pb-4 text-left">
                                    <!--begin::Timeline line-->
                                    <div class="timeline-line"></div>
                                    <!--end::Timeline line-->
                                    <!--begin::Timeline icon-->
                                    <div class="timeline-icon bg-info text-white">
                                        <i class="ki-outline ki-geolocation fs-3" style="color:white;"></i>
                                    </div>
                                    <!--end::Timeline icon-->
                                    <!--begin::Timeline content-->
                                    <div class="timeline-content ms-3">
                                        <!--begin::Label-->
                                        <span class="fs-7 fw-bolder text-info text-uppercase">Estimated Delivery</span>
                                        <!--end::Label-->
                                        <!--begin::Title-->
                                        <span class="fs-5 text-gray-800 fw-bold d-block">${
                                            item.estimated_delivery_date
                                        }</span>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Timeline content-->
                                </div>
                                <!--end::Timeline item-->
                            </div>
                            <!--end::Timeline-->
                        </div>
                        <!--end::Item-->
                    `;
                timelineContainer.append(timelineItem);
            });

            // Show alert if there are deliveries scheduled for tomorrow
            if (deliveriesForTomorrowCount > 0) {
                $("#deliveryAlert")
                    .text(
                        `Note: There are ${deliveriesForTomorrowCount} deliveries scheduled for tomorrow.`
                    )
                    .removeClass("d-none");
            } else {
                $("#deliveryAlert").addClass("d-none");
            }

            // Initialize and render the calendar with fetched events
            initializeCalendar(events);

            // Hide the spinner after data is loaded
            spinnerContainer.addClass("d-none");
        },
        error: function (error) {
            console.error("Error fetching timeline data", error);

            // Hide the spinner if there is an error
            spinnerContainer.addClass("d-none");
        },
    });
}

async function fetchQueryPerformanceLogs() {
    $('#queryPerformance-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/query-performance-logs',
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'function_name', name: 'function_name' },
            { data: 'avg_execution_time', name: 'avg_execution_time' },
            { data: 'avg_ping', name: 'avg_ping' },
            { data: 'avg_download_speed', name: 'avg_download_speed' },
            { data: 'avg_upload_speed', name: 'avg_upload_speed' }
        ],
        columnDefs: [
            { targets: [0], orderable: false } // Disable ordering for the index column
        ]
    });
}

async function fetchPoDataPerDays() {
    const spinner = document.getElementById("spinner-po");
    const filterSelect = document.getElementById("filter-select");
    const filterDate = document.getElementById("filter-date");
    const showExpired = document.getElementById("show-expired");
    const showCompleted = document.getElementById("show-completed");
    const showConfirmed = document.getElementById("show-confirmed");
    const showInProgress = document.getElementById("show-in-progress");

    spinner.style.display = "block";

    const selectedMonth = filterDate.value;

    try {
        const apiUrl = selectedMonth
            ? `/home/countDataPoPerDays?filterDate=${selectedMonth}`
            : "/home/countDataPoPerDays";
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();

        const dates = data.data.dailyData.map((item) => item.date);
        const expired = data.data.dailyData.map((item) => item.expired);
        const completed = data.data.dailyData.map((item) => item.completed);
        const confirmed = data.data.dailyData.map((item) => item.confirmed);
        const inProgress = data.data.dailyData.map((item) => item.in_progress);
        const totalCost = data.data.dailyData.map((item) => item.total_cost);

        function formatRupiah(value) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(value);
        }

        function initializeChart() {
            const seriesName = [];
            const seriesData = [];
            const seriesColors = [];

            if (showExpired.checked) {
                seriesName.push("Expired");
                seriesData.push(expired);
                seriesColors.push("#dc3545");
            }
            if (showCompleted.checked) {
                seriesName.push("Completed");
                seriesData.push(completed);
                seriesColors.push("#28a745");
            }
            if (showConfirmed.checked) {
                seriesName.push("Confirmed");
                seriesData.push(confirmed);
                seriesColors.push("#007bff");
            }
            if (showInProgress.checked) {
                seriesName.push("In Progress");
                seriesData.push(inProgress);
                seriesColors.push("#ffc107");
            }

            if (chart) {
                chart.destroy();
            }

            const options = {
                series: seriesData.map((data, index) => ({
                    name: seriesName[index],
                    data: data,
                    color: seriesColors[index],
                })),
                chart: {
                    height: 350,
                    type: "bar",
                    toolbar: {
                        show: true,
                    },
                    events: {
                        dataPointSelection: function (
                            event,
                            chartContext,
                            config
                        ) {
                            const selectedDate = dates[config.dataPointIndex];
                            const selectedStatus = seriesName[config.seriesIndex];
                            openModal(selectedDate,selectedStatus);
                        },
                    },
                    title: {
                        text: "Data Jumlah PO Per Tanggal",
                        align: "left",
                        margin: 10,
                        offsetX: 0,
                        offsetY: 0,
                        floating: false,
                        style: {
                            fontSize: "16px",
                            fontWeight: "bold",
                            color: "#263238",
                        },
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "55%",
                        endingShape: "rounded",
                        borderRadius: 9,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["transparent"],
                },
                xaxis: {
                    categories: dates,
                },
                yaxis: {
                    title: {
                        text: "Jumlah",
                    },
                    labels: {
                        formatter: function (value) {
                            return value;
                        },
                    },
                },
                fill: {
                    opacity: 1,
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val;
                        },
                    },
                },
            };

            chart = new ApexCharts(
                document.querySelector("#kt_apexcharts_1"),
                options
            );
            chart.render();
        }
        function openModal(date, status) {
            const modal = new bootstrap.Modal(document.getElementById("detailModal"));
            document.getElementById("modalTitle").textContent = `Details for ${date} - ${status}`;

            // Clear any existing content in the modal body
            const modalBody = document.getElementById("modalBody");
            modalBody.innerHTML = `
                <form id="searchForm" class="mb-3">
                    <div class="d-flex align-items-center">
                        <input type="text" id="searchInput" class="form-control form-control-sm me-2" placeholder="Search...">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <span id="searchSpinner" class="d-none ms-2">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </div>
                </form>
                <div id="tableContainer"></div>
            `;

            // Fetch and display additional details for the selected date and status
            fetch(`/home/countDataPoPerDate?date=${date}&status=${status}`)
                .then((response) => response.json())
                .then((data) => {
                    if (data.data.length > 0) {
                        // Create a table element
                        const table = document.createElement("table");
                        table.id = "detailsTable";
                        table.classList.add("table", "table-striped", "table-bordered");

                        // Create the table header
                        const thead = document.createElement("thead");
                        let estimatedDeliveryDateHeader = 'Estimated Delivery Date';

                        // Change the header text if status is 'In Progress'
                        if (status === 'In Progress') {
                            estimatedDeliveryDateHeader = 'Expired Date';
                        }

                        thead.innerHTML = `
                            <tr>
                                <th>PO Number</th>
                                <th>Status</th>
                                <th>${estimatedDeliveryDateHeader}</th>
                            </tr>
                        `;
                        table.appendChild(thead);

                        // Create the table body
                        const tbody = document.createElement("tbody");

                        data.data.forEach((item) => {
                            const tr = document.createElement("tr");

                            // Determine the text for the 'Estimated Delivery Date' based on the status
                            let estimatedDeliveryDate;
                            if (status === 'In Progress') {
                                estimatedDeliveryDate = item.not_after_date;
                            } else {
                                estimatedDeliveryDate = item.estimated_delivery_date;
                            }

                            tr.innerHTML = `
                                <td>${item.order_no}</td>
                                <td>${item.status}</td>
                                <td>${estimatedDeliveryDate}</td>
                            `;
                            tbody.appendChild(tr);
                        });

                        table.appendChild(tbody);

                        // Append the table to the container
                        document.getElementById("tableContainer").appendChild(table);

                        // Initialize DataTables on the created table
                        $(document).ready(function () {
                            const dataTable = $('#detailsTable').DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                responsive: true
                            });

                            // Add a search marker to indicate the search input
                            $('#detailsTable_filter input').attr('placeholder', 'Search...').addClass('search-marker');

                            // Handle form submission for searching
                            document.getElementById("searchForm").addEventListener("submit", function (event) {
                                event.preventDefault();
                                const searchValue = document.getElementById("searchInput").value;
                                document.getElementById("searchSpinner").classList.remove("d-none");
                                dataTable.search(searchValue).draw();
                                document.getElementById("searchSpinner").classList.add("d-none");
                            });
                        });

                    } else {
                        document.getElementById("tableContainer").textContent = "No data available for this date and status.";
                    }

                    modal.show();
                })
                .catch((error) => {
                    console.error("Error fetching details:", error);
                    document.getElementById("tableContainer").textContent = "An error occurred while fetching data.";
                });
        }




        initializeChart();

        filterSelect.addEventListener("change", function () {
            const selectedValue = filterSelect.value;
            if (selectedValue === "qty") {
                initializeChart();
            } else if (selectedValue === "cost") {
                const options = {
                    series: [
                        {
                            name: "Total Cost",
                            data: totalCost,
                            color: "#17a2b8",
                        },
                    ],
                    chart: {
                        height: 350,
                        type: "bar",
                        toolbar: {
                            show: true,
                        },
                        events: {
                            dataPointSelection: function (
                                event,
                                chartContext,
                                config
                            ) {
                                const selectedDate =
                                    dates[config.dataPointIndex];
                                openModal(selectedDate);
                            },
                        },
                        title: {
                            text: "Data Total Cost Per Tanggal",
                            align: "left",
                            margin: 10,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize: "16px",
                                fontWeight: "bold",
                                color: "#263238",
                            },
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "55%",
                            endingShape: "rounded",
                            borderRadius: 9,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ["transparent"],
                    },
                    xaxis: {
                        categories: dates,
                    },
                    yaxis: {
                        title: {
                            text: "Total Cost",
                        },
                        labels: {
                            formatter: function (value) {
                                return formatRupiah(value);
                            },
                        },
                    },
                    fill: {
                        opacity: 1,
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return formatRupiah(val);
                            },
                        },
                    },
                };

                if (chart) {
                    chart.destroy();
                }

                chart = new ApexCharts(
                    document.querySelector("#kt_apexcharts_1"),
                    options
                );
                chart.render();
            }
        });

        [showExpired, showCompleted, showConfirmed, showInProgress].forEach(
            (checkbox) => {
                checkbox.addEventListener("change", initializeChart);
            }
        );
    } catch (error) {
        console.error("Error fetching PO data:", error);
    } finally {
        spinner.style.display = "none";
    }
}

async function fetchPoData() {
    const spinner = document.getElementById("spinner-po");
    const poContent = document.getElementById("po-content");

    // Check if elements exist
    if (!spinner || !poContent) {
        console.error("Spinner or PO content element not found");
        return;
    }

    // Show the spinner while fetching data
    spinner.style.display = "block";
    poContent.style.display = "none"; // Hide the content initially

    try {
        const response = await fetch("/po/count"); // Replace with your API endpoint
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();
        console.log(data, "data");
        // Update the content with fetched data
        poContent.textContent = formatRupiah(data.data.totalCost); // Adjust according to your data structure
        poContent.style.display = "block"; // Show the content if data is fetched successfully
    } catch (error) {
        console.error("Error fetching PO data:", error);
    } finally {
        // Hide the spinner after fetching data
        spinner.style.display = "none";
    }
}

function fetchJumlahCuti() {
    $("#spinner-leave").show(); // Show spinner
    $.ajax({
        url: "/cuti/count",
        method: "GET",
        success: function (response) {
            $("#spinner-leave").hide(); // Hide spinner
            var content =
                '<div class="cuti-count animated fadeIn">' +
                response.count +
                "</div>";
            $("#leave-content").html(content);
            // Toastify({
            //     text: "Cuti count loaded successfully",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#4CAF50",
            //     stopOnFocus: true,
            // }).showToast();
        },
        error: function (error) {
            $("#spinner-leave").hide(); // Hide spinner
            console.log("Error fetching data", error);
            // Toastify({
            //     text: "Error loading cuti count",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#FF0000",
            //     stopOnFocus: true,
            // }).showToast();
        },
    });
}

function fetchCabangCount() {
    $("#spinner-cabang").show(); // Show spinner
    $.ajax({
        url: "/cabang/count",
        method: "GET",
        success: function (response) {
            $("#spinner-cabang").hide(); // Hide spinner
            var content =
                '<div class="cabang-count animated fadeIn">' +
                response.count +
                "</div>";
            $("#cabang-content").html(content);
            // Toastify({
            //     text: "Cabang count loaded successfully",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#4CAF50",
            //     stopOnFocus: true,
            // }).showToast();
        },
        error: function (error) {
            $("#spinner-cabang").hide(); // Hide spinner
            console.log("Error fetching data", error);
            // Toastify({
            //     text: "Error loading cabang count",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#FF0000",
            //     stopOnFocus: true,
            // }).showToast();
        },
    });
}

function fetchDepartmentCount() {
    $("#spinner-department").show(); // Show spinner
    $.ajax({
        url: "/departments/count",
        method: "GET",
        success: function (response) {
            $("#spinner-department").hide(); // Hide spinner
            var content =
                '<div class="department-count animated fadeIn">' +
                response.count +
                "</div>";
            $("#department-content").html(content);
            // Toastify({
            //     text: "Department count loaded successfully",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#4CAF50",
            //     stopOnFocus: true,
            // }).showToast();
        },
        error: function (error) {
            $("#spinner-department").hide(); // Hide spinner
            console.log("Error fetching data", error);
            // Toastify({
            //     text: "Error loading department count",
            //     duration: 3000,
            //     close: true,
            //     gravity: "top",
            //     position: "right",
            //     backgroundColor: "#FF0000",
            //     stopOnFocus: true,
            // }).showToast();
        },
    });
}

function fetchListCuti() {
    $("#spinner-leave").show(); // Show spinner

    $.ajax({
        url: "/cuti/data",
        method: "GET",
        success: function (response) {
            $("#spinner-leave").hide(); // Hide spinner
            var content = "";

            if (response.data.length > 0) {
                response.data.forEach(function (item) {
                    content +=
                        '<div class="leave-item">' +
                        '<h3 class="day">' +
                        item.nama_cuti +
                        " (" +
                        item.kode_cuti +
                        ")</h3>" +
                        '<p class="days">Jumlah Hari: ' +
                        item.jumlah_hari +
                        "</p>" +
                        "</div>";
                });
                $("#listleave-content").html(content);
                // Toastify({
                //     text: "Data cuti loaded successfully",
                //     duration: 3000,
                //     close: true,
                //     gravity: "top",
                //     position: "right",
                //     backgroundColor: "#4CAF50",
                //     stopOnFocus: true,
                // }).showToast();
            } else {
                $("#listleave-content").html(
                    '<div class="not-found-message">' +
                        '<div class="icon-container">' +
                        '<i class="fas fa-search" style="font-size: 25px; color: #FFAA00;"></i>' +
                        "</div>" +
                        '<p class="message-text">No data available</p>' +
                        "</div>"
                );
                Toastify({
                    text: "No data available",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#FFAA00",
                    stopOnFocus: true,
                }).showToast();
            }
        },
        error: function (error) {
            $("#spinner-leave").hide(); // Hide spinner
            Toastify({
                text: "Error loading data",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#FF0000",
                stopOnFocus: true,
            }).showToast();
        },
    });
}


function fetchJamKerja() {
    $("#spinner").show(); // Show spinner

    $.ajax({
        url: "/jam_kerja/data",
        method: "GET",
        success: function (response) {
            $("#spinner").hide(); // Hide spinner
            var content = "";

            if (response.data.length > 0) {
                response.data.forEach(function (item) {
                    content +=
                        '<div class="jam-kerja-item">' +
                        '<h3 class="day">' +
                        item.nama_jk +
                        " (" +
                        item.kode_jk +
                        ")</h3>" +
                        '<p class="time">Jam Masuk: ' +
                        item.jam_masuk +
                        " (" +
                        item.awal_jam_masuk +
                        " - " +
                        item.akhir_jam_masuk +
                        ")</p>" +
                        '<p class="time">Jam Pulang: ' +
                        item.jam_pulang +
                        "</p>" +
                        '<p class="time">Lintas Hari: ' +
                        item.lintas_hari +
                        "</p>" +
                        "</div>";
                });
                $("#jam-kerja-content").html(content);
                // Toastify({
                //     text: "Data jam kerja loaded successfully",
                //     duration: 3000,
                //     close: true,
                //     gravity: "top",
                //     position: "right",
                //     backgroundColor: "#4CAF50",
                //     stopOnFocus: true,
                // }).showToast();
            } else {
                $("#jam-kerja-content").html(
                    '<div class="not-found-message">' +
                        '<div class="icon-container">' +
                        '<i class="fas fa-search" style="font-size: 25px; color: #FFAA00;"></i>' +
                        "</div>" +
                        '<p class="message-text">No data available</p>' +
                        "</div>"
                );
                Toastify({
                    text: "No data available",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#FFAA00",
                    stopOnFocus: true,
                }).showToast();
            }
        },
        error: function (error) {
            $("#spinner").hide(); // Hide spinner
            console.log("Error fetching data", error);
            Toastify({
                text: "Error loading data",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#FF0000",
                stopOnFocus: true,
            }).showToast();
        },
    });
}

async function fetchCountPoDays(status, filterDate) {
    const url = `/home/countDataPoPerDays?filterDate=${filterDate}`;

    // Fetch data from your API
    const response = await fetch(url); // Replace 'your-api-endpoint' with your actual API URL
    const data = await response.json();
    // Process your data and extract the necessary information for the chart
    const categories = []; // Array to store categories (x-axis labels)
    const seriesData = []; // Array to store series data (y-axis values)
    // Populate categories and seriesData arrays based on the fetched data
    // Example: Assuming your data contains objects with 'date' and 'count' properties
    if (status == "rupiah") {
        data.data.forEach((item) => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalCost)); // Push count to seriesData array
        });
    } else if (status == "qty") {
        console.log(categories, seriesData, status, data.total, "seriesData");

        data.data.forEach((item) => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalPo)); // Push count to seriesData array
        });
    } else {
        console.log(categories, seriesData, status, data, "seriesData1");

        data.data.forEach((item) => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalCost)); // Push count to seriesData array
        });
    }

    // Define your ApexCharts options
    const options = {
        chart: {
            type: "line",
            height: 250, // Specify chart height
            // Add more chart options as needed
        },
        series: [
            {
                name: "Count", // Specify series name
                data: seriesData, // Specify series data
            },
        ],
        xaxis: {
            categories: categories, // Specify x-axis categories
            labels: {
                show: false, // Hide x-axis labels
            },
        },
        yaxis: {
            labels: {
                show: false, // Hide y-axis labels
            },
        },
        colors: ["#808080"],
        responsive: [
            {
                breakpoint: 1000, // Breakpoint for medium screens
                options: {
                    chart: {
                        width: "100%", // Set width to 100%
                    },
                    legend: {
                        position: "bottom", // Position legend at the bottom
                    },
                    xaxis: {
                        labels: {
                            show: false, // Hide x-axis labels for medium screens
                        },
                    },
                    yaxis: {
                        labels: {
                            show: false, // Hide y-axis labels for medium screens
                        },
                    },
                },
            },
            {
                breakpoint: 600, // Breakpoint for small screens
                options: {
                    chart: {
                        width: "100%", // Set width to 100%
                    },
                    xaxis: {
                        labels: {
                            show: false, // Hide x-axis labels for small screens
                        },
                    },
                    yaxis: {
                        labels: {
                            show: false, // Hide y-axis labels for small screens
                        },
                    },
                    legend: {
                        position: "bottom", // Position legend at the bottom
                    },
                },
            },
        ],
        // Add more chart options as needed
    };

    // Render the chart using ApexCharts
    const chart = new ApexCharts(document.querySelector("#chart-po"), options);
    chart.render();
}

function fetchPriceChangeData(id) {
    $.ajax({
        url: "/price-change/count", // Adjust the URL to match your route
        type: "GET",
        success: function (response) {
            $("#countPriceChange").html(response.count); // Assuming you have price_change_value in the response
        },
        error: function (xhr) {
            alert("Error: " + xhr.responseText);
        },
    });
}

async function fetchCountPo(status, filterDate) {
    try {
        // Show the loading indicator (spinner) and overlay
        var loaderOverlay = document.querySelector(".loader-overlay");
        loaderOverlay.style.display = "block";

        var cardBody = document.querySelector(".card-body");
        cardBody.style.display = "none"; // Hide the card body initially

        var spinnerElement = document.createElement("span");
        spinnerElement.className = "fas fa-spinner fa-spin"; // Font Awesome classes for the spinner
        spinnerElement.style.fontSize = "24px"; // Optional: Adjust the size of the spinner icon

        var targetElement = document.querySelector(".fs-2hx"); // Example target element
        targetElement.appendChild(spinnerElement);

        // Make an AJAX request to fetch countdataPo
        const url = `/home/countDataPo?filterDate=${filterDate}`;

        const response = await fetch(url, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
            redirect: "manual", // Manually handle redirects
        });

        // Handle the response as needed

        if (response.status === 302) {
            // Redirect detected, fetch the redirected URL
            const redirectedResponse = await fetch(
                response.headers.get("Location"),
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    redirect: "follow", // Follow redirects for the redirected URL
                }
            );

            if (!redirectedResponse.ok) {
                throw new Error("Error fetching countdataPo after redirect");
            }

            // Parse the JSON response
            const data = await redirectedResponse.json();

            // Update the DOM with the fetched countdataPo value
            var countPoElement = document.querySelector(".fs-2hx");
            countPoElement.textContent = data.total.totalCost; // Assuming the JSON response has a property named countdataPo

            // Hide the loading indicator and show the card body
            loaderOverlay.style.display = "none";
            cardBody.style.display = "flex"; // Assuming card-body uses flex display
            spinnerElement.remove();
        } else if (!response.ok) {
            throw new Error("Error fetching countdataPo");
        } else {
            // Parse the JSON response
            const data = await response.json();

            let integerPart = 0; // Initialize integerPart as a number

            // Update the DOM with the fetched countdataPo value
            var countPoElement = document.querySelector(".fs-2hx");
            countPoElement.textContent = "";
            if (status == "rupiah") {
                integerPart = Math.floor(data.total.totalCost);
            } else if (status == "qty") {
                integerPart = Math.floor(data.total.totalPo);
            } else {
                integerPart = Math.floor(data.total.totalCost);
            }

            countPoElement.textContent = formatNumber(integerPart); // Assuming the JSON response has a property named countdataPo

            // Hide the loading indicator and show the card body
            loaderOverlay.style.display = "none";
            cardBody.style.display = "flex"; // Assuming card-body uses flex display
            spinnerElement.remove();
        }
    } catch (error) {
        console.error("Error fetching countdataPo:", error);
    }
}

async function fetchCountRcv(status, filterDate) {
    try {
        // Show the loading indicator (spinner) and overlay
        var loaderOverlay = document.querySelector(".loader-overlay");
        loaderOverlay.style.display = "block";

        var cardBody = document.querySelector(".card-body");
        cardBody.style.display = "none"; // Hide the card body initially

        var spinnerElement = document.createElement("span");
        spinnerElement.className = "fas fa-spinner fa-spin"; // Font Awesome classes for the spinner
        spinnerElement.style.fontSize = "24px"; // Optional: Adjust the size of the spinner icon

        var targetElement = document.getElementById("countValueRcv"); // Example target element
        targetElement.appendChild(spinnerElement);

        // Make an AJAX request to fetch countdataPo
        const url = `/home/countDataRcv?filterDate=${filterDate}`;

        const response = await fetch(url, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
            redirect: "manual", // Manually handle redirects
        });

        // Handle the response as needed
        let data;
        if (response.status === 302) {
            const redirectedResponse = await fetch(
                response.headers.get("Location"),
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    redirect: "follow", // Follow redirects for the redirected URL
                }
            );

            if (!redirectedResponse.ok) {
                throw new Error("Error fetching countdataPo after redirect");
            }

            data = await redirectedResponse.json();
        } else if (!response.ok) {
            throw new Error("Error fetching countdataRcv");
        } else {
            data = await response.json();
        }

        let integerPart = 0; // Initialize integerPart as a number

        // Update the DOM with the fetched countdataPo value
        var countValueElement = document.getElementById("countValueRcv");
        countValueElement.textContent = "";
        if (status == "rupiah") {
            integerPart = Math.floor(data.total.totalCostRcv);
        } else if (status == "qty") {
            integerPart = Math.floor(data.total.totalRcv);
        } else {
            integerPart = Math.floor(data.total.totalCostRcv);
        }

        countValueElement.textContent = formatNumber(integerPart); // Assuming the JSON response has a property named countdataPo

        // Hide the loading indicator and show the card body
        loaderOverlay.style.display = "none";
        cardBody.style.display = "flex"; // Assuming card-body uses flex display
        spinnerElement.remove();
    } catch (error) {
        console.error("Error fetching countdataPo:", error);
    }
}

async function fetchCountRcvDays(status, filterDate) {
    const url = `/home/countDataRcvPerDays?filterDate=${filterDate}`;

    // Fetch data from your API
    const response = await fetch(url); // Replace 'your-api-endpoint' with your actual API URL
    const data = await response.json();
    // Process your data and extract the necessary information for the chart
    const categories = []; // Array to store categories (x-axis labels)
    const seriesData = []; // Array to store series data (y-axis values)
    // Populate categories and seriesData arrays based on the fetched data
    // Example: Assuming your data contains objects with 'date' and 'count' properties
    if (status == "rupiah") {
        data.total.dailyCounts.forEach((item) => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalCostRcv)); // Push count to seriesData array
        });
    } else if (status == "qty") {
        console.log("masuk sini ya");
        data.total.dailyCounts.forEach((item) => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalRcv)); // Push count to seriesData array
        });
    } else {
        console.log(data.total.dailyCounts);
        data.total.dailyCounts.forEach((item) => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalCostRcv)); // Push count to seriesData array
        });
    }

    // Define your ApexCharts options
    const options = {
        chart: {
            type: "line",
            height: 250, // Specify chart height
            // Add more chart options as needed
        },
        series: [
            {
                name: "Count", // Specify series name
                data: seriesData, // Specify series data
            },
        ],
        xaxis: {
            categories: categories, // Specify x-axis categories
            labels: {
                show: false, // Hide x-axis labels
            },
        },
        yaxis: {
            labels: {
                show: false, // Hide y-axis labels
            },
        },
        colors: ["#808080"],
        responsive: [
            {
                breakpoint: 1000, // Breakpoint for medium screens
                options: {
                    chart: {
                        width: "100%", // Set width to 100%
                    },
                    legend: {
                        position: "bottom", // Position legend at the bottom
                    },
                    xaxis: {
                        labels: {
                            show: false, // Hide x-axis labels for medium screens
                        },
                    },
                    yaxis: {
                        labels: {
                            show: false, // Hide y-axis labels for medium screens
                        },
                    },
                },
            },
            {
                breakpoint: 600, // Breakpoint for small screens
                options: {
                    chart: {
                        width: "100%", // Set width to 100%
                    },
                    xaxis: {
                        labels: {
                            show: false, // Hide x-axis labels for small screens
                        },
                    },
                    yaxis: {
                        labels: {
                            show: false, // Hide y-axis labels for small screens
                        },
                    },
                    legend: {
                        position: "bottom", // Position legend at the bottom
                    },
                },
            },
        ],
        // Add more chart options as needed
    };

    // Render the chart using ApexCharts
    const chart = new ApexCharts(document.querySelector("#chart-rcv"), options);
    chart.render();
}

function formatNumber(num) {
    if (num >= 1e12) {
        return (num / 1e12).toFixed(1) + " t";
    } else if (num >= 1e9) {
        return (num / 1e9).toFixed(1) + " m";
    } else if (num >= 1e6) {
        return (num / 1e6).toFixed(1) + " jt";
    } else if (num >= 1e3) {
        return (num / 1e3).toFixed(1) + " rb";
    } else {
        return num.toString();
    }
}
