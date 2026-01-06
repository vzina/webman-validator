<?php

use Vzina\LaravelValidation\UploadFileDecorator;

if (! function_exists('request_all')) {
    function request_all(): array
    {
        return ($req = request()) ? $req->all() + UploadFileDecorator::wrapper($req->file()) : [];
    }
}