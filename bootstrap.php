<?php

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Vzina\LaravelValidation\UploadFileDecorator;
use Vzina\LaravelValidation\ValidatorFactory;

if (! function_exists('make_validator')) {
    function make_validator(array $data, array $rules, array $messages = [], array $customAttributes = []): Validator
    {
        return ValidatorFactory::create()->make($data, $rules, $messages, $customAttributes);
    }
}

if (! function_exists('request_all')) {
    function request_all(): array
    {
        return ($req = request()) ? $req->all() + UploadFileDecorator::wrapper($req->file()) : [];
    }
}

if (! function_exists('request_validate')) {
    /**
     * @throws ValidationException
     */
    function request_validate(array $rules, array $messages = [], array $customAttributes = []): array
    {
        return make_validator(request_all(), $rules, $messages, $customAttributes)->validate();
    }
}