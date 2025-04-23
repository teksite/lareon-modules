@props(['model' ,'offset'=>0 ,'limit'=>5])
<div class="flex justify-center mt-6">
    <x-lareon::button.outline type="button"  role="button" id="moreComment" class="text-sm load_more load_more-comment" data-destination="{{route('ajax.client.more.comments')}}" data-target="listComment" data-bind="{{encrypt(get_class($model))}}" data-identify="{{encrypt($model->id)}}">
            {{__('see the rest of comments')}}
    </x-lareon::button.outline>
</div>
