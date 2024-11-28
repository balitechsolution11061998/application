<x-default-layout>
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

    <div class="container-fluid">
        <div class="dashboard-header text-center mb-4">
            <h2>Dashboard Pilkada</h2>
            <p class="lead">View and sync the latest voting data</p>
        </div>

        <!-- Sync Data Buttons with Font Awesome Icons -->
        <div class="d-flex justify-content-center mb-4">
            <button id="syncProvinsiButton" class="btn btn-lg btn-primary shadow-sm mx-2">
                <i class="fas fa-sync"></i> Sync Provinsi Data
            </button>
            <button id="syncKabupatenButton" class="btn btn-lg btn-success shadow-sm mx-2">
                <i class="fas fa-sync"></i> Sync Kabupaten Data
            </button>
            <button id="syncKecamatanButton" class="btn btn-lg btn-info shadow-sm mx-2">
                <i class="fas fa-sync"></i> Sync Kecamatan Data
            </button>

            <button id="syncKelurahanButton" class="btn btn-lg btn-secondary shadow-sm mx-2">
                <i class="fas fa-sync"></i> Sync Kelurahan Data
            </button>

            <button id="syncTpsButton" class="btn btn-lg btn-secondary shadow-sm mx-2">
                <i class="fas fa-sync"></i> Sync TPS Data
            </button>

            <button id="syncPilkadaButton" class="btn btn-lg btn-secondary shadow-sm mx-2">
                <i class="fas fa-sync"></i> Sync Pilkada
            </button>
        </div>

        @if (count($provinces) > 1)
            <!-- Province Select Dropdown -->
            <div class="form-floating border rounded">
                <select id="provinceSelect" class="form-select form-select-solid" placeholder="..."
                    data-control="select2">
                    <option></option> <!-- Placeholder -->
                    @foreach ($provinces as $province)
                        <option value="{{ $province->kode }}" data-kt-select2-country="{{ $province->flag_url ?? '' }}">
                            {{ $province->nama }}
                        </option>
                    @endforeach
                </select>
                <label for="provinceSelect">Select a province</label>
            </div>
            <div class="form-floating border rounded mt-3">
                <select id="kabupatenSelect" class="form-select form-select-solid" placeholder="Select a kabupaten"
                    data-control="select2">
                    <option></option> <!-- Placeholder -->
                </select>
                <label for="kabupatenSelect">Select a kabupaten</label>
            </div>

            <!-- Kecamatan Select Dropdown -->
            <div class="form-floating border rounded mt-3">
                <select id="kecamatanSelect" class="form-select form-select-solid" placeholder="Select a kecamatan">
                    <option></option> <!-- Placeholder -->
                </select>
                <label for="kecamatanSelect">Select a kecamatan</label>
            </div>

            <div class="form-floating border rounded mt-3">
                <select id="kelurahanSelect" class="form-select form-select-solid" placeholder="Select a Kelurahan">
                    <option></option> <!-- Placeholder -->
                </select>
                <label for="kelurahanSelect">Select a Kelurahan</label>
            </div>

            <div class="form-floating border rounded mt-3">
                <select id="tpsSelect" class="form-select form-select-solid" placeholder="Select a TPS">
                    <option></option> <!-- Placeholder -->
                </select>
                <label for="tpsSelect">Select a TPS</label>
            </div>

            <div class="container mt-4">
                <h3 class="mb-4">Ringkasan Data TPS</h3>
                <div id="summary" class="mb-4"></div>
                <div id="chart" class="mt-4"></div>
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
                                $('#kabupatenSelect').on('change.select2', function() {
                                    const kabupatenId = this.value;
                                    if (kabupatenId) {
                                        fetchData(
                                                `/data-kecamatan?province_id=${provinceId}&kabupaten_id=${kabupatenId}`,
                                                kecamatanSelect, "Kecamatan")
                                            .then(() => {
                                                $('#kecamatanSelect').on('change.select2',
                                                    function() {
                                                        const kecamatanId = this.value;
                                                        if (kecamatanId) {
                                                            fetchData(
                                                                    `/data-kelurahan?province_id=${provinceId}&kabupaten_id=${kabupatenId}&kecamatan_id=${kecamatanId}`,
                                                                    kelurahanSelect,
                                                                    "Kelurahan")
                                                                .then(() => {
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

            function fetchChartData(provinceId, kabupatenId, kecamatanId, kelurahanId, tpsId = null) {
                Swal.fire({
                    title: "Loading data...",
                    text: "Please wait while the data is being loaded.",
                    didOpen: () => Swal.showLoading(),
                });

                let apiUrl =
                    `/data-pilkada?province_id=${provinceId}&kabupaten_id=${kabupatenId}&kecamatan_id=${kecamatanId}&kelurahan_id=${kelurahanId}`;
                if (tpsId) {
                    apiUrl += `&tps_id=${tpsId}`;
                }

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
                                const tungsuraData = JSON.parse(tps.tungsura_administrasi);
                                summaryTotals.suara_sah += tungsuraData.suara_sah;
                                summaryTotals.suara_total += tungsuraData.suara_total;
                                summaryTotals.pemilih_dpt_l += tungsuraData.pemilih_dpt_l;
                                summaryTotals.pemilih_dpt_j += tungsuraData.pemilih_dpt_j;

                                const tpsChartData = JSON.parse(tps.tungsura_chart);
                                Object.entries(tpsChartData).forEach(([id, vote]) => {
                                    if (!acc[id]) acc[id] = 0;
                                    acc[id] += vote;
                                });
                                return acc;
                            }, {});

                            const summaryHtml = `
                    <p><strong>Suara Sah:</strong> ${summaryTotals.suara_sah}</p>
                    <p><strong>Suara Total:</strong> ${summaryTotals.suara_total}</p>
                    <p><strong>Pemilih DPT (Laki-laki):</strong> ${summaryTotals.pemilih_dpt_l}</p>
                    <p><strong>Pemilih DPT (Perempuan):</strong> ${summaryTotals.pemilih_dpt_j}</p>
                `;
                            document.querySelector("#summary").innerHTML = summaryHtml;

                            const totalVotes = Object.values(chartData).reduce((sum, vote) => sum + vote, 0);
                            const totalVotesHtml = `<p><strong>Total Votes:</strong> ${totalVotes}</p>`;
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
                                    colors.push(id === "1000037" ? "#003f5c" : "#d45087");
                                }
                            });

                            const options = {
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
                                    text: 'Pilkada Kecamatan Voting Result',
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
                                colors,
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

                            if (chart) {
                                // Update the existing chart
                                chart.updateOptions(options);
                                chart.updateSeries([{
                                    name: "Votes",
                                    data: votes
                                }]);
                            } else {
                                // Create a new chart
                                chart = new ApexCharts(document.querySelector("#chart"), options);
                                chart.render();
                            }

                            toastr.success("Chart updated successfully.");
                        } else {
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
