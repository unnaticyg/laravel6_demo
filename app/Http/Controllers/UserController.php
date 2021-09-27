<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Redirect,Response;
use Event;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display users using datatables
     */
    public function index(Request $request)
    {
        if(request()->ajax()) {
            $data = datatables()->of(User::select('*')->where('role','User'))
            ->addColumn('action', function($data){
                $editRoute = route('users.edit', $data->id);
                $deleteRoute = route('users.destroy', $data->id);
                $button = '<a href="'.$editRoute.'" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success edit-post btn-sm">Edit</i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<a href="javascript:void(0)" class="delete-user delete btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Delete" data-id="'.$data->id.'">Delete</a>';
                return $button;
                })
                ->addColumn('full_name', function ($data) {
                    return $data->first_name.' '.$data->last_name;
                })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
            return $data;
        }
        return view('users.lists');
    }

   

    /**
     * Display create user view page
     */
    public function create()
    {  

        return view('users.create');
    }

    /**
     * Insert the new users
     * @param Request #request
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'role'=>[''],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'gender'=>[''],
            ]);

            $userData = array('first_name' => $request['first_name'],
                            'last_name' => $request['last_name'],
                            'role' => 'User',
                            'email'=> $request['email'],
                            'password' => Hash::make($request['password']),
                            'gender'=> $request['gender']);
        
            $user = User::create($userData);

            //Send mail to registered user
            event(new UserRegistered($user->id));

            return redirect()->route('users')->with('success','User created successfully.');
        }catch(Exceptation $e){
            return redirect()-back()->with('errors','Error in store user');
        }
        
    }

    /**
     * Display edit user view page
     * @param  integer $id
     * @return 
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit',compact('user','id'));
    }

    /**
     * Update the specified resource in storage
     * @param \Illuminate\Http\Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $this->validate($request, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'gender' => [''],
            ]);
            $userData = User::find($id);
            $userData->first_name = $request['first_name'];
            $userData->last_name = $request['last_name'];
            $userData->gender = $request['gender'];
            $userData->email = request('email');
            $userData->save();
            $userData->update($request->all());
      
            return redirect()->route('users')->with('success','User updated successfully');
        }catch(Expectation $e){
            return redirect()->back()->with('error','Error in user updating');
        }
        
    }

    /**
     * Remove the specified user.
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            User::find($id)->delete();
            return redirect()->route('users')->with('success','User deleted successfully');
        }catch(Expectation $e){
            return redirect()->back()->with('error','Error in user delete!!');
        }
    }

    //****************************************************** */
}
