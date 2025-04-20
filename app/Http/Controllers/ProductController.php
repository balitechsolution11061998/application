<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Paguyuban;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $companies = Company::where('is_active', true)->get();
        return view('products.index', compact('companies'));
    }

    public function data(Request $request)
    {
        // Remove the debugging statement
        // dd("masuk sini");
        
        $query = Product::with(['company' => function ($query) {
            $query->select('id', 'name');
        }])
            ->select(['id', 'name', 'sku', 'price', 'image', 'company_id', 'is_active', 'created_at']);
    
        // Apply status filter if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
    
        // Apply company filter if provided
        if ($request->has('company') && $request->company !== '') {
            $query->where('company_id', $request->company);
        }
    
        return DataTables::of($query)
            ->addColumn('image_url', function ($product) {
                return $product->image ? asset('storage/' . $product->image) : asset('images/default-product.png');
            })
            ->addColumn('company.name', function ($product) {
                return $product->company ? $product->company->name : 'N/A';
            })
            ->editColumn('created_at', function ($product) {
                return $product->created_at->format('Y-m-d H:i');
            })
            ->toJson();
    }

    public function create()
    {
        $paguyubans = Paguyuban::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();
        return view('products.create', compact('paguyubans', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sku' => 'required|string|max:50|unique:products',
            'upc' => 'nullable|string|max:50|unique:products',
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'paguyubans' => 'nullable|array',
            'paguyubans.*.id' => 'exists:paguyubans,id',
            'paguyubans.*.price' => 'integer|min:0',
        ]);

        $data = $request->except('image', 'paguyubans');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/products', $filename);
            $data['image'] = $filename;
        }

        $product = Product::create($data);

        // Sync paguyuban prices
        if ($request->has('paguyubans')) {
            $paguyubanPrices = [];
            foreach ($request->paguyubans as $paguyuban) {
                if (isset($paguyuban['id']) && isset($paguyuban['price'])) {
                    $paguyubanPrices[$paguyuban['id']] = ['price' => $paguyuban['price']];
                }
            }
            $product->paguyubans()->sync($paguyubanPrices);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function detail($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return response()->json($this->formatProductData($product));
    }

    private function formatProductData($product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'image_url' => $this->getImageUrl($product),
            // ... field lainnya ...
            'company' => $product->company ? [
                'id' => $product->company->id,
                'name' => $product->company->name,
                'logo_url' => $this->getImageUrl($product->company, 'logo')
            ] : null,
            'created_at' => optional($product->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => optional($product->updated_at)->format('Y-m-d H:i:s')
        ];
    }

    private function getImageUrl($model, $field = 'image')
    {
        return $model->$field ? asset('storage/' . $model->$field) : asset('images/default-product.png');
    }

    public function edit(Product $product)
    {
        $paguyubans = Paguyuban::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();

        // Get current paguyuban prices
        $currentPaguyubans = $product->paguyubans->pluck('pivot.price', 'id')->toArray();

        return view('products.edit', compact('product', 'paguyubans', 'companies', 'currentPaguyubans'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'upc' => 'nullable|string|max:50|unique:products,upc,' . $product->id,
            'description' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'paguyubans' => 'nullable|array',
            'paguyubans.*.id' => 'exists:paguyubans,id',
            'paguyubans.*.price' => 'integer|min:0',
        ]);

        $data = $request->except('image', 'paguyubans');

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }

            $image = $request->file('image');
            $filename = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/products', $filename);
            $data['image'] = $filename;
        }

        $product->update($data);

        // Sync paguyuban prices
        $paguyubanPrices = [];
        if ($request->has('paguyubans')) {
            foreach ($request->paguyubans as $paguyuban) {
                if (isset($paguyuban['id']) && isset($paguyuban['price'])) {
                    $paguyubanPrices[$paguyuban['id']] = ['price' => $paguyuban['price']];
                }
            }
        }
        $product->paguyubans()->sync($paguyubanPrices);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Product status updated successfully.');
    }
}
