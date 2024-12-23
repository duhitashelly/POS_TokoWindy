<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(){
        $data = Kategori::all();
        return view('kategori.index', ['dataKategori' => $data]);
    }

    public function create(){
        return view('kategori.create');
    }

    public function store(Request $request){
        $data = new Kategori();
        $data->id = $request->id;
        $data->nama_kategori = $request->nama_kategori;
        $data->save();
        return redirect()->route('kategori.index');
    }

    public function edit($id){
        $data = Kategori::find($id);
        return view('kategori.edit', compact('data'));
    }

    public function update(Request $request, $id) {
        $data = Kategori::find($id);
        $data->nama_kategori = $request->nama_kategori;
        $data->update();
        return redirect()->route('kategori.index');
    }

    public function destroy($id){
        $data = Kategori::find($id);
        $data->delete();
        return redirect()->route('kategori.index');
    }
}
