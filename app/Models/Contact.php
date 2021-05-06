<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [ 'phone', 'fullname' ];

    public function setPhoneAttribute($value)
    {
        // Cleanup the phone number
        return $this->attributes['phone'] = preg_replace('~[^0-9]+~', '', $value);
    }
}
