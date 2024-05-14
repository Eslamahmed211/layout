@props(['name', 'id', 'normal'])

<td >
    <div class="{{ isset($normal) ? 'd-flex justify-content-center ' : 'end' }}">
        {{ $slot }}
        <div data-name="{{ $name }}" data-id="{{ $id }}" data-bs-target="#deleteModel" type="button"
             data-bs-toggle="modal" onclick="delete_model(this)" data-tippy-content="حذف" class="square-btn ltr has-tip"><i
                    class="far fa-trash-alt mr-2 icon "></i>
        </div>
    </div>
</td>
