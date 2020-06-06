<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    protected $table = 'skills';
    protected $fillable = ['curriculum_vitae_id', 'skill_training_certificate_name', 'date_of_issue', 'date_of_expiry', 'created_at', 'updated_at'];

    public function CurriculumVitae()
    {
        return $this->belongsTo(CurriculumVitae::class);
    }

    public function ListSkills()
    {
        return $this->belongsTo(ListSkills::class, 'skill_training_certificate_name');
    }
    
}