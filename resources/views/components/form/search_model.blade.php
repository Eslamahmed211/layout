@props(['id', "path" ])

<div class="modal fade" id="searchModel" tabindex="-1" aria-labelledby="Label_searchModel" aria-hidden="true">
    <div class="modal-dialog ">
        <form  class="modal-content" method="get" autocomplete="off" action="/{{$path}}">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="Label_searchModel">تصفية النتائج</h1>

                <x-form.button type="button" icon="close" class="close" data-bs-dismiss="modal" aria-label="Close"></x-form.button>

            </div>
            <div class="modal-body mt-1 row " style="padding: 10px 5px">
                {{$slot}}
            </div>
            <div class="modal-footer">
                <x-form.button title="تصفية وبحث"></x-form.button>
                <x-form.button class="close" type="button" data-bs-dismiss="modal" title="اغلاق"></x-form.button>
            </div>
        </form>
    </div>
</div>

