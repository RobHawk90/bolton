<?php

namespace App;

use Bolton\Entity\Nfe as EntityNfe;
use Bolton\Repository\NfeRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nfe extends Model implements NfeRepository
{
    protected $table = 'nfe_imports';

    public function findByAccessKey($accessKey): ?EntityNfe
    {
        $row = $this->where('access_key', $accessKey)->first();

        if (empty($row)) {
            return null;
        }

        return new EntityNfe(
            $row->access_key,
            $row->total_value
        );
    }

    public function clear(): void
    {
        $this->truncate();
    }

    public function saveAll(Array $nfeBatch): void
    {
        $batch = collect($nfeBatch)->map(function (EntityNfe $nfe) {
            return [
                'access_key' => $nfe->getAccessKey(),
                'total_value' => $nfe->getTotalValue(),
            ];
        });

        if ($batch->isEmpty()) {
            return;
        }

        $this->insert($batch->toArray());
    }

    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    public function commit(): void
    {
        DB::commit();
    }

    public function rollBack(): void
    {
        DB::rollBack();
    }
}
