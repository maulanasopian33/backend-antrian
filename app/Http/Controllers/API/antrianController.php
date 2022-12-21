<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class antrianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getalldata = antrian::whereDate('created_at', Carbon::today())->get();
        $getantrian = $getalldata->groupBy('id_loket');
        $keys       = array_keys($getantrian->all());
        // $counts      = array_keys($getantrian->all())->count();
        // $getantrian['1']->count();
        $hasil = [];
        $data  = [];
        for($i = 0; $i < sizeof($keys); $i++){
            $key   = $keys[$i];
            array_push($data,[
                'id'    => $key,
                'data'  => $getantrian[$key],
                'total' => $getantrian[$key]->count()
            ]);
        }
        $hasil['status'] = true;
        $hasil['data'] = $data;
        return response()->json($hasil);
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
            'id_loket'      => 'required',
            'id_antrian'    => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=> false,'message'=>$validator->errors()], 401);
        }
        $request['status'] = false;
        $proses = antrian::create($request->all());

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

    public function getantrian(){

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
        $search = antrian::where('id_antrian',$id)->first();
        $respon = [
            "status" => true,
            "message"=> "data berhasil diubah",
        ];
        if($search == null) {
            $respon['status']   = false;
            $respon['message']  = "Data tidak ditemukan";
            return response()->json($respon);
        }
        if($request->status === "true"){
            $request['status'] = true;
        }else{
            $request['status'] = false;
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
        //
    }
}
