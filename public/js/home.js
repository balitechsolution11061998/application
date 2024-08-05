$(document).ready(function () {

    fetchPoDataPerDays();
    fetchTimelineConfirmedData();


       // Automatically check the 'Average Execution Time' checkbox
       document.getElementById('showExecutionTime').checked = true;

       // Fetch and render chart data based on the default checkbox state
       fetchQueryPerformanceLogs();

       const checkboxes = document.querySelectorAll('.dropdown-item .form-check-input');

       checkboxes.forEach(checkbox => {
           checkbox.addEventListener('change', async function () {
               if (this.checked) {
                   checkboxes.forEach(cb => {
                       if (cb !== this) {
                           cb.checked = false; // Uncheck all other checkboxes
                       }
                   });
               }

               // Fetch and render chart data based on the selected checkbox
               await fetchQueryPerformanceLogs();
           });
       });


    document.getElementById('toggleView').addEventListener('change', function () {
        const isChecked = this.checked;

        // Show chart if checkbox is unchecked, otherwise show table
        document.getElementById('chartContainer').style.display = isChecked ? 'none' : 'block';
        document.getElementById('tableQueryPerformanceLog').style.display = isChecked ? 'block' : 'none';
    });

    document.getElementById('option2').checked = true;
    document.getElementById('toggle-cost').classList.add('active');
    fetchData('po');
    fetchData('receiving');

    // Event listeners for the toggle buttons
    document.getElementById("toggle-quantity").addEventListener("click", () => {
        fetchData('po');
        fetchData('receiving');

    });

    document.getElementById("toggle-cost").addEventListener("click", () => {
        fetchData('po');
        fetchData('receiving');
    });

});

document.querySelectorAll('.toggle-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            // Uncheck all checkboxes
            document.querySelectorAll('.toggle-checkbox').forEach(cb => cb.checked = false);
            // Check the current one
            this.checked = true;

            // Remove active class from all labels
            document.querySelectorAll('.btn-group-toggle .btn').forEach(btn => btn.classList.remove('active'));
            // Add active class to the corresponding label
            this.closest('label').classList.add('active');
        }
    });
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
    try {
        // Destroy existing DataTable instance if it exists
        if ($.fn.DataTable.isDataTable('#queryPerformance-table')) {
            $('#queryPerformance-table').DataTable().clear().destroy();
        }

        // Initialize DataTable
        dataTable = $('#queryPerformance-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/query-performance-logs',
                type: 'GET',
                data: function (d) {
                    d.function = $('#filterFunction').val(); // Add filter parameter
                }
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

        // Fetch chart data
        const chartResponse = await fetch('/query-performance-logs/chart-data');
        const chartData = await chartResponse.json();

        // Check if chartData contains expected data
        if (chartData && chartData.labels) {
            const labels = chartData.labels;

            // Convert milliseconds to seconds and format to 2 decimal places
            const executionTimes = chartData.executionTimes.map(time => (time).toFixed(2)); // Convert ms to s
            const pings = chartData.pings.map(ping => (ping / 1000).toFixed(2)); // Convert ms to s
            const memoryUsages = chartData.memoryUsages.map(memory => (memory / 1024).toFixed(2)); // Convert bytes to MB

            // Render chart with all data
            renderChart(labels, executionTimes, pings, memoryUsages);
        } else {
            console.warn("Unexpected chart data format:", chartData);
        }

    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

function renderChart(labels, executionTimes, pings, memoryUsages) {
    console.log(labels, executionTimes, pings, memoryUsages);

    // Destroy existing chart instance if it exists
    if (chartInstance) {
        chartInstance.destroy();
    }

    // Determine which series to include based on checkbox states
    const series = [];

    if (document.getElementById('showExecutionTime').checked) {
        series.push({
            name: 'Average Execution Time',
            data: executionTimes,
            color: '#1f77b4' // Blue color for execution times
        });
    }

    if (document.getElementById('showPing').checked) {
        series.push({
            name: 'Average Ping',
            data: pings,
            color: '#ff7f0e' // Orange color for ping times
        });
    }

    if (document.getElementById('showMemoryUsage').checked) {
        // Convert memory usage values to MB
        const memoryUsagesInMB = memoryUsages.map(memory => (memory / 1024).toFixed(2)); // Convert bytes to MB

        series.push({
            name: 'Memory Usage',
            data: memoryUsagesInMB,
            color: '#2ca02c' // Green color for memory usage
        });
    }

    if (series.length === 0) {
        // No series to show
        return;
    }

    // Create a new chart
    chartInstance = new ApexCharts(document.querySelector("#chartCanvas"), {
        chart: {
            type: 'bar', // Set to 'bar' for a bar chart
            height: 350,
            width: '100%',
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        series: series,
        xaxis: {
            categories: labels, // Set categories for the x-axis
            title: {
                text: 'Function Names',
                style: {
                    fontSize: '14px'
                }
            },
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            title: {
                text: 'Values',
                style: {
                    fontSize: '14px'
                }
            },
            labels: {
                formatter: function (value) {
                    // Determine if memory usage is being displayed
                    const isMemoryUsage = series.some(s => s.name === 'Memory Usage');
                    return isMemoryUsage ? `${value} MB` : value.toFixed(2); // Append 'MB' for memory usage
                },
                style: {
                    fontSize: '12px'
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: false, // Set to true for horizontal bars
                columnWidth: '35%', // Width of bars (adjusted for better spacing)
                endingShape: 'rounded', // Rounded edges for bars
                borderRadius: 5 // Radius for rounded corners
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '10px' // Smaller font size for data labels
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    // Determine if memory usage is being displayed
                    const isMemoryUsage = series.some(s => s.name === 'Memory Usage');
                    return isMemoryUsage ? `${val} MB` : `${val} ms`; // Append 'MB' or 'ms' based on the data
                }
            },
            style: {
                fontSize: '12px' // Smaller font size for tooltip
            }
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 300
                },
                xaxis: {
                    labels: {
                        style: {
                            fontSize: '10px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '10px'
                        }
                    }
                },
                dataLabels: {
                    style: {
                        fontSize: '8px'
                    }
                },
                legend: {
                    labels: {
                        style: {
                            fontSize: '10px'
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '10px'
                    }
                }
            }
        }]
    });

    // Render the chart
    chartInstance.render();
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

                                // Highlight the search terms in the table
                                dataTable.search(searchValue).draw();
                                highlightSearchTerms(searchValue);

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

        // Function to highlight search terms in the table
        function highlightSearchTerms(term) {
            const table = document.getElementById("detailsTable");
            if (term) {
                const regex = new RegExp(`(${term})`, 'gi');
                table.querySelectorAll('td').forEach(td => {
                    td.innerHTML = td.textContent.replace(regex, '<span class="highlight">$1</span>');
                });
            }
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

async function fetchData(type) {
    const spinner = document.getElementById(`spinner-${type}`);
    const content = document.getElementById(`${type}-content`);
    const title = document.getElementById(`${type}-title`);

    // Check if elements exist
    if (!spinner || !content || !title) {
        console.error(`${type} spinner, content, or title element not found`);
        return;
    }

    // Show the spinner while fetching data
    spinner.style.display = "block";
    content.style.display = "none"; // Hide the content initially

    let endpoint = '';
    let dataFields = {};

    if (type === 'po') {
        endpoint = "/po/count";
        dataFields = { totalKey: 'totalPo', costKey: 'totalCost' };
    } else if (type === 'receiving') {
        endpoint = "/home/countDataRcv";
        dataFields = { totalKey: 'totalRcv', costKey: 'totalCostRcv' };
    }

    try {
        const response = await fetch(endpoint);
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();

        // Extract data
        const totalValue = data.data[dataFields.totalKey];
        const totalCost = data.data[dataFields.costKey];

        // Get the current month and year
        const now = new Date();
        const currentMonth = now.toLocaleString('default', { month: 'long' });
        const currentYear = now.getFullYear();

        // Get the selected toggle
        const selectedToggle = document.querySelector('input[name="options"]:checked').id;

        let contentHtml = '';
        let titleHtml = '';
        if (selectedToggle === "option1") {
            // Show Quantity
            contentHtml = `
                <div class="content-container">
                    <div class="data-value">${totalValue}</div>
                    <div class="small-text"><strong>Month:</strong> ${currentMonth}<br>
                    <strong>Year:</strong> ${currentYear}</div>
                </div>
            `;
            titleHtml = `Total ${type === 'po' ? 'PO' : 'Receiving'} Count: `;
        } else if (selectedToggle === "option2") {
            // Show Cost
            const formattedCost = formatRupiah(totalCost);
            contentHtml = `
                <div class="content-container">
                    <div class="data-value">${formattedCost}</div>
                    <div class="small-text"><strong>Month:</strong> ${currentMonth}<br>
                    <strong>Year:</strong> ${currentYear}</div>
                </div>
            `;
            titleHtml = `Total ${type === 'po' ? 'PO' : 'Receiving'} Cost: `;
        }

        // Update the content with fetched data
        content.innerHTML = contentHtml;
        content.style.display = "block"; // Show the content if data is fetched successfully
        title.innerHTML = titleHtml; // Update the title
    } catch (error) {
        console.error(`Error fetching ${type} data:`, error);
        content.innerHTML = "<p>Error fetching data</p>"; // Show error message if needed
    } finally {
        // Hide the spinner after fetching data
        spinner.style.display = "none";
    }
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

// async function fetchCountPo(status, filterDate) {
//     try {
//         // Show the loading indicator (spinner) and overlay
//         var loaderOverlay = document.querySelector(".loader-overlay");
//         loaderOverlay.style.display = "block";

//         var cardBody = document.querySelector(".card-body");
//         cardBody.style.display = "none"; // Hide the card body initially

//         var spinnerElement = document.createElement("span");
//         spinnerElement.className = "fas fa-spinner fa-spin"; // Font Awesome classes for the spinner
//         spinnerElement.style.fontSize = "24px"; // Optional: Adjust the size of the spinner icon

//         var targetElement = document.querySelector(".fs-2hx"); // Example target element
//         targetElement.appendChild(spinnerElement);

//         // Make an AJAX request to fetch countdataPo
//         const url = `/home/countDataPo?filterDate=${filterDate}`;

//         const response = await fetch(url, {
//             method: "GET",
//             headers: {
//                 "Content-Type": "application/json",
//             },
//             redirect: "manual", // Manually handle redirects
//         });

//         // Handle the response as needed

//         if (response.status === 302) {
//             // Redirect detected, fetch the redirected URL
//             const redirectedResponse = await fetch(
//                 response.headers.get("Location"),
//                 {
//                     method: "GET",
//                     headers: {
//                         "Content-Type": "application/json",
//                     },
//                     redirect: "follow", // Follow redirects for the redirected URL
//                 }
//             );

//             if (!redirectedResponse.ok) {
//                 throw new Error("Error fetching countdataPo after redirect");
//             }

//             // Parse the JSON response
//             const data = await redirectedResponse.json();

//             // Update the DOM with the fetched countdataPo value
//             var countPoElement = document.querySelector(".fs-2hx");
//             countPoElement.textContent = data.total.totalCost; // Assuming the JSON response has a property named countdataPo

//             // Hide the loading indicator and show the card body
//             loaderOverlay.style.display = "none";
//             cardBody.style.display = "flex"; // Assuming card-body uses flex display
//             spinnerElement.remove();
//         } else if (!response.ok) {
//             throw new Error("Error fetching countdataPo");
//         } else {
//             // Parse the JSON response
//             const data = await response.json();

//             let integerPart = 0; // Initialize integerPart as a number

//             // Update the DOM with the fetched countdataPo value
//             var countPoElement = document.querySelector(".fs-2hx");
//             countPoElement.textContent = "";
//             if (status == "rupiah") {
//                 integerPart = Math.floor(data.total.totalCost);
//             } else if (status == "qty") {
//                 integerPart = Math.floor(data.total.totalPo);
//             } else {
//                 integerPart = Math.floor(data.total.totalCost);
//             }

//             countPoElement.textContent = formatNumber(integerPart); // Assuming the JSON response has a property named countdataPo

//             // Hide the loading indicator and show the card body
//             loaderOverlay.style.display = "none";
//             cardBody.style.display = "flex"; // Assuming card-body uses flex display
//             spinnerElement.remove();
//         }
//     } catch (error) {
//         console.error("Error fetching countdataPo:", error);
//     }
// }

// async function fetchReceivings() {
//     try {
//         // Show the loading indicator (spinner)
//         const spinner = document.getElementById('spinner-receiving');
//         spinner.style.display = 'block';

//         const receivingContent = document.getElementById('receiving-content');
//         const receivingMonthYear = document.getElementById('receiving-month-year');

//         // Clear existing content
//         receivingContent.textContent = "";

//         // Make an AJAX request to fetch receiving data
//         const url = `/home/countDataRcv`;

//         const response = await fetch(url, {
//             method: "GET",
//             headers: {
//                 "Content-Type": "application/json",
//             },
//             redirect: "manual", // Manually handle redirects
//         });

//         if (response.status === 302) {
//             // Redirect detected, fetch the redirected URL
//             const redirectedResponse = await fetch(response.headers.get("Location"), {
//                 method: "GET",
//                 headers: {
//                     "Content-Type": "application/json",
//                 },
//                 redirect: "follow", // Follow redirects for the redirected URL
//             });

//             if (!redirectedResponse.ok) {
//                 throw new Error("Error fetching receiving data after redirect");
//             }

//             // Parse the JSON response
//             const data = await redirectedResponse.json();

//             // Update the DOM with the fetched receiving data
//             receivingContent.textContent = formatNumber(data.totalRcv); // Update with total receivings
//             receivingMonthYear.textContent = `${data.month}-${data.year}`; // Update with month/year

//             // Hide the spinner
//             spinner.style.display = "none";
//         } else if (!response.ok) {
//             throw new Error("Error fetching receiving data");
//         } else {
//             // Parse the JSON response
//             const data = await response.json();

//             // Update the DOM with the fetched receiving data
//             receivingContent.textContent = formatNumber(data.totalRcv); // Update with total receivings
//             receivingMonthYear.textContent = `${data.month}-${data.year}`; // Update with month/year

//             // Hide the spinner
//             spinner.style.display = "none";
//         }
//     } catch (error) {
//         console.error("Error fetching receiving data:", error);
//         receivingContent.textContent = 'Error'; // Display error message if fetch fails
//         spinner.style.display = "none"; // Hide spinner
//     }
// }


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
