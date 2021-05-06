<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Cleanup the phone number
        $msisdn = preg_replace('~[^0-9]+~', '', $value);

        if (strlen($msisdn) <> 12) {
            return false;
        }

        if (substr($msisdn, 0, 3) != '380') {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid phone Number';
    }
}
