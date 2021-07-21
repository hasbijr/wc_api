<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;

    protected $table = "campaigns";

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
        'tanggal_mulai' => "datetime:d-m-Y",
        'tanggal_selesai' => "datetime:d-m-Y",
    ];

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
            'nama' => 'required',
            'tanggal_mulai' => 'required|date_format:Y-m-d',
            'tanggal_selesai' => 'date_format:Y-m-d',
            'deskripsi' => 'required',
            'is_publish' => 'required|boolean',
        ];
    }

    protected $appends = ['sum_total_outcome', 'sum_total_income'];

    public function campaignPhoto()
    {
        return $this->hasOne(CampaignPhoto::class);
    }

    public function campaignQrCode()
    {
        return $this->hasOne(CampaignQrCode::class);
    }

    public function campaignAgents()
    {
        return $this->hasMany(CampaignAgent::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function outcomes()
    {
        return $this->hasMany(Outcome::class);
    }

    public function rekapIncome()
    {
        return $this->hasMany(VRekapitulasiPendanaan::class, 'campaign_id', 'id')->where('type', 'income');
    }

    public function rekapOutcome()
    {
        return $this->hasMany(VRekapitulasiPendanaan::class, 'campaign_id', 'id')->where('type', 'outcome');
    }

    public function getSumTotalOutcomeAttribute()
    {
        return $this->rekapOutcome()->sum('nominal');
    }

    public function getSumTotalIncomeAttribute()
    {
        return $this->rekapIncome()->sum('nominal');
    }
}
