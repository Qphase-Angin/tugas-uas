<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil pengguna yang ditandai aktif (is_active = 1)
        $activeUsers = User::select('id', 'nama', 'email', 'image', 'is_active', 'created_at')
            ->where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->take(24)
            ->get();

        $totalUsers = User::count();

        // Ambil data items dari DB jika model tersedia
        try {
            $totalItems = Item::count();
            $newItemsCount = Item::where('created_at', '>=', now()->subDays(7))->count();
            $items = Item::orderBy('created_at', 'desc')->take(12)->get();
        } catch (\Throwable $e) {
            // Jika belum ada table/items, gunakan fallback
            $totalItems = 0;
            $newItemsCount = 0;
            $items = [];
        }

        return view('admin.dashboard', compact('activeUsers', 'items', 'totalUsers', 'totalItems', 'newItemsCount'));
    }

    // PROFIL

    public function tampilProfil()
    {
    return view('admin.profil');
    }

    public function updateProfil(Request $request)
    {
    $messages = [
        'nama.required' => 'Nama lengkap harus diisi.',
        'image.image' => 'Gambar harus berupa file image.',
        'image.max' => 'Maksimal ukuran file 1 MB.',
    ];
    $validatedData = $request->validate([
        'nama' => 'required|string|max:128',
        'image' => 'image|mimes:jpeg,jpg,png|file|max:1024',
    ], $messages);

    if ($request->file('image')) {
    // Hapus file lama dari disk 'public' jika bukan default
    if ($request->oldImage && $request->oldImage <> 'profil-pic/default.jpg') {
        Storage::disk('public')->delete($request->oldImage);
    }
    // Simpan file ke disk 'public' sehingga dapat diakses lewat asset('storage/...')
    $validatedData['image'] = $request->file('image')->store('profil-pic', 'public');
    }
    User::where('id', Auth::user()->id)->update($validatedData);
    return redirect()->route('admin.profil')->with('success', 'Profilmu berhasil
    diupdate.');
    }

    // GANTI PASSWORD
     public function tampilGantiPassword()
    {
    return view('admin.ganti_password');
    }

    public function updateGantiPassword(Request $request)
    {
        $messages = [
        'password_saat_ini.required' => 'Password saat ini harus diisi.',
        'password_saat_ini.min' => 'Minimal 8 karakter.',
        'password_baru.required' => 'Password baru harus diisi.',
        'password_baru.min' => 'Minimal 8 karakter.',
        'konfirmasi_password.required' => 'Konfirmasi password harus diisi.',
        'konfirmasi_password.min' => 'Minimal 8 karakter.',
        'konfirmasi_password.same' => 'Password dan konfirmasi password tidak
    cocok.',
        ];

        $validatedData = $request->validate([
        'password_saat_ini' => 'required|string|min:8',
        'password_baru' => 'required|string|min:8',
        'konfirmasi_password' => 'required|string|min:8|same:password_baru',
        ], $messages);

        $cekPassword = Hash::check($request->password_saat_ini, auth()->user()->password);

        if (!$cekPassword) {
        return redirect()->back()->with('error', 'Gagal, password saat ini salah');
        }

        User::where('id', Auth::user()->id)->update([
        'password' => Hash::make($request->password_baru),
        ]);
        return redirect()->route('admin.ganti-password')->with('success', 'Password berhasil diupdate.');
    }
}
