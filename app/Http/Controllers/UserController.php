<?php

namespace App\Http\Controllers;
use App\Item;
use App\user;
use Storage;

use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    use UploadTrait;
    public function __construct()

    {
        //$this->middleware('auth');
    }
    public function  adduseradmin($id)
    {
        $admin = user::find($id);
        $admin->assignRole(['super_admin']);
        return 'done';

if(Auth::user()->hasRole('super_admin'))
        {return "from admin";}
        return "hoel shit";
            // assign all permissions to admin role}
    }
    public function index(Request $request)
    {
       // $roles = Role::all();
        //$users = User::whereHas("roles", function($q){ $q->where("name", "super_admin"); });
//        return User::with('roles.name')->get();
        if(Auth::user()->hasRole('super_admin')) {

            if ($request->has('first_name')) {
                $user = user::query()->where('first_name', 'LIKE', "%$request->first_name%");
                return $user->paginate(8);
            }

            $bla = user::query()->with('citie:id,name')->get(['id', 'first_name','last_name','email','phone','cities_id', 'Status','created_at']);
            return $bla;

        }elseif ((Auth::user()->hasRole('city_admin'))){
             $cityID =auth::user()->cities_id;
             $adminID=auth::user()->id;
             return User::query()->where('cities_id','LIKE',"$cityID")->where('id','!=',"$adminID")->get();
        }
        return "dont have access";
    }
    public function  getcompany(){
        $user  = User::query()->with('citie')->where('Status', 'LIKE', '%' . 1 . '%')->where('is_a_company', 'LIKE', '%' . 1 . '%');
        return $user->paginate(8);
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

    public function change_status_U($id)
    {

        $user = User::find($id);
        switch ($user->Status) {
            case "1" :
                $user->Status = 0;
                $user->save();
                return response()->json([
                    'success' => true,
                ]);;
            case "0" :
                $user->Status = 1;
                $user->save();
                return response()->json([
                    'success' => true,
                ], 200);
        }
    }

    public function editprofile(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Get current user
        $user = user::findOrFail(auth()->user()->id);

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->gender = $request->input('gender');
        $user->cities_id = $request->input('cities_id');
        $user->phone = $request->input('phone');

        // Check if a profile image has been uploaded
        if ($request->has('image')) {
            // Get image file
            $image = $request->image;
            $iamgePath = Storage::disk('storage')->put('images', $image);
            $user->image  =Storage::url($iamgePath);


            // Make a image name based on user name and current timestamp
            // Define folder path
            // Make a file path where image will be stored [ folder path + file name + file extension]
            // Set user profile image path in database to filePath
        }
        $user->save();

    }

    public function store(Request $request)
    {
      //  user::create($request->all());
     //   return "done";
    }


    public function showByid($id)
    {

      // $user = User::find($id)->with('citie')->with('items')->where('Status', 'LIKE', '%' . 1 . '%');
        $user = user::where('id',$id)->with('citie','items');
         $num = Item::where('user_id',$id)->count();


        return $user->paginate(8);

    }
    public function showByname(Request $name)
    {

        $user = user::where('Status', 'LIKE', '%' . 1 . '%')->where('first_name','like', '%'. $name->first_name .'%');

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user with id ' . $name . ' cannot be found'
            ], 400);
        }

        return $user->paginate(10);
    }



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

    public function destroy($id)
    {
        //
    }

}
