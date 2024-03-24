<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\user;
use Exception;
use Hash;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use PhpParser\Node\Stmt\TryCatch;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.content.dashboard');
    }

    public function profile()
    {
        $id = Auth::guard('user')->user()->id;
        dd($id);
        return view('backend.content.profile');
    }

    public function resetPassword()
    {
        return view('backend.content.resetPassword');
    }

    public function ProsesResetPassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'c_new_password' => 'required_with:new_password|same:new_password|min:6',
        ]);

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        $id = Auth::guard('user')->user()->id;
        $user = user::findOrFail($id);

        if (Hash::check($old_password, $user->password)) {
            $user->password = bcrypt($new_password);

            try {
                $user->save();
                return redirect(route('dashboard.resetPassword'))->with('pesan', ['success', 'Password berhasil diubah']);
            } catch (\Exception $e) {
                return redirect(route('dashboard.resetPassword'))->with('pesan', ['danger', 'Password gagal diubah']);
            }
        }else {
            return redirect(route('dashboard.resetPassword'))->with('pesan', ['danger', 'Password lama salah']);
        }
    }
}
