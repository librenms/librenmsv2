<?php
/**
 * UpdateUserRequest.php
 *
 * Authorize and validate requests to update users.
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

namespace App\Http\Requests;

use App\Models\User;
use Auth;

class UpdateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->isAdmin()) {
            return true;
        }
        if (Auth::id() == $this->input('user_id')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->input('update') == 'password') {
            $user_id = $this->input('user_id');
            $rules = ['password'              => 'required|min:6|max:255',
                      'password_confirmation' => 'required|same:password',
            ];
            if (!Auth::user()->isAdmin() || Auth::id() == $user_id) {
                $rules['current_password'] = 'required|password:'.$user_id;
            }
            return $rules;
        }
        else {
            $user = User::find($this->input('user_id'));
            return ['username'    => 'required|max:20|unique:users,username,'.$user->username.',username',
                    'email'       => 'required|email|max:60|unique:users,email,'.$user->username.',username',
                    'realname'    => 'max:60',
                    'description' => 'min:3|max:1024',
            ];
        }
    }
}
