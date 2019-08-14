<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\CancellationPolicy;
use App\ChildrenPolicy;
use App\PackageImages;

class ServicesController extends Controller
{
    /**
     * 
     * Typehead Country
     *
     */
    public function autoSuggestCountry(){
        $results = DB::table('supplier_regions');
        $results = $results->select(array('country_id as id','country_code as value', 'country_name as name'));
        
        if(request()->has('q') && request('q') != null){
            if (strlen(request('q')) < 3)
                $results = $results->where('country_code', 'like', '%'.request('q').'%');
            else
                $results = $results->where('country_name', 'like', '%'.request('q').'%');
        }

        $results = $results->limit(10)->get();
        
        return $results;
    }

    /**
     * 
     * Typehead Region
     *
     */
    public function autoSuggestRegion(){
        $results = "";
        if (request()->has('country_id') && (request('country_id') != null || request('country_id') != "")){
            $regionList = DB::table('supplier_regions');
            $regionList = $regionList->select('region_list');
            $regionList = $regionList->where('country_id', '=', request('country_id'));
            $regionList = $regionList->get();
            if (count($regionList)>0){
                //$regionID_list = array_map('intval', explode(',', $regionList[0]->region_list));
                $regionID_list = explode(',', $regionList[0]->region_list);
                $results = DB::table('regions_list');
                $results = $results->select(array('RegionID as id','RegionName as value'))->whereIn('RegionID', $regionID_list);

                if(request()->has('q') && request('q') != null){
                    $results = $results->where('RegionName', 'like', '%'.request('q').'%');
                }

                $results = $results->orderBy('RegionName', 'ASC')->get();
			}
        }
        return $results;
    }

    /**
     * 
     * Typehead Supplier When Create User
     *
     */
    public function autoSuggestSupplier(){
        $results = "";
        
        if (request()->has('supplier_type') && (request('supplier_type') != null || request('supplier_type') != "")){
            $results = DB::table('supplier');
            $results = $results->select(array('supplier_id as id', 'supplier_name as value', 'supplier_code as code'));
            $results = $results->where('st_id', '=', request('supplier_type'));
            $results = $results->where('supplier_status', '=', 'actived');

            if(request()->has('q') && request('q') != null){
                $results = $results->where('supplier_name', 'like', '%'.request('q').'%');
            }
            $results = $results->limit(10)->get();
        }
        return $results;
    }

    /**
     * 
     * Typehead Supplier When Create New Package Plan
     *
     */
    public function autoSuggestSupplierPlan(){
        $results = "";
        
        if (request()->has('country_id') && (request('country_id') != null || request('country_id') != "")){
            $results = DB::table('supplier');
            $results = $results->select(array('supplier_id as id', 'supplier_name as value', 'supplier_code as code'));
            $results = $results->where('country_id', '=', request('country_id'));
            $results = $results->where('supplier_status', '=', 'actived');

            if(request()->has('q') && request('q') != null){
                $results = $results->where('supplier_name', 'like', '%'.request('q').'%');
            }        
            $results = $results->limit(10)->get();
        }
        return $results;
    }

    public function findCancelPolicyDetails(){
        $cancelpolicy = CancellationPolicy::findOrFail(request('cancel_policy_id'));
        return response()->json($cancelpolicy);
    }

    public function findChildPolicyDetails(){
        $childpolicy = ChildrenPolicy::findOrFail(request('child_policy_id'));
        return response()->json($childpolicy);
    }

    public function getLatLongtidueDefaultGoogleMap(){
       
        if (request()->has('region_name') && (request('region_name') != null || request('region_name') != "")){
            //get the meeting latitude longitude based on google map API
            $meeting_place  = request('region_name');
            $mapsApi 	 	= 'https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=AIzaSyCU6DYZrg6dilMCpFCncS4DkePSX9CatwI';
            $meetingName 	= str_replace(' ', '+', trim($meeting_place));
            
            $location 	 	= sprintf($mapsApi, $meetingName);
           
            //call map google API
            $location = json_decode(file_get_contents($location));

            if ($location->results[0]->geometry->location->lat != "" && $location->results[0]->geometry->location->lng !="")
            {
                $latitude = $location->results[0]->geometry->location->lat;
                $longtude = $location->results[0]->geometry->location->lng;
                return response()->json( array('lat' => $latitude, 'lng'=>$longtude));
            }
        }
        return "";
    }
    /**
     * 
     * Typehead Supplier On Package Rate/Allotment
     *
     */
    public function autoSuggestSupplierPackage(){
        $results = "";
        
        if (request()->has('region_id') && (request('region_id') != null || request('region_id') != "")){
            $results = DB::table('supplier');
            $results = $results->select(array('supplier_id as id', 'supplier_name as value'));
            $results = $results->where('region_id', '=', request('region_id'));
            $results = $results->where('supplier_status', '=', 'actived');

            if(request()->has('q') && request('q') != null){
                $results = $results->where('supplier_name', 'like', '%'.request('q').'%');
            }        
            $results = $results->orderBy('supplier_name', 'ASC')->limit(10)->get();
        }
        return $results;
    }
    /**
     * 
     * Typehead Product Plan On Package Rate/Allotment
     *
     */
    public function autoSuggestPlanPackage(){
        $results = "";
        
        if (request()->has('supplier_id') && (request('supplier_id') != null || request('supplier_id') != "")){
            $results = DB::table('package_plan');
            $results = $results->select(array('id as id', 'package_name as value', 'book_from as start', 'book_to as end'));
            $results = $results->where('supplier_id', '=', request('supplier_id'));
            //$results = $results->where('supplier_status', '=', 'actived');

            if(request()->has('q') && request('q') != null){
                $results = $results->where('package_name', 'like', '%'.request('q').'%');
            }        
            $results = $results->orderBy('package_name', 'ASC')->limit(10)->get();
        }
        return $results;
    }
    /**
     * 
     * Typehead Product Plan On Package Rate/Allotment
     *
     */
    public function autoSuggestPlanOptionPackage(){
        $results = "";
        
        if (request()->has('plan_id') && (request('plan_id') != null || request('plan_id') != "")){
            $results = DB::table('package_option');
            $results = $results->select(array('id as id', 'option_name as value', 'package_default_net as net', 'package_default_retail as retail', 'package_default_allotment as allotment'));
            $results = $results->where('plan_id', '=', request('plan_id'));
            $results = $results->where('option_status', '=', 'actived');

            if(request()->has('q') && request('q') != null){
                $results = $results->where('option_name', 'like', '%'.request('q').'%');
            }        
            $results = $results->orderBy('option_name', 'ASC')->limit(10)->get();
        }
        return $results;
    }
}
?>