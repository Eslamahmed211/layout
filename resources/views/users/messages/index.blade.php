@extends('admin.layout')

@section('title')
    <title>الرسائل</title>
@endsection

@section('content')
    <div class="content">



        <div class="actions border-0">

            <x-layout.back title="الرسائل"></x-layout.back>

            <div class="d-flex gap-2">


                <x-cr_button title="إضافة رسالة"></x-cr_button>
            </div>
        </div>

        <div class="tableSpace">
            <table id="sortable-table" class="mb-3">

                <thead>
                    <tr>
                        <th>العنوان</th>
                        <th>الاجراءات</th>

                    </tr>
                </thead>

                <tbody class="clickable">

                    @forelse ($messages as $message)
                        <tr>
                            <td>{{ $message->name }}</td>

                            <x-td_end normal id="{{ $message->id }}" name="{{ $message->name }}">
                                <x-update_button data-id="{{ $message->id }}" data-message="{{ $message->message }}"
                                    data-name="{{ $message->name }}"></x-update_button>
                            </x-td_end>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="2">لا يوجد رسائل </td>
                        </tr>
                    @endforelse


                </tbody>
            </table>

        </div>
    </div>

    <x-form.create_model static id="createModel" title="اضافة رسالة " path="users/messages">
        <div class="row g-2">
            <x-form.input col="col-12 m-0" required label="العنوان" name="name">
            </x-form.input>


            <x-form.textarea class="hasEmogi" col="col-12" rows="8" required label="المحتوي" name="message">
                <div class="row gap-2">
                    <button onclick="option('*' , 'message')" type="button"
                        class="font_option es-btn-primary">Bold</button>
                    <button onclick="option('__' , 'message')" type="button"
                        class="font_option es-btn-primary">Italic</button>
                    <button onclick="option('~~' , 'message')" type="button"
                        class="font_option es-btn-primary">Strike</button>
                    <button onclick="addName('message')" type="button" class="font_option es-btn-primary">اسم
                        العميل</button>

                </div>


            </x-form.textarea>


        </div>
    </x-form.create_model>

    <x-form.delete title="جهة رسالة" path="users/messages/destroy"></x-form.delete>

    <x-form.update_model static path="users/messages">
        <div class="row g-2">
            <input type="hidden" name="idInput" id="idInput">
            <x-form.input id="nameInput" col="col-12" required name="nameInput"></x-form.input>


            <x-form.textarea class="hasEmogi" col="col-12" rows="8" required label="المحتوي" name="messageInput">

                <div class="row gap-2">
                    <button onclick="option('*' , 'messageInput')" type="button"
                        class="font_option es-btn-primary">Bold</button>
                    <button onclick="option('__' , 'messageInput')" type="button"
                        class="font_option es-btn-primary">Italic</button>
                    <button onclick="option('~~' , 'messageInput')" type="button"
                        class="font_option es-btn-primary">Strike</button>
                    <button onclick="addName('messageInput')" type="button" class="font_option es-btn-primary">اسم
                        العميل</button>
                </div>


            </x-form.textarea>


        </div>
    </x-form.update_model>
@endsection


@section('js')


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

    <script src="{{ asset('assets/admin/js/lc_emoji_picker.min.js') }}"></script>

    <script>
        $('aside .messages').addClass('active');

        function showUpdateModel(e) {
            $("#idInput").val(e.getAttribute('data-id'));
            $("#nameInput").val(e.getAttribute('data-name'));
            $("#messageInput").val(e.getAttribute('data-message'));
            checkAllForms();
            $('#updateModel').modal('show');
        }
    </script>

    <script>
        function option(option, textareaId) {
            var textarea = document.getElementById(textareaId);
            var text = textarea.value;
            var start = textarea.selectionStart;
            var end = textarea.selectionEnd;

            if (start !== end) {
                var selectedText = text.substring(start, end);
                var modifiedText = option + selectedText + option;
                textarea.value = text.substring(0, start) + modifiedText + text.substring(end);
                textarea.setSelectionRange(start, start + modifiedText.length);
            }
        }

        function addName(textareaId) {
            var textarea = document.getElementById(textareaId);
            textarea.value += "[[Name]]";
        }

        new lc_emoji_picker('.hasEmogi', {
            use_noto_emojis: true,
            selection_callback: function(emoji, target_field) {
                console.log(emoji, target_field);
            },
        });
    </script>

@endsection
