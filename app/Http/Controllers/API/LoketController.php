<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\loket;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = loket::get();
        $respon = [
            "status" => true,
            "message"=> "OK",
            "data"   => $search
        ];
        if($search == null) {
            $respon['status']   = false;
            $respon['message']  = "Data tidak ditemukan";
        }

        return response()->json($respon);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator  = Validator::make(Request()->all(),[
            'id_loket' => 'required',
            'nama_loket' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=> false,'message'=>$validator->errors()], 401);
        }

        $proses = loket::create($request->all());

        $respon = [
            "status" => true,
            "message"=> "Data berhasil di tambahkan"
        ];

        return response()->json($respon);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $search = loket::where('id_loket',$id)->first();
        $respon = [
            "status" => true,
            "message"=> "data berhasil diubah",
        ];
        if($search == null) {
            $respon['status']   = false;
            $respon['message']  = "Data tidak ditemukan";
            return response()->json($respon);
        }
        if(!$search->update($request->all())){
            $respon['status']   = false;
            $respon['message']  = "Data tidak berhasil diubah";
        }
        return response()->json($respon);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $respon = [];
        $search = loket::where('id_loket',$id)->first();
        if($search == null) {
            $respon['status']   = false;
            $respon['message']  = "Data tidak ditemukan";
            return response()->json($respon);
        }
        if($search->delete()){
            $respon['status']   = false;
            $respon['message']  = "Data berhasil dihapus";
            return response()->json($respon);
        }
    }
}
