@extends('admin.layout')


@section('title')
    <title>ارسال فردي</title>

    <style>
        #loader {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 9;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            font-size: 40px;
            color: var(--mainColor);
            align-items: center;
            display: none
        }
    </style>
@endsection


@section('content')
    <div class="content">
        <form class="row form_style  position-relative">

            <div id="loader">
                <i class="fa-solid fa-spinner fa-spin"></i>
            </div>


            <x-form.select required col="col-lg-3 col-6" name="device" label="اختيار الرقم">
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.select required col="col-lg-3 col-6" name="message" label="اختيار الرسالة">
                @foreach ($messages as $message)
                    <option value="{{ $message->id }}">{{ $message->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.input name="to" required type="number" label="رقم المرسل اليه مع كود المحافظة"></x-form.input>

            <x-form.button onclick="send()" id="submitBtn" type="button" title="ارسال"></x-form.button>
        </form>


    </div>
@endsection


@section('js')
    <script>
        $('aside .send').addClass('active');
        $('.modelSelect').select2()

        function send() {

            let device = $("#device").val();
            let message = $("#message").val();
            let to = $("#to").val();

            if (device === "" || message === "" || to === "") {
                Swal.fire({
                    title: 'خطا!',
                    text: "يرجي ملئ جميع الحقول",
                    icon: 'error',
                    confirmButtonText: 'فهمت'
                })
            } else {

                $.ajax({
                    url: "/users/sent-single-message",
                    type: "POST",
                    data: {
                        device: device,
                        message: message,
                        to: to
                    },
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-Token',
                            "{{ csrf_token() }}");

                        $("#loader").addClass("d-flex");
                        $("#loader").removeClass("d-none");
                    },
                    success: function(data) {

                        $("#loader").addClass("d-none");
                        $("#loader").removeClass("d-flex");


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

                        $("#loader").addClass("d-none");
                        $("#loader").removeClass("d-flex");

                        Swal.fire({
                            title: 'خطا!',
                            text: 'هناك خطأ ما اثناء الارسال ',
                            icon: 'error',
                            confirmButtonText: 'فهمت'
                        })
                    }
                });
            }
        }
    </script>
@endsection
