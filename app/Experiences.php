<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Experiences extends Model
{
    protected $table = 'experiences';
    protected $fillable = ['curriculum_vitae_id', 'name_of_vessel', 'rank', 'vessel_type', 'grt_hp', 'company', 'principle_name', 'salary', 'onboard_period_from', 'onboard_period_to', 'standby_status'];

    public function CurriculumVitae()
    {
        return $this->belongsTo(CurriculumVitae::class);
    }

    // protected $casts = [
    //     'extra' => 'json',
    // ];
    
}