<x-default-layout>
    @section('title')
        Detail Purchase Order - #{{ $data['orderDetails']->order_no }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('orders') }}
    @endsection

    @push('styles')
        <style>
            body {
                background-color: #f8f9fa;
            }

            .detail-card {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border-radius: 12px;
                padding: 24px;
                background-color: #ffffff;
                margin-bottom: 24px;
            }

            .detail-header {
                font-size: 1.8rem;
                font-weight: bold;
                color: #495057;
                border-bottom: 2px solid #e9ecef;
                padding-bottom: 10px;
                margin-bottom: 16px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .detail-header i {
                color: #007bff;
            }

            .detail-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #f1f3f5;
            }

            .detail-label {
                font-size: 1rem;
                font-weight: 500;
                color: #6c757d;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .detail-value {
                font-size: 1.1rem;
                font-weight: 600;
                color: #212529;
                text-align: right;
            }

            .badge {
                padding: 6px 12px;
                border-radius: 12px;
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: uppercase;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .badge i {
                font-size: 0.8rem;
            }

            .badge.bg-success {
                background-color: #28a745;
                color: white;
            }

            .badge.bg-warning {
                background-color: #ffc107;
                color: black;
            }

            .badge.bg-danger {
                background-color: #dc3545;
                color: white;
            }

            .tracking-section {
                margin-top: 24px;
            }

            .tracking-step {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 12px;
            }

            .tracking-icon {
                font-size: 1.5rem;
                color: #007bff;
            }

            .tracking-description {
                font-size: 1rem;
                color: #495057;
            }

            .btn-back {
                display: inline-flex;
                align-items: center;
                font-size: 0.9rem;
                padding: 8px 16px;
                background-color: #6c757d;
                color: white;
                border-radius: 8px;
                text-decoration: none;
                transition: background-color 0.3s ease;
            }

            .btn-back:hover {
                background-color: #5a6268;
            }

            .btn-back i {
                margin-right: 6px;
            }

            /* Customize the button size and appearance */
            #printPOButton {
                padding: 0.375rem 0.75rem;
                /* Adjust padding for a smaller look */
                font-size: 0.875rem;
                /* Smaller font size */
                border-radius: 0.25rem;
                /* Make button edges slightly rounded */
            }

            #printPOButton i {
                margin-right: 0.5rem;
                /* Add space between the icon and text */
            }
        </style>
    @endpush

    <div class="container py-4">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('purchase-orders.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>

        <div class="container mt-4">
            <div class="card bg-white shadow-sm rounded-4">

                <div class="card-body">
                    @if ($data['orderDetails']->status === 'Printed')
                        <button class="btn btn-primary btn-sm rounded-4" id="printPOButton">
                            <i class="fas fa-print"></i> Print PO
                        </button>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-hashtag"></i> Order Number:
                                </div>
                                <div class="detail-value">
                                    <span id="orderNumber">{{ $data['orderDetails']->order_no ?? 'N/A' }}</span>
                                    <div id="spinnerOrder" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-alt"></i> Estimated Delivery Date:
                                </div>
                                <div class="detail-value">
                                    <!-- Check if the delivery date is null -->
                                    <span id="deliveryDate">
                                        @if($data['orderDetails']->estimated_delivery_date)
                                            @formattedDate($data['orderDetails']->estimated_delivery_date)
                                        @else
                                            <span class="text-muted">Not Available</span>
                                        @endif
                                    </span>

                                    <!-- Spinner shown when data is being loaded or if null -->
                                    <div id="spinnerDelivery" class="spinner-border spinner-border-sm text-primary d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3 detail-column">
                            <div class="detail-row">
                                <div class="detail-label">Store No</div>
                                <div class="detail-value">
                                    <span id="storeCode">{{ $data['store']['store_code'] ?? 'N/A' }}</span>
                                    <div id="spinnerStore" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Approval</div>
                                <div class="detail-value">
                                    <span id="approval">{{ $data['orderDetails']->approval_id ?? 'N/A' }}</span>
                                    <div id="spinnerApproval"
                                        class="spinner-border spinner-border-sm text-primary d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Supplier</div>
                                <div class="detail-value">
                                    <span id="supplierName">{{ $data['orderDetails']->supplier ?? 'N/A' }}</span>
                                    <div id="spinnerSupplier"
                                        class="spinner-border spinner-border-sm text-primary d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="badge-status badge
                                        @if ($data['orderDetails']->status === 'Progress') badge-warning
                                        @elseif ($data['orderDetails']->status === 'Completed') badge-success
                                        @elseif ($data['orderDetails']->status === 'Expired') badge-danger
                                        @elseif ($data['orderDetails']->status === 'Printed') badge-info
                                        @else badge-secondary @endif text-white">
                                        <i class="fas
                                            @if ($data['orderDetails']->status === 'Progress') fa-spinner fa-spin
                                            @elseif ($data['orderDetails']->status === 'Completed') fa-check-circle
                                            @elseif ($data['orderDetails']->status === 'Expired') fa-times-circle
                                            @elseif ($data['orderDetails']->status === 'Printed') fa-print
                                            @else fa-info-circle @endif text-white"></i>
                                        {{ $data['orderDetails']->status ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>





                        </div>

                        <div class="col-md-3 detail-column">
                            <div class="detail-row">
                                <div class="detail-label">Store Name</div>
                                <div class="detail-value">{{ $data['store']['store_name'] ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Order Date</div>
                                <div class="detail-value">
                                    @formattedDate($data['orderDetails']->approval_date)
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Supplier Name</div>
                                <div class="detail-value">{{ $data['supplier']['supp_name'] ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="col-md-3 detail-column">
                            <div class="detail-row">
                                <div class="detail-label">Store Address</div>
                                <div class="detail-value">{{ $data['store']['store_address'] ?? 'N/A' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Delivery Before</div>
                                <div class="detail-value">
                                    @formattedDate($data['orderDetails']->not_before_date)
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Supplier Address</div>
                                <div class="detail-value">{{ $data['supplier']['supp_address'] ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 detail-column">
                            <div class="detail-row">
                                <div class="detail-label">Store Address</div>
                                <div class="detail-value">{{ $data['store']['store_address1'] ?? 'N/A' }}</div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Expired Date</div>
                                <div class="detail-value">
                                    @formattedDate($data['orderDetails']->not_after_date)
                                </div>
                            </div>


                            <div class="detail-row">
                                <div class="detail-label">Contact Name</div>
                                <div class="detail-value">{{ $data['supplier']['contact_name'] ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>
            </div>


        </div>




    </div>
    @push('scripts')
        <script>
            // Show loading spinner for a short period to simulate loading
            window.onload = function() {
                // Show the spinner for 2 seconds before showing the data
                setTimeout(function() {
                    document.getElementById('loadingSpinner').style.display = 'none';
                    document.getElementById('orderDetails').style.display = 'block';
                }, 2000); // Adjust the time as needed
            };
        </script>
    @endpush
</x-default-layout>
