<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class AddGraph extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:graph
                        {filename : The Filename to add}
                        {namespace? : The namespace to use (optional) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new graph template class to help speed up building new graphs';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $filename = $this->argument('filename');
        $contents = File::get(storage_path('stubs/graph.stub'));
        $contents = str_replace('namespace App\Graphs;', "namespace App\Graphs\\".$this->argument('namespace').";", $contents);
        $contents = str_replace('GraphDummy', $this->argument('filename'), $contents);
        $filepath = base_path('app/Graphs/') . str_replace('\\', '/', $this->argument('namespace'));

        if (!file_exists($filepath)) {
            File::makeDirectory($filepath, 0755, true);
        }
        if (file_exists($filepath.'/'.ucfirst($this->argument('filename')).'.php')) {
            if (!$this->confirm("$filename alredy exists in $filepath, do you want to overwrite it?")) {
                $this->error('Exiting...');
                exit;
            }
        }
        File::put($filepath.'/'.ucfirst($this->argument('filename')).'.php', $contents, 'private');

        $this->info("Created file $filename in $filepath");
    }
}
