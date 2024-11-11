<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function store(Request $request){
        $data = $request->data;
        $response = [];
         try {
            foreach ($data as $key => $value) {
                // Check if the supplier already exists
                $cekDataSupplier = DB::table('supplier')->where('supp_code', $value['supp_code'])->first();

                // Prepare the data to be inserted/updated
                $dataInsert = [
                    'supp_name' => $value['supp_name'],
                    'terms' => $value['terms'],
                    'contact_name' => $value['contact_name'],
                    'contact_phone' => $value['contact_phone'],
                    'contact_fax' => $value['contact_fax'],
                    'address_1' => $value['address_1'],
                    'address_2' => $value['address_2'],
                    'city' => $value['city'],
                    'tax_ind' => $value['tax_ind'],
                    'consig_ind' => $value['consig_ind'],
                    'status' => 'Y',
                ];

                // Handle optional fields
                $dataInsert['post_code'] = ($value['post_code'] != '-----') ? $value['post_code'] : null;
                $dataInsert['tax_no'] = (!empty($value['collect_tax_no'])) ? $value['collect_tax_no'] : "N";

                // Update or insert the supplier data
                if ($cekDataSupplier != null) {
                    // Update existing supplier
                    $supplier = $this->supplierService->updateSupplier($dataInsert, $cekDataSupplier->id);
                    $response = [
                        'message' => 'Supplier berhasil diperbaharui',
                        'status' => true,
                                            'success'=>true
                    ];
                } else {
                    // Insert new supplier
                    $dataInsert['supp_code'] = $value['supp_code']; // Only set supp_code for new records
                    $supplier = $this->supplierService->createSupplier($dataInsert);
                    $response = [
                        'message' => 'Sukses menambahkan supplier',
                        'status' => true,
                        'success'=>true
                    ];
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            // Log the error message
            \Log::error('Error processing supplier data: ' . $e->getMessage());
            // You can also return an error response if needed
            $response = [
                'message' => 'Error processing supplier data',
                'status' => false,
            ];
        }
        return response()->json($response);

    }
}
