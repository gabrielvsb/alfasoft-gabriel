<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request){
        try {
            $inputs = $request->all();

            Contact::create(
                array(
                    'country_code' => $inputs['countryCode'],
                    'number' => $inputs['number'],
                    'id_pearson' => $inputs['idPearson']
                )
            );

            return response()->json('Contact created!');
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }
}
