@extends('admin.layout')


@section('title')
<title>اعدادات الموقع</title>
@endsection




@section('content')
<div class="content">
    <form class="row form_style" action="/admin/settings" method="post" enctype="multipart/form-data">

        @csrf
        @method('put')

        <x-form.input required col="col-lg-4 col-6" name="websiteName" label="اسم الموقع"
            :value="settings('websiteName')"></x-form.input>

        <x-form.input class="form-control" col="col-lg-4 col-12" onchange="checkAllForms()" type="file" accept="image/*"
            label="لوجو الموقع" name="logo"></x-form.input>

        <x-form.input class="form-control" col="col-lg-4 col-12" onchange="checkAllForms()" type="file" accept="image/*"
            label="ايقونة الموقع" name="fav"></x-form.input>

    

        <x-form.input col="col-lg-3 col-6" name="facebook" label="صفحة الفيسبوك" :value="settings('facebook')">
        </x-form.input>

        <x-form.input col="col-lg-3 col-6" name="instagram" label="انستجرام" :value="settings('instagram')">
        </x-form.input>

        <x-form.input col="col-lg-3 col-6" name="twitter" label="تويتر ( X )" :value="settings('twitter')">
        </x-form.input>

        <x-form.input col="col-lg-3 col-6" name="tiktok" label="تيك توك" :value="settings('tiktok')"></x-form.input>

        <x-form.input col="col-lg-3 col-6" name="telegram" label="تليجرام" :value="settings('telegram')"></x-form.input>

        <div class="mt-2">
            <x-form.button id="submitBtn" title="تعديل"></x-form.button>
        </div>

    </form>
</div>
@endsection


@section('js')
<script>
    $('aside .settings').addClass('active');
</script>
@endsection
