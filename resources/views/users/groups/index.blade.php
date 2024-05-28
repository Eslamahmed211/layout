@extends('admin.layout')

@section('title')
    <title>جهات الاتصال</title>
@endsection

@section('content')
    <div class="content">

        <div class="actions border-0">

            <x-layout.back title="جهات الاتصال"></x-layout.back>

            <div class="d-flex gap-2">


                <x-cr_button title="إضافة جهة اتصال"></x-cr_button>
            </div>
        </div>

        <div class="tableSpace">
            <table id="sortable-table" class="mb-3">

                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>عدد الارقام</th>
                        <th>الاجراءات</th>

                    </tr>
                </thead>

                <tbody class="clickable">

                    @forelse ($groups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>

                            <td><a href="/users/groups/{{$group->id}}/contacts">{{ count($group->contacts) }}</a></td>

                            <x-td_end normal id="{{ $group->id }}" name="{{ $group->name }}">
                                <x-update_button data-id="{{ $group->id }}"
                                    data-name="{{ $group->name }}"></x-update_button>
                            </x-td_end>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="3">لا يوجد جهات اتصال</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>

        </div>
    </div>

    <x-form.create_model id="createModel" title="اضافة جهة اتصال" path="users/groups">
        <div class="row g-2">
            <x-form.input col="col-12" required label="الاسم" name="name">
            </x-form.input>
        </div>
    </x-form.create_model>

    <x-form.delete title="جهة الاتصال" path="users/groups/destroy"></x-form.delete>

    <x-form.update_model path="users/groups">
        <div class="row g-2">
            <input type="hidden" name="idInput" id="idInput">
            <x-form.input id="nameInput" col="col-12" required name="nameInput"></x-form.input>
        </div>
    </x-form.update_model>
@endsection


@section('js')


    @if ($errors->any())
        @if ($errors->has('idInput'))
            <script>
                $(document).ready(function() {
                    $('#updateModel').modal('show');
                });
            </script>
        @else
            <script>
                $(document).ready(function() {
                    $('#createModel').modal('show');
                });
            </script>
        @endif
    @endif


    <script>
        $('aside .contacts').addClass('active');

        function showUpdateModel(e) {
            $("#idInput").val(e.getAttribute('data-id'));
            $("#nameInput").val(e.getAttribute('data-name'));
            checkAllForms();
            $('#updateModel').modal('show');
        }
    </script>

@endsection
