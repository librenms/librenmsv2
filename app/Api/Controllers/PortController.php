<?php

namespace App\Api\Controllers;

use Auth;
use App\User;
use App\Port;
use App\Api\Transformers\PortTransformer;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Input;

class PortController extends Controller
{
    use Helpers;

    public function __construct() {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasGlobalRead()) {
            $includes = explode(',', Input::get('include'));
            if (in_array('device', $includes)) {
                $ports = Port::with('device')->get();
            }
            else {
                $ports = Port::all();
            }
            return $this->response->collection($ports, new PortTransformer);
            return $ports;
        }
        else {
            return Auth::user()->ports()->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->hasGlobalRead()) {
            return Port::find($id);
        }
        else {
            $user = User::find($request->user()->user_id);
            return $user->ports()->find($id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
