<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule; 
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\PackagePlan;
use App\PackageOption;
use App\PackageRates;
use App\PackageAllotments;
use App\PackageChargeType;
use App\PackageServiceType;
use App\PackageImages;
use App\CancellationPolicy;
use App\ChildrenPolicy;
use App\Language;
use App\Currency;
use App\ProductType;
use App\PackageCategory;
use App\Themes;

class PackagePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packagePlan = new PackagePlan();
        $package = $packagePlan->fetchAllPackagePlan();
        $package_json = json_encode($package);
        return view('package_plan.index', compact('package_json'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category             = PackageCategory::where('status','=','actived')->get();
        $service_type         = PackageServiceType::where('status','=','actived')->get();
        $charge_type          = PackageChargeType::where('status','=','actived')->get();
        $product              = ProductType::where('status','=','actived')->get();
        $cancellation         = CancellationPolicy::where('status','=','actived')->get();
        $cancellation_default = CancellationPolicy::where('cancel_name','=','Strictly Non Refundable')->get();
        $children             = ChildrenPolicy::where('status','=','actived')->get();
        $language             = Language::where('status','=','actived')->get();
        $currency             = Currency::where('status','=','actived')->get();
        $themes               = Themes::where('status','=','actived')->get();
        return view('package_plan.create',compact('product','cancellation','cancellation_default','category','charge_type','service_type','currency','language','themes','children','keyword'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validator
        //-----------------------
        $validator = \Validator::make($request->all(), [
            'package_country_id'      => 'required', 
            'country_suggest'         => 'required', 
            'package_region_id'       => 'required',
            'region_suggest'          => 'required',
            'package_supplier_id'     => 'required',
            'supplier_suggest'        => 'required',
            'package_name'            => //'required|unique:package_plan,package_name',
                                        ['required', Rule::unique('package_plan')->where(function ($query) use ($request) {
                                            return $query->where('package_status','<>','deleted')->where('package_name', $request->package_name);
                                        })],
            'product_type'            => 'required',
            'package_rate'            => 'required',
            'package_duration_days'   => 'required|integer',
            'package_duration_hours'  => 'required|integer',
            'package_duration_minutes'=> 'required|integer',
            'package_overview'        => 'required',
            'package_expect'          => 'required',
            'package_inclusion'       => 'required',
            'package_exclusion'       => 'required',
            'sale_from'               => 'required',
            'sale_to'                 => 'required',
            'booking_from'            => 'required',
            'booking_to'              => 'required',
            'minimum_adult'           => 'required|integer',
            //'maximum_child'           => 'required|integer',
            'maximum_guest'           => 'required|integer', 
            'charge_type'             => 'required',
            'package_confirmation'    => 'required',
            'package_guide'           => 'required',
            'package_additional'      => 'required',
            'cancel_policy'           => 'required',
            'cancel_cut_off_time'     => 'required|integer',
            'child_policy'            => 'required',
            'numberOptional'          => 'required|integer',
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

        //Validator product options
        if ($request->get('numberOptional') > 0){
            for ($i=0; $i <= $request->get('numberOptional'); $i++){
                $validatorOption = \Validator::make($request->all(), [
                    'package_option_'.$i        => 'required',
                    'net_price_'.$i             => 'required',
                    'retail_price_'.$i          => 'required',
                    'package_allotment_'.$i     => 'required',
                    'package_applicable_'.$i    => 'required|array|min:1',              
                ]);

                if ($validatorOption->fails()) {
                    $message = "";
                    foreach($validatorOption->errors()->all() as $error)
                    {
                        if($message == "")
                            $message = $message.$error;
                        else
                            $message = $message."<br>".$error;
                    }
                    return response()->json(['errors'=> true, 'message'=>$message]);
                }
            }
        }
        //-----------------------
        //End Validator
        
        /** Get package_meeting_latitude and package_meeting_longitude  
         *  Based meeting_name and meeting_address
         **/
        /*
        $package_meeting_latitude = 0;
        $package_meeting_longitude = 0;
        if ($request->get('package_meeting')!=="" &&  $request->get('package_meeting')!==null){
            //get the meeting latitude longitude based on google map API
			$meeting_place  = $request->get('package_meeting').' '.$request->get('package_meeting_address');
            $mapsApi 	 	= 'https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=AIzaSyC0J0jOad2EfdA91auV0JoMC16XdeJWqFM';
            $meetingName 	= str_replace(' ', '+', trim($meeting_place));
            $location 	 	= sprintf($mapsApi, $meetingName);
            
            //call map google API
            $location = json_decode(file_get_contents($location));
			
            if ($location->results[0]->geometry->location->lat != "" && $location->results[0]->geometry->location->lng !="")
            {
                $package_meeting_latitude	= $location->results[0]->geometry->location->lat;
                $package_meeting_longitude	= $location->results[0]->geometry->location->lng;
            }
        }
        */

        //Upload Package Plan Document
        $document_path = "";
        /*
        if($request->package_plan_file) {
           
            $validatorFile = \Validator::make($request->all(), [
                'package_plan_file' => 'max:2000|mimes:doc,docx,pdf',               
            ]);

            if ($validatorFile->fails()) {
                $message = "";
                foreach($validatorFile->errors()->all() as $error)
                {
                    if($message == "")
                        $message = $message.$error;
                    else
                        $message = $message."<br>".$error;
                }
                return response()->json(['errors'=> true, 'message'=>$message]);
            }

            $document = $request->file('package_plan_file');
            $path = public_path('\images').'/'.preg_replace('/\s+/', '', $request->get('supplier_suggest'));
            
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $document->move($path, $document->getClientOriginalName());

            $document_path = $document->getClientOriginalName();
        }
        */
        //Table Package Plan
        $package_plan = new PackagePlan([
            'country_id'                => $request->get('package_country_id'), 
            'country_name'              => $request->get('country_suggest'), 
            'region_id'                 => $request->get('package_region_id'),
            'region_name'               => $request->get('region_suggest'),
            'supplier_id'               => $request->get('package_supplier_id'),
            'supplier_name'             => $request->get('supplier_suggest'),
            'package_name'              => $request->get('package_name'),
            'package_product_type'      => $request->get('product_type'),
            'package_themes'            => $request->get('package_themes')!=null?$this->ConvertArrayToString($request->get('package_themes')):null,
            'package_category'          => $request->get('package_category')!=null?$this->ConvertArrayToString($request->get('package_category')):null,
            'package_keyword'           => $request->get('package_keyword')!=null?json_encode($request->get('package_keyword')):null,
            //'package_status'            => $request->get('package_status'),
            //'package_distribution'      => $request->get('package_distribution'),
            'package_availibity'        => $request->get('package_availibity'),
            'package_language'          => $request->get('package_language'),
            'package_schedule_type'     => $request->get('package_schedule_type'),
            'package_duration_days'     => $request->get('package_duration_days'),
            'package_duration_hours'    => $request->get('package_duration_hours'),
            'package_duration_minutes'  => $request->get('package_duration_minutes'),
            'sale_from'                 => date('Y-m-d H:i:s', strtotime($request->get('sale_from'))),
            'sale_to'                   => date('Y-m-d H:i:s', strtotime($request->get('sale_to'))),
            'book_from'                 => date('Y-m-d H:i:s', strtotime($request->get('booking_from'))),
            'book_to'                   => date('Y-m-d H:i:s', strtotime($request->get('booking_to'))), 
            'min_adult'                 => $request->get('minimum_adult'),
            'max_child'                 => ($request->get('maximum_child')==null)?0:$request->get('maximum_child'),
            'max_guest'                 => $request->get('maximum_guest'),
            'package_cancel'            => $request->get('cancel_policy'),
            'cancel_cut_off_time'       => $request->get('cancel_cut_off_time'),
            'package_child'             => $request->get('child_policy'),
            'package_rate'              => $request->get('package_rate'),
            'package_offer'             => $request->get('offer_text'),
            'advance_purchased'         => $request->get('package_advance'),
            'package_discount_type'     => $request->get('discount_type'),
            'package_discount_value'    => $request->get('discount_value'),
            'package_overview'          => $request->get('package_overview'),
            'package_highlights'        => $request->get('package_highlights'),
            'package_expect'            => $request->get('package_expect'),
            'package_schedule'          => $request->get('package_schedule'),
            'package_inclusion'         => $request->get('package_inclusion'),
            'package_exclusion'         => $request->get('package_exclusion'),
            'package_confirmation'      => $request->get('package_confirmation'),
            'package_guide'             => $request->get('package_guide'),
            'package_attention'         => $request->get('package_attention'),
            'package_additional'        => $request->get('package_additional'),
            'package_contract_remark'   => $request->get('package_contract_remark'),
            'package_service_type'      => $request->get('service_type'),
            'package_meeting'           => $request->get('package_meeting'),
            'package_meeting_address'   => $request->get('package_meeting_address'),
            'package_meeting_latitude'  => $request->get('package_meeting_latitude')!=null?$request->get('package_meeting_latitude'):0,
            'package_meeting_longitude' => $request->get('package_meeting_longitude')!=null?$request->get('package_meeting_longitude'):0,
            'package_meeting_zoomsize'  => $request->get('package_meeting_zoomsize')!=null?$request->get('package_meeting_zoomsize'):13,
            'package_plan_file'         => $document_path==""?null:$document_path,
            'uid'                       => Auth::user()->id,
            'user_name'                 => Auth::user()->username,
        ]);
        
        $package_plan->save();
        $plan_id = $package_plan->id;

        //Package Inventory - Create
		$inventory = 'inventory'.$package_plan->region_id;
		$chk_procedure = DB::select('CALL CreateInventoryTable(?)',array($inventory));
		
        //Package Option
        for ($i=0; $i<=$request->get('numberOptional'); $i++)
        {    
            //Package Option
            $package_option = new PackageOption([
                'plan_id'                   => $plan_id,
                'option_name'               => $request->get('package_option_'.$i),
                'applicate_date'            => $this->ConvertArrayToString($request->get('package_applicable_'.$i)),
                'option_highlights'         => $request->get('option_highlights_'.$i),
                'package_currency'          => $request->get('package_currency'),
                'package_charge_type'       => $request->get('charge_type'),
                'package_default_net'       => $request->get('net_price_'.$i),
                'package_default_retail'    => $request->get('retail_price_'.$i),
                'package_default_allotment' => $request->get('package_allotment_'.$i),
                'created_at'                => Carbon::now()->toDateTimeString(),
                'uid'                       => Auth::user()->id,
                'user_name'                 => Auth::user()->username,
            ]);
            $package_option->save();
            $option_id = $package_option->id;
            
            $rate = array();
            $allotment = array();
            
            //Table Package Option, Rate, Allotment
            $dates = $this->date_parse($package_plan->book_from, $package_plan->book_to, $request->get('package_applicable_'.$i));

            //Prepare Data Rate, Allotment
            foreach($dates as $k=>$v)
            {
                $rates_data = array(
                    'plan_id'         => $plan_id,
                    'option_id'       => $option_id,
                    'date'            => $v,
                    'package_net'     => $package_option->package_default_net,
                    'package_retail'  => $package_option->package_default_retail,
                    'created_at'      => Carbon::now()->toDateTimeString(),
                    'uid'             => Auth::user()->id,
                    'user_name'       => Auth::user()->username,
                );
                

                $rate[] = $rates_data;

                $allotment_data = array(
                    'plan_id'         => $plan_id,
                    'option_id'       => $option_id,
                    'date'            => $v,
                    'allotment'       => $package_option->package_default_allotment,
                    'created_at'      => Carbon::now()->toDateTimeString(),
                    'uid'             => Auth::user()->id,
                    'user_name'       => Auth::user()->username,
                );
                
                $allotment[] = $allotment_data;

            }

            //Package Rate
            $package_rate = new PackageRates;
            $package_rate->insert($rate);

            //Package Allotment
            $package_allotments = new PackageAllotments;
            $package_allotments->insert($allotment);

            //Package Inventory - Insert Data
            DB::table($inventory)->insert($allotment);
        }

        //Package Image - Update Package Plan ID
        PackageImages::where('package_name', $package_plan->package_name)->update(['plan_id' => $package_plan->id]);

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
        $category     = PackageCategory::where('status','=','actived')->get();
        $product      = ProductType::where('status','=','actived')->get();
        $cancellation = CancellationPolicy::where('status','=','actived')->get();
        $children     = ChildrenPolicy::where('status','=','actived')->get();
        $service_type = PackageServiceType::where('status','=','actived')->get();
        $charge_type  = PackageChargeType::where('status','=','actived')->get();
        $currency     = Currency::where('status','=','actived')->get();
        $language     = Language::where('status','=','actived')->get();
        $themes       = Themes::where('status','=','actived')->get();
        
        $packagePlan   = PackagePlan::find($id);
        $packageOption = PackageOption::where('plan_id',$id)->where('option_status','=','actived')->get();
        $packageImage  = PackageImages::where('plan_id',$id)->orderBy('image_cover', 'desc')->orderBy('updated_at', 'asc')->get();

        $package_category   = explode('|', $packagePlan->package_category);
        $package_themes     = explode('|', $packagePlan->package_themes);
        $package_keyword    = json_decode($packagePlan->package_keyword, TRUE);

        $package_cancellation = CancellationPolicy::where('cancel_id', $packagePlan->package_cancel)->firstOrFail();
        $package_children     = ChildrenPolicy::where('policy_id', $packagePlan->package_child)->firstOrFail();
        
        return view('package_plan.edit', compact(
                                                'category',
                                                'product',
                                                'cancellation',
                                                'children',
                                                'currency',
                                                'language',
                                                'themes',
                                                'charge_type',
                                                'service_type',
                                                'packagePlan',
                                                'packageOption',
                                                'packageImage',
                                                'package_keyword',
                                                'package_category',
                                                'package_themes',
                                                'package_cancellation',
                                                'package_children'
                                            ));
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
        //Validator
        //-----------------------
        $validator = \Validator::make($request->all(), [
            'package_name'                  => 'required',
            'product_type'                  => 'required',
            'package_duration_days'         => 'required',
            'package_duration_hours'        => 'required',
            'package_duration_minutes'      => 'required',
            'cancel_policy'                 => 'required',
            'child_policy'                  => 'required',
            'package_overview'              => 'required',
            'package_expect'                => 'required',
            'package_inclusion'             => 'required',
            'package_exclusion'             => 'required',
            'package_confirmation'          => 'required',
            'package_guide'                 => 'required',
            'package_additional'            => 'required',
            'package_currency'              => 'required',
            //'charge_type'                   => 'required',
            'cancel_cut_off_time'           => 'required|integer',
            'minimum_adult'                 => 'required|integer',
            //'maximum_child'                 => 'required|integer',
            'maximum_guest'                 => 'required|integer',
            'package_advance'               => 'required|integer',
            'numberOptional'                => 'required|integer',
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
        //-----------------------
        //End Validator
       
        /** Get package_meeting_latitude and package_meeting_longitude  
         *  Based meeting_name and meeting_address
         **/
        /*
        $package_meeting_latitude = 0;
        $package_meeting_longitude = 0;
        if ($request->get('package_meeting')!=="" &&  $request->get('package_meeting')!==null){
            //get the meeting latitude longitude based on google map API
			$meeting_place  = $request->get('package_meeting').' '.$request->get('package_meeting_address');
            $mapsApi 	 	= 'https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=AIzaSyC0J0jOad2EfdA91auV0JoMC16XdeJWqFM';
            $meetingName 	= str_replace(' ', '+', trim($meeting_place));
            $location 	 	= sprintf($mapsApi, $meetingName);
            
            //call map google API
            $location = json_decode(file_get_contents($location));
			
            if ($location->results[0]->geometry->location->lat != "" && $location->results[0]->geometry->location->lng !="")
            {
                $package_meeting_latitude	= $location->results[0]->geometry->location->lat;
                $package_meeting_longitude	= $location->results[0]->geometry->location->lng;
            }
        }
        */
        
        $package_plan = PackagePlan::findOrFail($id);
        
        //Package Plan Document
        $document_path = "";
        /*
        if($request->package_plan_file) {
           
            $validatorFile = \Validator::make($request->all(), [
                'package_plan_file' => 'max:2000|mimes:doc,docx,pdf',               
            ]);

            if ($validatorFile->fails()) {
                $message = "";
                foreach($validatorFile->errors()->all() as $error)
                {
                    if($message == "")
                        $message = $message.$error;
                    else
                        $message = $message."<br>".$error;
                }
                return response()->json(['errors'=> true, 'message'=>$message]);
            }

            //Delete Old File Document
            if ($package_plan->package_plan_file !== null) {
                $file_path = public_path('\images').'\\'.preg_replace('/\s+/', '', $package_plan->supplier_name).'/'. $package_plan->package_plan_file;
               
                if (file_exists($file_path)) {
                    unlink($file_path);
                    $package_plan->package_plan_file = null;
                }
            }

            $document = $request->file('package_plan_file');
            $path = public_path('\images').'/'.preg_replace('/\s+/', '', $package_plan->supplier_name);
            
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $document->move($path, $document->getClientOriginalName());

            $document_path = $document->getClientOriginalName();
        }
        */

        //Table Package Plan
        $package_plan->package_name                 = $request->get('package_name');
        //$package_plan->package_status               = $request->get('package_status');
        //$package_plan->package_distribution         = $request->get('package_distribution');
        $package_plan->package_product_type         = $request->get('product_type');
        $package_plan->package_category             = $request->get('package_category')!=null?$this->ConvertArrayToString($request->get('package_category')):null;
        $package_plan->package_themes               = $request->get('package_themes')!=null?$this->ConvertArrayToString($request->get('package_themes')):null;
        $package_plan->package_keyword              = $request->get('package_keyword')!=null?json_encode($request->get('package_keyword')):null;
        $package_plan->package_duration_days        = $request->get('package_duration_days');
        $package_plan->package_duration_hours       = $request->get('package_duration_hours');
        $package_plan->package_duration_minutes     = $request->get('package_duration_minutes');
        $package_plan->package_availibity           = $request->get('package_availibity');
        $package_plan->package_schedule_type        = $request->get('package_schedule_type');
        $package_plan->package_language             = $request->get('package_language');
        $package_plan->min_adult                    = $request->get('minimum_adult');
        $package_plan->max_child                    = ($request->get('maximum_child')==null)?0:$request->get('maximum_child');
        $package_plan->max_guest                    = $request->get('maximum_guest');
        $package_plan->package_rate                 = $request->get('package_rate');
        $package_plan->advance_purchased            = $request->get('package_advance');
        $package_plan->package_offer                = $request->get('offer_text');
        $package_plan->package_discount_type        = $request->get('discount_type');
        $package_plan->package_discount_value       = $request->get('discount_value');
        $package_plan->package_overview             = $request->get('package_overview');
        $package_plan->package_highlights           = $request->get('package_highlights');
        $package_plan->package_expect               = $request->get('package_expect');
        $package_plan->package_inclusion            = $request->get('package_inclusion');
        $package_plan->package_exclusion            = $request->get('package_exclusion');
        $package_plan->package_schedule             = $request->get('package_schedule');
        $package_plan->package_meeting              = $request->get('package_meeting');
        $package_plan->package_meeting_address      = $request->get('package_meeting_address');
        $package_plan->package_service_type         = $request->get('service_type');
        $package_plan->package_meeting_latitude     = $request->get('package_meeting_latitude')!=null?$request->get('package_meeting_latitude'):0;
        $package_plan->package_meeting_longitude    = $request->get('package_meeting_longitude')!=null?$request->get('package_meeting_longitude'):0;
        $package_plan->package_meeting_zoomsize     = $request->get('package_meeting_zoomsize')!=null?$request->get('package_meeting_zoomsize'):13;
        $package_plan->package_attention            = $request->get('package_attention');
        $package_plan->package_confirmation         = $request->get('package_confirmation');
        $package_plan->package_guide                = $request->get('package_guide');
        $package_plan->package_additional           = $request->get('package_additional');
        $package_plan->package_contract_remark      = $request->get('package_contract_remark');
        $package_plan->package_cancel               = $request->get('cancel_policy');
        $package_plan->cancel_cut_off_time          = $request->get('cancel_cut_off_time');
        $package_plan->package_child                = $request->get('child_policy');
        //$package_plan->child_adult_percent          = $request->get('child_adult_percent');
        
        if (($package_plan->package_plan_file == null || $package_plan->package_plan_file == "") && $document_path != '')
            $package_plan->package_plan_file        = $document_path;
        
        $package_plan->uid                          = Auth::user()->id;
        $package_plan->user_name                    = Auth::user()->username;
        $package_plan->save();

        //Table Package Option
        $package_options = PackageOption::where('plan_id', $id)->get();
        for ($i=0; $i<=$request->get('numberOptional'); $i++)
        {    
            $package_options[$i]->option_name          = $request->get('package_option_'.$i);
            $package_options[$i]->option_highlights    = $request->get('option_highlights_'.$i);
            $package_options[$i]->package_currency     = $request->get('package_currency');
            //$package_options[$i]->package_charge_type  = $request->get('charge_type');
            $package_options[$i]->uid                  = Auth::user()->id;
            $package_options[$i]->user_name            = Auth::user()->username;
            $package_options[$i]->save();
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
        $PackagePlan = PackagePlan::find($id);
        $PackagePlan->package_status      = 'deleted';
        $PackagePlan->uid                 = Auth::user()->id;
        $PackagePlan->user_name           = Auth::user()->username;
        $PackagePlan->save();

        $PackageOption = PackageOption::where('plan_id', $id)->update(['option_status' => 'deleted'],['uid' => Auth::user()->id],['user_name' => Auth::user()->username]);

        return redirect('/package-plan')->with('success', 'The package plan has been deleted');
    }

    public function ConvertArrayToString(array $temp)
    {
        $result = "" ;
        if (isset($temp)) {
            for($i=0; $i < count($temp); $i++) {
                if($i > 0) {
                    $result .=  '|' . strtolower($temp[$i]);
                }
                else {
                    $result .=  strtolower($temp[$i]);
                }
            }
        }
        return $result;
    }

    /**
     * parser date
     * 
     * @return array
     */
    public function date_parse($startdate, $enddate, $weekdays=null)
    {
        $dates  = array();
        $isCount = 0;
        
        if ($weekdays != null)
            $isCount= count($weekdays);

        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $startdate)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $enddate)->format('Y-m-d');
        
        if($isCount > 0 && $isCount < 7) {
            $merge = array();
            for($i=0; $i < $isCount; $i++) {
                $out = 0;
                switch($weekdays[$i]){
                    case 'sun':
                        $out = 0;
                        break;
                    case 'mon':
                        $out = 1;
                        break;
                    case 'tue':
                        $out = 2;
                        break;
                    case 'wed':
                        $out = 3;
                        break;
                    case 'thu':
                        $out = 4;
                        break;
                    case 'fri':
                        $out = 5;
                        break;
                    case 'sat':
                        $out = 6;
                        break;
                }

                $temp = [];
                $startDate_1 = Carbon::parse($start_date)->next($out); // Get the first days.
                $endDate_1 = Carbon::parse($end_date);

                for ($date = $startDate_1; $date->lte($endDate_1); $date->addWeek()) {
                    $temp[] = $date->format('Y-m-d');
                }
                
                $merge = array_merge($merge, $temp);
                unset($temp);
            }
            asort($merge);
            foreach($merge as $v){
                $dates[] = $v;
            }
        }
        else {
            $period = CarbonPeriod::create($start_date, $end_date);
            // Convert the period to an array of dates
            $dates = $period->toArray();
        }

        return $dates;
    }

    /**
     * Update the Status of Product Plan
     *
     * @param  Request  $id,
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $result['error']           = true;
        $result['id']              = "";
        $result['status_id']       = "";
        $result['status_oldclass'] = "";
        $result['status_newclass'] = "";
        $result['status_title']    = "";
        if ($request->has('id') && ($request->get('id') != null || $request->get('status_update') != null)){
            $product = PackagePlan::find($request->get('id'));
            $product->package_status  = $request->get('status_update');
            $product->uid             = Auth::user()->id;
            $product->user_name       = Auth::user()->username;
            $product->save();
            
            $result['id']    = $request->get('id');
            $result['error'] = false;
            if ($request->get('status_update') == 1){
                $result['status_id']       = 1;
                $result['status_oldclass'] = "m-badge--danger";
                $result['status_newclass'] = "m-badge--primary";
                $result['status_title']    = "Active";
            }
            else{
                $result['status_id']       = 2;
                $result['status_oldclass'] = "m-badge--primary";
                $result['status_newclass'] = "m-badge--danger";
                $result['status_title']    = "Inactive";
            }
        }
        return response()->json($result);
    }

    /**
     * Update the Status of Product Plan
     *
     * @param  Request  $id,
     * @return \Illuminate\Http\Response
     */
    public function updateDistribution(Request $request)
    {
        $result['error']                    = true;
        $result['id']                       = "";
        $result['distribute_id']            = "";
        $result['distributedot_oldclass']   = "";
        $result['distributedot_newclass']   = "";
        $result['distributetitle_oldclass'] = "";
        $result['distributetitle_newclass'] = "";
        $result['distribute_title']         = "";
        
        if ($request->has('id') && ($request->get('id') != null || $request->get('distribute_update') != null)){
            $product = PackagePlan::find($request->get('id'));
            $product->package_distribution  = $request->get('distribute_update');
            $product->uid                   = Auth::user()->id;
            $product->user_name             = Auth::user()->username;
            $product->save();
            
            $result['id']    = $request->get('id');
            $result['error'] = false;
            if ($request->get('distribute_update') == 1){
                $result['distribute_id']            = 1;
                $result['distributedot_oldclass']   = "m-badge--accent";
                $result['distributedot_newclass']   = "m-badge--primary";
                $result['distributetitle_oldclass'] = "m--font-accent";
                $result['distributetitle_newclass'] = "m--font-primary";
                $result['distribute_title']         = "Published";
            }
            else{
                $result['distribute_id']            = 2;
                $result['distributedot_oldclass']   = "m-badge--primary";
                $result['distributedot_newclass']   = "m-badge--accent";
                $result['distributetitle_oldclass'] = "m--font-primary";
                $result['distributetitle_newclass'] = "m--font-accent";
                $result['distribute_title']         = "Offline";
            }
        }
        return response()->json($result);
    }
}
