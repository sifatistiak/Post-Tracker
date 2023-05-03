<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignTracker extends Model
{
    protected $table = 'campaign_tracking';

    protected $fillable = ['date', 'country_code', 'campaign_id','creative_id', 'browser_id', 'device_id', 'count'];

    public $timestamps = false;


    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'count' => 0,
    ];
}
