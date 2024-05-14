@extends('admin.layout')


@section('title')
<title>الرئيسية</title>
@endsection



@section('content')
<div class="content">
    الرئيسية
</div>
@endsection


@section('js')

<script>
    $('aside .home').addClass('active');
</script>

@endsection
