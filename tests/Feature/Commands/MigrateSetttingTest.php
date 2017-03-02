<?php
/**
 * MigrateSetttingTest.php
 *
 * Tests the migrate-settings command
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
namespace Tests\Feature\Commands;

use App\Models\User;
use Artisan;
use Auth;
use Config;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Settings;
use Tests\TestCase;

class MigrateSettingsTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $user = factory(User::class)->create(['level' => 10]);
        Auth::login($user);
    }

    public function testDryRun()
    {
        Config::set('_config.setting', 'config');
        Settings::set('setting', 'settings');

        Artisan::call('librenms:migrate-settings', ['--dry-run' => true]);

        $this->assertEquals("Migrating setting: 'setting' from 'settings' to 'config'\n--dry-run enabled: No changes were made.\n", Artisan::output());
    }

    public function testMigration()
    {
        Config::set('_config.setting', 'setting-config');
        Config::set('_config.anothersetting', 'anothersetting-config');
        Config::set('_config.configonly', 'configonly-config');
        Settings::set('setting', 'setting-settings');
        Settings::set('anothersetting', 'anothersetting-settings');
        Settings::set('settingsonly', 'settingsonly-settings');

        Artisan::call('librenms:migrate-settings');

        $expected = "Migrating setting: 'anothersetting' from 'anothersetting-settings' to 'anothersetting-config'\nMigrating setting: 'setting' from 'setting-settings' to 'setting-config'\n";

        $this->assertEquals($expected, Artisan::output());
        
        $this->assertEquals('setting-config', Settings::get('setting'));
        $this->assertEquals('anothersetting-config', Settings::get('anothersetting'));
        $this->assertEquals('settingsonly-settings', Settings::get('settingsonly'));
        $this->assertNull(Settings::get('configonly'));
    }

    public function testNonExistant()
    {
        Config::set('config.setting', 'config');
        Artisan::call('librenms:migrate-settings');
        $output = Artisan::output();
        $this->assertEmpty($output, 'Command output: '.rtrim($output));
    }

    public function testAlreadyMigrated()
    {
        Artisan::call('librenms:migrate-settings');
        $this->assertTrue(Settings::get('settings.migrated'));

        Artisan::call('librenms:migrate-settings');
        $this->assertEquals("Settings already migrated.\n", Artisan::output());
    }

    public function testForceMigration()
    {
        Artisan::call('librenms:migrate-settings');
        Artisan::call('librenms:migrate-settings', ['--force' => true]);
        $this->assertEquals("Settings already migrated.\nMigrating settings from config.php anyway.\n", Artisan::output());
    }
}
