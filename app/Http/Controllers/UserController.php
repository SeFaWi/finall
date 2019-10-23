<?php

namespace App\Http\Controllers;
use App\Item;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()

    {
        //$this->middleware('auth');
    }
    public function index(Request $request)
    {
            if ($request->has('first_name')) {
                $user = user::query()->where('first_name', 'LIKE', "%$request->first_name%");
              return $user-> paginate(8);
            }
        $bla = user::query()->get(['id', 'first_name', 'gender', 'image']);

            return $bla;

    }
    public function changeUC(Request $request,$id)
    {
            $user = user::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Item with id ' . $id . ' cannot be found'
            ], 400);
        }

            if($user->is_a_company!=$request->is_a_company)
                $user->is_a_company = $request->is_a_company;
            $user->save();

        if ($user) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user could not be change status'
            ], 500);
        }
    }

    public function change_status_U($id){

        $user = user::find($id);
        if($user->Status = 0){
            $user->Status = 1;
        }else{$user->Status= 0;}
        $user->save();
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
      //  user::create($request->all());
     //   return "done";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByid($id)
    {
        /**
         if( user::where('id' ,'=',$id)->get());
        return "Error false";
         return " Notfound";
*/
      // $user = User::find($id)->with('citie')->with('items')->where('Status', 'LIKE', '%' . 1 . '%');
        $user = user::where('id' ,$id)->with('citie','items');

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user with id ' . $id . ' cannot be found'
            ], 400);
        }

        return $user->paginate(10);
    }
    public function showByname(Request $name)
    {
        /**
         if( user::where('id' ,'=',$id)->get());
        return "Error false";
         return " Notfound";
      // $user = User::find($id)->with('citie')->with('items')->where('Status', 'LIKE', '%' . 1 . '%');*/
        $user = user::where('Status', 'LIKE', '%' . 1 . '%')->where('first_name','like', '%'. $name->first_name .'%');

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user with id ' . $name . ' cannot be found'
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


        public function update(Request $request,$id)
        {
            $user = user::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, user with id ' . $id . ' cannot be found'
                ], 400);
            }

            $updated = $user->fill($request->all())
                ->save();

            if ($updated) {
                return response()->json([
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, user could not be updated'
                ], 500);
            }
        }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
