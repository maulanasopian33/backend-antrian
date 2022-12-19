<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return response()->json([
            "status"    => "400",
            "message"   => "Anda harus login terlebih dahulu"
        ],400);
    }
    public function register(Request $request){
        $validator = Validator::make(Request()->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user   = User::create($input);
        $success['token'] =  $user->createToken($user->name)->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], 201);
    }
    public function postlogin(Request $req)
    {
        $validator  = Validator::make(Request()->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=> false,'error'=>$validator->errors()], 401);
        }
        $user   = User::where('email',$req->email)->first();
        if(!$user) return response()->json(['status'=> false,'error' => "Username tidak ditemukan",]);
        if(!Hash::check($req->password,$user->password)) return response()->json(['status'=>false,'error' => "Password Salah",]);

        $token = $user->createToken($user->name)->accessToken;
        return response()->json([
            'status'    => true,
            'message'   => [
                                'user'  => $user->name,
                                'token' => $token
                            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
