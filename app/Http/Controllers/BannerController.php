<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    //
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner=Banner::orderBy('id','DESC')->paginate(10);
        return view('banner.index')->with('banners',$banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string',
            'photo' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Prepare data for insertion
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $request->photo,
            'status' => $request->status,
        ];

        // Generate a unique slug
        $slug = Str::slug($request->title);
        $count = Banner::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;

        // Create a new banner
        $status = Banner::create($data);

        // Flash success or error message
        if ($status) {
            $request->session()->flash('success', 'Banner successfully added');
        } else {
            $request->session()->flash('error', 'Error occurred while adding banner');
        }

        // Redirect to the banner index page
        return redirect()->route('banner.index');
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
        $banner=Banner::findOrFail($id);
        return view('banner.edit')->with('banner',$banner);
    }
    public function data()
    {
        $banners = Banner::query();

        return DataTables::of($banners)
            ->addColumn('action', function ($banner) {
                return '
                    <a href="' . route('banner.edit', $banner->id) . '" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="' . route('banner.destroy', $banner->id) . '" class="d-inline-block" onsubmit="return confirm(\'Are you sure you want to delete this banner?\');">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                ';
            })
            ->editColumn('photo', function ($banner) {
                return $banner->photo
                    ? '<img src="' . $banner->photo . '" class="img-fluid rounded shadow-sm" style="max-width:80px" alt="' . $banner->title . '">'
                    : '<img src="' . asset('backend/img/thumbnail-default.jpg') . '" class="img-fluid rounded shadow-sm" style="max-width:80px" alt="default">';
            })
            ->editColumn('status', function ($banner) {
                return $banner->status == 'active'
                    ? '<span class="badge bg-success">' . $banner->status . '</span>'
                    : '<span class="badge bg-warning">' . $banner->status . '</span>';
            })
            ->rawColumns(['photo', 'status', 'action'])
            ->make(true);
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
        $banner=Banner::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required|max:50',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $request->photo,
            'status' => $request->status,
        ];
        // $slug=Str::slug($request->title);
        // $count=Banner::where('slug',$slug)->count();
        // if($count>0){
        //     $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['slug']=$slug;
        // return $slug;
        $status=$banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Banner successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred while updating banner');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner=Banner::findOrFail($id);
        $status=$banner->delete();
        if($status){
            request()->session()->flash('success','Banner successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}
