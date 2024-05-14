<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User as UserAlias;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;


include('auth_routes.php');


Route::prefix("profile")->middleware("auth")->group(function () {

    Route::get('/', function () {
        return view("profile");
    });

    Route::put('info', function (Request $request) {

        $data = $request->validate([
            "name" => "required|min:3|string",
            "img" => "nullable"
        ], [
            "name.required" => "يرجي كتابة اسمك",
        ]);

        $user = UserAlias::findOrFail(auth()->user()->id);

        if (isset($data["img"])) {
            $data["img"] = Storage::put("public/logo", $data['img']);
        }

        $user->update($data);

        return Redirect::back()->with("success", "تم التعديل بنجاح");

    });

    Route::get('delete_img', function () {

        $user = auth()->user();

        if ($user->img != null) {
            Storage::delete($user->img);
        }
        $user->img = null;
        $user->save();

        return redirect()->back()->with("success", "تم ازالة الصورة بنجاح");
    });

    Route::put('password', function (Request $request) {

        $data = $request->validate([
            "passwordOld" => "required|string",
            "password" => "required|min:8|max:32|confirmed|string",

        ], [
            "passwordOld.required" => "يرجي كتابة كلمة السر القديمة",
            "password.required" => "يرجي كتابة  كلمة المرور الجديدة",
            "password.min" => "يجب ان لا تقل كلمة المرور  الجديدة عن 8 ارقام",
            "password.confirmed" => "كلمة المرور غير متطابقة",
        ]);


        if (!Hash::check($data["passwordOld"], auth()->user()->password)) {
            return Redirect::back()->with("error", "كلمة المرور القديمة خطأ")->withInput();
        }
        $data["password"] = bcrypt($data["password"]);


        $user = UserAlias::findOrFail(auth()->user()->id);

        $user->update($data);


        return Redirect::back()->with("success", "تم  تغير كلمة السر بنجاح");


    });


});
