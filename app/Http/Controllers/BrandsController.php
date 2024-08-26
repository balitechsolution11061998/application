<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    //
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand=Brands::orderBy('id','DESC')->paginate();
        return view('brand.index')->with('brands',$brand);
    }

    public function data()
    {
        $brands = Brands::select(['id', 'title', 'slug', 'status']);

        return DataTables::of($brands)
            ->addColumn('action', function($row) {
                $editUrl = route('brands.edit', $row->id);
                $deleteUrl = route('brands.destroy', $row->id);
                return '<a href="'.$editUrl.'" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="'.$deleteUrl.'" class="d-inline">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>';
            })
            ->editColumn('status', function($row) {
                return $row->status == 'active' ? '<span class="badge bg-success">'.$row->status.'</span>' : '<span class="badge bg-warning">'.$row->status.'</span>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required',
        ]);
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Brands::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $data;
        $status=Brands::create($data);
        if($status){
            request()->session()->flash('success','Brand successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('brands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand=Brands::find($id);
        if(!$brand){
            request()->session()->flash('error','Brand not found');
        }
        return view('brand.edit')->with('brand',$brand);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand=Brands::find($id);
        $this->validate($request,[
            'title'=>'string|required',
        ]);
        $data=$request->all();

        $status=$brand->fill($data)->save();
        if($status){
            request()->session()->flash('success','Brand successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand=Brands::find($id);
        if($brand){
            $status=$brand->delete();
            if($status){
                request()->session()->flash('success','Brand successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('brands.index');
        }
        else{
            request()->session()->flash('error','Brand not found');
            return redirect()->back();
        }
    }
}
