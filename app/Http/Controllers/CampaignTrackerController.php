<?php

namespace App\Http\Controllers;

use App\Jobs\TrackCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CampaignTrackerController extends Controller
{
    public function index(Request $request)
    {
        $params = [
            'date' => date('Y-m-d'),
            'campaign_id' => $request->query('cid'),
            'creative_id' => $request->query('crid'),
            'browser_id' => $request->query('bid'),
            'device_id' => $request->query('did'),
            'client_ip' => $request->query('cip'),
        ];

        try {
            dispatch(new TrackCampaign($params));
        } catch (\Throwable $th) {
            Log::alert($th);
        } finally {
            $imageLink = 'https://picsum.photos/1';
            return $imageLink;
        }
    }
}
