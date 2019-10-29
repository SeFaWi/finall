<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\image;
use App\Item;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Storage;
use App\user;

use Tymon\JWTAuth\Exceptions\JWTException;



class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()

    {
      //  $this->middleware('auth');
    }
    public function index(Request $request)
    {

        $item = Item::query()->with('user','imageFrist')->where('Status', 'LIKE', '%' . 1 . '%');
        if ($request->has('categorie_id')) {

            $item = $item->where('categorie_id', 'LIKE', "%$request->categorie_id%");
        }
        if ($request->has('city_id')) {

            $item = $item->with('cities')->where('city_id', 'LIKE', "%$request->city_id%");
        }
        if ($request->has('delivery')) {

            $item = $item->where('delivery', 'LIKE', "%$request->delivery%");
        }
        if ($request->has('itemname')) {

            $item = $item->where('name', 'LIKE', "%$request->itemname%");
        }
        return $item->paginate(9);
    }

    public function AllItemAdmin(Request $request){
        $item = Item::query()->with(array('user'=>function($query){
            $query->select('id','email');
        }));
        if($request->has('categorie_id'))
            $item = $item->where('categorie_id', 'LIKE', '%' . $request->categorie_id . '%');

        return $item->paginate(9);
    }
    public function change_statusI($id){


            $bla = Item::find($id);
                switch ($bla->Status) {
                    case "1" :
                        $bla->Status = 0;
                        $bla->save();
                        return response()->json([
                            'success' => true,
                        ]);;
                    case "0" :
                        $bla->Status = 1;
                        $bla->save();
                        return response()->json([
                            'success' => true,
                        ], 200);
                }

            return " auth error";

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
      //JWTAuth::user()->items()->create($request->all());
        $user = Auth::user();
        $description = $request->description;
        $name = $request->name;
        $address = $request->address;
        $categorie_id = $request->categorie_id;
        $city_id = $request->city_id;
        $delivery = $request->delivery;
        $iamges = array($request->images);

        $item = Item::create([
            'name' => $name,
            'description' => $description,
            'address' => $address,
            'categorie_id' => $categorie_id,
            'city_id' => $city_id,
            'delivery' => $delivery,
            'user_id' => $user->id,
        ]);
        foreach($iamges as $iamge){

            $iamgePath = Storage::disk('storage')->put('images', $iamge);
            image::create([
                'item_id' =>$item->id,
                'path' =>Storage::url($iamgePath)

            ]);
        }
        return response()->json(['error'=> false,'data' =>$item]);

       //  $post = new Item();
        //$post->name=$request->name;
         //$post->description=$request->description;
         //$post->user_id=$request->user_id;
         //$post->categorie_id=$request->categorie_id;
         //$post->city_id=$request->city_id;
         //$post->address=$request->address;
         //$post->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Item::where('id' ,$id)->with('cities','user','categorie','images')->get();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user with id ' . $id . ' cannot be found'
            ], 400);
        }
        return  $user;

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
        $item = Item::find($id);
        $userId = Auth::id();
        if($item->user_id == $userId) {
            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, item with id ' . $id . ' cannot be found'
                ], 400);
            }

            $updated = $item->fill($request->all())
                ->save();

            if ($updated) {
                return response()->json([
                    'success' => true
                ]);
            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Item could not be updated'
            ], 500);
        }

    }
    public function change_availability($id)
    {

        $bla = Item::find($id);
        $userId = Auth::id();
        if($bla->user_id == $userId) {
    switch ($bla->available) {
        case "1" :
            $bla->available = 0;
            $bla->save();
            return response()->json([
                'success' => true,
            ]);;
        case "0" :
            $bla->available = 1;
            $bla->save();
            return response()->json([
                'success' => true,
            ], 200);
    }
}
return " auth error";


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
        $userId = Auth::id();
        if($item->user_id == $userId) {
        $item->delete();

        if ($item) {
            return response()->json([
                'success' => true
            ]);
        }
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, you cant delete or not find '
            ], 300);
        }

    }
    public function deleteAdmin($id)
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
                'message' => 'Sorry, item could not be delete'
            ], 500);
          }

    }
}
