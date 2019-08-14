<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class GoogleRecaptcha implements Rule
{

    protected $google_private_key = "6LcBkZcUAAAAAOCsD5UAjNaatrmCKMGq4bLEqijR";
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify',
            [
				'verify' => false,
                'form_params' => [
                    'secret'    => $this->google_private_key,
                    'remoteip'  => request()->getClientIp(),
                    'response'  => $value
                ]
            ]
        );

        $body = json_decode((string)$response->getBody());
        return $body->success;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Are you a robot?';
    }
}
