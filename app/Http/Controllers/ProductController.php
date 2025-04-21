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
        $query = Product::with(['company:id,name,logo'])
            ->select([
                'id', 
                'name', 
                'sku', 
                'price', 
                'image', 
                'company_id', 
                'is_active', 
                'created_at',
                'stock',
                'stock_threshold',
                'discount_price',
                'description'
                // Removed 'category' from select
            ]);
    
        return DataTables::of($query)
            ->addColumn('image_url', function ($product) {
                return $product->image ? asset('storage/' . $product->image) : asset('images/default-product.png');
            })
            ->addColumn('company_logo', function ($product) {
                return $product->company && $product->company->logo 
                    ? asset('storage/' . $product->company->logo) 
                    : null;
            })
            ->addColumn('category', function ($product) {
                return $product->category ?? 'No category'; // Handle null case
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

       /**
     * Display the specified product.
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::with([
                    'company' => function ($query) {
                        $query->select('id', 'name', 'logo');
                    },
                    'paguyubans' => function ($query) {
                        $query->select('paguyubans.id', 'name')
                            ->withPivot('price');
                    }
                ])
                ->findOrFail($id);
    
            return view('products.show', [ // Note: changed to products.show
                'product' => $product,
                'image_url' => $this->getImageUrl($product),
                'company_logo_url' => $product->company 
                    ? $this->getImageUrl($product->company, 'logo') 
                    : null
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('products.index')
                ->with('error', 'Product not found');
        }
    }

    public function datas(Request $request)
{
    // Fetch the products along with the company data
    $products = Product::with(['company:id,name'])
        ->select(['id', 'name', 'sku', 'price', 'image', 'company_id', 'is_active', 'created_at', 'stock', 'stock_threshold', 'discount_price', 'description'])
        ->get();  // Use get() to retrieve all products

    // Prepare the data to return
    $data = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'price' => $product->price,
            'image_url' => $product->image ? asset('storage/' . $product->image) : asset('images/default-product.png'),
            'company' => $product->company ? [
                'id' => $product->company->id,
                'name' => $product->company->name,
            ] : null,
            'created_at' => $product->created_at->format('Y-m-d H:i:s'),
            'stock' => $product->stock,
            'stock_threshold' => $product->stock_threshold,
            'discount_price' => $product->discount_price,
            'description' => $product->description,
            'is_active' => $product->is_active,
            'category' => $product->category ?? 'No category',
            // Add any other necessary fields
        ];
    });

    // Return the data as JSON
    return response()->json(['data' => $data]);
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

 

    public function edit(Product $product)
    {
        $paguyubans = Paguyuban::where('is_active', true)->get();
        $companies = Company::where('is_active', true)->get();
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

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }

            $image = $request->file('image');
            $filename = Str::slug($request->name) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/products', $filename);
            $data['image'] = $filename;
        }

        $product->update($data);

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

    private function formatProductData($product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'image_url' => $this->getImageUrl($product),
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
}
