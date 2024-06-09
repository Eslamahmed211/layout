<?php

namespace App\Http\Controllers;

use App\Models\campaign;
use App\Models\campaignContact;
use App\Models\device;
use App\Models\group;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{

    function index()
    {
        $campaigns = campaign::withCount("numbers")->get();

        return view("users.campaigns.index", get_defined_vars());
    }

    function create()
    {
        $devices = device::all();
        $messages = message::all();
        $groups = group::all();


        return view("users/campaigns/create", compact("devices", "messages", "groups"));
    }

    function store(Request $request)
    {


        $validator = Validator::make($request->all()["formData"], [
            'name' => 'required|string',
            'device_id' => 'required|integer',
            'message_id' => 'required|integer',
            'from' => 'required|integer',
            'to' => 'required|integer',
            'started_at' => 'required'
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

        if (!isset($request->all()["numbers"])) {
            return json(["status" => "error", "message" => "يرجي اضافة ارقام"]);
        }

        $validator_numbers = Validator::make($request->all(), [
            'numbers.*.name' => 'nullable|string',
            'numbers.*.phone' => 'required|string'
        ], [
            'numbers.*.phone.required' => 'يرجى كتابة الرقم في الصف رقم :index',
            'required' => 'حقل :attribute مطلوب في الصف رقم :index',
        ]);



        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json([
                'status' => "error",
                'message' => isset($errors[0]) ? $errors[0] : 'Validation error',
            ]);
        }

        if ($validator_numbers->fails()) {
            $errors = $validator_numbers->errors()->all();

            return response()->json([
                'status' => "error",
                'message' => isset($errors[0]) ? $errors[0] : 'Validation error',
            ]);
        }





        $device_id = device::findOrFail($validator->validated()["device_id"]);
        $message_id = message::find($validator->validated()["message_id"]);

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

            DB::beginTransaction();

            $insterd = campaign::create($validator->validated());

            $index = 1;
            foreach ($validator_numbers->validated()["numbers"] as $contact) {

                campaignContact::create([
                    "name" => $contact["name"],
                    "phone" => $contact["phone"],
                    "campaign_id" => $insterd->id,
                    "order" =>     $index
                ]);

                $index++;
            }


            DB::commit();

            return json(["status" => "success", "message" => "تم حفظ الحملة بنجاح"]);
        } catch (\Throwable $th) {
            return json(["status" => "error", "message" => "هناك خطأ اثناء الحفظ"]);
        }
    }
}
