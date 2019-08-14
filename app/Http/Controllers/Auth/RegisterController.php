<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\SupplierRegistrationForm;
use App\Rules\GoogleRecaptcha;
use App\ProductType;
use App\PackageCategory;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $category = PackageCategory::where('status','=','actived')->get();
        $product  = ProductType::where('status','=','actived')->get();
        return view('auth.register',compact('category','product'));
    }

    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'first_name'            => ['required', 'string', 'max:50'],
            'last_name'             => ['required', 'string', 'max:50'],
            'job_title'             => ['required', 'string', 'max:50'],
            'email'                 => ['required', 'string', 'email', 'max:255'],
            'password'              => ['required', 'string', "regex:/^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,30}$/"],
            'mobile_number'         => ['required', 'string', 'max:50'],
            'company_name'          => ['required', 'string', 'max:50'],
            'company_web'           => ['required', 'string', 'max:50'],
            'country'               => ['required', 'string', 'max:50'],
            'supplier_category'     => ['required', 'array', 'min:1'],
            'supplier_product_type' => ['required', 'array', 'min:1'],
            'instant_confirm'       => ['required'],
            'term_condition'        => ['required'],
            'g-recaptcha-response'  => ['required', new GoogleRecaptcha],
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
        
        //Sending email to 
        Mail::to(trim($request->get('email')))
                ->bcc(env('MAIL_PACKAGE', false))
                ->send(new SupplierRegistrationForm($request->all()));

        // check for failures
        if (Mail::failures())
            return response()->json(['errors'=> true, 'message'=>'Failed to send email, please try again.']);
        else
            return response()->json(['errors'=> false, 'message'=>'Email have been sent successful']);
    }

}
