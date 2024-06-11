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



        {{-- <div class="tableSpace">
            <table id="sortable-table" class="mb-3">

                <tbody class="clickable">

                </tbody>
            </table>
        </div> --}}
    </div>
@endsection


@section('js')
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
    </script>
@endsection
