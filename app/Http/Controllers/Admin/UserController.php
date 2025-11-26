<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Destroy user
    public function destroy(User $user)
    {
        // optionally delete user image
        if ($user->image && $user->image !== 'profil-pic/default.jpg') {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User dihapus.');
    }
}
