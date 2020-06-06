<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    protected $table = 'certificates';
    protected $fillable = ['curriculum_vitae_id', 'certificate_of_competency_name', 'capacity', 'date_of_issue', 'date_of_expiry', 'created_at', 'updated_at'];

    public function CurriculumVitae()
    {
        return $this->belongsTo(CurriculumVitae::class);
    }
    
    public function ListCertificates()
    {
        return $this->belongsTo(ListCertificates::class, 'certificate_of_competency_name');
    }

}