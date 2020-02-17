<?php

namespace App\Jobs;

use App\Nfe;
use Bolton\Domain\NfeImporter;
use Bolton\Rest\Api\ArquiveiApi;
use Bolton\XmlParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportNfe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $nfeImporter = new NfeImporter(
                new Nfe(),
                new ArquiveiApi(),
                new XmlParser()
            );
            $nfeImporter->importAll();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
