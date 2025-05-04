<div  id="{{uuid_create().rand(10,100)}}">
    <div class="custom_widget">
    </div>
    @if($widget->body)
        <div class="body_widget">
            {!! $widget->body !!}
        </div>
    @endif
    @if($slot)
        <div class="inner_widget">
            {!! $slot !!}
        </div>
    @endif
</div>
