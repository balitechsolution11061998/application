$(document).ready(function () {
    fetchQueryPerformanceLogs();
    document.getElementById('showExecutionTime').checked = true;

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


});

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
            },
            toolbar: {
                show: true
            }
        },
        series: series,
        xaxis: {
            categories: labels, // Set categories for the x-axis
            title: {
                text: 'Function Names',
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    color: '#333'
                }
            },
            labels: {
                style: {
                    fontSize: '12px',
                    colors: '#555'
                }
            }
        },
        yaxis: {
            title: {
                text: 'Values',
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    color: '#333'
                }
            },
            labels: {
                formatter: function (value) {
                    // Determine if memory usage is being displayed
                    const isMemoryUsage = series.some(s => s.name === 'Memory Usage');
                    return isMemoryUsage ? `${value} MB` : value.toFixed(2); // Append 'MB' for memory usage
                },
                style: {
                    fontSize: '12px',
                    colors: '#555'
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: false, // Set to true for horizontal bars
                columnWidth: '35%', // Width of bars (adjusted for better spacing)
                endingShape: 'rounded', // Rounded edges for bars
                borderRadius: 8 // Radius for rounded corners
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '10px',
                colors: ['#fff']
            },
            dropShadow: {
                enabled: true,
                top: 1,
                left: 1,
                blur: 1,
                opacity: 0.5
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            labels: {
                style: {
                    fontSize: '12px',
                    colors: '#333'
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
                fontSize: '12px',
                fontFamily: 'Arial, sans-serif'
            },
            theme: 'dark', // Dark theme for tooltip
            marker: {
                show: true
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
                { data: 'avg_upload_speed', name: 'avg_upload_speed' },
                { data: 'avg_memory_usage', name: 'avg_memory_usage' }
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
