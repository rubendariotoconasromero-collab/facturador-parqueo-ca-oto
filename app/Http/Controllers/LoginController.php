<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function login(Request $request){
        // Validación
        $credenciales=[
            'name'=> $request->name,
            'password'=> $request->password,
        ];

        if(Auth::attempt($credenciales)){

            if(Auth::user()->estado==1){
                $request->session()->regenerate();
                return redirect()->intended(route('siat.clientes'));
            }else{
                $mensaje='El usuario se encuentra INHABILITADO';
                return redirect()->route('login')->with(['mensaje'=>$mensaje]);
            }
        }else{
            $mensaje='Usuario y contraseña INCORRECTOS';
            return redirect()->route('login')->with(['mensaje'=>$mensaje]);
        }
    }

    public function logout(Request $request){
        Auth::Logout();// Laravel cierra la sesión
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
