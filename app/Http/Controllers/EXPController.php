<?php
namespace App\Http\Controllers;

use App\Experiences;
use Illuminate\Http\Request;

class EXPController extends Controller
{

    public function index()
    {
        $Experiences = Experiences::get();

        return response()->json([
            'status' => 'success',
            'data' => $Experiences
        ], 200);
    }


	public function show(Request $request)
	{
	    $q = $request->get('q');

	    return Experiences::where('standby_status', 'like', "%$q%")->paginate(null, ['id', 'standby_status as text']);
	}


}