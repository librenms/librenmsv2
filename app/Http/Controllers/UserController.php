<?php

namespace App\Http\Controllers;

use App\DataTables\General\UserDataTable;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Auth;
use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Helpers;

    /**
     * Constructor
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        if (Auth::user()->isAdmin()) {
            return $dataTable->render('users.manage');
        }
        return redirect('preferences');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $user = User::create($request->all());

        return response()->json(['message' => trans('user.text.created', ['username' => $user->username])]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        // show read only view of user info here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $user = User::with('devices', 'ports')->findOrFail($user_id);

        if (Auth::user()->isAdmin()) {
            return view('users.edit')->withUser($user);
        }

        return redirect('preferences');
    }

    /**
     * Show the user's preference page
     *
     * @return \Illuminate\Http\Response
     */
    public function preferences()
    {
        $user = Auth::user();

        $device_count = $user->devices()->count();
        $port_count = $user->ports()->count();

        return view('users.preferences', compact('device_count', 'port_count'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest|Request $request
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $user_id)
    {
        $user = User::find($user_id);
        $user->update($request->all());
        if ($request->input('update') == 'password') {
            $message = trans('user.text.pwdupdated');
        }
        else {
            $message = trans('user.text.updated', ['username' => $user->username]);
        }

        return redirect()->back()->with(['type' => 'success', 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteUserRequest $request, $user_id)
    {
        $user = User::find($user_id);
        $user->delete();

        return response()->json(['message' => trans('user.text.deleted', ['username' => $user->username])]);
    }
}
