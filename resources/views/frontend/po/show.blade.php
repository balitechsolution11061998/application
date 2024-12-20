@extends('layouts.master')
@section('title', 'Purchase Order')
@section('content')

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
            background-color: #007bff;
            /* Primary color */
            padding: 16px;
            border-radius: 8px;
        }

        .comment-section h5 {
            margin-bottom: 12px;
            color: white;
            /* White text */
        }

        .comment-section p {
            margin: 0;
            color: white;
            /* White text */
        }

        .approved-by {
            margin-top: 16px;
            font-size: 1rem;
            color: #495057;
            /* Dark color for contrast */
        }

        .modal-content {
            border-radius: 10px;
            /* Rounded corners for the modal */
        }

        .form-label {
            font-weight: bold;
            /* Bold labels */
            color: #333;
            /* Darker color for better readability */
        }

        .form-control {
            border-radius: 5px;
            /* Rounded corners for input fields */
            border: 1px solid #ced4da;
            /* Light border */
        }

        .form-control:focus {
            border-color: #80bdff;
            /* Change border color on focus */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            /* Shadow effect on focus */
        }

        .btn {
            border-radius: 5px;
            /* Rounded corners for buttons */
        }
    </style>

    <div class="container py-4">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="{{ route('purchase-orders.supplier.getOrders') }}" class="btn-back">
                <i class="fas fa-arrow-left icon-white"></i> Back to Orders
            </a>
        </div>


        <div class="container mt-4">
            <div class="card bg-white shadow-sm rounded-4">
                <div class="card-body">
                    @if ($data['orderDetails']->status === 'Confirmed')
                        <a class="btn btn-success btn-sm rounded-3" id="printPOButton_{{ $data['orderDetails']->order_no }}"
                            onclick="confirmPrint('{{ $data['orderDetails']->order_no }}')">
                            <i class="fas fa-printer"></i> Print PO
                        </a>
                    @elseif ($data['orderDetails']->status === 'Printed')
                        <a class="btn btn-warning btn-sm rounded-3"
                            id="deliveryPOButton_{{ $data['orderDetails']->order_no }}"
                            onclick="deliveryPo('{{ $data['orderDetails']->order_no }}')">
                            <i class="fas fa-box"></i> Delivery PO
                        </a>
                    @endif


                    @php
                        $hasError = false;
                        foreach ($data['orderItems'] as $item) {
                            if ($item->itemSupplier === 'Y' && $item->vat_cost == 0) {
                                $hasError = true;
                                break;
                            }
                        }
                    @endphp

                    @if ($hasError)
                        <div class="alert alert-danger" role="alert">
                            <strong>Data yang direlase salah!</strong> Silahkan periksa Vega untuk memeriksa data yang
                            benar, dan silahkan infokan ke user terkait.
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-alt"></i> Confirmation Date:
                                </div>
                                <div class="detail-value">
                                    <span id="deliveryDate">
                                        @if ($data['orderDetails']->confirmation_date)
                                            @formattedDate($data['orderDetails']->confirmation_date)
                                        @else
                                            <span>Data Tidak Tersedia</span>
                                        @endif
                                    </span>
                                    <div id="spinnerDelivery" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-alt"></i> Estimated Delivery Date:
                                </div>
                                <div class="detail-value">
                                    <span id="deliveryDate">
                                        @if ($data['orderDetails']->estimated_delivery_date)
                                            @formattedDate($data['orderDetails']->estimated_delivery_date)
                                        @else
                                            <span>Data Tidak Tersedia</span>
                                        @endif
                                    </span>
                                    <div id="spinnerDelivery" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="detail-row">
                                <div class="detail-label" style="font-weight: 600; color: #495057;">
                                    <i class="fas fa-calendar-alt" style="color: #007bff;"></i> Tanggal Terima:
                                </div>
                                <div class="detail-value d-flex align-items-center"
                                    style="font-size: 1.1rem; color: #212529;">
                                    <span id="deliveryDate" class="me-2">
                                        @if ($data['orderDetails']->receive_date)
                                            @formattedDate($data['orderDetails']->receive_date)
                                        @else
                                            <span>Data Tidak Tersedia</span>
                                        @endif
                                    </span>
                                    <div id="spinnerDelivery" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status">
                                        <span class="sr-only">Memuat...</span>
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
                                    <div id="spinnerApproval" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Supplier</div>
                                <div class="detail-value">
                                    <span id="supplierName">{{ $data['orderDetails']->supplier ?? 'N/A' }}</span>
                                    <div id="spinnerSupplier" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Receive No</div>
                                <div class="detail-value">
                                    <span id="receiveNo">
                                        <i class="fas fa-receipt" style="margin-right: 5px;"></i>
                                        <!-- Icon for Receive No -->
                                        {{ $data['orderDetails']->receive_no ?? 'N/A' }}
                                    </span>
                                    <div id="spinnerReceive" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span
                                        class="badge-status badge
                                        @if ($data['orderDetails']->status === 'Progress') badge-warning
                                        @elseif ($data['orderDetails']->status === 'Completed') badge-success
                                        @elseif ($data['orderDetails']->status === 'Expired') badge-danger
                                        @elseif ($data['orderDetails']->status === 'Printed') badge-info
                                        @elseif ($data['orderDetails']->status === 'Confirmed') badge-confirmed
                                        @elseif ($data['orderDetails']->status === 'Delivery') badge-primary <!-- New condition for Delivery -->
                                        @else badge-secondary @endif">
                                        <i
                                            class="fas
                                            @if ($data['orderDetails']->status === 'Progress') fa-spinner fa-spin
                                            @elseif ($data['orderDetails']->status === 'Completed') fa-check-circle
                                            @elseif ($data['orderDetails']->status === 'Expired') fa-times-circle
                                            @elseif ($data['orderDetails']->status === 'Printed') fa-print
                                            @elseif ($data['orderDetails']->status === 'Confirmed') fa-check
                                            @elseif ($data['orderDetails']->status === 'Delivery') fa-truck <!-- New icon for Delivery -->
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
                                <div class="detail-value">{{ $data['supplier']['supplier_name'] ?? 'N/A' }}</div>
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
                                <div class="detail-value">{{ $data['supplier']['supplier_contact'] ?? 'N/A' }}</div>
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
                                            <th>PPN Cost</th>
                                            <th>Quantity Ordered</th>
                                            <th>Purchase UOM</th>
                                            <th>Regular Discount</th>
                                            <th>Total</th>
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
                                                $discountAmount =
                                                    $item->permanent_disc_pct > 0
                                                        ? $itemTotal * ($item->permanent_disc_pct / 100)
                                                        : 0; // Calculate discount amount
                                                $itemTotalAfterDiscount = $itemTotal - $discountAmount; // Adjust item total after discount
                                                $totalCost += $itemTotalAfterDiscount; // Add item total to total cost

                                                // Calculate VAT total based on the original item total
                                                $vatAmount = $item->vat_cost * $item->qty_ordered; // Total VAT before discount
                                                $discountAmountPPN =
                                                    $item->permanent_disc_pct > 0
                                                        ? $vatAmount * ($item->permanent_disc_pct / 100)
                                                        : 0; // Calculate discount amount for VAT

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
                                                    <i class="fas fa-tag" style="color: #007bff;"></i>
                                                    {{ $item->sku }}
                                                </td>
                                                <td class="text-wrap">{{ $item->sku_desc }}</td>
                                                <td class="text-center">
                                                    <i class="fas fa-barcode" style="color: #28a745;"></i>
                                                    {{ $item->upc }}
                                                </td>
                                                <td class="text-center">{{ $item->tag_code }}</td>
                                                <td class="text-end">{{ number_format($item->unit_cost, 2) }}</td>
                                                <td class="text-end">{{ number_format($item->unit_retail, 2) }}</td>

                                                <td class="text-end">{{ number_format($vat_costTotal, 2) }}</td>
                                                <!-- Total PPN for the item -->
                                                <td class="text-center">{{ $item->qty_ordered }}</td>
                                                <td class="text-center">{{ $item->purchase_uom }}</td>
                                                <td class="text-center">
                                                    {{ $item->permanent_disc_pct > 0 ? $item->permanent_disc_pct . '%' : '0%' }}
                                                </td> <!-- Displaying percentage -->

                                                <td class="text-end">{{ number_format($itemTotalAfterDiscount, 2) }}
                                                </td> <!-- Total for the item after discount -->
                                                <!-- Total PPN for the item -->
                                                <td class="text-end">{{ number_format($discountAmount, 2) }}</td>
                                                <!-- Total Discount for the item -->
                                                <td class="text-end">{{ number_format($subTotal, 2) }}</td>
                                                <!-- Sub Total for the item -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @php
                                            // Calculate final grand total after subtracting total discount
                                            $grandTotal = $totalCost + $totalPPN; // Grand total without discount
                                        @endphp
                                        <tr class="table-dark">
                                            <td colspan="13" class="text-end text-white"><strong>TOTAL
                                                    DISCOUNT:</strong></td>
                                            <td class="text-end text-white">{{ number_format($totalDiscount, 2) }}
                                            </td> <!-- Total Discount for all items -->
                                        </tr>
                                        <tr class="table-dark">
                                            <td colspan="13" class="text-end text-white"><strong>TOTAL (before
                                                    PPN):</strong></td>
                                            <td class="text-end text-white">{{ number_format($totalCost, 2) }}</td>
                                            <!-- Total Cost before discount -->
                                        </tr>
                                        <tr class="table-dark">
                                            <td colspan="13" class="text-end text-white"><strong>PPN:</strong></td>
                                            <td class="text-end text-white">{{ number_format($totalPPN, 2) }}</td>
                                            <!-- Total PPN -->
                                        </tr>
                                        <tr class="table-dark">
                                            <td colspan="13" class="text-end text-white"><strong>TOTAL (after PPN -
                                                    Discount):</strong></td>
                                            <td class="text-end text-white">{{ number_format($grandTotal, 2) }}</td>
                                            <!-- Grand Total after discount -->
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
                        <p>* Jika harga barang tidak sama dengan harga di PO mohon segera menghubungi bagian
                            merchandising sebelum barang dikirimkan.</p>
                        <p>* Jika terdapat perubahan harga mohon diinformasikan paling lambat 14 hari sebelumnya.</p>
                        <p>* Apabila tidak ada informasi perubahan harga yang diberikan ke bagian merchandising, maka
                            harga yang diakui adalah harga terendah.</p>
                        <p>* Nota retur yang sudah diterbitkan oleh Minimat akan langsung dipotong pada faktur tagihan
                            suppliers tanpa pemberitahuan terlebih dahulu sesuai dengan perjanjian yang disepakati.</p>
                        <p>* Barang yang tidak diambil atas nota retur yang sudah dibuat menjadi tanggung jawab
                            suppliers.</p>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h2 class="h4 mb-3">History</h2>
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        @if ($data['orderDetails']->printed_at)
                                            <label for="">History Print</label>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-center p-3 border rounded bg-light">
                                                    <i class="fas fa-clock me-3 text-primary" style="font-size: 2em;"></i>
                                                    <div>
                                                        <div class="fw-bold" style="font-size: 1.2em;">
                                                            {{ \Carbon\Carbon::parse($data['orderDetails']->printed_at)->format('d M Y H:i') }}
                                                        </div>
                                                        <div class="text-muted" style="font-size: 0.9em;">
                                                            <i class="fas fa-user me-1" style="color: #6c757d;"></i>
                                                            by <span
                                                                style="font-weight: bold; color: #343a40;">{{ $data['orderDetails']->printed_user_name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($data['orderDetails']->confirmation_date)
                                            <label for="">History Konfirmasi</label>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex align-items-center p-3 border rounded bg-light">
                                                    <i class="fas fa-clock me-3 text-primary" style="font-size: 2em;"></i>
                                                    <div>
                                                        <div class="fw-bold" style="font-size: 1.2em;">
                                                            {{ \Carbon\Carbon::parse($data['orderDetails']->confirmation_date)->format('d M Y H:i') }}
                                                        </div>
                                                        <div class="text-muted" style="font-size: 0.9em;">
                                                            <i class="fas fa-user me-1" style="color: #6c757d;"></i>
                                                            by <span
                                                                style="font-weight: bold; color: #343a40;">{{ $data['orderDetails']->confirmation_user_name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comment and Approval Section -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="comment-section p-3 mb-4 bg-light border rounded">
                                <h5 class="mb-3" style="color: black;">Comment Description</h5>
                                <p style="color: black;">{{ $data['orderDetails']->comment_desc ?? 'N/A' }}</p>
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
    <div class="modal fade" id="deliveryModal" tabindex="-1" aria-labelledby="deliveryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Added modal-lg class here -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deliveryModalLabel">Delivery PO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deliveryForm">
                        <input type="hidden" id="orderNoId" name="order_no">

                        <!-- Confirmation Date and Time Input at the top -->
                        <div class="mb-3">
                            <label for="confirmationDateTime" class="form-label">Confirmation Date and Time:</label>
                            <input type="datetime-local" id="confirmationDateTime" class="form-control" required>
                        </div>

                        <div id="itemDetails" class="mb-3"></div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rejectCheckbox">
                            <label class="form-check-label" for="rejectCheckbox">Reject Delivery</label>
                        </div>

                        <div id="rejectReasonContainer" style="display: none;">
                            <label for="rejectReason" class="mt-2">Reason for Rejection:</label>
                            <textarea id="rejectReason" class="form-control" rows="3" placeholder="Enter reason for rejection"></textarea>

                            <!-- Checkbox for confirming reason submission -->
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="confirmReasonCheckbox">
                                <label class="form-check-label" for="confirmReasonCheckbox">I confirm the reason for
                                    rejection</label>
                            </div>
                        </div>

                        <button id="rejectButton" class="btn btn-danger mt-2" style="display: none;">
                            <i class="fas fa-times"></i> Reject
                        </button>

                        <button id="submitButton" class="btn btn-primary mt-2">
                            <i class="fas fa-check"></i> Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

    <script>
        // Show loading spinner for a short period to simulate loading


        function confirmPrint(orderNo) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to print Order No: " + orderNo,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, print it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading spinner
                    Swal.fire({
                        title: 'Printing...',
                        text: 'Please wait while we process your request.',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Set a timeout for the loading spinner
                    const loadingTimeout = setTimeout(() => {
                        Swal.fire({
                            title: 'Still loading...',
                            text: 'The process is taking longer than expected. Would you like to continue waiting or reload the page?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Continue Waiting',
                            cancelButtonText: 'Reload Page'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // User chose to continue waiting
                                Swal.fire({
                                    title: 'Continuing...',
                                    text: 'Thank you for your patience!',
                                    icon: 'info',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            } else {
                                // User chose to reload the page
                                location.reload(); // Hard reload the page
                            }
                        });
                    }, 10000); // 10 seconds timeout

                    // AJAX call to print the PO
                    $.ajax({
                        url: '/purchase-orders/print-po', // Your route to handle the print
                        method: 'POST',
                        data: {
                            order_no: orderNo,
                            _token: '{{ csrf_token() }}' // Include CSRF token for security
                        },
                        success: function(response) {
                            // Clear the loading timeout
                            clearTimeout(loadingTimeout);

                            // Check if the response indicates success
                            if (response.success) {
                                // Show toastr notification
                                toastr.success('Order No: ' + orderNo +
                                    ' has been printed successfully.');

                                // Encode the order number for the URL
                                const encodedOrderNo = btoa(orderNo
                                    .toString()); // Base64 encode the order number

                                // Redirect to the orders page with the encoded order number
                                setTimeout(function() {
                                    window.location.href = '/purchase-orders/supplier/show/' +
                                        encodedOrderNo; // Redirect link
                                }, 2000); // 2 seconds delay before redirecting
                            } else {
                                toastr.error('Error: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            // Clear the loading timeout
                            clearTimeout(loadingTimeout);

                            // Check if the error is due to a network issue
                            if (xhr.status === 0) {
                                toastr.error(
                                    'Connection error. Please check your internet connection.');
                            } else {
                                toastr.error('Failed to print Order No: ' + orderNo +
                                    '. Please try again.');
                            }
                        },
                        complete: function() {
                            // Close the loading spinner after the AJAX call is complete
                            Swal.close();
                        }
                    });
                }
            });
        }


        function deliveryPo(orderNo) {
            // Clear previous data
            $('#itemQuantity').val('');
            $('#itemDetails').empty();

            // Encode the order number
            const encodedOrderNo = btoa(orderNo); // Base64 encode
            $("#orderNoId").val(orderNo);

            // Fetch data using AJAX
            $.ajax({
                url: `/purchase-orders/get-delivery-items/${encodedOrderNo}`, // Adjust the URL as necessary
                type: 'GET',
                success: function(data) {
                    // Assuming data is an array of items
                    if (data.length > 0) {
                        // Get the supplier code from the first item (assuming all items have the same supplier)
                        const supplierCode = data[0].supplier_code;

                        // Create HTML for supplier code
                        let detailsHtml = `
                    <div style="color: black; font-weight: bold; margin-bottom: 10px;">
                        Supplier Code: ${supplierCode}
                    </div>
                    <table id="deliveryItemsTable" class="table table-responsive">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Description</th>
                                <th>Quantity Ordered</th>
                                <th>Quantity to Deliver</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                        data.forEach(item => {
                            detailsHtml += `
                        <tr>
                            <td style="color:black;">${item.sku}</td>
                            <td style="color:black;">${item.sku_desc}</td>
                            <td style="color:black;">${item.qty_ordered}</td>
                            <td>
                                <input type="number" class="form-control" style="color: black;"
                                    placeholder="Enter quantity"
                                    min="0"
                                    max="${item.qty_ordered}"
                                    id="qtyToDeliver_${item.sku}"
                                    value="${item.qty_ordered}"
                                    oninput="checkQuantity('${item.sku}')" />
                                <textarea id="reason_${item.sku}" class="form-control text-danger" style="display: none; resize: none;" rows="2"></textarea> <!-- Editable textarea for reason -->
                            </td>
                        </tr>
                    `;
                        });

                        detailsHtml += '</tbody></table>';
                        $('#itemDetails').html(detailsHtml);

                        // Initialize DataTable if needed
                        // $('#deliveryItemsTable').DataTable(); // Uncomment if using DataTables

                    } else {
                        $('#itemDetails').html('<p>No items available for delivery.</p>');
                    }
                    // Show the modal
                    $('#deliveryModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error fetching delivery items:', xhr);
                    alert('Failed to fetch delivery items. Please try again.');
                }
            });
        }


        $(document).ready(function() {
            // Initialize CKEditor for the reason textarea in classic mode
            let editorInstance;
            ClassicEditor
                .create(document.querySelector('#rejectReason'), {
                    // Configure the toolbar to include font color
                    toolbar: [
                        'fontColor', // Include the font color option
                        'bold',
                        'italic',
                        'underline',
                        'undo',
                        'redo'
                    ],
                    // Set the default text color to black
                    initialData: '<p style="color: black;">Your text here...</p>',
                    // Configure the font color options
                    fontColor: {
                        options: [
                            'black', // Add black to the color options
                            'red',
                            'green',
                            'blue',
                            // Add more colors as needed
                        ],
                        support: {
                            options: true,
                        },
                    },
                    // Set the default color for the text
                    styles: {
                        'color': 'black' // Set default text color to black
                    }
                })
                .then(editor => {
                    editorInstance = editor;

                    // Load saved content from localStorage if it exists
                    const savedReason = localStorage.getItem('rejectReason');
                    if (savedReason) {
                        editor.setData(savedReason);
                    }

                    // Listen for changes in the CKEditor
                    editor.model.document.on('change:data', () => {
                        const reason = editorInstance.getData();
                        if (reason.trim() !== '') {
                            // Save the content to localStorage
                            localStorage.setItem('rejectReason', reason);
                            toastr.success('Reason auto-saved successfully.'); // Show success message
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            // Set the current date and time in the confirmation input when the modal is shown
            $('#deliveryModal').on('show.bs.modal', function() {
                const now = new Date();
                const formattedDate = now.toISOString().slice(0, 16); // Format to YYYY-MM-DDTHH:MM
                $('#confirmationDateTime').val(formattedDate); // Set the value of the datetime-local input
            });

            // Handle checkbox change event
            $('#rejectCheckbox').change(function() {
                if ($(this).is(':checked')) {
                    $('#rejectReasonContainer').show(); // Show the reason textarea
                    $('#rejectButton').show(); // Show the reject button
                    $('#submitButton').hide(); // Hide the submit button
                } else {
                    $('#rejectReasonContainer').hide(); // Hide the reason textarea
                    $('#rejectButton').hide(); // Hide the reject button
                    $('#submitButton').show(); // Show the submit button
                }
            });

            // Handle reject button click
            $('#rejectButton').click(function() {
                // Get the value from the CKEditor instance
                const reason = editorInstance.getData();
                if (reason.trim() === '') {
                    toastr.error('Please provide a reason for rejection.');
                    return;
                }

                // Proceed with rejection logic (e.g., AJAX call)
                $.ajax({
                    url: '/purchase-orders/reject-delivery', // Your endpoint for rejection
                    type: 'POST',
                    data: {
                        orderNo: $('#orderNoId').val(), // Include order number if needed
                        reason: reason
                    },
                    success: function(response) {
                        toastr.success('Delivery rejected successfully.');
                        $('#deliveryModal').modal('hide');
                        // Clear localStorage after successful submission
                        localStorage.removeItem('rejectReason');
                        window.location.href =
                            '/purchase-orders/supplier/getOrders'; // Redirect to the orders page
                    },
                    error: function(xhr) {
                        toastr.error('Failed to reject delivery. Please try again.');
                    }
                });
            });
        });


        // Function to check quantity on keyup
        function checkQuantity(sku) {
            const inputField = document.getElementById(`qtyToDeliver_${sku}`);
            const qtyToDeliver = inputField.value.trim() === "" ? null : parseInt(inputField
            .value); // Treat empty input as null
            const maxQty = parseInt(inputField.max); // Get the max quantity
            const reasonTextarea = document.getElementById(`reason_${sku}`); // Get the reason textarea

            // Check if quantity exceeds the ordered quantity
            if (qtyToDeliver > maxQty) {
                toastr.warning(`Quantity to deliver for SKU ${sku} exceeds the ordered quantity.`);
                inputField.value = maxQty; // Set the input value to the maximum quantity
            }

            // Show reason if quantity is 0
            if (qtyToDeliver === 0) {
                reasonTextarea.style.display = 'block'; // Show the textarea
                reasonTextarea.value = 'Stock Kosong'; // Clear the reason textarea if quantity is not 0
            } else {
                reasonTextarea.style.display = 'none'; // Hide the textarea
                reasonTextarea.value = ''; // Clear the reason textarea if quantity is not 0
            }
        }


        // Set up AJAX to include CSRF token


        $('#deliveryForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let isValid = true; // Flag to check if all inputs are valid
            let totalQtyOrdered = 0; // To track total quantity ordered
            const deliveryData = []; // Array to hold delivery data

            // Get the confirmation date
            const confirmationDate = $('#confirmationDateTime').val();
            if (!confirmationDate) {
                toastr.error('Please select a confirmation date.');
                isValid = false;
            }

            // Check if rejection is selected and reason is confirmed
            if ($('#rejectCheckbox').is(':checked')) {
                const reason = $('#rejectReason').val();
                if (reason.trim() === '') {
                    toastr.error('Please provide a reason for rejection.');
                    isValid = false;
                }
                if (!$('#confirmReasonCheckbox').is(':checked')) {
                    toastr.error('You must confirm the reason for rejection.');
                    isValid = false;
                }
            }

            // Loop through each input to validate
            $('input[type="number"]').each(function() {
                const qtyToDeliver = $(this).val().trim() === "" ? null : parseInt($(this)
                    .val()); // Treat empty input as null
                const maxQty = parseInt($(this).attr('max')); // Get the max quantity

                // Check if quantity is null
                if (qtyToDeliver === null) {
                    toastr.error(
                        `Quantity to deliver for SKU ${$(this).attr('id').split('_')[1]} cannot be null.`
                    );
                    isValid = false; // Set valid flag to false
                }

                // Check if quantity exceeds the ordered quantity
                if (qtyToDeliver > maxQty) {
                    toastr.warning(
                        `Quantity to deliver for SKU ${$(this).attr('id').split('_')[1]} exceeds the ordered quantity.`
                    );
                    isValid = false; // Set valid flag to false
                }

                // Check if quantity is negative
                if (qtyToDeliver < 0) {
                    toastr.error(
                        `Quantity to deliver for SKU ${$(this).attr('id').split('_')[1]} cannot be negative.`
                    );
                    isValid = false; // Set valid flag to false
                }

                // Collect data for submission
                const sku = $(this).attr('id').split('_')[1];
                const reason = document.getElementById(`reason_${sku}`).value;
                deliveryData.push({
                    sku: sku,
                    qtyToDeliver: qtyToDeliver,
                    reason: reason
                });

                totalQtyOrdered += qtyToDeliver; // Accumulate total quantity
            });

            if (isValid) {
                // Show confirmation dialog using SweetAlert
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to save the delivery quantities?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with AJAX call to save data
                        $.ajax({
                            url: '/purchase-orders/delivery', // Replace with your actual endpoint
                            type: 'POST',
                            data: {
                                deliveryData: deliveryData,
                                orderNo: $('#orderNoId').val(), // Include order number if needed
                                confirmationDate: confirmationDate // Include confirmation date
                            },
                            success: function(response) {
                                toastr.success('Delivery quantities saved successfully.');
                                $('#deliveryModal').modal('hide');
                                window.location.href =
                                    '/purchase-orders/supplier/getOrders'; // Redirect to the orders page
                            },
                            error: function(xhr) {
                                toastr.error(
                                    'Failed to save delivery quantities. Please try again.');
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection
