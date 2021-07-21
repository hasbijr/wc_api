<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutcomeDistributionPointEvidence extends Model
{
    use SoftDeletes;

    protected $table = "outcome_distribution_point_evidences";

    // protected $fillable = [];

    // public $timestamps = false;

    protected $appends = ['url'];

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    public function getUrlAttribute()
    {
        return url('/outcome-evidence/' . $this->id);
    }
}
