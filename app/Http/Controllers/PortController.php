<?php

namespace App\Http\Controllers;

use Auth;
use Dingo\Api\Http;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class PortController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $api = $this->api->be(Auth::user());
        $ports = $api->get('/api/ports?include=device');

        return view('ports.list', ['ports' => $ports]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // show a single device
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //edit device form??
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //process device modify
    }
}
