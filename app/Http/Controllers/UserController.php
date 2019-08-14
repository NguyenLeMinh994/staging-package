<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Supplier;
use App\SupplierType;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::leftJoin('supplier', function ($join1) {
                        $join1->on('users.supplier_id', '=', 'supplier.supplier_id');
                    })->leftJoin('supplier_types', function ($join2) {
                        $join2->on('supplier.st_id', '=', 'supplier_types.st_id');
                    })
                    ->select(
                        'users.*',
                        'supplier.supplier_name',
                        'supplier_types.st_name'
                    )
                    ->where('users.user_status', '!=', 'deleted')
                    ->get();
        return view('user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplierType = SupplierType::where('st_status','!=','deleted')->get();
        return view('user.create', compact('supplierType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'           => 'required',
            'user_username'         => 'required',
            'user_firstname'        => 'required',
            'user_lastname'         => 'required',
            'user_phone'            => 'required',
            'user_email'            => 'required|unique:users,email',
            'user_password'         => 'required|regex:/^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,30}$/',
            'user_password_retype'  => 'required|same:user_password',
            'user_type'             => 'required',
            'user_status'           => 'required',
        ]);


        $users = new User([
            'supplier_id' => $request->get('supplier_id'),
            'role'        => $request->get('user_type'),
            'username'    => $request->get('user_username'),
            'first_name'  => $request->get('user_firstname'),
            'last_name'   => $request->get('user_lastname'),
            'phone'       => $request->get('user_phone'),
            'email'       => $request->get('user_email'),
            'password'    => Hash::make($request->get('user_password_retype')),
            'user_status' => $request->get('user_status'),
        ]);
        
        $users->save();
        $users_id = $users->id;

        if($users_id < 10)
            $user_id_str = '00'.$users_id;
        else if($users_id >= 10 && $users_id < 100)
            $user_id_str = '0'.$users_id;
        else
            $user_id_str = $users_id;

        $users_update = User::find($users_id);
        $users_update->user_code = $request->get('supplier_code').'-'.$user_id_str;
        $users_update->uid       = Auth::user()->id;
        $users_update->user_name = Auth::user()->username;
        $users_update->save();

        return redirect('/user')->with('success', 'The new user has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::leftJoin('supplier', function ($join1) {
                    $join1->on('users.supplier_id', '=', 'supplier.supplier_id');
                })->leftJoin('supplier_types', function ($join2) {
                    $join2->on('supplier.st_id', '=', 'supplier_types.st_id');
                })
                ->select(
                    'users.*',
                    'supplier.country_code',
                    'supplier.supplier_name',
                    'supplier_types.st_name'
                )
                ->where('users.id', '=', $id)
                ->get();
        return view('user.edit', compact('user'));
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
        $request->validate([
            'user_firstname'        => 'required',
            'user_lastname'         => 'required',
            'user_phone'            => 'required',
            'user_password'         => 'required|regex:/(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,30}/',
            'user_password_retype'  => 'required|same:user_password',
            'user_type'             => 'required',
            'user_status'           => 'required',
        ]);

        $user = User::find($id);
        $user->first_name   = $request->get('user_firstname');
        $user->last_name    = $request->get('user_lastname');
        $user->role         = $request->get('user_type');
        $user->phone        = $request->get('user_phone');
        $user->password     = Hash::make($request->get('user_password'));
        $user->user_status  = $request->get('user_status');       
        $user->uid          = Auth::user()->id;       
        $user->user_name    = Auth::user()->username;
        $user->save();

        return redirect('/user')->with('success', 'The user has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        $users->user_status = 'deleted';
        $users->uid       = Auth::user()->id;
        $users->user_name = Auth::user()->username;
        $users->save();

        return redirect('/user')->with('success', 'The user has been deleted');
    }
}
