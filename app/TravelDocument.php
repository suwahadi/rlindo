<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class TravelDocument extends Model
{
	protected $table = 'travel_documents';
	protected $fillable = ['curriculum_vitae_id', 'document_type', 'document_no', 'document_date_of_issue', 'document_date_of_expiry', 'document_place_of_issue', 'document_file'];

    public function CurriculumVitae()
    {
        return $this->belongsTo(CurriculumVitae::class);
    }

}