<?php

namespace App\Http\Requests;

use App\Exceptions\ApiValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class PublicRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new ApiValidationException([$validator->errors()]);
    }
}
