<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\setting;

class settingsController extends Controller
{
    public function index()
    {
        return view("admin/settings");
    }

    function update(Request $request)
    {
        $data = $request->validate([
            "logo" => "nullable|image",
            "fav" => "nullable|image",
            "websiteName" => "required|string",
    
            "facebook" => "nullable|string",
            "instagram" => "nullable|string",
            "twitter" => "nullable|string",
            "tiktok" => "nullable|string",
            "telegram" => "nullable|string",

        ]);

        if (isset($data["logo"])) {
            $data["logo"] = Storage::put("public/imgs", $data["logo"]);
        }

        if (isset($data["fav"])) {
            $data["fav"] = Storage::put("public/imgs", $data["fav"]);
        }

        foreach ($data as $key => $value) {
            setting::where("key", $key)->update([
                "value" => $value
            ]);
        }

        return redirect()->back()->with("success", "تم التعديل بنجاح");
    }


}
