<?php



namespace App\Http\Controllers\backend;



use Request;

use App\Models\User;

use Auth;

use Carbon\Carbon;

use Session;

use Mail;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;



class UserController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {



      $user = User::where('role','=','customer')->get();



      return view('backend.users.index',compact('user'));

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {



      return view('backend.users.create');

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

      $input = Request::all();



      

      $validation = Validator::make($input,

       [

       'name' => 'required',

       'email' => 'required',

       ]);

      if( $validation->fails() ) {

       return redirect('admin/users/create')->withErrors($validation->errors());

     }

     else

     {



       // $imageFiles = Input::file('image');



       // if(isset($imageFiles))

       // {

       //   $name=str_random(6).'_'.$imageFiles->getClientOriginalName();

       //   $imageFiles->move(public_path().'/backend/images/blog/',$name);  

       //   $imagedata = $name;  



       // }

       $dataArray = array(

        "name"     =>   $input['name'],

        "email"   =>      $input['email'],

        "role"   =>     'customer',

        'password' => Hash::make('12345678'),

        // "image"   =>      $imagedata

        );





       User::create($dataArray);

       Session::flash('success','Insert record successfully.');

       return redirect('admin/users');

     }

   }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {



     $users = User::findOrFail($id);

     return view('backend.users.show',compact('users'));

   }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

      $users = User::findOrFail($id);

      return view('backend.users.edit',compact('users'));

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

     $user = User::findOrFail($id);

     $input = Request::all();



     $validation = Validator::make($input,

       [

       'name' => 'required',

       'email' => 'required',

       ]);



     if( $validation->fails() ) {

       return redirect('/admin/users/'.$id.'/edit')->withErrors($validation->errors());

     }

     else

     {



       $user->name =$input['name'];

       $user->email=$input['email'];

      // $blog->image=$imagedata;

       $user->updated_at=Carbon::now();

       $user->save();



       Session::flash('success','Update record successfully.');

       return redirect('admin/users');

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

      $user = User::findOrFail($id);

      $user->delete();

      Session::flash('success','Successfully deleted.');

      return redirect('admin/users');

    }


}

