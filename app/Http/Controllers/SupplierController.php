<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\PackagePlan;
use App\Supplier;
use App\SupplierContact;
use App\SupplierType;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::leftJoin('supplier_types', function ($join) {
                        $join->on('supplier.st_id', '=', 'supplier_types.st_id');
                    })
                    ->select(
                        'supplier.*',
                        'supplier_types.st_name'
                    )
                    ->where('supplier.supplier_status', '!=', 'deleted')
                    ->get();
        return view('supplier.index', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplierType = SupplierType::where('st_status','!=','deleted')->get();
        return view('supplier.create', compact('supplierType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'country_suggest'   => 'required',
            'country_id'        => 'required',
            'country_code'      => 'required',
            'region_suggest'    => 'required',
            'region_id'         => 'required',
            'supplier_name'     => 'required',
            'supplier_category' => 'required',
            'status'            => 'required',
            'supplier_address_1'=> 'required',
            'supplier_phone'    => 'required|min:10',
            'contact1_firstname'=> 'required',
            'contact1_lastname' => 'required',
            'contact1_role'     => 'required',
            'contact1_email'    => 'required',
            'contact1_phone'    => 'required',
            'contact2_firstname'=> 'required',
            'contact2_lastname' => 'required',
            'contact2_role'     => 'required',
            'contact2_email'    => 'required',
            'contact2_phone'    => 'required',
        ]);

        if ($validator->fails())
        {
            $message = "";
            foreach($validator->errors()->all() as $error)
            {
                if($message == "")
                    $message = $message.$error;
                else
                    $message = $message."<br>".$error;
            }
            return response()->json(['errors'=> true, 'message'=>$message]);
        } 

        $suppliers = Supplier::where('supplier.supplier_status', '!=', 'deleted')->get();
        
        //Check supplier duplicate
        $result = array();
        foreach ($suppliers as $item){
            if ($item->region_name == $request->get('region_suggest') && $item->st_id == $request->get('supplier_category')){
                if(strtolower($item->supplier_name) == strtolower(trim($request->get('supplier_name')))){
                    $result['error']   = true; 
                    $result['message'] = "This supplier already exist in system";
                    return response()->json($result);  
                } 
            }       
        }
        
        //Table Supplier
        $supplier = new Supplier([
            'st_id'                 => $request->get('supplier_category'),
            'country_id'            => $request->get('country_id'),
            'country_code'          => $request->get('country_code'),
            'country_name'          => str_replace($request->get('country_code')." - ","",$request->get('country_suggest')),
            'region_id'             => $request->get('region_id'),
            'region_name'           => $request->get('region_suggest'),
            'supplier_name'         => trim($request->get('supplier_name')),
            'supplier_address_1'    => $request->get('supplier_address_1'),
            'supplier_address_2'    => $request->get('supplier_address_2'),
            'supplier_phone'        => $request->get('supplier_phone'),
            'supplier_web'          => $request->get('supplier_web'),
            'supplier_social_1'     => $request->get('social_1'),
            'supplier_social_2'     => $request->get('social_2'),
            'supplier_description'  => $request->get('description'),
            'supplier_status'       => $request->get('status'),
        ]);
        $supplier->save();
        
        $supplier_id = $supplier->supplier_id;

        if($supplier_id < 10)
            $supplier_id_str = '00'.$supplier_id;
        else if($supplier_id >= 10 && $supplier_id < 100 )
            $supplier_id_str = '0'.$supplier_id;
        else
            $supplier_id_str = $supplier_id;
            

        $supplier_update = Supplier::find($supplier_id);
        $supplier_update->supplier_code = $request->get('country_code').'_'.$request->get('region_id').'_'.$supplier_id_str;
        $supplier_update->uid           = Auth::user()->id;
        $supplier_update->user_name     = Auth::user()->username;
        $supplier_update->save();

        //Table supplier_contact
        $allContact = [];
        for ($i=1;$i<=2;$i++){
            $contact = new SupplierContact();
            $contact->supplier_id       = $supplier_id;
            $contact->contact_firstname = $request->get('contact'.$i.'_firstname');
            $contact->contact_lastname  = $request->get('contact'.$i.'_lastname');
            $contact->contact_role      = $request->get('contact'.$i.'_role');
            $contact->contact_skype     = $request->get('contact'.$i.'_skype');
            $contact->contact_email     = $request->get('contact'.$i.'_email');
            $contact->contact_phone     = $request->get('contact'.$i.'_phone');
            $contact->created_at        = Carbon::now()->toDateTimeString();
            $contact->uid               = Auth::user()->id;
            $contact->user_name         = Auth::user()->username;

            $allContact[] = $contact->attributesToArray();
        }

        SupplierContact::insert($allContact);

        $result['error']   = false;
        $result['message'] = "You have stored the records successfully";
        return response()->json($result);
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
        $supplier = Supplier::find($id);
        $supplierType = SupplierType::where('st_status','!=','deleted')->get();
        $contact = SupplierContact::where('supplier_id', '=', $id)->get();
        return view('supplier.edit', compact('supplier','supplierType','contact'));
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
        $validator = \Validator::make($request->all(), [
            'supplier_name'     => 'required',
            'supplier_category' => 'required',
            'status'            => 'required',
            'supplier_address_1'=> 'required',
            'supplier_phone'    => 'required|min:10',
            'contact1_firstname'=> 'required',
            'contact1_lastname' => 'required',
            'contact1_role'     => 'required',
            'contact1_email'    => 'required',
            'contact1_phone'    => 'required',
            'contact2_firstname'=> 'required',
            'contact2_lastname' => 'required',
            'contact2_role'     => 'required',
            'contact2_email'    => 'required',
            'contact2_phone'    => 'required',
        ]);

        if ($validator->fails())
        {
            $message = "";
            foreach($validator->errors()->all() as $error)
            {
                if($message == "")
                    $message = $message.$error;
                else
                    $message = $message."<br>".$error;
            }
            return response()->json(['errors'=> true, 'message'=>$message]);
        } 

        //Table supplier
        $Supplier = Supplier::find($id);
        $Supplier->supplier_name        = $request->get('supplier_name');
        $Supplier->st_id                = $request->get('supplier_category');
        $Supplier->supplier_status      = $request->get('status');
        $Supplier->supplier_address_1   = $request->get('supplier_address_1');
        $Supplier->supplier_address_2   = $request->get('supplier_address_2');
        $Supplier->supplier_phone       = $request->get('supplier_phone');
        $Supplier->supplier_web         = $request->get('supplier_web');
        $Supplier->supplier_social_1    = $request->get('social_1');
        $Supplier->supplier_social_2    = $request->get('social_2');
        $Supplier->supplier_description = $request->get('description');
        $Supplier->uid       = Auth::user()->id;
        $Supplier->user_name = Auth::user()->username;
        $Supplier->save();
        
        //Table supplier_contact
        $contact = SupplierContact::where('supplier_id', '=', $id)->get();
        for ($i=1;$i<=2;$i++){
            $contact[$i-1]->contact_firstname = $request->get('contact'.$i.'_firstname');
            $contact[$i-1]->contact_lastname  = $request->get('contact'.$i.'_lastname');
            $contact[$i-1]->contact_role      = $request->get('contact'.$i.'_role');
            $contact[$i-1]->contact_skype     = $request->get('contact'.$i.'_skype');
            $contact[$i-1]->contact_email     = $request->get('contact'.$i.'_email');
            $contact[$i-1]->contact_phone     = $request->get('contact'.$i.'_phone');
            $contact[$i-1]->uid               = Auth::user()->id;
            $contact[$i-1]->user_name         = Auth::user()->username;
            $contact[$i-1]->save();
        }
        
        $result['error']   = false;
        $result['message'] = "You have stored the records successfully";
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Check relationship with package plan when admin delete the suppliers
        $packagePlan = PackagePlan::where('supplier_id', '=', $id)->where('package_status', '!=', 'deleted')->get();
        $packagePlanCount = $packagePlan->count();

        $Supplier = Supplier::find($id);
        if ($packagePlanCount == 0) {
            $Supplier->supplier_status = 'deleted';
            $Supplier->uid       = Auth::user()->id;
            $Supplier->user_name = Auth::user()->username;
            $Supplier->save();

            $Supplier_contact = SupplierContact::where('supplier_id', '=', $id)->get();
            for ($i=1;$i<=2;$i++){
                $Supplier_contact[$i-1]->contact_status    = 'deleted';
                $Supplier_contact[$i-1]->uid               = Auth::user()->id;
                $Supplier_contact[$i-1]->user_name         = Auth::user()->username;
                $Supplier_contact[$i-1]->save();
            }
            return redirect('/supplier')->with('success', 'The supplier has been deleted');
        }
        else
            return redirect('/supplier')->withErrors('There is '.$packagePlanCount.' package plan under supplier '.$Supplier->supplier_name.'. It\'s can not be deleted');
    }
}
?>