<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // membuat bikin 2 fungsi
    // handle register user
    // handle login user
    public function Register(Request $req) {
        try {
            // jabakan request yang akan di tampung
            $validasi = Validator::make($req->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);
            if ($validasi->fails()) {
                return response()->json($validasi->errors(), 422);
            }
    
            $credential = new User();
            $credential->name = $req->name;
            $credential->email = $req->email;
            $credential->password = Hash::make($req->password);
            $credential->save();
            
            $response = [
                'success' => true,
                'status' => 200,
                'message' => 'Pendaftaran Berhasil',
                'data' => $credential,
            ];
            return response()->json($response);
    
        } catch (\Throwable $th) {
            // throw $st;
            $response = ['status' => 500, 'message' => $th];
        };
    }

    function Login(Request $req) {
        // tahapan login
        // cek user atau tidak
        $user = User::where('email', $req->email)->first();
        if($user != null && Hash::check($req->password, $user->password)) {
            $token = $user->createToken('Personal Token')->plainTextToken;
            $response = [
                'success' => true,
                'status' => 200,
                'token' => $token,
                'massage' => 'Login Success',
                'data' => $user
            ];
            return response()->json($response);
        }elseif($user==null) {
            $response = [
                'success' => false,
                'status' => 500,
                'message' => 'Akun Tidak ditemukan',
            ];
            return response()->json($response);
        }else{
            $response = [
                'success' => false,
                'status' => 500,
                'massage' => 'Email atau Password Salah!',
            ];
            return response()->json($response);
        }    
    }
}
