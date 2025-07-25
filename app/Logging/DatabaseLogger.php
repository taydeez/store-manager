<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\DB;

class DatabaseLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger('mysql');
        $logger->pushHandler(new class extends AbstractProcessingHandler {
            protected function write($record): void
            {
                DB::table('logs')->insert([
                    'level' => $record['level_name'],
                    'message' => $record['message'],
                    'context' => json_encode($record['context']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return $logger;
    }
}
