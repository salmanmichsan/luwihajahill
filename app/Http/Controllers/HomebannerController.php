<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File; 
use App\Homebanner;
use DataTables;
class HomebannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('banner.homebanner');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banner.homebannercreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'caption'   =>  'required',
            'image'     =>  'required|image|max:2048'
        ]);
        $image = $request->file('image');
        $extention = $image->getClientOriginalExtension();
        // return($image->getClientOriginalName());
        Storage::disk('banner')->put($image->getFilename().'.'.$extention, File::get($image)); 
        $banner = new Homebanner;
        $banner->image = $image->getFilename().'.'.$extention;
        $banner->caption = $request->caption;
        if($request->active){
            $request->active = 1;
        }else{
            $request->active = 0;
        }
        $banner->active = $request->active;

        $banner->save();
        return redirect('homebanner')->with('success', 'Banner generated successfully.');
    }

    public function getBasicData()
    {
        $users = Homebanner::select(['id','image','caption','active']);
        foreach ($users as $key => $value) {
            if($value->active = 1){
                $value->active = 'Active';
            }
            else{
                $value->active = 'Non-Active';
            }
        }

        return DataTables::of($users)
                ->addColumn('action', function ($user) {
                        return '<a href="/homebanner/'.$user->id.'/edit" class="btn btn-xs btn-warning"><i class="fa fa-pen"></i></a> <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#exampleModal_'.$user->id.'"><i class="fa fa-trash"></i></button><div class="modal fade" id="exampleModal_'.$user->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Banner</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Anda yakin ingin menghapus banner ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <form method="post" action="/homebanner/'.$user->id.'/delete">
                                                '.csrf_field().'
                                            <button type="submit" class="btn btn-primary">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                })->addColumn('img',function($user){
                        $url = asset('uploads/banner/'.$user->image.'');
                        return '<img src="'.$url.'" height="50">';
                })->addColumn('status',function($user){
                        if($user->active == 1){
                            $user->active = 'Active';
                        }else{
                            $user->active = 'No';
                        }
                        return $user->active;
                })
                ->rawColumns(['img','action','status'])
                // ->editColumn('id', 'ID: {{$id}}')
                // ->removeColumn('password')
                ->make(true);
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
        $data = Homebanner::findOrFail($id);
        return view('banner.homebanneredit', compact('data'));
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
        $data = Homebanner::findOrFail($id);        
        $image_name = $data->image;
        $image = $request->file('image');
        if($request->file('image')!=''){
            $request->validate([
                'caption'    =>  'required',
                'image'     =>  'required|image|max:2048'
            ]);    
            Storage::disk('banner')->delete($data->image);
                
            
            $extention = $image->getClientOriginalExtension();            
            $image_name = $image->getFilename().'.'.$extention;
            Storage::disk('banner')->put($image->getFilename().'.'.$extention, File::get($image)); 
        }else{
            $request->validate([
                'caption'    =>  'required',
            ]);                
        }
        if($request->active){
            $request->active = 1;
        }else{
            $request->active = 0;
        }
        $form_data = array(
            'image'         =>   $image_name,
            'caption'       =>   $request->caption,
            'active'        =>   $request->active
            
        );
        // dd($form_data);
        $data->update($form_data);
        
        return redirect('homebanner')->with('success', 'Banner is successfully updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Homebanner::findOrFail($id);
        Storage::disk('banner')->delete($data->image);

        $data->delete();
        return redirect('homebanner')->with('success', 'Data is successfully deleted');
    }
}
