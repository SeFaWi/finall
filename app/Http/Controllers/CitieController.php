<?php

namespace App\Http\Controllers;

use App\Cities;
use Illuminate\Http\Request;

class CitieController extends Controller
{

    public function index(Request $request)
    {
        if($request->has('id')) {

            !$citie = Cities::find($request->id);
            if (!$citie) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, citie with id ' . $request->id . ' cannot be found'
                ], 400);
            }
        }
        if($request->has('id'))
         return Cities::find($request->id)->all('id','name');

        return Cities::all('id','name');
    }



    public function store(Request $request)
    {
        $citie = Cities::create($request->all());
        if ($citie) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Item could not be updated'
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $citie = Cities::findOrFail($id);

        if (!$citie) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $citie->fill($request->all())
            ->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Item could not be updated'
            ], 500);
        }

    }


    public function delete($id)
    {
        $citie = Cities::find($id);
        $citie->delete();
        if ($citie) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Item could not be updated'
            ], 500);
        }


    }
}
