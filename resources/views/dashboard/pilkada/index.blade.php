<x-default-layout>
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

    <div class="container-fluid py-5 bg-light">
        <!-- Dashboard Header -->
        <div class="dashboard-header text-center mb-5">
            <h1 class="display-4 fw-bold">Dashboard Pilkada</h1>
            <p class="lead text-muted">Monitor and sync the latest voting data seamlessly</p>
        </div>

        <!-- Sync Data Buttons Section -->
        <div class="d-flex justify-content-center flex-wrap gap-3 mb-5">
            <button id="syncProvinsiButton" class="btn btn-primary btn-lg d-flex align-items-center gap-2 shadow">
                <i class="fas fa-sync"></i>
                <span>Sync Provinsi Data</span>
            </button>
            <button id="syncKabupatenButton" class="btn btn-success btn-lg d-flex align-items-center gap-2 shadow">
                <i class="fas fa-sync"></i>
                <span>Sync Kabupaten Data</span>
            </button>
            <button id="syncKecamatanButton" class="btn btn-info btn-lg d-flex align-items-center gap-2 shadow">
                <i class="fas fa-sync"></i>
                <span>Sync Kecamatan Data</span>
            </button>
            <button id="syncKelurahanButton" class="btn btn-secondary btn-lg d-flex align-items-center gap-2 shadow">
                <i class="fas fa-sync"></i>
                <span>Sync Kelurahan Data</span>
            </button>
            <button id="syncTpsButton" class="btn btn-warning btn-lg d-flex align-items-center gap-2 shadow">
                <i class="fas fa-sync"></i>
                <span>Sync TPS Data</span>
            </button>
            <button id="syncPilkadaButton" class="btn btn-dark btn-lg d-flex align-items-center gap-2 shadow">
                <i class="fas fa-sync"></i>
                <span>Sync Pilkada</span>
            </button>
        </div>

        @if (count($provinces) > 1)
            <!-- Province and Location Select Dropdowns -->
            <div class="row gy-4">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select id="provinceSelect" class="form-select" data-control="select2">
                            <option></option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->kode }}"
                                    data-kt-select2-country="{{ $province->flag_url ?? '' }}">
                                    {{ $province->nama }}
                                </option>
                            @endforeach
                        </select>
                        <label for="provinceSelect">Select a Province</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select id="kabupatenSelect" class="form-select" data-control="select2">
                            <option></option>
                        </select>
                        <label for="kabupatenSelect">Select a Kabupaten</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select id="kecamatanSelect" class="form-select">
                            <option></option>
                        </select>
                        <label for="kecamatanSelect">Select a Kecamatan</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select id="kelurahanSelect" class="form-select">
                            <option></option>
                        </select>
                        <label for="kelurahanSelect">Select a Kelurahan</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select id="tpsSelect" class="form-select">
                            <option></option>
                        </select>
                        <label for="tpsSelect">Select a TPS</label>
                    </div>
                </div>
            </div>

            <!-- Summary and Chart Section -->
            <div class="container mt-5">
                <h3 class="mb-4 text-center">Ringkasan Data TPS</h3>
                <div id="summary" class="mb-4 p-4 border rounded bg-white shadow-sm">
                    <p class="text-center text-black">Summary will appear here</p>
                </div>

                <div id="chart" class="p-4 border rounded bg-white shadow-sm">
                    <p class="text-muted text-center">Bar Chart will be displayed here</p>
                </div>
                <div id="pieChart" class="p-4 border rounded bg-white shadow-sm mt-4">
                    <p class="text-muted text-center">Pie Chart will be displayed here</p>
                </div>

            </div>
        @endif
    </div>


    @push('scripts')
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Initialize Select2 for Province, Kabupaten, Kecamatan, Kelurahan, and TPS Dropdowns
                $('#provinceSelect, #kabupatenSelect, #kecamatanSelect, #kelurahanSelect, #tpsSelect').select2({
                    placeholder: "Select an option",
                    allowClear: true,
                });

                // Utility function to populate dropdown and initialize Select2
                function populateDropdown(selectElement, data, placeholder) {
                    selectElement.innerHTML = '<option></option>'; // Clear existing options
                    if (selectElement.id === 'tpsSelect') {
                        // Tambahkan opsi "Semua TPS" secara eksplisit
                        const allOption = document.createElement('option');
                        allOption.value = "all";
                        allOption.textContent = "Semua TPS";
                        selectElement.appendChild(allOption);
                    }
                    if (data.length > 0) {
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.kode;
                            option.textContent = item.nama;
                            selectElement.appendChild(option);
                        });
                    }

                    // Safely initialize or reinitialize Select2
                    if ($.fn.select2) {
                        if ($(selectElement).hasClass('select2-hidden-accessible')) {
                            $(selectElement).select2('destroy');
                        }
                        $(selectElement).select2({
                            placeholder: placeholder,
                            allowClear: true,
                        });
                    } else {
                        console.error("Select2 plugin not loaded.");
                    }
                }


                // Fetch data and handle dropdown population
                function fetchData(url, selectElement, placeholder) {
                    return fetch(url)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => populateDropdown(selectElement, data, placeholder))
                        .catch(error => {
                            console.error(`Error fetching ${placeholder.toLowerCase()} data:`, error);

                            // Display toastr error notification
                            toastr.error(`Failed to load ${placeholder.toLowerCase()} data. Please try again.`);
                        });
                }


                // Handle Province change
                $('#provinceSelect').on('change.select2', function() {
                    const provinceId = this.value;
                    const kabupatenSelect = document.getElementById('kabupatenSelect');
                    const kecamatanSelect = document.getElementById('kecamatanSelect');
                    const kelurahanSelect = document.getElementById('kelurahanSelect');
                    const tpsSelect = document.getElementById('tpsSelect');

                    // Reset Kabupaten, Kecamatan, Kelurahan, and TPS dropdowns
                    kabupatenSelect.innerHTML = '<option></option>';
                    kecamatanSelect.innerHTML = '<option></option>';
                    kelurahanSelect.innerHTML = '<option></option>';
                    tpsSelect.innerHTML = '<option></option>';

                    // Destroy Kecamatan, Kelurahan, and TPS Select2 safely
                    [kecamatanSelect, kelurahanSelect, tpsSelect].forEach(select => {
                        if ($(select).hasClass('select2-hidden-accessible')) $(select).select2(
                            'destroy');
                        $(select).val(null).trigger('change');
                    });

                    if (provinceId) {
                        fetchData(`/data-kabupaten?province_id=${provinceId}`, kabupatenSelect, "Kabupaten")
                            .then(() => {
                                fetchChartData(provinceId);
                                $('#kabupatenSelect').on('change.select2', function() {
                                    const kabupatenId = this.value;
                                    if (kabupatenId) {
                                        fetchData(
                                                `/data-kecamatan?province_id=${provinceId}&kabupaten_id=${kabupatenId}`,
                                                kecamatanSelect, "Kecamatan")
                                            .then(() => {
                                                fetchChartData(provinceId,kabupatenId);
                                                $('#kecamatanSelect').on('change.select2',
                                                    function() {
                                                        const kecamatanId = this.value;
                                                        if (kecamatanId) {
                                                            fetchData(
                                                                    `/data-kelurahan?province_id=${provinceId}&kabupaten_id=${kabupatenId}&kecamatan_id=${kecamatanId}`,
                                                                    kelurahanSelect,
                                                                    "Kelurahan")
                                                                .then(() => {
                                                                    fetchChartData(provinceId,kabupatenId,kecamatanId);
                                                                    $('#kelurahanSelect')
                                                                        .on('change.select2',
                                                                            function() {
                                                                                const
                                                                                    kelurahanId =
                                                                                    this
                                                                                    .value;
                                                                                if (
                                                                                    kelurahanId
                                                                                ) {
                                                                                    fetchData
                                                                                        (
                                                                                            `/data-tps?province_id=${provinceId}&kabupaten_id=${kabupatenId}&kecamatan_id=${kecamatanId}&kelurahan_id=${kelurahanId}`,
                                                                                            tpsSelect,
                                                                                            "TPS"
                                                                                        )
                                                                                        .then(
                                                                                            () => {
                                                                                                // Tambahkan event listener untuk TPS setelah data dimuat
                                                                                                $('#tpsSelect')
                                                                                                    .on('change.select2',
                                                                                                        function() {
                                                                                                            const
                                                                                                                tpsId =
                                                                                                                this
                                                                                                                .value;
                                                                                                            if (tpsId ===
                                                                                                                "all"
                                                                                                            ) {
                                                                                                                fetchChartData
                                                                                                                    (provinceId,
                                                                                                                        kabupatenId,
                                                                                                                        kecamatanId,
                                                                                                                        kelurahanId
                                                                                                                    );
                                                                                                            } else if (
                                                                                                                tpsId
                                                                                                            ) {
                                                                                                                fetchChartData
                                                                                                                    (provinceId,
                                                                                                                        kabupatenId,
                                                                                                                        kecamatanId,
                                                                                                                        kelurahanId,
                                                                                                                        tpsId
                                                                                                                    );
                                                                                                            } else {
                                                                                                                toastr
                                                                                                                    .warning(
                                                                                                                        'Please select a valid TPS.'
                                                                                                                    );
                                                                                                            }
                                                                                                        }
                                                                                                    );
                                                                                            }
                                                                                        );
                                                                                } else {
                                                                                    tpsSelect
                                                                                        .innerHTML =
                                                                                        '<option></option>';
                                                                                    if ($(
                                                                                            tpsSelect
                                                                                        )
                                                                                        .hasClass(
                                                                                            'select2-hidden-accessible'
                                                                                        )
                                                                                    ) {
                                                                                        $(tpsSelect)
                                                                                            .select2(
                                                                                                'destroy'
                                                                                            );
                                                                                    }
                                                                                    $(tpsSelect)
                                                                                        .val(
                                                                                            null
                                                                                        )
                                                                                        .trigger(
                                                                                            'change'
                                                                                        );
                                                                                }
                                                                            });

                                                                });
                                                        } else {
                                                            kelurahanSelect.innerHTML =
                                                                '<option></option>';
                                                            tpsSelect.innerHTML =
                                                                '<option></option>';
                                                            [kelurahanSelect, tpsSelect]
                                                            .forEach(select => {
                                                                if ($(select)
                                                                    .hasClass(
                                                                        'select2-hidden-accessible'
                                                                    )) $(select)
                                                                    .select2(
                                                                        'destroy');
                                                                $(select).val(null)
                                                                    .trigger(
                                                                        'change');
                                                            });
                                                        }
                                                    });
                                            });
                                    } else {
                                        kecamatanSelect.innerHTML = '<option></option>';
                                        kelurahanSelect.innerHTML = '<option></option>';
                                        tpsSelect.innerHTML = '<option></option>';
                                        [kecamatanSelect, kelurahanSelect, tpsSelect].forEach(
                                            select => {
                                                if ($(select).hasClass(
                                                        'select2-hidden-accessible')) $(select)
                                                    .select2('destroy');
                                                $(select).val(null).trigger('change');
                                            });
                                    }
                                });
                            });
                    }
                });



                // Generic function to sync data and handle progress
                const syncData = (buttonSelector, routeGenerator, successMessage) => {
                    $(buttonSelector).on('click', function() {
                        const provinceId = $("#provinceSelect").val();
                        const kabupatenId = $("#kabupatenSelect").val();
                        const kecamatanId = $("#kecamatanSelect").val();
                        const kelurahanId = $("#kelurahanSelect")
                            .val(); // Ensure kelurahan is also selected
                        const tpsId = $("#tpsSelect").val(); // Fetch TPS ID for Pilkada sync

                        // Validation before syncing data
                        if ((routeGenerator === generateKabupatenRoute || routeGenerator ===
                                generateKecamatanRoute) && !provinceId) {
                            toastr.error('Please select a province first.');
                            return;
                        }

                        if ((routeGenerator === generateKecamatanRoute || routeGenerator ===
                                generateKelurahanRoute) && !kabupatenId) {
                            toastr.error('Please select a kabupaten first.');
                            return;
                        }

                        if ((routeGenerator === generateKelurahanRoute || routeGenerator ===
                                generateTpsRoute) && !kecamatanId) {
                            toastr.error('Please select a kecamatan first.');
                            return;
                        }

                        if ((routeGenerator === generateTpsRoute || routeGenerator ===
                                generatePilkadaRoute) && !kelurahanId) {
                            toastr.error('Please select a kelurahan first.');
                            return;
                        }

                        if (routeGenerator === generatePilkadaRoute && !tpsId) {
                            toastr.error('Please select a TPS first.');
                            return;
                        }

                        const route = routeGenerator(provinceId, kabupatenId, kecamatanId, kelurahanId,
                            tpsId);

                        // Show loading state
                        Swal.fire({
                            title: 'Syncing Data...',
                            text: 'Please wait while we sync the data.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                        });

                        // Make the AJAX request to sync the data
                        $.ajax({
                            url: route,
                            type: 'GET',
                            beforeSend: () => {
                                // Show Swal loader before the AJAX call
                                Swal.fire({
                                    title: 'Processing...',
                                    html: '<div class="spinner-border text-primary" role="status"></div>',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success: (response) => {
                                Swal.close(); // Close Swal loader
                                if (response.code === 200) {
                                    toastr.success(successMessage);

                                    // Show animation (optional delay before reloading)
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Data synced successfully. Reloading...',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false,
                                        willClose: () => {
                                            location.reload(); // Reload the page
                                        }
                                    });
                                } else {
                                    toastr.error('Failed to sync data.');
                                }
                            },
                            error: () => {
                                Swal.close(); // Close Swal loader
                                toastr.error(
                                    'An error occurred while syncing data. Please try again.'
                                );
                            }
                        });

                    });
                };

                // Route generators for dynamic routes
                const generateProvinsiRoute = () => '/sync-provinces';
                const generateKabupatenRoute = (provinceId) => `/sync-kabupaten/${provinceId}`;
                const generateKecamatanRoute = (provinceId, kabupatenId) =>
                    `/sync-kecamatan/${provinceId}/${kabupatenId}`;
                const generateKelurahanRoute = (provinceId, kabupatenId, kecamatanId) =>
                    `/sync-kelurahan/${provinceId}/${kabupatenId}/${kecamatanId}`;
                const generateTpsRoute = (provinceId, kabupatenId, kecamatanId, kelurahanId) =>
                    `/sync-tps/${provinceId}/${kabupatenId}/${kecamatanId}/${kelurahanId}`;
                const generatePilkadaRoute = (provinceId, kabupatenId, kecamatanId, kelurahanId, tpsId) =>
                    `/sync-pilkada/${provinceId}/${kabupatenId}/${kecamatanId}/${kelurahanId}/${tpsId}`;

                // Bind syncData to buttons
                syncData('#syncProvinsiButton', generateProvinsiRoute, 'Province data successfully synced!');
                syncData('#syncKabupatenButton', generateKabupatenRoute, 'Kabupaten data successfully synced!');
                syncData('#syncKecamatanButton', generateKecamatanRoute, 'Kecamatan data successfully synced!');
                syncData('#syncKelurahanButton', generateKelurahanRoute, 'Kelurahan data successfully synced!');
                syncData('#syncTpsButton', generateTpsRoute, 'TPS data successfully synced!');
                syncData('#syncPilkadaButton', generatePilkadaRoute, 'Pilkada data successfully synced!');

            });

            // Fetch data for the chart
            let chart; // Declare the chart instance globally or outside the function to reuse it.
            let pieChart; // Declare the pie chart instance globally.

            function fetchChartData(provinceId, kabupatenId = null, kecamatanId = null, kelurahanId = null, tpsId = null) {
                Swal.fire({
                    title: "Loading data...",
                    text: "Please wait while the data is being loaded.",
                    didOpen: () => Swal.showLoading(),
                });

                // Construct the API URL based on available parameters
                let apiUrl = `/data-pilkada?province_id=${provinceId}`;
                if (kabupatenId) apiUrl += `&kabupaten_id=${kabupatenId}`;
                if (kecamatanId) apiUrl += `&kecamatan_id=${kecamatanId}`;
                if (kelurahanId) apiUrl += `&kelurahan_id=${kelurahanId}`;
                if (tpsId) apiUrl += `&tps_id=${tpsId}`;

                fetch(apiUrl)
                    .then((response) => {
                        if (!response.ok) throw new Error(`Failed to fetch chart data: ${response.statusText}`);
                        return response.json();
                    })
                    .then((data) => {
                        Swal.close();

                        if (data.code === 200 && data.data.length > 0) {
                            console.log(data.data, 'data');

                            const summaryTotals = {
                                suara_sah: 0,
                                suara_total: 0,
                                pemilih_dpt_l: 0,
                                pemilih_dpt_j: 0,
                            };

                            const chartData = data.data.reduce((acc, tps) => {
                                // Check if tungsura_administrasi is valid and parse it
                                let tungsuraData = null;
                                try {
                                    tungsuraData = JSON.parse(tps.tungsura_administrasi);
                                } catch (e) {
                                    console.error("Error parsing tungsura_administrasi:", e);
                                }

                                // Only proceed if tungsuraData is valid
                                if (tungsuraData) {
                                    summaryTotals.suara_sah += tungsuraData.suara_sah || 0;
                                    summaryTotals.suara_total += tungsuraData.suara_total || 0;
                                    summaryTotals.pemilih_dpt_l += tungsuraData.pemilih_dpt_l || 0;
                                    summaryTotals.pemilih_dpt_j += tungsuraData.pemilih_dpt_j || 0;

                                    const tpsChartData = JSON.parse(tps.tungsura_chart);
                                    Object.entries(tpsChartData).forEach(([id, vote]) => {
                                        if (!acc[id]) acc[id] = 0;
                                        acc[id] += vote;
                                    });
                                }
                                return acc;
                            }, {});

                            const summaryHtml = `
                    <p><strong style="color: black;">Suara Sah:</strong  style="color: black;> ${summaryTotals.suara_sah}</p>
                    <p><strong style="color: black;">Suara Total:</strong  style="color: black;> ${summaryTotals.suara_total}</p>
                    <p><strong style="color: black;">Pemilih DPT (Laki-laki):</strong  style="color: black;> ${summaryTotals.pemilih_dpt_l}</p>
                    <p><strong style="color: black;">Pemilih DPT (Perempuan):</strong  style="color: black;> ${summaryTotals.pemilih_dpt_j}</p>
                `;
                            document.querySelector("#summary").innerHTML = summaryHtml;

                            const totalVotes = Object.values(chartData).reduce((sum, vote) => sum + vote, 0);
                            const totalVotesHtml =
                                `<p><strong style="color: black;">Total Votes:</strong> ${totalVotes}</p>`;
                            document.querySelector("#summary").innerHTML += totalVotesHtml;

                            const candidateMapping = {
                                "1000037": "Paslon No. 1",
                                "1000038": "Paslon No. 2",
                            };

                            const categories = [];
                            const votes = [];
                            const colors = [];

                            Object.entries(chartData).forEach(([id, vote]) => {
                                if (id !== "null" && candidateMapping[id]) {
                                    categories.push(candidateMapping[id]);
                                    votes.push(vote);
                                    // Set color based on candidate
                                    if (id === "1000037") {
                                        colors.push("#0000FF"); // Blue for Paslon No. 1
                                    } else if (id === "1000038") {
                                        colors.push("#FF0000"); // Red for Paslon No. 2
                                    }
                                }
                            });

                            // Bar Chart Options
                            const barOptions = {
                                chart: {
                                    type: 'bar',
                                    height: 350,
                                    toolbar: {
                                        show: false
                                    },
                                    animations: {
                                        enabled: true,
                                        speed: 800
                                    },
                                },
                                plotOptions: {
                                    bar: {
                                        borderRadius: 8,
                                        columnWidth: '50%',
                                    },
                                },
                                title: {
                                    text: 'Pilkada Voting Result (Bar Chart)',
                                    align: 'center'
                                },
                                xaxis: {
                                    categories
                                },
                                yaxis: {
                                    title: {
                                        text: 'Votes'
                                    }
                                },
                                series: [{
                                    name: "Votes",
                                    data: votes
                                }],
                                colors, // Use the colors array with specific colors
                                dataLabels: {
                                    enabled: true
                                },
                                tooltip: {
                                    theme: 'light',
                                    y: {
                                        formatter: (val) => `${val} Votes`
                                    },
                                },
                            };

                            // Pie Chart Options
                            const pieOptions = {
                                chart: {
                                    type: 'pie',
                                    height: 350,
                                },
                                title: {
                                    text: 'Pilkada Voting Result (Pie Chart)',
                                    align: 'center'
                                },
                                series: votes,
                                labels: categories,
                                colors, // Use the colors array with specific colors
                                dataLabels: {
                                    enabled: true
                                },
                                tooltip: {
                                    theme: 'light',
                                    y: {
                                        formatter: (val) => `${val} Votes`
                                    },
                                },
                            };

                            // Render Bar Chart
                            if (chart) {
                                // Update the existing bar chart
                                chart.updateOptions(barOptions);
                                chart.updateSeries([{
                                    name: "Votes",
                                    data: votes
                                }]);
                            } else {
                                // Create a new bar chart
                                chart = new ApexCharts(document.querySelector("#chart"), barOptions);
                                chart.render();
                            }

                            // Render Pie Chart
                            if (pieChart) {
                                // Update the existing pie chart
                                pieChart.updateOptions(pieOptions);
                                pieChart.updateSeries(votes);
                            } else {
                                // Create a new pie chart
                                pieChart = new ApexCharts(document.querySelector("#pieChart"), pieOptions);
                                pieChart.render();
                            }

                            toastr.success("Charts updated successfully.");
                        } else {
                            document.querySelector("#summary").innerHTML =
                                "<p>No data available for the selected filters.</p>";
                            if (chart) chart.destroy(); // Destroy chart if no data
                            if (pieChart) pieChart.destroy(); // Destroy pie chart if no data
                            toastr.error(data.message || "No data available for the selected filters.");
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error("Error fetching chart data:", error);
                        toastr.error("An error occurred while fetching chart data.");
                    });
            }
        </script>
    @endpush
</x-default-layout>
