<x-lareon::admin-editor-layout type="update">
    @section('title', __(':title settings',['title'=>__('OAuth')]))
    @section('description', __('OAuth is a secure authorization protocol that lets websites or apps access a user\'s information from another service without needing the user\'s password'))

    @section('formRoute', route('admin.settings.oauth.update'))

    @section('form')
        <div class="grid md:grid-cols-3 gap-6">
           <div class="md:col-span-2 space-y-6 items-start">
               @foreach(config('lareon.oauth.types') ?? config('modules.oauth.types') ?? [] as $type=>$detail)
                   <x-lareon::box>
                       <h3>
                           {{__($type)}}
                       </h3>
                           <hr class="border-slate-200 my-3">
                       <div>
                           <x-lareon::sections.radio :value="old('oauth.'.$type.'.enable') ?? $data[$type]['enable'] ?? ''" :title="__('activation')" name="oauth[{{$type}}][enable]" :required="false" :items="[['title'=>__('activate') ,'value'=>1],['title'=>__('deactivated') ,'value'=>0]]"/>
                           <x-lareon::sections.text :value="old('oauth.'.$type.'.secret_key') ?? $data[$type]['secret_key'] ?? ''" :title="__('secret key')" name="oauth[{{$type}}][secret_key]" :required="false"/>
                           <x-lareon::sections.text :value="old('oauth.'.$type.'.client_id') ?? $data[$type]['client_id'] ?? ''" :title="__('client id')" name="oauth[{{$type}}][client_id]" :required="false"/>
                       </div>
                   </x-lareon::box>
               @endforeach
           </div>
            <div>
              <div class="p-4 rounded-lg border border-slate-200">
                  <h3>
                      {{__('links to get data')}}
                  </h3>
                  <ul class="list-disc spacy-y-3 list-inside">
                      <li>
                          <a href="https://console.cloud.google.com/apis/credentials" class="text-blue-600">
                              google
                          </a>
                      </li>
                      <li>
                          <a href="https://console.cloud.google.com/apis/credentials" class="text-blue-600">
                              linkedin
                          </a>
                      </li>
                      <li>
                          <a href="https://console.cloud.google.com/apis/credentials" class="text-blue-600">
                              github
                          </a>
                      </li>
                      <li>
                          <a href="https://console.cloud.google.com/apis/credentials" class="text-blue-600">
                              gitlab
                          </a>
                      </li>
                      <li>
                          <a href="https://console.cloud.google.com/apis/credentials" class="text-blue-600">
                              facebook
                          </a>
                      </li>
                      <li>
                          <a href="https://console.cloud.google.com/apis/credentials" class="text-blue-600">
                              twitter
                          </a>
                      </li>
                  </ul>
              </div>
            </div>
        </div>
    @endsection
</x-lareon::admin-editor-layout>
