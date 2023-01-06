<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class CustomValidationException extends Exception
{
    protected $validator;
	protected $code = 422;

	public function __construct(Validator $validator) {
		$this->validator = $validator;
	}

	public function render() {
		return response()->json([
            "message" => "Fields Validation Failed.",
            "errors" => $this->validator->errors()
        ], $this->code);
	}
}
