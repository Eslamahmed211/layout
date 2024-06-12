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
        $campaigns = campaign::withCount("numbers")->withCount("success")->withCount("failed")->get();

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


        $device_id = device::find($validator->validated()["device_id"]);
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

        if ($validator->validated()["from"] > $validator->validated()["to"]) {

            return json([
                "status" => "error",
                'message' => "لا يمكن ان يكون  الفاصل الزمني الثاني اكبر من الفاصل الزمني الاول",
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

    function edit(campaign $campaign)
    {
        $devices = device::all();
        $messages = message::all();
        $groups = group::all();



        return view("users/campaigns/edit", compact("devices", "messages", "groups", "campaign"));
    }

    function update(Request $request, campaign $campaign)
    {


        $data = $request->validate([
            'name' => 'required|string',
            'device_id' => 'required|integer',
            'message_id' => 'required|integer',
            'from' => 'required|integer',
            'to' => 'required|integer',
            'started_at' => 'required',
            "status" => "required|in:pending,stoped"
        ], [
            'device.required' => 'يرجي اخيار رقم',
            'message.required' => 'يرجي اخيار رسالة',
            'name.required' => 'يرجي كتابة اسم الحملة',
            'from.required' => 'يرجي كتابة الفاصل الزمني الاول',
            'to.required' => 'يرجي كتابة الفاصل الزمني الثاني',
            'started_at.required' => 'يرجي كتابة تاريخ بداية الحملة',

        ]);


        $device_id = device::find($data["device_id"]);
        $message_id = message::find($data["message_id"]);

        if (!$device_id) {
            return redirect()->back()->with("error", 'الرقم غير موجود');
        }
        if (!$message_id) {

            return redirect()->back()->with("error", 'الرسالة غير موجودة');
        }

        if ($data["from"] > $data["to"]) {
            return redirect()->back()->with("error", "لا يمكن ان يكون  الفاصل الزمني الثاني اكبر من الفاصل الزمني الاول");
        }

        try {

            $campaign->update($data);

            return redirect()->back()->with("success", "تم التعديل بنجاح");
        } catch (\Throwable $th) {

            return redirect()->back()->with("error", "لم يتم التعديل");
        }
    }

    public function changeOrder(Request $request)
    {

        campaignContact::where('id', $request->id)->update([
            'order' => $request->order + 1
        ]);

        return true;
    }


    public function update_contact(Request $request)
    {
        $data = $request->validate([
            "idInput" => "required|string",
            'nameInput' => 'nullable|string',
            'phoneInput' => 'required|string',
        ]);

        $data = collect($data)->mapWithKeys(function ($value, $key) {
            return [str_replace('Input', '', $key) => $value];
        })->toArray();

        $contact = campaignContact::findOrFail($data["id"]);
        $contact->update($data);
        return redirect()->back()->with("success", "تم التعديل بنجاح");
    }


    public function destroy(Request $request)
    {
        $contact = campaign::where("user_id", auth()->id())->findOrFail($request->delete_id);
        $contact->delete();
        return redirect()->back()->with("success", "تم الازالة بنجاح");
    }



    public function destroy_contact(Request $request)
    {
        $contact = campaignContact::where("user_id", auth()->id())->findOrFail($request->delete_id);
        $contact->delete();
        return redirect()->back()->with("success", "تم الازالة بنجاح");
    }


    public function store_new_contact(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'phone' => 'required|string',
            'campaign_id' => 'required|string',
        ]);

        $campaign = campaign::findOrFail($data["campaign_id"]);

        campaignContact::create($data);
        return redirect()->back()->with("success", "تم الاضافة بنجاح");
    }

    public function contacts_import(Request $request)
    {
        $data = $request->validate([
            'group_id' => 'required|string',
            'campaign_id' => 'required|string',
        ]);

        $campaign = campaign::findOrFail($data["campaign_id"]);
        $group = group::findOrFail($data["group_id"]);

        DB::beginTransaction();

        foreach ($group->contacts as $contact) {
            campaignContact::create([
                "campaign_id" => $data['campaign_id'],
                "name" =>  $contact->name ?? "",
                "phone" =>  $contact->phone,
            ]);
        }

        DB::commit();
        return redirect()->back()->with("success", "تم الاضافة بنجاح");
    }
}
