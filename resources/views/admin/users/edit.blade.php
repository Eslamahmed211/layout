@extends('admin.layout')


@section('title')
    <title>تعديل {{ $user->name }}</title>
@endsection





@section('content')
    <div class="content">

        <div class="actions border-0" >
            <x-layout.back  back="admin/users" title=" تعديل {{ $user->name }}"></x-layout.back>
        </div>


        <form class="row form_style" action="/admin/users/{{ $user->id }}" method="post">

            @csrf
            @method('put')


            <x-form.input col="col-lg-3 col-12" required label="اسم المستخدم" name="name" placeHolder="مثال : اسلام احمد "
                value="{{ $user->name }}"></x-form.input>

            <x-form.input col="col-lg-3 col-12" type="email" disabled label="ايميل المستخدم" name="email"
                placeHolder="مثال :eslam@gmail.com " value="{{ $user->email }}"></x-form.input>

            <x-form.input col="col-lg-3 col-12" type="password" label="كلمة السر" name="password"></x-form.input>

            <x-form.input col="col-lg-3 col-12" type="password" label="تاكيد كلمة السر" name="password_confirmation">
            </x-form.input>


            <div class="col-lg-3 col-12 group " id="role_id">
                <label for="role_id" class="mb-2">الصلاحية<span class="text-danger">*</span>
                </label>
                <select name="role_id" class="js-example-basic-single">
                    @foreach ($roles as $role)
                        <option @selected($user->role_id == $role->id) value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-lg-3 col-12 group ">
                <label for="active" class="mb-2">حالة الحساب<span class="text-danger">*</span>
                </label>
                <select name="active" class="js-example-basic-single">
                    <option @selected($user->active == '1') value="1">نشط</option>
                    <option @selected($user->active == '0') value="0">غير نشط</option>
                </select>
            </div>



            <div class="col-12 mt-3">
                <x-form.button id="submitBtn" title="تعديل"></x-form.button>
            </div>
        </form>
    </div>
@endsection


@section('js')
    <script>
        $('aside .users').addClass('active');
        $('.js-example-basic-single').select2();

        function check_role(e) {
            if (e.value == "admin") {
                $("#role_id").css("display", "flex");
            } else {
                $("#role_id").css("display", "none");
            }
        }
    </script>
@endsection
