<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignQrCode extends Model
{
    use SoftDeletes;

    protected $table = "campaign_qr_codes";

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    protected $appends = ['url'];

    // protected $fillable = [];

    // public $timestamps = false;

    /**
     * Get model validation rules.
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return [
            'campaign_qr_codes.nama_linkaja' => 'required',
        ];
    }

    public function getUrlAttribute()
    {
        return url('/campaign/' . $this->campaign_id . '/qr-code/' . $this->id);
    }
}
