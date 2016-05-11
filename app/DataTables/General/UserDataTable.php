<?php
/**
 * UsersDataTable.php
 *
 * Provide layout and data for the Users DataTable
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
 * @copyright  2016 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\DataTables\General;

use App\DataTables\BaseDataTable;
use App\Models\User;

class UserDataTable extends BaseDataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('level', function($user) {
                return trans('user.level.'.$user->level);
            })
            ->editColumn('actions', function($user) {
                $edit = '<a type="button" class="btn btn-xs btn-primary" href="'.
                    route('users.edit', ['user_id' => $user->user_id]).
                    '"><i class="fa fa-edit fa-lg fa-fw"></i><span class="hidden-xs"> '.trans('button.edit').'</span></a> ';

                $delete = '<button type="button" class="btn btn-xs btn-danger userDeleteModal" data-toggle="modal" data-target="#deleteModal" data-href="'.
                    route('users.destroy', ['user_id' => $user->user_id]).
                    '"><i class="fa fa-trash fa-lg fa-fw"></i><span class="hidden-xs"> '.trans('button.delete').'</span></button> ';

                return $edit.$delete;
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $users = User::select('users.*');
        return $this->applyScopes($users);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            'username' => [
                'title' => trans('user.text.username'),
            ],
            'realname' => [
                'title' => trans('user.text.realname'),
            ],
            'level'    => [
                'title' => trans('user.text.level'),
            ],
            'actions'  => [
                'title' => trans('user.text.actions'),
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'users';
    }
}
