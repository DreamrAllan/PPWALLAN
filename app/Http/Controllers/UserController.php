<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationNotification; // Import mail class
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Please login to access the dashboard.'])
                ->onlyInput('email');
        }

        $users = User::get();
        return view('users')->with('users', $users);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $file = public_path('storage/' . $user->photo);

        try {
            if (File::exists($file)) {
                File::delete($file);
            }
            $user->delete();
        } catch (\Throwable $th) {
            return redirect()->route('users.index')->with('error', 'Gagal hapus data');
        }

        return redirect()->route('users.index')->with('success', 'Berhasil hapus data');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            $newPhoto = $request->file('photo');
            $newPhotoPath = 'uploads/photos/';

            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $newPhoto->store($newPhotoPath, 'public');
            $user->photo = $path;
        }

        $user->save();
        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
    
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'registered_at' => $user->created_at->format('Y-m-d H:i:s'),
        ];
    
        // Cek apakah email berhasil dikirim
        try {
            Mail::to($user->email)->send(new RegistrationNotification($data));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    
        return redirect()->route('home')->with('success', 'Pendaftaran berhasil. Email notifikasi telah dikirim.');
    }    
}
