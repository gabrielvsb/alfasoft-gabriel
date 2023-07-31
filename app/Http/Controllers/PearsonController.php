<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Pearson;
use Illuminate\Http\Request;

class PearsonController extends Controller
{
    public function index(){
        try {
            $pearson_list = Pearson::all()->toArray();
            return view('pearson.index', ['persons' => $pearson_list]);
        }catch (\Exception $exception){
            return view('error.index', ['msg' => $exception->getMessage()]);
        }
    }

    public function store(Request $request){
        try {
            $inputs = $request->all();

            Pearson::create(
                array(
                    'name' => $inputs['name'],
                    'email' => $inputs['email']
                )
            );

            return response()->json('Pearson created!');
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

    public function getPearson($id_pearson){
        try {
            $pearson = Pearson::where('id', $id_pearson)->first();
            if(empty($pearson)){
                return response()->json('Not found!', 404);
            }
            return response()->json($pearson);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

    public function getPearsonContacts($id_pearson)
    {
        try {
            $list_contacts = Pearson::find($id_pearson)->contacts;

            if(empty($list_contacts)){
                return response()->json('Not found!', 404);
            }
            return response()->json($list_contacts);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

    public function update(Request $request){
        try {
            $inputs = $request->all();
            $pearson = Pearson::find($inputs['idPearson']);

            if (empty($pearson)){
                return response()->json('Something is wrong!', 404);
            }
            $pearson->name = $inputs['name'];
            $pearson->email = $inputs['email'];
            $pearson->save();

            return response()->json('Pearson updated!');
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

    public function destroy(Request $request){
        try {
            $inputs = $request->all();
            Contact::where('id_pearson', $inputs['idPearson'])->delete();
            Pearson::destroy($inputs['idPearson']);

            return response()->json('Pearson deleted!');
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }
}
