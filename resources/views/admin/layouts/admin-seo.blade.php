<x-lareon::admin-layout>
    @props(['type'=>'create' ,'instance'=>null , 'publishStatus'=>true])
    @section('title')
        @yield('title')
    @endsection
    @section('description')
        @yield('description')
    @endsection

    @section('header.start')
        <a href="{{url()->query(url()->current() ,['type'=>'website'])}}" class="{{request()->get('type') === 'website'? 'cursor-not-allowed text-blue-300':'text-blue-600 font-semibold'}}">
            {{__('website')}}</a>
        <a href="{{url()->query(url()->current() ,['type'=>'local_business'])}}" class="{{request()->get('type') === 'local_business'? 'cursor-not-allowed text-blue-300':'text-blue-600 font-semibold'}}">
            {{__('local business')}}</a>
        <a href="{{url()->query(url()->current() ,['type'=>'organization'])}}" class="{{request()->get('type') === 'organization'? 'cursor-not-allowed text-blue-300':'text-blue-600 font-semibold'}}">
            {{__('organization')}}</a>
    @endsection

    @section('header.end')
        <x-lareon::button.solid type="submit" role="submit" class="block w-full" onclick="document.getElementById('createForm').submit()" color="blue">
            {{__('update')}}
        </x-lareon::button.solid>
    @endsection

    <form method="POST" action="{{route('admin.seo.site.update')}}" id="createForm">
        <div class="mb-6">
            <div class="md:col-span-2 lg:col-span-2 xl:col-span-5 flex flex-col gap-6">
                <div>
                    @csrf
                    @method('PATCH')
                    @yield('form')
                    @yield('form.before.end')
                    <input type="hidden" class="hidden" name="type" value="{{request()->query('type') ?? 'website'}}">
                </div>
            </div>
            <div class="flex flex-col gap-6 xl:col-span-2">
                @yield('aside')
                @if($instance)
                    <x-lareon::sections.publish-data :instance="$instance"/>
                @endif
            </div>
        </div>
    </form>
    @yield('form.after')

</x-lareon::admin-layout>
