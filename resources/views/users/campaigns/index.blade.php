@extends('admin.layout')

@section('title')
    <title> الحملات الاعلانية</title>
@endsection

@section('content')
    <div class="content">

        <div class="actions border-0">

            <x-layout.back title="الحملات الاعلانية"></x-layout.back>


            <a href="/users/campaigns/create">
                <div>
                    <button type="button" class="es-btn-primary"> إضافة حملة جديدة <svg width="16px"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                        </svg>
                    </button>
                </div>
            </a>

        </div>

        <div class="tableSpace">
            <table id="sortable-table" class="mb-3">

                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>عدد الارقام</th>
                        <th>نجح</th>
                        <th>فشل</th>
                        <th>الحالة</th>
                        <th>الاجرءات</th>

                    </tr>
                </thead>

                <tbody class="clickable">

                    @forelse ($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->name }}</td>

                            <td>{{ $campaign->numbers_count }}</td>

                            <td> <span class="Delivered"
                                    style="font-weight: 900 ; font-size: 12px">{{ $campaign->success_count }}</span> </td>

                            <td> <span class="cancel"
                                    style="font-weight: 900 ; font-size: 12px">{{ $campaign->failed_count }}</span> </td>




                            @if ($campaign->status == 'complete')
                                <td><span class="Delivered">اكتملت</span></td>
                            @elseif($campaign->status == 'pending')
                                <td><span class="pindding">انتظار</span></td>
                            @elseif($campaign->status == 'running')
                                <td><span class="done">قيد الارسال</span></td>
                            @elseif($campaign->status == 'stoped')
                                <td><span class="pindding">متوقفة</span></td>
                            @endif

                            <x-td_end normal id="{{ $campaign->id }}" name="{{ $campaign->name }}">
                                <x-form.link style="height: 32px" target="_self" title="تعديل"
                                    path="users/campaigns/{{ $campaign->id }}/edit"></x-form.link>
                            </x-td_end>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="6">لا يوجد حملات مضافة</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>

        </div>
    </div>

    <x-form.delete title="الحملة الاعلانية" path="users/campaigns/destroy"></x-form.delete>

    <x-form.update_model path="users/groups">
        <div class="row g-2">
            <input type="hidden" name="idInput" id="idInput">
            <x-form.input id="nameInput" col="col-12" required name="nameInput"></x-form.input>
        </div>
    </x-form.update_model>
@endsection


@section('js')
    <script>
        $('aside .campaigns').addClass('active')
    </script>
@endsection
