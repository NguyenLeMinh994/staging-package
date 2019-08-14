<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ProductType;
use App\PackageCategory;

class SupplierRegistrationForm extends Mailable
{
    use Queueable, SerializesModels;
    public $userInfor;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userInformation) {
        $this->userInfor = $userInformation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $category = PackageCategory::where('status','=','actived')->get();
        $product  = ProductType::where('status','=','actived')->get();
        
        return $this->view('email.register_confirmation', compact('category','product','userInfor'));
    }
}
