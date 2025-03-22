<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|string',
            'options' => 'nullable|json',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    // Menampilkan detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    // Mengupdate produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'price' => 'sometimes|integer',
            'image' => 'sometimes|string',
            'options' => 'nullable|json',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}