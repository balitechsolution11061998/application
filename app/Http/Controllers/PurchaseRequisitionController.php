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
        dd($request->all());
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
            $purchaseRequisition->kondisiBarang = 'new';
            $purchaseRequisition->keteranganKondisiBarang = $request->keteranganKondisiBarang;
            $purchaseRequisition->pembayaran = "kredit";
            $purchaseRequisition->status = 'progress';
            $purchaseRequisition->steps = "departmentheadho";
            $purchaseRequisition->nama_pr = $request->nama_pr;
            $purchaseRequisition->departement_pemesan = 9;
            $purchaseRequisition->save();

            // Save PurchaseRequisitionDetails
            foreach ($request->detail as $tempDetail) {
                $detail = new PurchaseRequisitionDetail();
                $detail->purchase_requisition_id = $purchaseRequisition->id;
                $detail->purchase_requisition_detail_name = $tempDetail['purchase_requisition_detail_name'];
                $detail->kebutuhan = $tempDetail['kebutuhan'];
                $detail->keterangan_kebutuhan = $tempDetail['keterangan_kebutuhan'] ?? '';
                $detail->qty = $tempDetail['qty'];
                $detail->hargaPerPcs = 0;
                $detail->hargaPerPcsRp = 0;
                $detail->hargaTotal = 0;
                $detail->hargaTotalRp = 'Rp ' . number_format(0, 0, ',', '.');
                $detail->satuan = $tempDetail['satuan'] ?? '-';
                $detail->save();
            }
            return $request->all();
            // Save PurchaseRequisitionImages
            foreach ($request->image as $tempImage) {
                $image = new PurchaseRequisitionImage();
                $image->purchase_requisition_id = $purchaseRequisition->id;
                $image->name = $tempImage['name'];
                $image->save();
            }

            // Commit the transaction
            DB::commit();

            // Return response with PR ID
            return response()->json([
                'success' => true,
                'message' => 'Purchase requisition created successfully',
                'purchaseRequisitionId' => $purchaseRequisition->id,
                'icon' => 'success',
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            // DB::rollBack(); // Uncomment this if using transactions
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}