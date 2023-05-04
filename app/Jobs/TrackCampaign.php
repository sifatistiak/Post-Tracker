<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class TrackCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fetch country data from IP
        $country_code = Cache::remember($this->params['client_ip'], 60 * 24, function () {
            $response = Http::get('https://ipwhois.app/json/' . $this->params['client_ip']);
            $data = $response->json();
            return $data['country_code'] ?? 'NF'; //NF = Not Found
        });

        $key = $this->params['date'] . '_' . $country_code . '_' . $this->params['campaign_id'] . '_' . $this->params['creative_id'] . '_' . $this->params['browser_id'] . '_' . $this->params['device_id'];

        // Save data to Redis
        // connect to redis
        $redis = Redis::connection();

        // fetch existed data
        // check whether same key exists already?
        $response = $redis->get('count:' . $key);
        $response = json_decode($response);

        if (!$response) {
            $redis->set(
                'count:' . $key,
                json_encode([
                    'data' => $key,
                    'count' => 1
                ])
            );
        } else {
            $count = ($response->count ?? 0) + 1;
            $redis->set(
                'count:' . $key,
                json_encode([
                    'data' => $key,
                    'count' => $count
                ])
            );
        }
    }
}
