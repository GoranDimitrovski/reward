<?php

namespace App\Validators;

use Illuminate\Validation\Validator as Validator;

class CustomValidator extends Validator {

    protected function validateImageOrUrl($attribute, $value, $parameters) {
        return ($this->validateBase64Image($attribute, $value, $parameters) || $this->validateActiveUrl($attribute, $value, $parameters));
    }

    public function validateBase64Image($value) {
        $explode = explode(',', $value);
        $allow = ['png', 'jpg', 'svg'];
        $format = str_replace(
                [
            'data:image/',
            ';',
            'base64',
                ], [
            '', '', '',
                ], $explode[0]
        );
        // check file format
        if (!in_array($format, $allow)) {
            return false;
        }
        // check base64 format
        if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
            return false;
        }
        return true;
    }

}
