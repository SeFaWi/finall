<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

class CategorieController extends Controller
{

    public function index(Request $request)
    {

        if ($request->has('without_image') ) {
            return  Categories::all("id","name");
        } elseif ($request->has('first'))
        {
                    return Categories::all('id','name')->whereBetween('id',[1 , $request->first]);
        }
        else {
            $cate = Categories::query();
            return $cate->paginate(8);
        }
    }


    public function store(Request $request)
    {
        $cate = Categories::create($request->all());
        if ($cate) {
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


    public function show($id)
    {
        return Categories::findOrFail()($id);
    }


    public function update(Request $request, $id)
    {
        $cate = Categories::findOrFail($id);

        if (!$cate) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $cate->fill($request->all())
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
        $cate = Categories::find($id);
        $cate->delete();
        if ($cate) {
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
