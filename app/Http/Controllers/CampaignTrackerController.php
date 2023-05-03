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
            'country_code' => $request->query('country_code') ?? 'bd',
            'campaign_id' => $request->query('cid'),
            'creative_id' => $request->query('crid'),
            'browser_id' => $request->query('bid'),
            'device_id' => $request->query('did'),
            'count' => $request->query('count'),
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
