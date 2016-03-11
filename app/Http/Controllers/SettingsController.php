<?php
/**
 * Copyright (C) 2016 Tony Murray <murraytony@gmail.com>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Config;
use Illuminate\Http\Request;
use Settings;

class SettingsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(Request $request) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('settings.list', ['settings' => Config::all()]);

//        $settings[] = config('config.snmp.v3.0');
//        Config::set('config.snmp.v3.0.authlevel', 'changed');
//        $settings[] = config()->get('config.snmp.v3.0.authlevel');
//        config()->set('config.snmp.v3.0', ['authlevel' => 'changed2', 'authname' => config('config.snmp.v3.0.authname'), 'authpass' => 'changed2', 'authalgo' => 'changed2', 'cryptopass' => 'changed2', 'cryptoalgo' => 'changed2']);
//        $settings[] = config('config.snmp.v3');
//        $settings[] = Config::get('config.snmp.v3.0.authlevel');

//        $set = new Settings(); // until I get the facade set up
//        $settings[] = Settings::get('email_backend');
//        $settings[] = Settings::get('snmp.v3.0.authlevel');
        $settings[] = Settings::get('alert');
        $settings[] = Settings::get('snmp');
//        $settings[] = $set->get(null);  // same as all, but only gets db settings...
//        $set->set('custom', 'something');
//        $settings[] = $set->get('custom');
//        dd(settings());
//        $settings = $set->all();

        return view('settings.list', ['settings' => $settings]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
