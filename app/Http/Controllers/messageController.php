<?php

namespace App\Http\Controllers;

use App\Models\message;
use Illuminate\Http\Request;

class messageController extends Controller
{
    function index()
    {
        $messages  = message::all();
        return view("users/messages/index", compact("messages"));
    }

    public function destroy(Request $request)
    {
        $message = message::findOrFail($request->delete_id);
        $message->delete();
        return redirect()->back()->with("success", "تم الازالة بنجاح");
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'message' => 'required|string',
        ]);
        message::create($data);
        return redirect()->back()->with("success", "تم الاضافة بنجاح");
    }

    public function update(Request $request)
    {

        $data = $request->validate([
            "idInput" => "required|string",
            'nameInput' => 'required|string',
            'messageInput' => 'required|string',
        ]);

        $data = collect($data)->mapWithKeys(function ($value, $key) {
            return [str_replace('Input', '', $key) => $value];
        })->toArray();

        $message = message::findOrFail($data["id"]);
        $message->update($data);
        return redirect()->back()->with("success", "تم التعديل بنجاح");
    }
}
