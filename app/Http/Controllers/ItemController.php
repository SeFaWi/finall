<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
use JWTAuth;
use App\user;
use Tymon\JWTAuth\Exceptions\JWTException;



class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $item = Item::query()->with('user')->where('Status', 'LIKE', '%' . 1 . '%');

        if ($request->has('categorie_id')) {

            $item = $item->where('categorie_id', 'LIKE', "%$request->categorie_id%");
        }
        if ($request->has('city_id')) {

            $item = $item->with('cities')->where('city_id', 'LIKE', "%$request->city_id%");
        }
        if ($request->has('delivery')) {

            $item = $item->where('delivery', 'LIKE', "%$request->delivery%");
        }

        return $item->paginate(10);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      JWTAuth::user()->items()->create($request->all());


       //  $post = new Item();
        //$post->name=$request->name;
         //$post->description=$request->description;
         //$post->user_id=$request->user_id;
         //$post->categorie_id=$request->categorie_id;
         //$post->city_id=$request->city_id;
         //$post->address=$request->address;
         //$post->save();
         return "Item created";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Item::where('id' ,$id)->with('cities','user','categorie');

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user with id ' . $id . ' cannot be found'
            ], 400);
        }

        return $user->paginate(10);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Item::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $product->fill($request->all())
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
    public function change_availability(Request $request, $id)
    {


        $product = Item::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Item with id ' . $id . ' cannot be found'
            ], 400);
        }

        if($request->available!=$product->available) {
            $product->available = $request->available;
            $updated = $product;
            $updated->save();
        }
        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Availability could not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $item = Item::Find($id);
        $item->delete();

        if ($item) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Availability could not be updated'
            ], 500);
        }
    }
}
