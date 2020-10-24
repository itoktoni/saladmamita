<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use michaelFrank\dynamicphoto\config\CkeditorUploud;

class APIController extends Controller
{
    public function login(Request $request)
    {
        //VALIDASI DATA YANG DIKIRIMKAN
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'type' => 'required'
        ]);

        //CARI BERDASARKAN EMAIL
        $user = User::where('email', $request->email)->first();

        //LAKUKAN PENGECEKAN, JIKA PASSWORDNYA TIDAK SESUAI
        if (!Hash::check($request->password, $user->password)) {
            //MAKA BERIKAN RESPON FAILED
            return response()->json(['status' => 'failed', 'data' => 'Password Anda Salah']);
        }
        //SELAIN ITU, BERIKAN RESPON SUKSES DAN GENERATE TOKEN LOGIN
        return response()->json(['status' => 'success', 'data' => $user->createToken($request->type)->plainTextToken]);
    }

    public function data()
    {
        $data = User::all();
        return response()->json($data, 200);
    }

    public function uploud(Request $req)
    {
        $file =  new CkeditorUploud();
        $saved = $file->uploadAction($req, 'Album01');
        return $saved;
    }
}
