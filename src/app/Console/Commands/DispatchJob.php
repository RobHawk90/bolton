<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DispatchJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:job {job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch a job from App\\Jobs, given a ClassName';

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
        $jobClass = "\\App\\Jobs\\{$this->argument('job')}";
        dispatch(new $jobClass());
    }
}
