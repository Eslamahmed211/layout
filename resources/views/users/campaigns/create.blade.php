@extends('admin.layout')


@section('title')
    <title>ارسال فردي</title>
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
    </div>
@endsection


@section('js')
    <script>
        $('aside .campaigns').addClass('active');
        $('.modelSelect').select2()

        flatpickr('input.date', {
            enableTime: true,
            dateFormat: "Y-m-d h:i",
            minDate: "today",

            onChange: function(selectedDates, dateStr, instance) {
                checkUseDate();
            }
        });

        function send() {

            var formData = $("form").serialize();

            $.ajax({
                type: "POST",
                url: "/users/campaigns",
                data: formData,
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



            // if (device === "" || message === "" || to === "") {
            //     Swal.fire({
            //         title: 'خطا!',
            //         text: "يرجي ملئ جميع الحقول",
            //         icon: 'error',
            //         confirmButtonText: 'فهمت'
            //     })
            // } else {

            //     $.ajax({
            //         url: "/users/sent-single-message",
            //         type: "POST",
            //         data: {
            //             device: device,
            //             message: message,
            //             to: to
            //         },
            //         beforeSend: function(xhr) {
            //             xhr.setRequestHeader('X-CSRF-Token',
            //                 "{{ csrf_token() }}");
            //         },
            //         success: function(data) {

            //             if (data.status == "error") {
            //                 Swal.fire({
            //                     title: 'خطا!',
            //                     text: data.message,
            //                     icon: 'error',
            //                     confirmButtonText: 'فهمت'
            //                 })
            //             } else if (data.status == "success") {
            //                 Swal.fire({
            //                     title: 'تم',
            //                     text: data.message,
            //                     icon: 'success',
            //                     confirmButtonText: 'فهمت'
            //                 })
            //             }


            //         },
            //         error: function(xhr, status, error) {
            //             Swal.fire({
            //                 title: 'خطا!',
            //                 text: 'هناك خطأ ما ',
            //                 icon: 'error',
            //                 confirmButtonText: 'فهمت'
            //             })
            //         }
            //     });
            // }
        }
    </script>
@endsection
