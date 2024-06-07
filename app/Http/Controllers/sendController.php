<?php

namespace App\Http\Controllers;

use App\Models\device;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class sendController extends Controller
{
    function sent_single_index()
    {
        $devices = device::all();
        $messages = message::all();

        return view("users/send/single", compact("devices", "messages"));
    }

    function sent_direct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device' => 'required|integer',
            'message' => 'required|integer',
            'to' => 'required|string',
        ], [
            'device.required' => 'يرجي اخيار رقم',
            'message.required' => 'يرجي اخيار رسالة',
            'to.required' => 'يرجي كتابة اسم المرسل اليه',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json([
                'status' => "error",
                'message' => isset($errors[0]) ? $errors[0] : 'Validation error',
            ]);
        }

        $device = device::find($request->device)->token;
        $message = message::find($request->message)->message;

        try {
            return json(sendMessage($device, $request->to, $message));
        } catch (\Throwable $th) {
            return json(["status" => "error", "message" => "هناك خطأ ما"]);
        }
    }
}
