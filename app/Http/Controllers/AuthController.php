<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (auth()->attempt($credentials)) {
            $token = Auth::guard('api')->attempt($credentials);
            return response()->json([
                'success' => true,
                'message' => 'Login Berhasil',
                'token'   => $token,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password Salah'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_customer' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        unset($input['konfirmasi_password']);
        $Customer = Customer::create($input);

        return response()->json([
            'data' => $Customer
        ]);
    }

    public function login_customer()
    {
        return view('auth.login_customer');
    }

    public function login_customer_action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors()->toArray());
            return redirect('/login_customer');
        }

        $credentials = $request->only('email', 'password');
        $customer = Customer::where('email', $request->email)->first();

        if ($customer) {
            if (Auth::guard('webcustomer')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect('/');
            } else {
                Session::flash('failed', "Password salah");
                return redirect('/login_customer');
            }
        } else {
            Session::flash('failed', "Email Tidak ditemukan");
            return redirect('/login_customer');
        }
    }

    public function register_customer()
    {
        return view('auth.register_customer');
    }

    public function register_customer_action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_customer' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors()->toArray());
            return redirect('/register_customer');
        }

        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        unset($input['konfirmasi_password']);
        Customer::create($input);

        Session::flash('success', 'Akun berhasil dibuat');
        return redirect('/login_customer');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

    public function logout_customer()
    {
        Auth::guard('webcustomer')->logout();
        Session::flush();
        return redirect('/');
    }
}
