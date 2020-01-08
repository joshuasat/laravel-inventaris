<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Penerbit;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class PenerbitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $penerbits = Penerbit::get();
        return view('penerbits.index', compact('penerbits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        return view('penerbits.create');
    }

    public function format()
    {
        $data = [['judul' => null, 'isbn' => null]];
            $fileName = 'format-buku';
            

        $export = Excel::create($fileName.date('Y-m-d_H-i-s'), function($excel) use($data){
            $excel->sheet('buku', function($sheet) use($data) {
                $sheet->fromArray($data);
            });
        });

        return $export->download('xlsx');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|string|max:255',
            'penerbit' => 'required|string'
        ]);

        if($request->file('cover')) {
            $file = $request->file('cover');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('cover')->move("images/buku", $fileName);
            $cover = $fileName;
        } else {
            $cover = NULL;
        }

    Penerbit::create([
                'id' => $request->get('id'),
                'penerbit' => $request->get('penerbit'),
            ]);

        alert()->success('Berhasil.','Data telah ditambahkan!');

        return redirect()->route('penerbits.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->level == 'user') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $data = Penerbit::findOrFail($id);

        return view('penerbits.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if(Auth::user()->level == 'user') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $data = Penerbit::findOrFail($id);
        return view('penerbits.edit', compact('data'));
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
        Penerbit::find($id)->update([
             'id' => $request->get('id'),
             'penerbit' => $request->get('penerbit'),
                ]);

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->route('penerbits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penerbit::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('penerbits.index');
    }
}
