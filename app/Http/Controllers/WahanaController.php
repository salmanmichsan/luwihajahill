<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File; 
use App\Wahana;
use DataTables;
class WahanaController extends Controller
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
        return view('wahana.homebanner');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wahana.homebannercreate');
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
            'name'   =>  'required',
            'category' => 'required',
            'image'     =>  'required|image|max:2048'
        ]);
        $image = $request->file('image');
        $extention = $image->getClientOriginalExtension();
        // return($image->getClientOriginalName());
        Storage::disk('wahana')->put($image->getFilename().'.'.$extention, File::get($image)); 
        $wahana = new Wahana;
        $wahana->image = $image->getFilename().'.'.$extention;
        $wahana->name = $request->name;
        
        $wahana->category = $request->category;

        $wahana->save();
        return redirect('wahana')->with('success', 'wahana generated successfully.');
    }

    public function getBasicData()
    {
        $users = Wahana::select(['id','image','name','category']);        
        return DataTables::of($users)
                ->addColumn('action', function ($user) {
                        return '<a href="/wahana/'.$user->id.'/edit" class="btn btn-xs btn-warning"><i class="fa fa-pen"></i></a> <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#exampleModal_'.$user->id.'"><i class="fa fa-trash"></i></button><div class="modal fade" id="exampleModal_'.$user->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus wahana</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Anda yakin ingin menghapus wahana ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <form method="post" action="/wahana/'.$user->id.'/delete">
                                                '.csrf_field().'
                                            <button type="submit" class="btn btn-primary">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                })->addColumn('img',function($user){
                        $url = asset('uploads/wahana/'.$user->image.'');
                        return '<img src="'.$url.'" height="50">';
                })->addColumn('category',function($user){
                        
                        return $user->category;
                })
                ->rawColumns(['img','action','category'])
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
        $data = Wahana::findOrFail($id);
        return view('wahana.homebanneredit', compact('data'));
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
        $data = Wahana::findOrFail($id);        
        $image_name = $data->image;
        $image = $request->file('image');
        if($request->file('image')!=''){
            $request->validate([
                'name'    =>  'required',
                'category'    =>  'required',
                'image'     =>  'required|image|max:2048'
            ]);    
            Storage::disk('wahana')->delete($data->image);
                
            
            $extention = $image->getClientOriginalExtension();            
            $image_name = $image->getFilename().'.'.$extention;
            Storage::disk('wahana')->put($image->getFilename().'.'.$extention, File::get($image)); 
        }else{
            $request->validate([
                'name'    =>  'required',
                'category'    =>  'required'
            ]);                
        }
        
        $form_data = array(
            'image'         =>   $image_name,
            'name'       =>   $request->name,
            'category'        =>   $request->category
            
        );
        // dd($form_data);
        $data->update($form_data);
        
        return redirect('wahana')->with('success', 'wahana is successfully updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Wahana::findOrFail($id);
        Storage::disk('wahana')->delete($data->image);

        $data->delete();
        return redirect('wahana')->with('success', 'Data is successfully deleted');
    }
}
