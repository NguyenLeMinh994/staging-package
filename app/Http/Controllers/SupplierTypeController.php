<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\SupplierType;
use App\Supplier;

class SupplierTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = SupplierType::where('st_status','!=','deleted')->get();
        return view('supplier_types.index', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier_types.create');
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
            'st_name'   => 'required',
            'st_status' => 'required',
        ]);
       
        $supplierType = new SupplierType([
            'st_name'       => $request->get('st_name'),
            'st_status'     => $request->get('st_status'),
            'uid'           => Auth::user()->id,
            'user_name'     => Auth::user()->username,
        ]);
        
        $supplierType->save();
        return redirect('/supplier-type')->with('success', 'The new supplier type has been added');
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
        $supplierType = SupplierType::find($id);
        return view('supplier_types.edit', compact('supplierType'));
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
            'st_name'   => 'required',
            'st_status' => 'required',
        ]);
    
        $supplierType = SupplierType::find($id);
        $supplierType->st_name      = $request->get('st_name');
        $supplierType->st_status    = $request->get('st_status');
        $supplierType->uid          = Auth::user()->id;
        $supplierType->user_name    = Auth::user()->username;
        $supplierType->save();

        return redirect('/supplier-type')->with('success', 'The supplier type has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Check relationship with supplier when admin delete the supplier type
        $supplier = Supplier::where('st_id', '=', $id)->where('supplier_status', '!=', 'deleted')->get();
        $supplierCount = $supplier->count();
        
        $SupplierType = SupplierType::find($id);
        if ($supplierCount == 0) {
            $SupplierType->st_status    = 'deleted';
            $SupplierType->uid       = Auth::user()->id;
            $SupplierType->user_name = Auth::user()->username;
            $SupplierType->save();
            return redirect('/supplier-type')->with('success', 'The supplier type has been deleted');
        } else 
            return redirect('/supplier-type')->withErrors('There is '.$supplierCount.' supplier under supplier type '.$SupplierType->st_name.'. It\'s can not be deleted');
    }

    
}
?>