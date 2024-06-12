@extends('admin.layout')


@section('title')
    <title>الحملات الاعلانية</title>
@endsection



@section('content')
    <div class="content">

        <div class="actions border-0">
            <x-layout.back back="users/campaigns" title="الحملات الاعلانية"></x-layout.back>
        </div>

        <form class="row form_style" method="post" action="/users/campaigns/{{ $campaign->id }}">

            @csrf
            @method('PUT')

            <x-form.input label="اسم الحملة" name="name" required col="col-lg-2 col-6"
                value="{{ $campaign->name }}"></x-form.input>


            <x-form.select required col="col-lg-2 col-6" name="device_id" label="اختيار الرقم">
                @foreach ($devices as $device)
                    <option @selected($device->id == $campaign->device_id) value="{{ $device->id }}">{{ $device->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.select required col="col-lg-2 col-6" name="message_id" label="اختيار الرسالة">
                @foreach ($messages as $message)
                    <option @selected($message->id == $campaign->message_id) value="{{ $message->id }}">{{ $message->name }}</option>
                @endforeach
            </x-form.select>



            <x-form.input label="الفاصل الزمن من " name="from" required col="col-lg-2 col-6" placeholder="بالثواني"
                type="number" value="{{ $campaign->from }}"></x-form.input>

            <x-form.input label="الفاصل الزمن الي" placeholder="بالثواني" type="number" name="to" required
                col="col-lg-2 col-6" value="{{ $campaign->to }}"></x-form.input>


            <x-form.input class="date checkThis" dir="rtl" label="تاريخ بداية الحملة" name="started_at" required
                col="col-lg-2 col-6" value="{{ $campaign->started_at }}"></x-form.input>


            <x-form.select required col="col-lg-2 col-6" name="status" label="تغير حالة الحملة الي">
                <option @selected($campaign->status == 'pending') value="pending">انتظار</option>
                <option @selected($campaign->status == 'stoped') value="stoped">ايقاف</option>

            </x-form.select>

            <x-form.button title="تعديل الحملة "></x-form.button>
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

                <thead>
                    <tr>
                        <th>#</th>
                        <th>الرقم</th>
                        <th>الاسم</th>
                        <th>الحالة</th>
                        <th>اجراءات</th>
                    </tr>
                </thead>

                <tbody class="clickable">
                    @foreach ($campaign->numbers as $number)
                        <tr class="contact">
                            <td>
                                <x-icons.move></x-icons.move> {{ $loop->index += 1 }}
                            </td>

                            <td class="td_phone">
                                {{ $number->phone }}
                            </td>

                            <input type="hidden" value="{{ $number->id }}" class="ids">


                            <td class="td_name">{{ $number->name }}</td>

                            @if ($number->status == 'pending')
                                <td><span class="pindding">انتظار</span></td>
                            @elseif($number->status == 'success')
                                <td><span class="Delivered">نجح</span></td>
                            @elseif($number->status == 'failed')
                                <td><span class="cancel">فشل</span></td>
                            @elseif($number->status == 'sending')
                                <td><span class="blue">قيد الارسال</span></td>
                            @endif

                            <x-td_end normal id="{{ $number->id }}" name="{{ $number->name }}">

                                <x-update_button data-id="{{ $number->id }}" data-name="{{ $number->name }}"
                                    data-phone="{{ $number->phone }}"></x-update_button>
                            </x-td_end>




                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-form.button onclick="UpdateOrder()" title="تغير الترتيب"></x-form.button>
    </div>

    <x-form.update_model path="users/campaigns/update_contact">
        <div class="row g-2">
            <input type="hidden" name="idInput" id="idInput">
            <x-form.input id="nameInput" label="الاسم" col="col-12" name="nameInput"></x-form.input>
            <x-form.input id="phoneInput" label="الرقم مع كود المحافظة" col="col-12" required
                name="phoneInput"></x-form.input>

        </div>
    </x-form.update_model>

    <x-form.delete title="الرقم" path="users/campaigns/contacts/destroy"></x-form.delete>



    <div class="modal fade" id="createModel" tabindex="-1" aria-labelledby="Label_createModel" aria-hidden="true">
        <div class="modal-dialog  ">
            <form class="modal-content" method="post" action="/users/campaigns/contacts">

                <div id="model_loader">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                </div>


                <input type="hidden" value="{{ $campaign->id }}" name="campaign_id">


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
                    <x-form.button id="submitBtn" icon="plus" title="اضافة رقم جديد"></x-form.button>
                    <x-form.button class="close" type="button" data-bs-dismiss="modal" title="اغلاق"></x-form.button>
                </div>
            </form>
        </div>

    </div>

    <div class="modal fade" id="importFromGroup" tabindex="-1" aria-labelledby="LabelimportFromGroup"
        aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="/users/campaigns/contacts_import">

                <input type="hidden" value="{{ $campaign->id }}" name="campaign_id">


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
                    <x-form.button id="submitBtn" icon="plus" title="استرداد"></x-form.button>
                    <x-form.button class="close" type="button" data-bs-dismiss="modal" title="اغلاق"></x-form.button>
                </div>
            </form>
        </div>

    </div>
@endsection


@section('js')
    <x-move type="users" model="campaigns/updateNumber"></x-move>



    <script>
        $('aside .campaigns').addClass('active');
        $('.modelSelect').select2()


        flatpickr('input.date', {
            enableTime: true,
            time_24hr: false,
            minDate: "today",

            onChange: function(selectedDates, dateStr, instance) {
                checkUseDate();
            }
        });


        function showUpdateModel(e) {
            $("#idInput").val(e.getAttribute('data-id'));
            $("#nameInput").val(e.getAttribute('data-name'));
            $("#phoneInput").val(e.getAttribute('data-phone'));
            $('#updateModel').modal('show');
            checkAllForms();
        }
    </script>
@endsection
