$(document).ready(function () {
    // Fetch all initial data on page load
    fetchPoDataPerDays();
    fetchTimelineConfirmedData();
    fetchServiceLevelSupplier();
    fetchItemDetails();
    fetchTandaTerimaList();
    fetchTotals();

    // Set initial toggle states
    document.getElementById("option2").checked = true;
    document.getElementById("toggle-cost").classList.add("active");

    // Fetch data for all sections
    fetchDataPo();
    fetchDataReceiving();
    fetchDataTandaTerima();

    // Event listeners for the toggle buttons
    document.getElementById("toggle-quantity").addEventListener("click", () => {
        fetchDataPo();
        fetchDataReceiving();
        fetchDataTandaTerima();
    });

    document.getElementById("toggle-cost").addEventListener("click", () => {
        fetchDataPo();
        fetchDataReceiving();
        fetchDataTandaTerima();
    });

    // Fetch data when tab is shown
    document
        .querySelector('a[href="#kt_list_widget_16_tab_4"]')
        .addEventListener("shown.bs.tab", function () {
            const today = new Date().toISOString().split("T")[0];
            fetchReceivingData(today);
        });
});

async function fetchDataPo() {
    const spinner = document.getElementById("po-spinner");
    const content = document.getElementById("po-content");
    const title = document.getElementById("po-title");

    if (!spinner || !content || !title) {
        console.error("PO spinner, content, or title element not found");
        return;
    }

    spinner.style.display = "block";
    content.style.display = "none";

    try {
        const response = await fetch("/po/count");
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();

        const totalValue = data.totalPo;
        const totalCost = data.totalCost;

        updateContent("po", totalValue, totalCost);
    } catch (error) {
        console.error("Error fetching PO data:", error);
        content.innerHTML = "<p>Error fetching data</p>";
    } finally {
        spinner.style.display = "none";
    }
}

async function fetchDataReceiving() {
    const spinner = document.getElementById("receiving-spinner");
    const content = document.getElementById("receiving-content");
    const title = document.getElementById("receiving-title");

    if (!spinner || !content || !title) {
        console.error("Receiving spinner, content, or title element not found");
        return;
    }

    spinner.style.display = "block";
    content.style.display = "none";

    try {
        const response = await fetch("/home/countDataRcv");
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();

        const totalValue = data.totalRcv;
        const totalCost = data.totalCostRcv;

        updateContent("receiving", totalValue, totalCost);
    } catch (error) {
        console.error("Error fetching Receiving data:", error);
        content.innerHTML = "<p>Error fetching data</p>";
    } finally {
        spinner.style.display = "none";
    }
}

async function fetchDataTandaTerima() {
    const spinner = document.getElementById("tandaterima-spinner");
    const content = document.getElementById("tandaterima-content");
    const title = document.getElementById("tandaterima-title");

    if (!spinner || !content || !title) {
        console.error("Tanda Terima spinner, content, or title element not found");
        return;
    }

    spinner.style.display = "block";
    content.style.display = "none";

    try {
        const response = await fetch("/home/countTandaTerima");
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const data = await response.json();

        const totalValue = data.totalTandaTerima;
        const totalCost = data.totalCostTandaTerima;

        updateContent("tandaterima", totalValue, totalCost);
    } catch (error) {
        console.error("Error fetching Tanda Terima data:", error);
        content.innerHTML = "<p>Error fetching data</p>";
    } finally {
        spinner.style.display = "none";
    }
}

function updateContent(type, totalValue, totalCost) {
    const content = document.getElementById(`${type}-content`);
    const title = document.getElementById(`${type}-title`);

    // Get the current month and year
    const now = new Date();
    const currentMonth = now.toLocaleString("default", { month: "long" });
    const currentYear = now.getFullYear();

    // Get the selected toggle
    const selectedToggle = document.querySelector('input[name="options"]:checked')?.id;

    let contentHtml = "";
    let titleHtml = "";
    if (selectedToggle === "option1") {
        // Show Quantity
        contentHtml = `
            <div class="content-container">
                <div class="data-value">${totalValue}</div>
                <div class="small-text"><strong>Month:</strong> ${currentMonth}<br>
                <strong>Year:</strong> ${currentYear}</div>
            </div>
        `;
        titleHtml = `Total ${type === "po" ? "PO" : type === "receiving" ? "Receiving" : "Tanda Terima"} Count`;
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
        titleHtml = `Total ${type === "po" ? "PO" : type === "receiving" ? "Receiving" : "Tanda Terima"} Cost`;
    }

    // Update the content with fetched data
    content.innerHTML = contentHtml;
    content.style.display = "block";
    title.innerHTML = titleHtml;
}

document.querySelectorAll(".toggle-checkbox").forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
        if (this.checked) {
            // Uncheck all checkboxes
            document
                .querySelectorAll(".toggle-checkbox")
                .forEach((cb) => (cb.checked = false));
            // Check the current one
            this.checked = true;

            // Remove active class from all labels
            document
                .querySelectorAll(".btn-group-toggle .btn")
                .forEach((btn) => btn.classList.remove("active"));
            // Add active class to the corresponding label
            this.closest("label").classList.add("active");
        }
    });
});

function fetchReceivingData(date) {
    fetch(`/po/receiving?filterDate=${date}`)
        .then((response) => response.json())
        .then((data) => {
            const container = document.querySelector(
                "#kt_list_widget_16_tab_4 .timeline-container"
            );
            container.innerHTML = data
                .map((item) => `<div class="item">${item.details}</div>`)
                .join("");
        })
        .catch((error) => console.error("Error fetching data:", error));
}

document
    .getElementById("filter-date")
    .addEventListener("change", fetchPoDataPerDays);
const indonesianHolidays2024 = [
    { title: "Tahun Baru Masehi", start: "2024-01-01" },
    { title: "Tahun Baru Imlek", start: "2024-02-10" },
    { title: "Hari Raya Nyepi", start: "2024-03-11" },
    { title: "Waisak", start: "2024-05-23" },
    { title: "Kenaikan Isa Almasih", start: "2024-05-09" },
    { title: "Hari Lahir Pancasila", start: "2024-06-01" },
    { title: "Hari Raya Idul Fitri", start: "2024-04-10" },
    { title: "Hari Raya Idul Fitri", start: "2024-04-11" },
    { title: "Hari Buruh", start: "2024-05-01" },
    { title: "Hari Raya Idul Adha", start: "2024-06-17" },
    { title: "Tahun Baru Hijriah", start: "2024-07-07" },
    { title: "Hari Kemerdekaan Indonesia", start: "2024-08-17" },
    { title: "Maulid Nabi", start: "2024-09-15" },
    { title: "Hari Natal", start: "2024-12-25" },
];

function initializeCalendar(events) {
    var calendarEl = document.getElementById("calendar");

    if (!calendarEl) {
        console.error("Calendar element not found.");
        return;
    }

    if (window.calendar) {
        window.calendar.destroy(); // Destroy existing calendar instance if it exists
    }

    try {
        window.calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
            },
            nowIndicator: true,
            initialView: "dayGridMonth",
            editable: false,
            dayMaxEvents: true, // Enable "1 more" link for dayMaxEvents
            events: events.concat(indonesianHolidays2024).map((event) => {
                const eventDate = moment(event.start).format("YYYY-MM-DD");
                const todayDate = moment().format("YYYY-MM-DD");

                // Check if the event is an Indonesian holiday
                const isHoliday = indonesianHolidays2024.some(
                    (holiday) => holiday.start === event.start
                );

                // Set the title based on whether it's a holiday
                const updatedTitle = isHoliday
                    ? `Public Holiday: ${event.title}`
                    : event.title;

                // Return the updated event object
                return {
                    ...event, // Spread the original event properties
                    title: updatedTitle, // Update the title with "Public Holiday" if applicable
                    classNames:
                        eventDate === todayDate
                            ? "bg-warning"
                            : isHoliday
                            ? "bg-danger public-holiday"
                            : "bg-purple",
                    backgroundColor: isHoliday
                        ? "#ff4c4c"
                        : event.backgroundColor || "", // Set background color to red for holidays
                    borderColor: isHoliday
                        ? "#ff4c4c"
                        : event.borderColor || "",
                    textColor: isHoliday ? "#ffffff" : event.textColor || "",
                    extendedProps: {
                        ...event.extendedProps, // Preserve any existing extendedProps
                        isHoliday: isHoliday, // Flag to indicate if the event is a public holiday
                        htmlContent: `
                                <div class="event-content">
                                    <i class="fas fa-calendar-day"></i>
                                    <span>${updatedTitle}</span>
                                </div>
                            `, // Display "Public Holiday" if it's a holiday
                    },
                };
            }),

            eventContent: function (info) {
                // Render HTML content from extendedProps
                return { html: info.event.extendedProps.htmlContent };
            },
            eventDidMount: function (info) {
                // Override the default "1 more" text with custom text
                info.el
                    .querySelectorAll(".fc-daygrid-more-link")
                    .forEach((link) => {
                        if (info.event.extendedProps.isHoliday) {
                            link.textContent = "1 public holiday";
                        } else {
                            link.textContent = "1 more event";
                        }
                    });
            },
            // Use this callback to add classes after rendering
            datesSet: function () {
                setTimeout(() => {
                    const holidayDates = indonesianHolidays2024.map((holiday) =>
                        moment(holiday.start).format("YYYY-MM-DD")
                    );
                    document
                        .querySelectorAll(".fc-daygrid-day")
                        .forEach((dayCell) => {
                            const date = dayCell.getAttribute("data-date");
                            if (holidayDates.includes(date)) {
                                dayCell.classList.add("public-holiday-day");
                            }
                        });
                }, 0); // Delay execution to ensure elements are available
            },
        });

        // Render the calendar
        window.calendar.render();

        // Add resize listener to adjust calendar height dynamically
        window.addEventListener("resize", () => {
            calendarEl.style.height = `${window.innerHeight - 100}px`;
            window.calendar.render(); // Re-render to apply the new height
        });
    } catch (error) {
        console.error("Error initializing calendar:", error);
    }
}

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
    var timelineContainer = $("#kt_list_widget_16_tab_1 .timeline-container");
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
                                        <!--begin::Label-->
                                        <span class="fs-7 fw-bolder text-info text-uppercase">Order</span>
                                        <!--end::Label-->
                                        <!--begin::Title-->
                                        <a href="#" class="fs-5 text-gray-800 fw-bold d-block text-hover-primary">${
                                            item.order_no
                                        }</a>
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

            // Update deliveries for tomorrow count
            $("#deliveriesForTomorrowCount").text(deliveriesForTomorrowCount);

            // Show or hide the badge based on the deliveries count
            if (deliveriesForTomorrowCount > 0) {
                $("#deliveriesForTomorrowBadge").removeClass("d-none");
            } else {
                $("#deliveriesForTomorrowBadge").addClass("d-none");
            }

            // Hide the spinner
            spinnerContainer.addClass("d-none");

            // Initialize the calendar with fetched events
            initializeCalendar(events);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);

            // Hide the spinner in case of an error
            spinnerContainer.addClass("d-none");

            timelineContainer.html(
                "<p class='text-danger'>Failed to load data. Please try again later.</p>"
            );
        },
    });
}



async function fetchPoDataPerDays() {
    const spinner = document.getElementById("spinner-po");
    const filterDate = document.getElementById("filter-date");
    const showExpired = document.getElementById("show-expired");
    const showCompleted = document.getElementById("show-completed");
    const showConfirmed = document.getElementById("show-confirmed");
    const showInProgress = document.getElementById("show-in-progress");
    const showReject = document.getElementById("show-reject");

    let chart = null;

    async function loadData() {
        spinner.style.display = "block";

        const selectedMonth = filterDate.value;

        try {
            const apiUrl = selectedMonth
                ? `/home/countDataPoPerDays?filterDate=${selectedMonth}`
                : "/home/countDataPoPerDays";
            const response = await fetch(apiUrl);

            if (!response.ok) {
                throw new Error("Failed to fetch PO data.");
            }

            const data = await response.json();

            if (!data || !data.data || data.data.dailyData.length === 0) {
                throw new Error("No data available for the selected period.");
            }

            const dates = data.data.dailyData.map((item) => item.date);
            const expired = data.data.dailyData.map((item) => item.expired);
            const completed = data.data.dailyData.map((item) => item.completed);
            const confirmed = data.data.dailyData.map((item) => item.confirmed);
            const inProgress = data.data.dailyData.map(
                (item) => item.in_progress
            );
            const totalReject = data.data.dailyData.map((item) => item.reject);

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
                if (showReject.checked) {
                    seriesName.push("Reject");
                    seriesData.push(totalReject);
                    seriesColors.push("#dc3545");
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
                                const selectedDate =
                                    dates[config.dataPointIndex];
                                const selectedStatus =
                                    seriesName[config.seriesIndex];
                                openModal(selectedDate, selectedStatus);
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
                const modal = document.getElementById("detailModal");
                const modalTitle = document.getElementById("modalTitle");
                const modalBody = document.getElementById("modalBody");

                modalTitle.textContent = `Details for ${status} on ${formatDate(
                    date
                )}`;

                modalBody.innerHTML =
                    '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';

                fetch(`/home/countDataPoPerDate?date=${date}&status=${status}`)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.data && data.data.length > 0) {
                            let tableHtml = `
                                    <table id="poDetailsTable" class="table align-middle table-row-dashed fs-6 gy-5 mb-0" style="color:black">
                                        <thead>
                                            <tr>
                                                <th>Order No</th>
                                                <th>Expired Date</th>`;

                            // Add the `Estimated Delivery Date` column if the status is `confirmed` or `printed`
                            if (
                                status === "Confirmed" ||
                                status === "printed"
                            ) {
                                tableHtml += `<th>Estimated Delivery Date</th>`;
                            }

                            if (status === "Completed") {
                                tableHtml += `<th>Estimated Delivery Date</th>`;
                                tableHtml += `<th>Receive Date</th>`;
                            }

                            tableHtml += `</tr></thead><tbody>`;

                            // Populate table rows with data
                            data.data.forEach((item) => {
                                tableHtml += `
                                        <tr>
                                            <td>${item.order_no}</td>
                                            <td>${formatDate(
                                                item.not_after_date
                                            )}`;

                                // Add the `Estimated Delivery Date` data if the status is `confirmed` or `printed`
                                if (
                                    item.status === "Confirmed" ||
                                    item.status === "printed"
                                ) {
                                    tableHtml += `<td>${formatDate(
                                        item.estimated_delivery_date
                                    )}</td>`;
                                }
                                if (item.status === "Completed") {
                                    tableHtml += `<td>${formatDate(
                                        item.estimated_delivery_date
                                    )}</td>`;
                                    tableHtml += `<td>${formatDate(
                                        item.rcv_head.receive_date
                                    )}</td>`;
                                }
                                tableHtml += `</tr>`;
                            });

                            tableHtml += `
                                    </tbody>
                                </table>
                                `;

                            modalBody.innerHTML = tableHtml;

                            // Initialize DataTables
                            $("#poDetailsTable").DataTable({
                                responsive: true,
                                pageLength: 5,
                                lengthChange: false,
                                autoWidth: false,
                                ordering: true,
                                order: [[0, "asc"]],
                            });
                        } else {
                            modalBody.innerHTML =
                                '<div class="text-center">No details available for this date.</div>';
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching modal details:", error);
                        modalBody.innerHTML =
                            '<div class="text-center text-danger">Failed to load details.</div>';
                    });

                // Show the modal
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            }

            initializeChart();
        } catch (error) {
            console.error("Error:", error);
        } finally {
            spinner.style.display = "none";
        }
    }

    loadData();

    filterDate.addEventListener("change", loadData);
    showExpired.addEventListener("change", loadData);
    showCompleted.addEventListener("change", loadData);
    showConfirmed.addEventListener("change", loadData);
    showInProgress.addEventListener("change", loadData);
    showReject.addEventListener("change", loadData);
}

  // Function to show the modal with AJAX-loaded content
  function showModal(title, url, type) {
    document.getElementById('mdlFormTitle').textContent = title;
    document.getElementById('mdlFormContent').style.display = 'none';
    const modal = new bootstrap.Modal(document.getElementById('mdlForm'));
    modal.show();

    if (type === 'faq') {
        loadFaqContent();
    } else if (type === 'form') {
        loadFormContent(url);
    }
}

// Function to load FAQ content
function loadFaqContent() {
    document.getElementById('mdlFormContent').innerHTML = `
        <div class="mb-3">
            <input type="text" id="faqSearchInput" class="form-control" placeholder="Search FAQs...">
        </div>
        <div id="faqResults"><p class="text-muted">Start typing to search for FAQs...</p></div>
    `;
    document.getElementById('mdlFormContent').style.display = 'block';

    let faqs = [];

    // Fetch FAQs from the server
    fetch('/faqs')
        .then(response => response.json())
        .then(data => {
            faqs = data;

            // Event listener for search input
            document.getElementById('faqSearchInput').addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const faqResults = document.getElementById('faqResults');
                faqResults.innerHTML = '';

                if (query.length > 0) {
                    const filteredFaqs = faqs.filter(faq => faq.question.toLowerCase().includes(query));

                    if (filteredFaqs.length > 0) {
                        filteredFaqs.forEach(faq => {
                            const faqItem = document.createElement('div');
                            faqItem.className = 'faq-item mb-3 d-flex align-items-start';
                            faqItem.innerHTML = `
                                <img src="${faq.image || 'https://via.placeholder.com/50'}" alt="${faq.question}" class="me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                <div>
                                    <h6 class="fw-bold">${faq.question}</h6>
                                    <p class="text-muted">${faq.answer}</p>
                                    <hr>
                                </div>
                            `;
                            faqResults.appendChild(faqItem);
                        });
                    } else {
                        faqResults.innerHTML = '<p class="text-muted">No FAQs found.</p>';
                    }
                } else {
                    faqResults.innerHTML = '<p class="text-muted">Start typing to search for FAQs...</p>';
                }
            });
        })
        .catch(error => console.error('Error fetching FAQs:', error));
}


// Function to load form content via AJAX
function loadFormContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('modalSpinner').style.display = 'none';
            document.getElementById('mdlFormContent').style.display = 'block';
            document.getElementById('mdlFormContent').innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading form content:', error);
            document.getElementById('modalSpinner').style.display = 'none';
            document.getElementById('mdlFormContent').style.display = 'block';
            document.getElementById('mdlFormContent').innerHTML = '<p class="text-danger">Failed to load content. Please try again later.</p>';
        });
}

// Example usage for showing the FAQ
document.getElementById('help-btn').addEventListener('click', function() {
    showModal('Search FAQ', '', 'faq');
});

// Example usage for showing a form




function formatDate(dateString) {
    // Define an array of month names in Indonesian
    const months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    // Create a Date object from the provided date string
    const date = new Date(dateString);

    // Extract day, month, and year
    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();

    // Return formatted date as "23 Desember 2023"
    return `${day} ${month} ${year}`;
}

// Function to animate progress bar
function fetchServiceLevelSupplier() {
    $.ajax({
        url: "/home/service-level", // Adjust URL as necessary
        method: "GET",
        success: function (response) {
            if (response.success) {
                const data = response.data;
                if (data.length > 0) {
                    // Sort data by average_service_level in descending order and get the top 5
                    const topSuppliers = data
                        .sort(
                            (a, b) =>
                                b.average_service_level -
                                a.average_service_level
                        )
                        .slice(0, 5);

                    // Clear any existing content
                    $("#supplier-list").empty();

                    // Generate and append list items for each supplier
                    topSuppliers.forEach((supplier) => {
                        const supplierHtml = `
                                <li class="list-group-item mb-3" style="color: black;">
                                    <h6 class="mb-1" style="color: black;"><strong>${supplier.supplier_name}</strong></h6>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"
                                            style="width: 0%;"
                                            aria-valuenow="${supplier.average_service_level}" aria-valuemin="0" aria-valuemax="100">
                                            <span>${supplier.average_service_level}%</span>
                                        </div>
                                    </div>
                                    <p class="mb-0 mt-1" style="color: black;">Service Level: <strong>${supplier.average_service_level}%</strong></p>
                                </li>
                            `;
                        $("#supplier-list").append(supplierHtml);

                        // Animate the progress bar
                        $(".progress-bar")
                            .last()
                            .animate(
                                { width: `${supplier.average_service_level}%` },
                                1000
                            );
                    });
                } else {
                    // Handle case where there is no data
                    $("#supplier-list").html(`
                            <li class="list-group-item text-center" style="color: black;">No data available</li>
                        `);
                }
            } else {
                // Handle error case
                console.error("Failed to fetch data:", response.error);
                $("#supplier-list").html(`
                        <li class="list-group-item text-center" style="color: black;">Error loading data</li>
                    `);
            }
        },
        error: function (xhr, status, error) {
            // Handle AJAX error
            console.error("AJAX error:", status, error);
            $("#supplier-list").html(`
                    <li class="list-group-item text-center" style="color: black;">Error loading data</li>
                `);
        },
    });
}
function fetchItemDetails() {
    const table = $('#item-details-table').DataTable({
        responsive: true,
        autoWidth: false, // Prevent automatic column width calculation for better responsiveness
        pageLength: 3, // Set pagination to 3 entries per page
        lengthMenu: [3], // Display only 3 entries per page, remove the default dropdown
        columns: [
            { title: "Description" },
            { title: "SKU" },
            { title: "Cost PO" },
            { title: "Cost Supplier" }
        ],
        language: {
            emptyTable: "Loading data..."
        }
    });

    // Function to format numbers as Rupiah
    const formatRupiah = (amount) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    };

    $.ajax({
        url: '/home/price-diff', // Adjust URL as necessary
        method: 'GET',
        success: function(response) {
            console.log(response, 'response111');

            const data = response.data;

            if (data.length > 0) {
                table.clear(); // Clear existing data

                data.forEach(item => {
                    table.row.add([
                        item.sku_desc,
                        item.sku,
                        formatRupiah(item.cost_po),
                        formatRupiah(item.cost_supplier)
                    ]);
                });

                table.draw(); // Draw the table with new data
            } else {
                table.clear().draw();
                $('#item-details-list').html('<tr><td colspan="4">No data available</td></tr>');
            }

        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
            $('#item-details-list').html('<tr><td colspan="4">Error loading data</td></tr>');
        }
    });
}



// Call the function to fetch data when the page loads




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

async function fetchTotals() {
    const url = '/home/getTotals'; // Adjust endpoint if needed

    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.success) {
            // Format numbers with thousand separators
            const formatThousand = (amount) => {
                return new Intl.NumberFormat('id-ID').format(amount);
            };

            document.getElementById('total-suppliers').textContent = formatThousand(data.totalSuppliers);
            document.getElementById('total-stores').textContent = formatThousand(data.totalStores);
        } else {
            console.error('Error fetching totals:', data.error);
        }
    } catch (error) {
        console.error('Error fetching totals:', error);
    }
}

// Call the function on page load


async function fetchTandaTerimaList(page = 1) {
    const url = `/home/tandaTerima?page=${page}`; // Adjust endpoint if needed

    try {
        const loadingSpinner = document.getElementById('loading-spinner');
        loadingSpinner.classList.remove('d-none'); // Show spinner

        const response = await fetch(url);
        const data = await response.json();

        const receiptList = document.getElementById('receipt-list');
        const pagination = document.getElementById('pagination');
        receiptList.innerHTML = ''; // Clear existing content
        pagination.innerHTML = ''; // Clear pagination

        loadingSpinner.classList.add('d-none'); // Hide spinner

        if (data.data.length === 0) {
            receiptList.innerHTML = '<p class="text-muted">No receipts found.</p>';
            return;
        }

        // Display the list of Tanda Terima
        data.data.forEach(item => {
            const listItem = document.createElement('a');
            listItem.href = `#`; // Placeholder link for further actions
            listItem.className = 'list-group-item list-group-item-action';
            listItem.innerHTML = `
                <div class="d-flex w-100 justify-content-between" style="color:black;">
                    <h5 class="mb-1" style="color:black;font-weight:bold;">${item.no_tt || 'No Order Number'}</h5>
                    <small>${item.tanggal}</small>
                </div>
                <p class="mb-1">${item.sup_name}</p>
                <small>Status: <span class="${item.status === 'n' ? 'badge bg-danger' : 'badge bg-success'}">
                    ${item.status === 'pending' ? 'Not Approved' : 'Approved'}
                </span></small>
            `;
            receiptList.appendChild(listItem);
        });

        // Handle pagination
        const totalPages = Math.ceil(data.recordsTotal / data.perPage); // Calculate total pages
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement('button');
            pageItem.textContent = i;
            pageItem.className = `btn btn-sm ${i === page ? 'btn-primary' : 'btn-outline-primary'} mx-1`;
            pageItem.addEventListener('click', () => fetchTandaTerimaList(i));
            pagination.appendChild(pageItem);
        }
    } catch (error) {
        console.error('Error fetching Tanda Terima list:', error);
        const receiptList = document.getElementById('receipt-list');
        receiptList.innerHTML = '<p class="text-danger">Error fetching data. Please try again later.</p>';
    }
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
    if (status == "rupiah") {
        data.total.dailyCounts.forEach((item) => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalCostRcv)); // Push count to seriesData array
        });
    } else if (status == "qty") {
        console.log("masuk sini ya", totalRcv);
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
