<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;

class LoginRegisterController extends Controller
{
    // Instantiate a new LoginRegisterController instance
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard']);
    }

    // Display the registration form
    public function register()
    {
        return view('auth.register');
    }

    // Store a new user
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Authenticate the user
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);

        // Redirect the user to the dashboard
        $request->session()->regenerate();
        return redirect()->route('dashboard')
            ->withSuccess('You have successfully registered & logged in!');
    }

    // Display the login form
    public function login()
    {
        return view('auth.login');
    }

    // Authenticate the user
    public function authenticate(Request $request)
    {
        // Validate the incoming credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        // Redirect back with an error if authentication fails
        return back()->withErrors([
            'email' => 'Your provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Display the dashboard to authenticated users
    public function dashboard()
{
    // Check if the user is authenticated
    if (Auth::check()) {
        $user = Auth::user();

        // Jika pengguna adalah admin
        if ($user->level === 'admin') {
            // Ambil data buku untuk dashboard admin
            $data_buku = Buku::all();
            $jumlah_buku = $data_buku->count();
            $total_harga = $data_buku->sum('harga');

            return view('auth.dashboard', compact('data_buku', 'jumlah_buku', 'total_harga'));
        }

        // Jika user biasa, arahkan ke halaman home
        return view('home');
    }

    // Redirect to the login page if not authenticated
    return redirect()->route('login')
        ->withErrors(['email' => 'Please login to access the dashboard.']);
}


    // Logout the user from the application
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
}
