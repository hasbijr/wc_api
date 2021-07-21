<?php

namespace App\Models;

use App\CustomHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutcomeDistribution extends Model
{
    use SoftDeletes;

    protected $table = "outcome_distributions";

    // protected $fillable = [];

    // public $timestamps = false;

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    protected $appends = ['sisa_distribution_point', 'sum_distribution_point', 'created_at_tgl_id'];

    public function campaignAgent()
    {
        return $this->belongsTo(CampaignAgent::class, 'campaign_agent_id', 'id');
    }

    public function outcome()
    {
        return $this->belongsTo(Outcome::class);
    }

    public function outcomeDistributionPoints()
    {
        return $this->hasMany(OutcomeDistributionPoint::class);
    }

    public function getSisaDistributionPointAttribute()
    {
        $jml_dist = $this->outcomeDistributionPoints()->sum('jumlah_dana');
        return ($this->nominal - $jml_dist);
    }

    public function getSumDistributionPointAttribute()
    {
        return (int) $this->outcomeDistributionPoints()->sum('jumlah_dana');
    }

    public function getcreatedAtTglIdAttribute()
    {
        return CustomHelpers::dateId($this->created_at);
    }
}
