<?php
/**
 * app/Http/Controllers/General/SearchController.php
 *
 * HTTP Controller for searches
 *
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
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2016 Neil Lathwood
 * @author     Neil Lathwood <neil@lathwood.co.uk>
 */

namespace App\Http\Controllers\General;

use App\DataTables\General\ArpDataTable;
use App\DataTables\General\IPv4DataTable;
use App\DataTables\General\IPv6DataTable;
use App\DataTables\General\MacDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|null
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|null
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|null
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Respoonse|null
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|null
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
     * @return \Illuminate\Http\Response|null
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response|null
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function ipv4(IPv4DataTable $dataTable)
    {
        return $dataTable->render('general.search.list');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function ipv6(IPv6DataTable $dataTable)
    {
        return $dataTable->render('general.search.list');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function mac(MacDataTable $dataTable)
    {
        return $dataTable->render('general.search.list');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function arp(ArpDataTable $dataTable)
    {
        return $dataTable->render('general.search.list');
    }
}
