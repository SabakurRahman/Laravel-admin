<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class QueryExecutedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if (env('QUERY_LOG_ENABLE')){
            Log::channel('sql_query')->info(
                'SQL Query',
                [
                    'query'    => $event->sql,
                    'bindings' => $event->bindings,
                    'time'     => $event->time,
                ]
            );
        }
    }
}
