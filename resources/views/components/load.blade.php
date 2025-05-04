@foreach((new \Lareon\Modules\Oauth\App\Logic\OauthLogic())->get()->result as $key=>$value)
        <a href="{{route('auth.oauth.redirect',['type'=>$key])}}" {{$attributes->merge()}} title="{{__('by :title',['title'=>__($key)])}}">
            <img src="{{asset('admin/images/'.$key.'-icon.svg') }}" alt="{{__('by :title',['title'=>__($key)])}}" width="35" height="35">
        </a>
@endforeach
