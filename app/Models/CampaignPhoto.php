<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignPhoto extends Model
{
    use SoftDeletes;

    protected $table = "campaign_photos";

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    protected $appends = ['url'];

    // protected $fillable = [];

    // public $timestamps = false;

    public function getUrlAttribute()
    {
        return url('/campaign/' . $this->campaign_id . '/photo/' . $this->id);
    }
}
