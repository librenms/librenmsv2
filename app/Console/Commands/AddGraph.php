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
    protected $description = 'Generate new graph template';

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
        // dd($this->argument('namespace'));
        $contents = File::get(storage_path('Stubs/Data.stub'));
        $contents = str_replace('GraphDummy', $this->argument('filename'), $contents);
        $contents = str_replace('namespace App\Graphs;', "namespace App\Graphs\\".$this->argument('namespace').";", $contents);
        dd($contents);
        return $stub;
    }
}
