<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\PurchaseRequisitionImage;
use Illuminate\Http\Request;

class PurchaseRequisitionController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Extract main requisition data from the request
            $data = $request->all();

            // Decode the 'detail' and 'image' JSON strings
            $details = json_decode($data['detail'], true);
            $images = json_decode($data['image'], true);

            // Insert into purchase_requisition table without 'no_pr'
            $purchaseRequisition = PurchaseRequisition::create([
                'region_id' => 4, // Set this according to your logic
                'department_id' => 9, // Set this according to your logic
                'nama_department' => 'Development', // Set this according to your logic
                'nama_pembuat' => $data['nama_pembuat'],
                'tanggalpr' => $data['tanggal_pr'],
                'tanggal_update_step_pr' => now(),
                'kondisiBarang' => 'Baru', // Set this according to your logic
                'keteranganKondisiBarang' => $data['keteranganKondisiBarang'],
                'pembayaran' => 'Kredit', // Set this according to your logic
                'status' => 'progress', // Set this according to your logic
                'steps' => 'Department Head Office', // Set this according to your logic
                'nama_pr' => $data['nama_pr'],
                'departement_pemesan' => 9, // Set this according to your logic
            ]);

            // Generate no_pr based on the ID
            $purchaseRequisition->no_pr = 'PR-' . $purchaseRequisition->id;
            $purchaseRequisition->save();

            // Insert into purchase_requisition_detail table
            if(count($details) > 0){
                foreach ($details as $detail) {
                    PurchaseRequisitionDetail::create([
                        'purchase_requisition_id' => $purchaseRequisition->id,
                        'purchase_requisition_detail_name' => $detail['purchase_requisition_detail_name'],
                        'kebutuhan' => $detail['kebutuhan'],
                        'keterangan_kebutuhan' => $detail['keterangan_kebutuhan'],
                        'qty' => $detail['qty'],
                        'hargaPerPcs' => 0, // Set this according to your logic
                        'hargaPerPcsRp' => 'Rp 0', // Set this according to your logic
                        'hargaTotal' => 0, // Set this according to your logic
                        'hargaTotalRp' => 'Rp 0', // Set this according to your logic
                        'satuan' => $detail['satuan'],
                    ]);
                }
            }

            // Insert into purchase_requisition_image table
            if(count($images) > 0){
                foreach ($images as $image) {
                    PurchaseRequisitionImage::create([
                        'purchase_requisition_id' => $purchaseRequisition->id,
                        'link_file' => $image['name'],
                        'name' => basename($image['name']),
                    ]);
                }
            }

            DB::commit();

            // Return a JSON response with success message and the PR ID
            return response()->json([
                'success' => true,
                'message' => 'Purchase Requisition created successfully.',
                'purchase_requisition_id' => $purchaseRequisition->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
{
    try {
        // Retrieve the purchase requisition by ID
        $purchaseRequisition = PurchaseRequisition::with(['details', 'images']) // Include related details and images
            ->findOrFail($id);

        // Return a JSON response with the purchase requisition data
        return response()->json([
            'success' => true,
            'message' => 'Purchase Requisition retrieved successfully.',
            'data' => $purchaseRequisition
        ]);

    } catch (\Exception $e) {
        // Handle the exception and return an error response
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage(),
        ], 500);
    }
}


}
