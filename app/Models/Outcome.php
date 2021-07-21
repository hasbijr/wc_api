<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outcome extends Model
{
    use SoftDeletes;

    protected $table = "outcomes";

    // protected $fillable = [];

    // public $timestamps = false;

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
        'deleted_at' => "datetime:Y-m-d H:i:s",
    ];

    protected $appends = ['sum_nominal'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function outcomeDistribution()
    {
        return $this->hasMany(OutcomeDistribution::class);
    }

    public function getSumNominalAttribute()
    {
        return $this->OutcomeDistribution()->sum('nominal');
    }
}
