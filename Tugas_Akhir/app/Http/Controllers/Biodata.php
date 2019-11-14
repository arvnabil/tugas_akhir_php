<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\tbl_biodata;
use Illuminate\Support\Facades\DB;
class Biodata extends Controller
{
    public function store(Request $request){
    	$this->validate($request, [
    		'file' => 'required|max:2048'
    	]);
    	// Menyimpan data dile yg diupload ke variable $file
    	$file = $request->file('file');
    	$nama_file = time()."_".$file->getClientOriginalName();
    	// isi dengan nama folder tempat kemana file diupload 
    	$tujuan_upload = 'data_file';
    	if($file->move($tujuan_upload, $nama_file)){
    		$data = tbl_biodata::create([
    			'nama' => $request->nama,
    			'no_hp' => $request->no_hp,
    			'alamat' => $request->alamat,
    			'hobi' => $request->hobi,
    			'foto' => $nama_file
    		]);
    		$res['message'] = "Berhasil Disimpan!";
    		$res['value'] = $data;
    		return response($res);
    	}
    }

    public function hapus($id)
    {
       $data = DB::table('tbl_biodata')->where('id', $id)->get();
       foreach ($data as $biodata) {
            if (file_exists(public_path('data_file/'.$biodata->foto))){
                @unlink(public_path('data_file/'.$biodata->foto));
                DB::table('tbl_biodata')->where('id', $id)->delete();
                $res['message'] = "Berhasil Dihapus!";
                return response($res);
            }else{
                $res['message'] = "Empty!";
                return response($res);
            }
        }
    }

    public function update(Request $request){
    	if(!empty($request->file)){
    		$this->validate($request, [
    		'file' => 'required|max:2048'
	    	]);
	    	// Menyimpan data dile yg diupload ke variable $file
	    	$file = $request->file('file');

	    	$nama_file = time()."_".$file->getClientOriginalName();

	    	// isi dengan nama folder tempat kemana file diupload 
	    	$tujuan_upload = 'data_file';
	    	$file->move($tujuan_upload, $nama_file);
	    	$data = DB::table('tbl_biodata')->where('id', $request->id)->get();
	    	// Update data
	    	foreach ($data as $biodata) {
	    		@unlink(public_path('data_file/'.$biodata->foto));
	    		$ket = DB::table('tbl_biodata')->where('id', $request->id)->update([
		    			'nama' => $request->nama,
						'no_hp' => $request->no_hp,
						'alamat' => $request->alamat,
						'hobi' => $request->hobi,
						'foto' => $nama_file
	    			]);
	    	$res['message'] = "Berhasil Diubah!";
    		$res['value'] = $ket;
    		return response($res);
	    	}
    	}else{
    		$data = DB::table('tbl_biodata')->where('id', $request->id)->get();
	    	// Update data
	    	foreach ($data as $biodata) {
	    		$ket = DB::table('tbl_biodata')->where('id', $request->id)->update([
		    			'nama' => $request->nama,
		    			'no_hp' => $request->no_hp,
		    			'alamat' => $request->alamat,
		    			'hobi' => $request->hobi,
	    			]);
	    	$res['message'] = "Berhasil Diubah!";
    		$res['value'] = $ket;
    		return response($res);
	    	}
    	}
    }

    public function getDetail($id)
    {
       $data = DB::table('tbl_biodata')->where('id', $id)->get();
       if(count($data) > 0){
            $res['message'] = "Baca Data Sesuai id!";
            $res['value'] = $data;
            return response($res);
        } else {
            $res['message'] = "Empty!";
            return response($res);
        }
    }

    public function getData(){

    	$data = DB::table('tbl_biodata')->get();
    	if(count($data) > 0){
    		$res['message'] = "Baca Semua Data!";
    		$res['value'] = $data;
    		return response($res);
    	} else {
    		$res['message'] = "Empty!";
    		return response($res);
    	}
    }
}
