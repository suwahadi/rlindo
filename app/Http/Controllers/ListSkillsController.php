<?php
namespace App\Http\Controllers;

use App\ListSkills;
use Illuminate\Http\Request;

class ListSkillsController extends Controller
{

    public function index()
    {
        $ListSkills = ListSkills::get();
        return ListSkills::where('status', '=', 1)->paginate(null, ['id', 'skill_training_certificate_name as text']);
    }

}