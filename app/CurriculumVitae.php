<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class CurriculumVitae extends Model
{
    protected $table = 'curriculum_vitaes';
    protected $fillable = ['photo', 'name', 'rank', 'ppe_size', 'date_of_birth', 'place_of_birth', 'religion', 'nationality', 'blood_group', 'email', 'home_tel', 'mobile_tel', 'home_address'];

    public function TravelDocument()
    {
        return $this->hasMany(TravelDocument::class);
    }

    public function Experiences()
    {
        return $this->hasMany(Experiences::class);
    }

    public function Certificates()
    {
        return $this->hasMany(Certificates::class, 'curriculum_vitae_id');
    }

    public function Skills()
    {
        return $this->hasMany(Skills::class, 'curriculum_vitae_id');
    }

}