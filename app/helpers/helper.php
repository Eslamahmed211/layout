<?php

use App\Models\User;
use App\Models\setting;


if (!function_exists("path")) {
    function path($img)
    {
        $img = str_replace("public", "storage", $img);

        $img = asset("$img");

        return $img;
    }
}

if (!function_exists("json")) {
    function json($data)
    {
        return response()->json($data);
    }
}

if (!function_exists("check_Email")) {
    function check_Email($email)
    {
        $email = User::withTrashed()
            ->where("email", $email)
            ->first();


        if ($email != null) {
            return redirect()->back()
                ->withErrors("هذا البريد مسجل به من قبل")
                ->withInput();
        }

        return false;
    }
}

if (!function_exists('settings')) {
    function settings($column)
    {

        return setting::where("key", $column)->first()?->value;
    }
}

function get_logo()
{

    return path(setting::where("key", "logo")->first()?->value);
}

function get_fav()
{

    return path(setting::where("key", "fav")->first()?->value);
}

