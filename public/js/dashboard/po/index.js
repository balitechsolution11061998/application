// Interval waktu untuk polling (dalam milidetik)
const POLLING_INTERVAL = 60000; // 60 detik

// Fungsi untuk memulai polling
function startPolling() {
    // Panggil fungsi fetchDataCount dan fetchDataCountHistory terlebih dahulu
    fetchDataCount();
    fetchDataCountHistory();

    // Set interval untuk polling
    setInterval(() => {
        fetchDataCount(); // Ambil data status
        fetchDataCountHistory(); // Ambil data history
    }, POLLING_INTERVAL);
}

// Panggil fungsi startPolling untuk memulai polling
startPolling();

async function fetchDataCount() {
    try {
        // Fetch data dari endpoint
        const response = await fetch('/dashboard-po/fetchDataPerStatus');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        // Parsing data JSON
        const data = await response.json();
        console.log(data, 'data');

        // Update DOM dengan data dan trigger animations pada slide aktif
        updateDOMWithData(data);
        triggerAnimationsOnActiveSlide(data);

    } catch (error) {
        console.error("Error fetching data count:", error);
    }
}

async function fetchDataCountHistory() {
    try {
        // Fetch data dari endpoint
        const response = await fetch('/dashboard-po/purchase-orders/count-per-date');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        // Parsing data JSON
        const data = await response.json();
        console.log(data, 'data');

        // Update DOM dengan data
        updateDOMWithData(data);

        // Render ulang grafik dengan data terbaru
        renderChart(data);

    } catch (error) {
        console.error("Error fetching data count history:", error);
    }
}

let chart; // Variabel global untuk menyimpan instance chart

function renderChart(data) {
    console.log(data);

    const dates = data.approval_date;
    const amounts = data.counts;

    if (chart) {
        chart.updateSeries([{
            name: 'Purchase Order History',
            data: amounts
        }]);
        chart.updateOptions({
            xaxis: {
                categories: dates
            }
        });
    } else {
        const options = {
            chart: {
                type: 'area', // Ubah tipe chart menjadi 'area'
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                },
                zoom: {
                    enabled: false
                },
                height: 400
            },
            series: [{
                name: 'Purchase Order History',
                data: amounts
            }],
            xaxis: {
                categories: dates,
                labels: {
                    format: 'dd MMM'
                },
                animation: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Qty'
                },
                animation: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            title: {
                text: 'Purchase Order History',
                align: 'left'
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val;
                    }
                },
                animation: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            stroke: {
                curve: 'smooth', // Garis tetap halus
                width: 3
            },
            markers: {
                size: 4,
                colors: "#FFA41B",
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7,
                }
            },
            fill: {
                type: 'gradient', // Menggunakan gradient untuk area
                gradient: {
                    shade: 'dark', // Warna gradient
                    gradientToColors: ['#4CAF50'], // Warna akhir gradient
                    shadeIntensity: 1, // Intensitas gradient
                    opacityFrom: 0.7, // Opasitas awal
                    opacityTo: 0.3, // Opasitas akhir
                    stops: [0, 100] // Titik awal dan akhir gradient
                }
            }
        };

        chart = new ApexCharts(document.querySelector("#history_po"), options);
        chart.render();
    }
}

function updateDOMWithData(data) {
    // Update Progress Data
    updateCardData('progress', data.progress, data.progressPercentage);

    // Update Confirmed Data
    updateCardData('confirmed', data.confirmed, data.confirmedPercentage);

    // Update Print Data
    updateCardData('print', data.printed, data.printedPercentage);

    // Update Expired Data
    updateCardData('expired', data.expired, data.expiredPercentage);

    // Update Reject Data
    updateCardData('reject', data.rejected, data.rejectedPercentage);

    // Update Complete Data
    updateCardData('complete', data.completed, data.completedPercentage);
}

function updateCardData(status, count, percentage) {
    const countElement = document.getElementById(`${status}Count`);
    const percentageElement = document.getElementById(`${status}Percentage`);
    const textElement = document.getElementById(`${status}Text`);
    const barElement = document.getElementById(`${status}Bar`);

    if (countElement) {
        countElement.textContent = count || 0;
    }
    if (percentageElement) {
        percentageElement.textContent = `${percentage || 0}%`;
    }
    if (textElement) {
        textElement.textContent = `${capitalizeFirstLetter(status)} (${count || 0} tasks)`;
    }
    if (barElement) {
        barElement.style.width = `${percentage || 0}%`;
        barElement.setAttribute('aria-valuenow', percentage || 0);
    }
}

function triggerAnimationsOnActiveSlide(data) {
    const carouselElement = document.getElementById('statusCarousel');
    carouselElement.addEventListener('slid.bs.carousel', function () {
        const activeSlide = carouselElement.querySelector('.carousel-item.active');

        // Trigger animations for the active slide
        if (activeSlide) {
            const statusCards = activeSlide.querySelectorAll('.card');
            statusCards.forEach(card => {
                const status = card.querySelector('.card-label').textContent.toLowerCase();
                const countElement = card.querySelector(`#${status}Count`);
                const percentageElement = card.querySelector(`#${status}Percentage`);

                if (countElement) {
                    const endValue = parseInt(countElement.textContent, 10);
                    animateValue(countElement, 0, endValue, 1000);
                }
                if (percentageElement) {
                    const endPercentage = parseInt(percentageElement.textContent, 10);
                    animateValue(percentageElement, 0, endPercentage, 1000);
                }
            });
        }
    });
}

function animateValue(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        element.textContent = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
function renderPOFollowUpTable() {
    // Inisialisasi DataTables
    const dt = $("#po_followup").DataTable({
        processing: true, // Menampilkan loading indicator
        serverSide: true, // Mengaktifkan server-side processing
        ajax: {
            url: "/dashboard-po/purchase-orders/followUp", // Ganti dengan endpoint API Anda
            type: "GET", // Metode HTTP untuk mengambil data
            dataSrc: "data", // Properti dalam respons JSON yang berisi data
            error: function (xhr, error, thrown) {
                console.error("Error fetching data: ", error);
                alert("Terjadi kesalahan saat mengambil data. Silakan coba lagi.");
            }
        },
        columns: [
            { data: 'order_no', title: 'Order No' },
            { data: 'approval_date', title: 'Approval Date' },
            { data: 'not_after_date', title: 'Expired Date' },
            { data: 'days_since_approval', title: 'Tanggal Hari' },
            {
                data: 'status',
                title: 'Status',
                render: function (data, type, row) {
                    // Define badge class and icon based on status
                    let badgeClass = 'badge-light';
                    let iconClass = 'fas fa-question-circle'; // Default icon
            
                    if (data === 'Progress') {
                        badgeClass = 'badge-warning';
                        iconClass = 'fas fa-spinner'; // Icon for Progress
                    } else if (data === 'Confirmed') {
                        badgeClass = 'badge-info';
                        iconClass = 'fas fa-check-circle'; // Icon for Confirmed
                    } else if (data === 'Pending Payment') {
                        badgeClass = 'badge-danger';
                        iconClass = 'fas fa-exclamation-circle'; // Icon for Pending Payment
                    } else if (data === 'Completed') {
                        badgeClass = 'badge-success';
                        iconClass = 'fas fa-check'; // Icon for Completed
                    }
            
                    // Add padding and Font Awesome icon to the badge
                    return `<span class="badge ${badgeClass} p-2"><i class="${iconClass} me-2"></i>${data}</span>`;
                }
            },
            {
                data: null,
                title: 'Tindakan',
                orderable: false,
                render: function (data, type, row) {
                    // Tombol tindakan
                    return `
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#" data-kt-docs-table-filter="edit_row">Edit</a></li>
                                <li><a class="dropdown-item" href="#" data-kt-docs-table-filter="delete_row">Delete</a></li>
                            </ul>
                        </div>
                    `;
                }
            }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" // Bahasa Indonesia
        },
        paging: true, // Aktifkan pagination
        pageLength: 10, // Tampilkan 10 data per halaman
        lengthChange: false, // Nonaktifkan pilihan jumlah data per halaman
        searching: true, // Aktifkan fitur pencarian
        ordering: true, // Aktifkan sorting
        info: true // Tampilkan informasi jumlah data
    });

    // Handle search input
    const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
    if (filterSearch) {
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Handle action buttons
    $('#po_followup').on('click', '[data-kt-docs-table-filter="edit_row"]', function (e) {
        e.preventDefault();
        const row = dt.row($(this).closest('tr')).data();
        alert('Edit PO: ' + row.order_no);
        // Implement your edit functionality here
    });

    $('#po_followup').on('click', '[data-kt-docs-table-filter="delete_row"]', function (e) {
        e.preventDefault();
        const row = dt.row($(this).closest('tr')).data();
        if (confirm('Apakah Anda yakin ingin menghapus PO: ' + row.order_no + '?')) {
            // Implement your delete functionality here
            alert('Delete PO: ' + row.order_no);
        }
    });
}

function fetchDataCountPerRegion() {
    am5.ready(function () {
        // Create root element
        var root = am5.Root.new("kt_amcharts_3");

        // Set themes
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        // Create chart
        var chart = root.container.children.push(am5percent.PieChart.new(root, {
            layout: root.verticalLayout
        }));

        // Create series
        var series = chart.series.push(am5percent.PieSeries.new(root, {
            alignLabels: true,
            calculateAggregates: true,
            valueField: "value",
            categoryField: "category"
        }));

        series.slices.template.setAll({
            strokeWidth: 3,
            stroke: am5.color(0xffffff)
        });

        series.labelsContainer.set("paddingTop", 30);

        // Set up adapters for variable slice radius
        series.slices.template.adapters.add("radius", function (radius, target) {
            var dataItem = target.dataItem;
            var high = series.getPrivate("valueHigh");

            if (dataItem) {
                var value = target.dataItem.get("valueWorking", 0);
                return radius * value / high;
            }
            return radius;
        });

        // Function to fetch data via AJAX and update chart
        function fetchDataAndUpdateChart() {
            $.ajax({
                url: '/dashboard-po/purchase-orders/count-per-region', // Replace with your API endpoint
                method: 'GET',
                success: function (response) {
                    // Transform response data to match chart's expected format
                    var chartData = response.map(function(item) {
                        return {
                            category: item.region,
                            value: item.total_count
                        };
                    });

                    series.data.setAll(chartData);
                    console.log(chartData, 'chartData');

                    // Update legend
                    legend.data.setAll(series.dataItems);

                    // Adjust chart width if necessary
                    chart.set("width", $("#kt_amcharts_3").width()); // Corrected line
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Create legend
        var legend = chart.children.push(am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50,
            marginTop: 15,
            marginBottom: 15
        }));

        // Initial data fetch and chart setup
        fetchDataAndUpdateChart();

        // Play initial series animation
        series.appear(1000, 100);

        // Optionally, set up a timer or event to refresh data periodically
        setInterval(fetchDataAndUpdateChart, 60000); // Refresh every 60 seconds
    });
}



// Render tabel saat halaman dimuat
document.addEventListener("DOMContentLoaded", () => {
    renderPOFollowUpTable();
    fetchDataCountPerRegion();
});


