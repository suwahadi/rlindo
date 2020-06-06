<?php
namespace App\Http\Controllers;

use App\ListCertificates;
use Illuminate\Http\Request;

class ListCertificatesController extends Controller
{

    public function index()
    {
        $ListCertificates = ListCertificates::get();
        return ListCertificates::where('status', '=', 1)->paginate(null, ['id', 'certificate_of_competency_name as text']);
    }

	public function show(Request $request)
	{
	    $q = $request->get('q');
	    return ListCertificates::where('certificate_of_competency_name', 'like', "%$q%")->paginate(null, ['id', 'certificate_of_competency_name as text']);
	}

}