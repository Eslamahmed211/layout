@extends('admin.layout')

@section('title')
    <title> ارقام {{ $group->name }}</title>
@endsection

@section('content')
    <div class="content">

        <div class="actions border-0">

            <x-layout.back back="users/groups" title="ارقام {{ $group->name }} ( {{ count($contacts) }} )"></x-layout.back>

            <div class="d-flex gap-2">
                <x-form.button class="default" onclick="showUpload()" icon="upload" type="button"
                    title="استيراد ارقام"></x-form.button>

                <x-form.link path="users/groups/{{ $group->id }}/export" icon="excel" title="تصدير"></x-form.link>


                <x-cr_button title="إضافة رقم جديد"></x-cr_button>
            </div>
        </div>

        <div class="tableSpace">
            <table id="sortable-table" class="mb-3">

                <thead>
                    <tr>
                        <Th>#</Th>
                        <th>الرقم</th>
                        <th>الاسم</th>
                        <th>الاجراءات</th>

                    </tr>
                </thead>

                <tbody class="clickable">

                    @forelse ($contacts as $contact)
                        <tr>
                            <td>
                                <x-icons.move></x-icons.move>{{ $contact->order }}
                            </td>

                            <td>
                                {{ $contact->phone }}
                            </td>

                            <input type="hidden" value="{{ $contact->id }}" class="ids">


                            <td>{{ $contact->name }}</td>

                            <x-td_end normal id="{{ $contact->id }}" name="{{ $contact->name }}">
                                <x-update_button data-id="{{ $contact->id }}" data-name="{{ $contact->name }}"
                                    data-phone="{{ $contact->phone }}"></x-update_button>
                            </x-td_end>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="4">لا يوجد ارقام</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>

            @if ($contacts->isNotEmpty())
                <x-form.button onclick="UpdateOrder()" title="تغير الترتيب"></x-form.button>
            @endif
        </div>
    </div>

    <x-form.create_model id="createModel" title="اضافة رقم جديد" path="users/contacts">
        <div class="row g-2">
            <x-form.input col="col-12" label="الاسم" name="name"></x-form.input>

            <input type="hidden" name="group_id" value="{{ $group->id }}">
            <x-form.input col="col-12" required placeholder="2010xxxxxxx" label="الرقم مع كود المحافظة"
                name="phone"></x-form.input>

        </div>
    </x-form.create_model>

    <x-form.delete title="الرقم" path="users/contacts/destroy"></x-form.delete>

    <x-form.update_model path="users/contacts">
        <div class="row g-2">
            <input type="hidden" name="idInput" id="idInput">
            <x-form.input id="nameInput" label="الاسم" col="col-12" name="nameInput"></x-form.input>
            <x-form.input id="phoneInput" label="الرقم مع كود المحافظة" col="col-12" required
                name="phoneInput"></x-form.input>

        </div>
    </x-form.update_model>
@endsection


@section('js')


    <x-move type="users" model="contacts"></x-move>


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
            $("#phoneInput").val(e.getAttribute('data-phone'));
            $('#updateModel').modal('show');
            checkAllForms();
        }

        function showUpload() {
            Swal.fire({
                title: 'استيراد ارقام',
                html: `
            <form id="uploadForm" method="POST" action="/users/groups/{{ $group->id }}/upload_contacts_file" enctype="multipart/form-data">
                <input type="file" name="file" accept=".csv,text/plain" id="fileInput" class="swal2-file-input form-control" required>
                <a href="/example/ارقام.csv" download>تحميل نموذج</a>

                @csrf
            </form>
        `,
                showCancelButton: true,
                confirmButtonText: 'استرداد',
                cancelButtonText: 'اغلاق',
                preConfirm: () => {
                    const fileInput = Swal.getPopup().querySelector('#fileInput');
                    if (!fileInput.files.length) {
                        Swal.showValidationMessage('من فضلك اختار ملف');
                        return false;
                    }
                    return true;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    const uploadForm = document.getElementById('uploadForm');
                    uploadForm.submit();
                }
            });
        }
    </script>


@endsection
