<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection


    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-light">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="section-title mb-0"><i class="fas fa-info-circle"></i> Query Performance Logs</h2>
                    <div class="d-flex align-items-center">
                        <!-- Toggle Switch with Custom Styling -->
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggleView">
                            <label class="form-check-label" for="toggleView">Show Table</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Dropdown Button -->
                    <div class="dropdown mb-4">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Show Data Series
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-average-query"
                            aria-labelledby="dropdownMenuButton">
                            <li>
                                <div class="dropdown-item form-check">
                                    <input class="form-check-input" type="checkbox" id="showExecutionTime">
                                    <label class="form-check-label" for="showExecutionTime">Average Execution
                                        Time</label>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item form-check">
                                    <input class="form-check-input" type="checkbox" id="showPing">
                                    <label class="form-check-label" for="showPing">Average Ping</label>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item form-check">
                                    <input class="form-check-input" type="checkbox" id="showMemoryUsage">
                                    <label class="form-check-label" for="showMemoryUsage">Memory Usage</label>
                                </div>
                            </li>
                        </ul>
                    </div>



                    <!-- Chart Container -->
                    <div class="chart-container mb-4" id="chartContainer">
                        <div id="chartCanvas"></div>
                    </div>
                    <!-- Table Container (Initially Hidden) -->
                    <div class="table-responsive" id="tableQueryPerformanceLog" style="display: none;">
                        <table id="queryPerformance-table" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Function Name</th>
                                    <th>Average Execution Time</th>
                                    <th>Average Ping</th>
                                    <th>Average Download Speed</th>
                                    <th>Average Upload Speed</th>
                                    <th>Memory Usage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated here by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/home4.js') }}"></script>
        <script src="{{ asset('js/formatRupiah.js') }}"></script>
    @endpush
</x-default-layout>
