<?php

namespace App\Console\Commands;

use App\Models\CampaignTracker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class AggregateCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aggregate:campaign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregate campaign tracking / count data from Redis to MySql';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $error = 0;
        $redis = Redis::connection();
        $keys = $redis->keys('count:*');

        if (count($keys) === 0) {
            $this->warn('No new entry found');
            exit;
        }
        //using progress bar
        $bar = $this->output->createProgressBar(count($keys));
        $bar->start();

        foreach ($keys as $key) {
            $response = $redis->get($key);
            $response = json_decode($response);

            if ($response) {
                $data = explode('_', $response->data);
                // $dataToBeInserted
                try {
                    CampaignTracker::create([
                        'date' => $data[0],
                        'country_code' => $data[1],
                        'campaign_id' => $data[2],
                        'creative_id' => $data[3],
                        'browser_id' => $data[4],
                        'device_id' => $data[5],
                        'count' => $response->count,
                    ]);
                } catch (\Throwable $th) {
                    $error++;
                } finally {
                    $bar->advance();
                    //deleting the key
                    $redis->del($key);
                }
            }
        }
        $bar->finish();
        $this->newLine();
        if ($error > 0) $this->error('Occurred ' . $error . ' Entry Problem');
        $this->line('Redis Cleared');
    }
}
