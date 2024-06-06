<?php

namespace App\Http\Controllers;

use App\Models\device;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class sendController extends Controller
{
    function sent_direct_index()
    {
        $devices = device::all();
        $messages = message::all();

        return view("users/send/direct_index", compact("devices", "messages"));
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

        $response = Http::post(env("SCRIPT_URL") . "/send-message", [
            'id' => $device,
            'to' => "+" . $request->to,
            'message' => $message,
        ]);

        try {
            return json($response->json());
        } catch (\Throwable $th) {
            return json(["status" => "error", "message" => "هناك خطأ ما"]);
        }
    }
}
