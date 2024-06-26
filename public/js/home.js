document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("quickGuideButton")
        .addEventListener("click", function () {
            introJs()
                .setOptions({
                    steps: [
                        {
                            element: "#cardCountPo",
                            intro: "This card is used to track the number of Purchase Orders (POs) released through the system in terms of currency (rupiah) and quantity (qty).",
                            position: "right",
                            title: "Purcase Order", // Add the title here
                        },
                        {
                            element: "#cardCountRcv",
                            intro: "This card is used to track the number of Receivings (RCVs) processed through the system in terms of currency (rupiah) and quantity (qty).",
                            position: "right",
                            title: "Receivings", // Add the title here
                        },
                    ],
                    tooltipClass: "custom-tooltip-class",
                })
                .start();
        });

    document.getElementById("filter").addEventListener("click", function () {
        // Show SweetAlert2 spinner
        Swal.fire({
            title: "Loading...",
            text: "Please wait",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        // Simulate some processing delay
        setTimeout(function () {
            // Close SweetAlert2
            Swal.close();

            // Open modal
            $("#mdlForm").modal("show");
            $("#mdlFormTitle").html("Filter");
            // Inject form content into modal
            $('#mdlFormContent').html(`
                <form id="filterForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dateRange">Date Range</label>
                                <input type="text" class="form-control" id="dateRange" name="dateRange" value="null">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="store">Store</label>
                                <select class="form-control" id="store" name="store">
                                    <option value="">Select Store</option>
                                    <option value="store1">Store 1</option>
                                    <option value="store2">Store 2</option>
                                    <!-- Add more store options here -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <select class="form-control" id="supplier" name="supplier">
                                    <option value="">Select Supplier</option>
                                    <option value="supplier1">Supplier 1</option>
                                    <option value="supplier2">Supplier 2</option>
                                    <!-- Add more supplier options here -->
                                </select>
                            </div>
                        </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier">Status</label>
                                <select class="form-control" id="statusData" name="statusData">
                                    <option value="">Select Status</option>
                                    <option value="rupiah">Total (Rp.)</option>
                                    <option value="qty">Qty</option>
                                    <!-- Add more supplier options here -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Apply Filters</button>

                </form>
            `);

            // Initialize date range picker
            $("#dateRange").daterangepicker({
                opens: "left",
                autoUpdateInput: false,
                locale: {
                    cancelLabel: "Clear",
                },
            });

            $("#dateRange").on("apply.daterangepicker", function (ev, picker) {
                $(this).val(
                    picker.startDate.format("MM/DD/YYYY") +
                        " - " +
                        picker.endDate.format("MM/DD/YYYY")
                );
            });

            $("#dateRange").on("cancel.daterangepicker", function (ev, picker) {
                $(this).val("");
            });

            // Handle form submission
            $("#filterForm").on("submit", function (event) {
                event.preventDefault(); // Prevent the default form submission

                // Get form values
                var dateRange = $("#dateRange").val();
                var store = $("#store").val();
                var supplier = $("#supplier").val();
                var statusData = $("#statusData").val();

                fetchCountPo(statusData,dateRange);
                fetchCountPoDays(statusData,dateRange);
                fetchCountRcv(statusData,dateRange);
                fetchCountRcvDays(statusData,dateRange);

                // Close modal after processing
                $("#mdlForm").modal("hide");

                // Optionally, show a success message
                Swal.fire({
                    icon: "success",
                    title: "Filters Applied",
                    text: "Your filters have been applied successfully.",
                });
            });
        }, 2000); // Change the timeout duration as needed
    });

    fetchCountPo(null,null);
    fetchCountPoDays(null,null);

    fetchCountRcv(null,null);
    fetchCountRcvDays(null,null);

});

async function fetchCountPoDays(status,filterDate) {
    const url = `/home/countDataPoPerDays?filterDate=${filterDate}`;

    // Fetch data from your API
    const response = await fetch(url); // Replace 'your-api-endpoint' with your actual API URL
    const data = await response.json();
    // Process your data and extract the necessary information for the chart
    const categories = []; // Array to store categories (x-axis labels)
    const seriesData = []; // Array to store series data (y-axis values)
    // Populate categories and seriesData arrays based on the fetched data
    // Example: Assuming your data contains objects with 'date' and 'count' properties
    if(status == "rupiah"){
        data.data.forEach(item => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalCost)); // Push count to seriesData array
        });
    }else if(status=="qty"){
        console.log(categories,seriesData,status,data.total,'seriesData');

        data.data.forEach(item => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalPo)); // Push count to seriesData array
        });
    }else{
        console.log(categories,seriesData,status,data,'seriesData1');

        data.data.forEach(item => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalCost)); // Push count to seriesData array
        });
    }


    // Define your ApexCharts options
    const options = {
        chart: {
            type: 'line',
            height: 250, // Specify chart height
            // Add more chart options as needed
        },
        series: [{
            name: 'Count', // Specify series name
            data: seriesData, // Specify series data
        }],
        xaxis: {
            categories: categories, // Specify x-axis categories
            labels: {
                show: false, // Hide x-axis labels
            }
        },
        yaxis: {
            labels: {
                show: false, // Hide y-axis labels
            }
        },
        colors: ['#808080'],
        responsive: [
            {
                breakpoint: 1000, // Breakpoint for medium screens
                options: {
                    chart: {
                        width: '100%', // Set width to 100%
                    },
                    legend: {
                        position: 'bottom', // Position legend at the bottom
                    },
                    xaxis: {
                        labels: {
                            show: false, // Hide x-axis labels for medium screens
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false, // Hide y-axis labels for medium screens
                        }
                    }
                },
            },
            {
                breakpoint: 600, // Breakpoint for small screens
                options: {
                    chart: {
                        width: '100%', // Set width to 100%
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
                        position: 'bottom', // Position legend at the bottom
                    },
                },
            },
        ],
        // Add more chart options as needed
    };

    // Render the chart using ApexCharts
    const chart = new ApexCharts(document.querySelector('#chart-po'), options);
    chart.render();

}


async function fetchCountPo(status,filterDate) {
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
            countPoElement.textContent= "";
            if(status == "rupiah"){

                integerPart = Math.floor(data.total.totalCost);
            } else if(status == "qty"){
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
            const redirectedResponse = await fetch(response.headers.get("Location"), {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
                redirect: "follow", // Follow redirects for the redirected URL
            });

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

async function fetchCountRcvDays(status,filterDate) {
    const url = `/home/countDataRcvPerDays?filterDate=${filterDate}`;

    // Fetch data from your API
    const response = await fetch(url); // Replace 'your-api-endpoint' with your actual API URL
    const data = await response.json();
    // Process your data and extract the necessary information for the chart
    const categories = []; // Array to store categories (x-axis labels)
    const seriesData = []; // Array to store series data (y-axis values)
    // Populate categories and seriesData arrays based on the fetched data
    // Example: Assuming your data contains objects with 'date' and 'count' properties
    if(status == "rupiah"){
        data.total.dailyCounts.forEach(item => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalCostRcv)); // Push count to seriesData array
        });
    }else if(status=="qty"){
        console.log("masuk sini ya");
        data.total.dailyCounts.forEach(item => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalRcv)); // Push count to seriesData array
        });
    }else{
        console.log(data.total.dailyCounts);
        data.total.dailyCounts.forEach(item => {
            categories.push(item.tanggal); // Push date to categories array
            seriesData.push(formatRupiah(item.totalCostRcv)); // Push count to seriesData array
        });
    }


    // Define your ApexCharts options
    const options = {
        chart: {
            type: 'line',
            height: 250, // Specify chart height
            // Add more chart options as needed
        },
        series: [{
            name: 'Count', // Specify series name
            data: seriesData, // Specify series data
        }],
        xaxis: {
            categories: categories, // Specify x-axis categories
            labels: {
                show: false, // Hide x-axis labels
            }
        },
        yaxis: {
            labels: {
                show: false, // Hide y-axis labels
            }
        },
        colors: ['#808080'],
        responsive: [
            {
                breakpoint: 1000, // Breakpoint for medium screens
                options: {
                    chart: {
                        width: '100%', // Set width to 100%
                    },
                    legend: {
                        position: 'bottom', // Position legend at the bottom
                    },
                    xaxis: {
                        labels: {
                            show: false, // Hide x-axis labels for medium screens
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false, // Hide y-axis labels for medium screens
                        }
                    }
                },
            },
            {
                breakpoint: 600, // Breakpoint for small screens
                options: {
                    chart: {
                        width: '100%', // Set width to 100%
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
                        position: 'bottom', // Position legend at the bottom
                    },
                },
            },
        ],
        // Add more chart options as needed
    };

    // Render the chart using ApexCharts
    const chart = new ApexCharts(document.querySelector('#chart-rcv'), options);
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
