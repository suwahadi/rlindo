<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ListSkills extends Model
{
    protected $table = 'list_skills';
    protected $fillable = ['skill_training_certificate_name', 'status', 'created_at', 'updated_at'];
    
    public function Skills()
    {
        return $this->hasMany(Skills::class, 'id');
    }

}