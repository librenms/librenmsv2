<?php

namespace App\Http\Controllers;

use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Route;
use Hash;
use App\User;

class UserController extends Controller
{
    use Helpers;

    public function __construct(Request $request) {
        $this->middleware('auth');
    }

    public function preferences(Request $request) {

        $method = $request->method();
        $updated = false;
        if ($request->user()->hasGlobalRead() === true)
        {
            $devices = [];
            $ports   = [];
        }
        else {
            $devices = User::find($request->user()->user_id)->devices()->count();
            $ports   = User::find($request->user()->user_id)->ports()->count();
        }

        if ($method === "POST")
        {
            $this->validate($request, [
                'current_password' => 'required|max:255',
                'new_password' => 'required|min:8|max:255',
                'repeat_password' => 'required|same:new_password|min:8|max:255',
            ]);
            if (!Hash::check($request->current_password, $request->user()->password))
            {
                return back()->withInput()->withErrors(['current_password'=>'Current password is incorrect']);
            }
            $user = User::where('user_id', $request->user()->user_id)->first();
            $user->password = Hash::make($request->new_password);
            if ($user->save())
            {
                $updated = true;
            }
        }
        return view('users.preferences', ['updated' => $updated, 'devices' => $devices, 'ports' => $ports]);
    }
}
