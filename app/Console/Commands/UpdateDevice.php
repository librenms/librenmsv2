<?php
/**
 * UpdateDevice.php
 *
 * Little command for tweaking database for ui testing
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
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Console\Commands;

use App\Events\ListDevices;
use App\Models\Device;
use Illuminate\Console\Command;

class UpdateDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:update {--id=} {--status=} {--uptime=} {--pop} {--push} {--delete=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a device to up (1) or down (0)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $delete = $this->option('delete');
        if ($this->option('pop') || $delete) {
            if ($delete) {
                $device = Device::find($delete);
            } else {
                $device = Device::orderBy('device_id', 'desc')->first();
            }

            $device->delete();
            return;
        }

        // Fire off an event, just randomly grabbing the first user for now
        $id = $this->option('id');

        if ($id == 'all') {
            $this->info('all');
            $devices = Device::all();
        } elseif ($this->option('push')) {
            $this->info('push');
            $devices = [new Device(['hostname' => 'Mockery'])];
        } elseif ($id === null) {
            $this->info('first');
            $devices = [Device::first()];
        } else {
            $this->info('findOrNew');
            $devices = [Device::findOrNew($id)];
        }

        /** @var Device $device */
        foreach ($devices as $device) {
            if ($this->option('status') !== null) {
                $device->status = $this->option('status');
            }

            if ($this->option('uptime') !== null) {
                $device->uptime = $this->option('uptime');
            }

            $device->save();

            if (empty($device->hostname) || $device->hostname == 'Mockery') {
                $device->hostname = 'Mockery'.$device->device_id;
                $device->save();
            }
        }
    }
}
