<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ListCertificates extends Model
{
    protected $table = 'list_certificates';
    protected $fillable = ['certificate_of_competency_name', 'status', 'created_at', 'updated_at'];

    public function Certificates()
    {
        return $this->hasMany(Certificates::class, 'id');
    }
    
}