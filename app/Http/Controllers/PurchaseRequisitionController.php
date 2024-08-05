<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\PurchaseRequisitionImage;
use Illuminate\Http\Request;
class QueryPerformanceLogController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Insert into purchase_requisition table without 'no_pr'
            $purchaseRequisition = PurchaseRequisition::create([
                'region_id' => 4, // Set this according to your logic
                'department_id' => 9, // Set this according to your logic
                'nama_department' => 'Development', // Set this according to your logic
                'nama_pembuat' => $request->input('nama_pembuat'),
                'tanggalpr' => $request->input('tanggal_pr'),
                'tanggal_update_step_pr' => now(),
                'kondisiBarang' => 'Baru', // Set this according to your logic
                'keteranganKondisiBarang' => $request->input('keteranganKondisiBarang'),
                'pembayaran' => 'Kredit', // Set this according to your logic
                'status' => 'progress', // Set this according to your logic
                'steps' => 'Department Head Office', // Set this according to your logic
                'nama_pr' => $request->input('nama_pr'),
                'departement_pemesan' => 9, // Set this according to your logic
            ]);

            // Generate no_pr based on the ID
            $purchaseRequisition->no_pr = 'PR-' . $purchaseRequisition->id;
            $purchaseRequisition->save();

            // Insert into purchase_requisition_detail table
            $details = json_decode($request->input('detail'), true);
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

            // Insert into purchase_requisition_image table
            $images = json_decode($request->input('image'), true);
            foreach ($images as $image) {
                PurchaseRequisitionImage::create([
                    'purchase_requisition_id' => $purchaseRequisition->id,
                    'link_file' => $image['name'],
                    'name' => basename($image['name']),
                ]);
            }

            DB::commit();

            // Return a JSON response with success message and the PR ID
            return response()->json([
                'success' => true,
                'message' => 'Purchase Requisition created successfully.',
                'purchase_requisition_id' => $purchaseRequisition->id,
                'no_pr' => $purchaseRequisition->no_pr,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
