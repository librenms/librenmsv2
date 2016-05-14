<?php

namespace App\Console\Commands;

use App\Models\DbConfig;
use Config;
use Illuminate\Console\Command;
use Settings;

class MigrateSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'librenms:migrate-settings
    {--force} : Force the migration. WARNING: May lose some of your settings.
    {--dry-run} : Print changes that would be made, but do not commit them.';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import settings from config.php that existed in the database previously into the database.  (The database now overrides config.php)';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Settings::get('settings.migrated')) {
            $this->info(trans('commands.migrate-settings.migrated'));
            if (!$this->option('force')) {
                return;
            }
            $this->warn(trans('commands.migrate-settings.migrated_warning'));
        }

        $settings = DbConfig::pluck('config_name');

        foreach ($settings as $key) {
            $config_key = '_config.'.$key;

            if (Config::has($config_key)) {
                $old = Settings::get($key);
                $new = Config::get($config_key);

                if ($old !== $new) {
                    $this->info(trans('commands.migrate-settings.migrating', ['setting' => $key, 'old' => $old, 'new' => $new]));

                    if (!$this->option('dry-run')) {
                        // we aren't authenticated so we can't write through the Settings facade
                        DbConfig::updateOrCreate(['config_name' => $key], ['config_value' => $new]);
                    }
                }
            }
        }

        if (!$this->option('dry-run')) {
            Settings::flush();  // clear the settings cache
            DbConfig::updateOrCreate(['config_name' => 'settings.migrated'], ['config_value' => true]);
        }
    }
}
