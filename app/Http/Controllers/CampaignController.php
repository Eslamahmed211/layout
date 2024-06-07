<?php

namespace App\Http\Controllers;

use App\Models\campaign;
use App\Models\device;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{

    function create()
    {
        $devices = device::all();
        $messages = message::all();

        return view("users/campaigns/create", compact("devices", "messages"));
    }

    function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'device_id' => 'required|integer',
            'message_id' => 'required|integer',
            'from' => 'required|integer',
            'to' => 'required|integer',
            'started_at' => 'required|date_format:Y-m-d h:i'
        ], [
            'device.required' => 'يرجي اخيار رقم',
            'message.required' => 'يرجي اخيار رسالة',
            'name.required' => 'يرجي كتابة اسم الحملة',
            'from.required' => 'يرجي كتابة الفاصل الزمني الاول',
            'to.required' => 'يرجي كتابة الفاصل الزمني الثاني',
            'started_at.required' => 'يرجي كتابة تاريخ بداية الحملة',

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json([
                'status' => "error",
                'message' => isset($errors[0]) ? $errors[0] : 'Validation error',
            ]);
        }

        $device_id = device::findOrFail($request->device_id);
        $message_id = message::find($request->message_id);

        if (!$device_id) {
            return json([
                "status" => "error",
                'message' => 'الرقم غير موجود',
            ]);
        }

        if (!$message_id) {
            return json([
                "status" => "error",
                'message' => 'الرسالة غير موجودة',
            ]);
        }


        $device_id = $device_id->id;
        $message_id = $message_id->message;


        try {
            campaign::create($validator->validated());

            return json(["status" => "success", "message" => "تم حفظ الحملة بنجاح"]);
        } catch (\Throwable $th) {
            return json(["status" => "error", "message" => "هناك خطأ اثناء الحفظ"]);
        }
    }
}
