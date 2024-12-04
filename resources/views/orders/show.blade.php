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

            #printPOButton {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                border-radius: 0.25rem;
            }

            #printPOButton i {
                margin-right: 0.5rem;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            thead {
                background-color: #343a40;
                color: white;
            }

            th,
            td {
                padding: 12px 15px;
                text-align: center;
                border-bottom: 1px solid #dee2e6;
            }

            th {
                position: sticky;
                top: 0;
                z-index: 10;
            }

            tbody tr:hover {
                background-color: #f1f1f1;
            }

            .text-end {
                text-align: right;
            }

            .text-wrap {
                word-wrap: break-word;
            }

            .black-text {
                color: #212529;
            }

            @media (max-width: 768px) {
                th,
                td {
                    padding: 8px;
                    font-size: 14px;
                }
            }

            .icon-white {
                color: white;
            }

            .note-section {
                background-color: #e9ecef;
                border-left: 5px solid #007bff;
                padding: 16px;
                margin-bottom: 24px;
                border-radius: 8px;
            }

            .note-section h5 {
                margin-bottom: 12px;
                color: #495057;
            }

            .note-section p {
                margin: 0;
                color: #212529;
            }

            .comment-section {
                margin-top: 24px;
                padding: 16px;
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
                border-radius: 8px;
            }

            .comment-section h5 {
                margin-bottom: 12px;
                color: #495057;
            }

            .comment-section p {
                margin: 0;
                color: #212529;
            }

            .comment-section .approved-by {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 16px;
            }
            .comment-section {
                background-color: #007bff; /* Primary color */
                padding: 16px;
                border-radius: 8px;
            }

            .comment-section h5 {
                margin-bottom: 12px;
                color: white; /* White text */
            }

            .comment-section p {
                margin: 0;
                color: white; /* White text */
            }

            .approved-by {
                margin-top: 16px;
                font-size: 1rem;
                color: #495057; /* Dark color for contrast */
            }
        </style>
    @endpush

    <div class="container py-4">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('purchase-orders.index') }}" class="btn-back">
                <i class="fas fa-arrow-left icon-white"></i> Back to Orders
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
                                    <div id="spinnerOrder" class="spinner-border spinner-border-sm text-primary d-none" role="status">
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
                                    <span id="deliveryDate">
                                        @if ($data['orderDetails']->estimated_delivery_date)
                                            @formattedDate($data['orderDetails']->estimated_delivery_date)
                                        @else
                                            <span class="text-muted">Not Available</span>
                                        @endif
                                    </span>
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
                                    <div id="spinnerStore" class="spinner-border spinner-border-sm text-primary d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-row">
                                <div class="detail-label">Approval</div>
                                <div class="detail-value">
                                    <span id="approval">{{ $data['orderDetails']->approval_id ?? 'N/A' }}</span>
                                    <div id="spinnerApproval" class="spinner-border spinner-border-sm text-primary d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Supplier</div>
                                <div class="detail-value">
                                    <span id="supplierName">{{ $data['orderDetails']->supplier ?? 'N/A' }}</span>
                                    <div id="spinnerSupplier" class="spinner-border spinner-border-sm text-primary d-none" role="status">
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
                        <div class="col-md-12 detail-column">
                            <div class="table-responsive">
                                <table id="kt_datatable_both_scrolls" class="table gy-5 gs-7 black-text">
                                    <thead class="table-dark">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>SKU</th>
                                            <th>Description</th>
                                            <th>UPC</th>
                                            <th>Tag</th>
                                            <th>Unit Cost</th>
                                            <th>Unit Retail</th>
                                            <th>Status PPN</th>
                                            <th>PPN Cost</th>
                                            <th>Quantity Ordered</th>
                                            <th>Purchase UOM</th>
                                            <th>Regular Discount</th>
                                            <th>Total</th>
                                            <th>Total PPN</th>
                                            <th>Total Discount</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody style="background-color: white; color: black;">
                                        @php
                                            $totalCost = 0; // Initialize total cost
                                            $totalPPN = 0; // Initialize total PPN
                                            $totalDiscount = 0; // Initialize total discount
                                        @endphp
                                        @foreach ($data['orderItems'] as $index => $item)
                                            @php
                                                // Calculate item total before discount
                                                $itemTotal = $item->qty_ordered * $item->unit_cost; // Total before discount
                                                $discountAmount = ($item->permanent_disc_pct > 0) ? ($itemTotal * ($item->permanent_disc_pct / 100)) : 0; // Calculate discount amount
                                                $itemTotalAfterDiscount = $itemTotal - $discountAmount; // Adjust item total after discount
                                                $totalCost += $itemTotalAfterDiscount; // Add item total to total cost

                                                // Calculate VAT total based on the original item total
                                                $vatAmount = $item->vat_cost * $item->qty_ordered; // Total VAT before discount
                                                $discountAmountPPN = ($item->permanent_disc_pct > 0) ? ($vatAmount * ($item->permanent_disc_pct / 100)) : 0; // Calculate discount amount for VAT

                                                $vat_costTotal = $vatAmount - $discountAmountPPN; // Adjust VAT cost after discount
                                                $totalPPN += $vat_costTotal; // Add to total PPN

                                                // Accumulate total discount
                                                $totalDiscount += $discountAmount; // Accumulate total discount

                                                // Calculate subtotal for the item
                                                $subTotal = $itemTotalAfterDiscount + $vat_costTotal; // Subtotal for the item
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-wrap">
                                                    <i class="fas fa-tag" style="color: #007bff;"></i> {{ $item->sku }}
                                                </td>
                                                <td class="text-wrap">{{ $item->sku_desc }}</td>
                                                <td class="text-center">
                                                    <i class="fas fa-barcode" style="color: #28a745;"></i> {{ $item->upc }}
                                                </td>
                                                <td class="text-center">{{ $item->tag_code }}</td>
                                                <td class="text-end">{{ number_format($item->unit_cost, 2) }}</td>
                                                <td class="text-end">{{ number_format($item->unit_retail, 2) }}</td>
                                                <td class="text-center">
                                                    @if (is_null($item->itemSupplier))
                                                        <span class="badge bg-secondary">
                                                            <i class="fas fa-exclamation-circle" style="color: red;"></i> Tidak Ada Data
                                                        </span>
                                                    @elseif($item->itemSupplier->vat_ind === 'Y')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle" style="color: green;"></i> PPN
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle" style="color: red;"></i> No PPN
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-end">{{ number_format($vat_costTotal, 2) }}</td> <!-- Total PPN for the item -->
                                                <td class="text-center">{{ $item->qty_ordered }}</td>
                                                <td class="text-center">{{ $item->purchase_uom }}</td>
                                                <td class="text-center">
                                                    {{ $item->permanent_disc_pct > 0 ? $item->permanent_disc_pct . '%' : '0%' }}
                                                </td> <!-- Displaying percentage -->

                                                <td class="text-end">{{ number_format($itemTotalAfterDiscount, 2) }}</td> <!-- Total for the item after discount -->
                                                <td class="text-end">{{ number_format($vat_costTotal, 2) }}</td> <!-- Total PPN for the item -->
                                                <td class="text-end">{{ number_format($discountAmount, 2) }}</td> <!-- Total Discount for the item -->
                                                <td class="text-end">{{ number_format($subTotal, 2) }}</td> <!-- Sub Total for the item -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @php
                                            // Calculate final grand total after subtracting total discount
                                            $grandTotal = $totalCost + $totalPPN; // Grand total without discount
                                        @endphp
                                        <tr class="table-dark">
                                            <td colspan="15" class="text-end text-white"><strong>TOTAL DISCOUNT:</strong></td>
                                            <td class="text-end text-white">{{ number_format($totalDiscount, 2) }}</td> <!-- Total Discount for all items -->
                                        </tr>
                                        <tr class="table-dark">
                                            <td colspan="15" class="text-end text-white"><strong>TOTAL (before PPN):</strong></td>
                                            <td class="text-end text-white">{{ number_format($totalCost, 2) }}</td> <!-- Total Cost before discount -->
                                        </tr>
                                        <tr class="table-dark">
                                            <td colspan="15" class="text-end text-white"><strong>PPN:</strong></td>
                                            <td class="text-end text-white">{{ number_format($totalPPN, 2) }}</td> <!-- Total PPN -->
                                        </tr>
                                        <tr class="table-dark">
                                            <td colspan="15" class="text-end text-white"><strong>TOTAL (after PPN - Discount):</strong></td>
                                            <td class="text-end text-white">{{ number_format($grandTotal, 2) }}</td> <!-- Grand Total after discount -->
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Note Section -->
                    <div class="note-section">
                        <h5>Note: IMPORTANT</h5>
                        <p>* Dokumen ini tidak perlu tanda tangan karena di cetak melalui sistem.</p>
                        <p>* Jika harga barang tidak sama dengan harga di PO mohon segera menghubungi bagian merchandising sebelum barang dikirimkan.</p>
                        <p>* Jika terdapat perubahan harga mohon diinformasikan paling lambat 14 hari sebelumnya.</p>
                        <p>* Apabila tidak ada informasi perubahan harga yang diberikan ke bagian merchandising, maka harga yang diakui adalah harga terendah.</p>
                        <p>* Nota retur yang sudah diterbitkan oleh Minimat akan langsung dipotong pada faktur tagihan suppliers tanpa pemberitahuan terlebih dahulu sesuai dengan perjanjian yang disepakati.</p>
                        <p>* Barang yang tidak diambil atas nota retur yang sudah dibuat menjadi tanggung jawab suppliers.</p>
                    </div>

                    <!-- Comment and Approval Section -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="comment-section p-3 mb-4 bg-light border rounded">
                                <h5 class="mb-3">Comment Description</h5>
                                <p>{{ $data['orderDetails']->comment_desc ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-12 approved-by text-end">
                            <span>Approved by,</span>
                            <span class="fw-bold ms-2">{{ $data['orderDetails']->approval_id ?? 'N/A' }}</span>
                        </div>
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
