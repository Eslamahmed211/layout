@extends('admin.layout')


@section('title')
    <title>الحملات الاعلانية</title>
@endsection



@section('content')
    <div class="content">

        <div class="actions border-0">
            <x-layout.back back="users/campaigns" title="الحملات الاعلانية"></x-layout.back>
        </div>

        <form class="row form_style">

            <x-form.input label="اسم الحملة" name="name" required col="col-lg-2 col-6"></x-form.input>


            <x-form.select required col="col-lg-2 col-6" name="device_id" label="اختيار الرقم">
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.select required col="col-lg-2 col-6" name="message_id" label="اختيار الرسالة">
                @foreach ($messages as $message)
                    <option value="{{ $message->id }}">{{ $message->name }}</option>
                @endforeach
            </x-form.select>



            <x-form.input label="الفاصل الزمن من " name="from" required col="col-lg-2 col-6" placeholder="بالثواني"
                type="number"></x-form.input>

            <x-form.input label="الفاصل الزمن الي " placeholder="بالثواني" type="number" name="to" required
                col="col-lg-2 col-6"></x-form.input>


            <x-form.input class="date checkThis" dir="rtl" label="تاريخ بداية الحملة" name="started_at" required
                col="col-lg-2 col-6"></x-form.input>

            <x-form.button onclick="send()" id="submitBtn" type="button" title="حفظ الحملة "></x-form.button>
        </form>



        <div class="actions border-0">

            <div class="d-flex align-items-center">


                <h1 class="contnet-title"> الارقام </h1>

            </div>

            <div class="d-flex gap-2">


                <div class="d-flex gap-2 justify-content-end">
                    <button class="es-btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createModel">
                        إضافة رقم
                        <svg width="16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                        </svg>

                    </button>

                    <button class="es-btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#importFromGroup">
                        استرداد جهة اتصال
                    </button>



                </div>
            </div>
        </div>

        <div class="tableSpace">
            <table id="sortable-table" class="mb-3">

                <tbody class="clickable">

                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="createModel" tabindex="-1" aria-labelledby="Label_createModel" aria-hidden="true">
        <div class="modal-dialog  ">
            <form class="modal-content">

                <div id="model_loader">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                </div>

                @csrf

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="Label_createModel">اضافة رقم جديد</h1>

                    <x-form.button type="button" icon="close" class="close" data-bs-dismiss="modal"
                        aria-label="Close"></x-form.button>

                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <x-form.input col="col-12" label="الاسم" name="name"></x-form.input>

                        <x-form.input col="col-12" required placeholder="2010xxxxxxx" label="الرقم مع كود المحافظة"
                            name="phone"></x-form.input>

                    </div>
                </div>
                <div class="modal-footer">
                    <x-form.button type="button" onclick="addManualRow()" id="submitBtn" icon="plus"
                        title="اضافة رقم جديد"></x-form.button>
                    <x-form.button class="close" type="button" data-bs-dismiss="modal" title="اغلاق"></x-form.button>
                </div>
            </form>
        </div>

    </div>


    <div class="modal fade" id="importFromGroup" tabindex="-1" aria-labelledby="LabelimportFromGroup" aria-hidden="true">
        <div class="modal-dialog  ">
            <form class="modal-content">

                <div id="model_loader">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                </div>

                @csrf

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="Label_importFromGroup"> استرداد جهة اتصال</h1>

                    <x-form.button type="button" icon="close" class="close" data-bs-dismiss="modal"
                        aria-label="Close"></x-form.button>

                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <x-form.select required col="col-lg-12" name="group_id" label="اختيار جهة الاتصال">
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </x-form.select>

                    </div>
                </div>
                <div class="modal-footer">
                    <x-form.button type="button" onclick="importFromGroup()" id="submitBtn" icon="plus"
                        title="استرداد"></x-form.button>
                    <x-form.button class="close" type="button" data-bs-dismiss="modal" title="اغلاق"></x-form.button>
                </div>
            </form>
        </div>

    </div>
@endsection


@section('js')
    <x-move type="users" model="contacts"></x-move>


    <script>
        $('aside .campaigns').addClass('active');
        $('.modelSelect').select2()


        $('#importFromGroup .modelSelect').select2({
            dropdownParent: $('#importFromGroup .modal-content')
        });

        flatpickr('input.date', {
            enableTime: true,
            dateFormat: "Y-m-d h:i",
            minDate: "today",

            onChange: function(selectedDates, dateStr, instance) {
                checkUseDate();
            }
        });

        function send() {

            let formDataObj = {};
            new FormData(document.querySelector("form")).forEach((value, key) => {
                formDataObj[key] = value;
            });


            let numbers = [];

            document.querySelectorAll(".tableSpace tr.contact").forEach(function(tr) {
                numbers.push({
                    name: tr.querySelector(".td_name").textContent.trim(),
                    phone: tr.querySelector(".td_phone").textContent.trim()
                });
            });

            let dataToSend = {
                formData: formDataObj,
                numbers: numbers
            };

            $.ajax({
                type: "POST",
                url: "/users/campaigns",
                data: dataToSend,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-Token',
                        "{{ csrf_token() }}");
                },
                success: function(data) {

                    if (data.status == "error") {
                        Swal.fire({
                            title: 'خطا!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'فهمت'
                        })
                    } else if (data.status == "success") {
                        Swal.fire({
                            title: 'تم',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'فهمت'
                        })
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'خطا!',
                        text: 'هناك خطأ ما ',
                        icon: 'error',
                        confirmButtonText: 'فهمت'
                    })
                }
            });
        }


        function deleteRow(e) {
            var row = $(e).closest('tr');
            if (row) {
                row.remove();
            }
        }


        function addManualRow() {
            let name = $("#createModel #name").val();
            let phone = $("#createModel #phone").val();


            let cartona = `<tr class="contact">
                        <td>
                            <x-icons.move></x-icons.move> 
                        </td>

                        <td class="td_phone">
                        ${phone}
                        </td>


                        <td class="td_name">${name}</td>

                        <td>
                            <div onclick="deleteRow(this)" data-tippy-content="حذف" class="square-btn delete-btn ltr has-tip"><i
                                    class="far fa-trash-alt mr-2 icon "></i>
                            </div>
                        </td>


                    </tr>`

            $("tbody").append(cartona);

            $("#createModel #name").val("");
            $("#createModel #phone").val("");

            $("#createModel").modal('hide');


        }

        function importFromGroup() {
            let group_id = $("#group_id").val()


            $.ajax({
                type: "get",
                url: `/users/groups/${group_id}`,
                success: function(data) {

                    if (data.status == "error") {
                        Swal.fire({
                            title: 'خطا!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'فهمت'
                        })
                    } else if (data.status == "success") {
                        let contacts = data.data;

                        let cartona = ``;

                        contacts.forEach(element => {
                            cartona += `<tr class="contact">
                        <td>
                            <x-icons.move></x-icons.move> 
                        </td>

                        <td class="td_phone">
                        ${element.phone}
                        </td>


                        <td class="td_name">${element.name}</td>

                        <td>
                            <div onclick="deleteRow(this)" data-tippy-content="حذف" class="square-btn delete-btn ltr has-tip"><i
                                    class="far fa-trash-alt mr-2 icon "></i>
                            </div>
                        </td>


                    </tr>`


                        });

                        $("tbody").append(cartona);
                        $("#importFromGroup").modal('hide');




                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'خطا!',
                        text: 'هناك خطأ ما ',
                        icon: 'error',
                        confirmButtonText: 'فهمت'
                    })
                }
            });

        }
    </script>
@endsection
