<?php
namespace App\Http\Controllers;

use App\CurriculumVitae;
use Illuminate\Http\Request;

class CVController extends Controller
{

    public function index()
    {
        $CurriculumVitae = CurriculumVitae::get();

        return response()->json([
            'status' => 'success',
            'data' => $CurriculumVitae
        ], 200);
    }


	public function show(Request $request)
	{
	    $q = $request->get('q');

	    return CurriculumVitae::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
	}


}