@extends('admin.layout')


@section('title')
    <title>الصلاحيات</title>
@endsection

@section('nav_title')
    <x-layout.back title="الصلاحيات"></x-layout.back>
@endsection


@section('css')
    <style>
        form .role {
            display: flex;
            align-items: center;
            column-gap: 20px;
            border-bottom: 1px solid #dddddd;
            padding: 10px;
        }

        .action2,
        .master {
            display: flex;
            align-items: center;
            column-gap: 10px;

        }

        .master label {
            margin: 0px;
            font-size: 14px;
            font-weight: 500;
        }


        .role label {
            margin: 0px;
            font-size: 15px;
        }
    </style>
@endsection


@section('content')
    <div class="content">

        <div class="actions border-0">

            <div class="d-flex align-items-center">

                <h1 class="contnet-title">الصلاحيات</h1>

            </div>

            <div class="d-flex gap-2">

                <div class="d-flex justify-content-end">
                    <x-cr_button title="إضافة صلاحية"></x-cr_button>


                </div>
            </div>
        </div>




        <div class="tableSpace">
            <table>

                <tbody>

                @forelse ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>

                        <x-td_end   id="{{ $role->id }}" name="{{ $role->name }}">
                            <x-form.link style="height: 32px" target="_self" title="تعديل"
                                         path="admin/roles/{{ $role->id }}/edit"></x-form.link>
                        </x-td_end>

                    </tr>
                @empty

                    <tr>
                        <td colspan="1">لا يوجد صلاحيات مضافة</td>
                    </tr>
                @endforelse


                </tbody>
            </table>

        </div>


    </div>

    <x-form.create_model id="createModel" title="اضافة صلاحية جديدة" path="admin/roles">
        <div>
            <x-form.input col="col-12" required label="اسم الصلاحية" name="name"
                          placeHolder="مثال : خدمة العملاء "></x-form.input>

            <div class="col-12">

                <div id="AdminRoles" class="mt-3">
                    <p class="contnet-title d-flex align-items-center m-0">
                        <label for="all"> الصلاحيات كاملة </label>
                        <input class="mx-2" onchange="allCheckedAdmin(this)" id="all" type="checkbox">
                    </p>
                    <div class="tree">
                        @foreach (config('adminRoles.permissions') as $rolee => $actions)
                            <div class="role">
                                <div class="master">
                                    @if (is_array($actions))
                                        <input type="checkbox" id="{{ $rolee }}" class="master-checkbox"
                                               onchange="toggleSubPermissions(this)">
                                        <label for="{{ $rolee }}">{{ $rolee }}</label>
                                        <div class="sub-permissions">
                                            @foreach ($actions as $subAction => $subActionValue)
                                                <div class="sub-role">
                                                    <input name="permissions[]" value="{{ $subActionValue }}"
                                                           type="checkbox" id="{{ $subActionValue }}"
                                                           class="sub-checkbox">
                                                    <label for="{{ $subActionValue }}">{{ $subAction }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <input name="permissions[]" value="{{ $actions }}" type="checkbox"
                                               id="{{ $actions }}" class="master-checkbox">
                                        <label for="{{ $actions }}">{{ $rolee }}</label>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </x-form.create_model>

    <x-form.delete title="الصلاحية" path="admin/roles/destroy"></x-form.delete>
@endsection


@section('js')
    @if ($errors->any())
        <script>
            $(document).ready(function () {
                $('#createModel').modal('show');
            });
        </script>
    @endif

    <script>
        $('aside .roles').addClass('active');

        function allCheckedAdmin(e) {
            $('#AdminRoles input:checkbox').not(e).prop('checked', e.checked);
        }

        function toggleSubPermissions(masterCheckbox) {
            var subPermissions = masterCheckbox.parentElement.querySelector('.sub-permissions').querySelectorAll(
                '.sub-checkbox');
            for (var i = 0; i < subPermissions.length; i++) {
                subPermissions[i].checked = masterCheckbox.checked;
            }
        }
    </script>
@endsection
