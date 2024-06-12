@extends('admin.layout')


@section('css')
    <style>
        /* Override the direction for the carousel */
        #carousel {
            direction: rtl !important;
        }

        .count {
            padding: 20px;
            border-radius: 8px;
            box-shadow: rgb(228, 231, 236) 0px 0px 1px 1px, rgba(29, 41, 57, 0.05) 0px 4px 4px;
            background-color: rgb(255, 255, 255);
            display: flex;
            justify-content: space-between;

        }

        .title {
            margin-bottom: 4px;
            border-bottom: 1px dotted rgb(208, 213, 221);
            color: rgb(102, 112, 133);
            width: fit-content;
            padding-bottom: 5px;
            font-weight: 500
        }

        .icone {
            background-color: rgb(239, 248, 255);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
        }

        .icone svg {
            width: 24px;
            height: 24px;
        }

        .count .number {
            font-size: 20px;
            line-height: 28px;
            letter-spacing: 0px;
            font-weight: 700;
        }

        .d {
            display: flex;

        }

        .d {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .item {
            width: calc(20% - 15px) !important;
        }

        @media (max-width:993px) {

            .d {
                justify-content: center;
            }

            .item {
                width: calc(50% - 15px) !important;
            }
        }

        @media (max-width:767px) {

            .d {
                justify-content: center;
            }

            .item {
                width: calc(100% - 15px) !important;
            }
        }
    </style>
@endsection


@section('title')
    <title>الرئيسية</title>
@endsection



@section('content')
    <div class="d my-4 content">

        <x-count notClick=true title="اجمالي الحملات" count="{{ count($all) }} " color="rgb(249, 250, 251)">
            <i class="fa-regular fa-paper-plane"></i>
        </x-count>

        <x-count notClick=true title=" الارقام في الحملات" count="{{ $all->sum('numbers_count') }} "
            color="rgb(249, 250, 251)">
            <i class="fa-solid fa-hashtag"></i>
        </x-count>


        <x-count notClick=true title="في الانتظار" count="{{ $all->sum('pending_count') }} رقم " color="rgb(249, 250, 251)">
            <i class="fa-regular fa-clock fa-fw"></i>
        </x-count>


        <x-count notClick=true title="جاري الارسال" count="{{ $all->sum('sending_count') }} رقم "
            color="rgb(249, 250, 251)">
            <i class="fa-regular fa-paper-plane"></i>
        </x-count>

        <x-count notClick=true title="تم ارسال" count="{{ $all->sum('success_count') }} رقم " color="rgb(249, 250, 251)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#039855"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg> </x-count>

        <x-count notClick=true title="فشل الارسال" count="{{ $all->sum('failed_count') }} رقم " color="rgb(249, 250, 251)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="rgb(236, 74, 10)" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </x-count>


        <x-count notClick=true title="اجمالي الارقام" count="{{ $contact_count }} " color="rgb(249, 250, 251)">
            <i class="fa-solid fa-hashtag"></i>
        </x-count>

    </div>
@endsection


@section('js')
    <script>
        $('aside .home').addClass('active');
    </script>
@endsection
