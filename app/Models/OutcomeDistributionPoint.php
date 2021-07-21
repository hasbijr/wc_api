<?php

namespace App\Models;

use App\CustomHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutcomeDistributionPoint extends Model
{
    use SoftDeletes;

    protected $table = "outcome_distribution_points";

    // protected $fillable = [];

    // public $timestamps = false;

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    protected $appends = ['tanggal_tgl_id', 'url_evidence'];

    public function getTanggalTglIdAttribute()
    {
        return CustomHelpers::dateId($this->tanggal);
    }

    public function getUrlEvidenceAttribute()
    {
        return url('/distribution-point-evidence/' . $this->id);
    }

    public function outcomeDistribution()
    {
        return $this->belongsTo(OutcomeDistribution::class);
    }

    public function outcomeDistributionPointEvidences()
    {
        return $this->hasMany(OutcomeDistributionPointEvidence::class);
    }
}
