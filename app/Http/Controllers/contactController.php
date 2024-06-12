<?php

namespace App\Http\Controllers;

use App\Exports\contactExport;
use App\Imports\contactImport;
use App\Models\contact;
use App\Models\group;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class contactController extends Controller
{
    function index()
    {
        $groups  = group::all();
        return view("users/groups/index", compact("groups"));
    }

    function show(group $group)
    {
        return json(["status" => "success", "data" => $group->contacts]);
    }


    public function destroy(Request $request)
    {
        $group = group::findOrFail($request->delete_id);
        $group->delete();
        return redirect()->back()->with("success", "تم الازالة بنجاح");
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        group::create($data);
        return redirect()->back()->with("success", "تم الاضافة بنجاح");
    }

    public function update(Request $request)
    {

        $data = $request->validate([
            "idInput" => "required|string",
            'nameInput' => 'required|string',
        ]);

        $data = collect($data)->mapWithKeys(function ($value, $key) {
            return [str_replace('Input', '', $key) => $value];
        })->toArray();

        $group = group::findOrFail($data["id"]);
        $group->update($data);
        return redirect()->back()->with("success", "تم التعديل بنجاح");
    }

    function contacts_index(group $group)
    {
        $contacts  =  $group->contacts;

        return view("users/groups/contacts", compact("contacts", "group"));
    }

    public function destroy_contact(Request $request)
    {
        $contact = contact::where("user_id", auth()->id())->findOrFail($request->delete_id);
        $contact->delete();
        return redirect()->back()->with("success", "تم الازالة بنجاح");
    }
    public function store_contact(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string',
            'phone' => 'required|string',
            "group_id" => 'required|integer'
        ]);
        contact::create($data);
        return redirect()->back()->with("success", "تم الاضافة بنجاح");
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

        $contact = contact::findOrFail($data["id"]);
        $contact->update($data);
        return redirect()->back()->with("success", "تم التعديل بنجاح");
    }



    function upload_contacts_file(group $group, Request $request)
    {
        $data = $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        Excel::import(new contactImport($group->id), $data["file"]);
        return redirect()->back()->with('success', "تم الاسترداد بنجاح");
    }

    function export(group $group)
    {
        $data = $group->contacts;

        $file_name = " ارقام " . $group->name . ".xlsx";
        return Excel::download(new contactExport($data), $file_name);
    }


    public function changeOrder(Request $request)
    {
        contact::where('id', $request->id)->update([
            'order' => $request->order + 1
        ]);
        return true;
    }
}
