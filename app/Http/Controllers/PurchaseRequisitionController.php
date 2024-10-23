<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\PurchaseRequisitionImage;
use App\Models\TempPurchaseRequisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseRequisitionController extends Controller
{
    //
    public function store(Request $request)
    {
        // DB::beginTransaction(); // Uncomment this to enable transactions if necessary
        try {
            // Get the last PurchaseRequisition ID
            $lastId = PurchaseRequisition::max('id');
            $newNoPr = $lastId + 1;

            // Create a new PurchaseRequisition instance
            $purchaseRequisition = new PurchaseRequisition();
            $purchaseRequisition->no_pr = 'PR' . $newNoPr;
            $purchaseRequisition->region_id = 4;
            $purchaseRequisition->department_id = 9;
            $purchaseRequisition->nama_department = "development";
            $purchaseRequisition->nama_pembuat = $request->nama_pembuat;
            $purchaseRequisition->tanggalpr = $request->tanggal_pr;
            $purchaseRequisition->tanggal_update_step_pr = $request->tanggal_pr;
            $purchaseRequisition->kondisiBarang = 'baru';
            $purchaseRequisition->keteranganKondisiBarang = $request->keteranganKondisiBarang;
            $purchaseRequisition->pembayaran = "kredit";
            $purchaseRequisition->status = 'progress';
            $purchaseRequisition->steps = "departmentheadho";
            $purchaseRequisition->nama_pr = $request->nama_pr;
            $purchaseRequisition->departement_pemesan = 9;
            $purchaseRequisition->save();
            // Save PurchaseRequisitionDetails

            // Decode the 'detail' field if it's a JSON string
            $details = is_string($request->detail) ? json_decode($request->detail, true) : $request->detail;

            // Check if the decoded 'detail' is an array
            if (is_array($details)) {
                foreach ($details as $tempDetail) {
                    $detail = new PurchaseRequisitionDetail();
                    $detail->purchase_requisition_id = $purchaseRequisition->id;

                    // Access array values with array-style syntax
                    $detail->purchase_requisition_detail_name = $tempDetail['purchase_requisition_detail_name'];
                    $detail->kebutuhan = $tempDetail['kebutuhan'];
                    $detail->keterangan_kebutuhan = $tempDetail['keterangan_kebutuhan'] ?? ''; // Use array syntax and default if null
                    $detail->qty = $tempDetail['qty'];
                    $detail->hargaPerPcs = 0; // This value can be set as per your logic
                    $detail->hargaPerPcsRp = 0; // This value can be set as per your logic
                    $detail->hargaTotal = 0; // This value can be set as per your logic
                    $detail->hargaTotalRp = 'Rp ' . number_format(0, 0, ',', '.');
                    $detail->satuan = $tempDetail['satuan'] ?? '-'; // Use array syntax and default if null

                    // Save each detail
                    $detail->save();
                }
            } else {
                // Return an error response if 'detail' is not an array
                return response()->json([
                    'success' => false,
                    'message' => 'The detail field must be a valid array.'
                ], 400);
            }

            // Decode the 'image' field if it's a JSON string
            $images = is_string($request->image) ? json_decode($request->image, true) : $request->image;

            // Check if the decoded 'image' is an array
            if (is_array($images)) {
                // Save PurchaseRequisitionImages
                foreach ($images as $tempImage) {
                    $image = new PurchaseRequisitionImage();
                    $image->purchase_requisition_id = $purchaseRequisition->id;
                    $image->name = $tempImage['name']; // Use array syntax
                    $image->save();
                }
            } else {
                // Return an error response if 'image' is not an array
                return response()->json([
                    'success' => false,
                    'message' => 'The image field must be a valid array.'
                ], 400);
            }


            // Commit the transaction
            DB::commit();

            // Return response with PR ID
            return response()->json([
                'success' => true,
                'message' => 'Purchase requisition created successfully',
                'purchase_requisition_id' => $purchaseRequisition->id,
                'icon' => 'success',
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            // DB::rollBack(); // Uncomment this if using transactions
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
