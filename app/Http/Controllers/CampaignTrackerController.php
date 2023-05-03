<?php

namespace App\Http\Controllers;

use App\Jobs\TrackCampaign;
use Illuminate\Http\Request;

class CampaignTrackerController extends Controller
{
    public function index(Request $request)
    {
        $params = [
            'date' => $request->query('date'),
            'country_code' => $request->query('country_code'),
            'campaign_id' => $request->query('cid'),
            'creative_id' => $request->query('crid'),
            'browser_id' => $request->query('bid'),
            'device_id' => $request->query('did'),
            'count' => $request->query('count'),
        ];
        dispatch(new TrackCampaign($params));
    }
}
