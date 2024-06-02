@props(['id', 'title', 'path', 'img' , "static"])

<div class="modal fade" @isset($static)
data-bs-backdrop="static"
@endisset id="{{ $id }}"
    tabindex="-1" aria-labelledby="Label_{{ $id }}" aria-hidden="true">
    <div class="modal-dialog  ">
        <form class="modal-content" method="post" autocomplete="off" action="/{{ $path }}"
            @isset($img) enctype="multipart/form-data" @endisset>

            <div id="model_loader">
                <i class="fa-solid fa-spinner fa-spin"></i>
            </div>

            @csrf

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="Label_{{ $id }}">{{ $title }}</h1>

                <x-form.button type="button" icon="close" class="close" data-bs-dismiss="modal"
                    aria-label="Close"></x-form.button>

            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <x-form.button id="submitBtn" icon="plus" title="{{ $title }}"></x-form.button>
                <x-form.button class="close" type="button" data-bs-dismiss="modal" title="اغلاق"></x-form.button>
            </div>
        </form>
    </div>

</div>
