@props(['value'=>[] ,'instance'=>null ,'accordion'=>true ,'open'=>true ,'url'=>route('admin.ajax.seo.schema_model')])
<x-lareon::accordion.box :title="__('seo')" :accordion="$accordion" :open="$open">
    <input type="hidden" value="{{!is_null($instance) ? get_class($instance) : ''}}"  id="instance">
    <input type="hidden" value="{{!is_null($instance) ? $instance->id : ''}}"  id="instanceId">
    <input type="hidden" value="{{$url}}"  id="schema_loader__url">
    <div x-data="{ tabs: [
        { id: 1, title: 'meta tags', active: true },
        { id: 2, title: 'schema', active: false },
        { id: 3, title: 'sitemap', active: false },
      ], activeTab: 1 }">
        <!-- Tabs -->
        <nav class="relative flex w-full overflow-hidden z-0 rounded-t-lg shadow" aria-label="Tabs">
            <template x-for="(tab, ix) in tabs" :key="tab.id">
                <a href="#" :class="tab.active ? 'bg-slate-50' : 'bg-slate-200'"
                   class="group relative min-w-0 flex-1 overflow-hidden py-4 px-4 text-center hover:bg-slate-50 focus:z-10" :aria-current="tab.active ? 'page' : 'undefined'"
                   @click.prevent="tabs.forEach(tab => tab.active = false); tabs[ix].active = true">
                    <span x-text="tab.title" class="tab.active ? 'text-black' : 'text-gray-800'"></span>
                    <span aria-hidden="true" :class="tab.active ? 'bg-blue-600' : 'bg-transparent'" class="absolute inset-x-0 bottom-0 h-1"></span>
                </a>
            </template>
        </nav>

        <div class="shadow">
            <x-lareon::box>
                <section x-show="tabs.find(tab => tab.id === 1).active">
                    <x-seo::sections.instance.meta :data="$value['meta'] ?? []"/>
                </section>
                <section x-show="tabs.find(tab => tab.id === 2).active">
                    <x-seo::sections.instance.schema :data="$value['schema'] ?? []"/>
                </section>
                <section x-show="tabs.find(tab => tab.id === 3).active">
                    <x-seo::sections.instance.sitemap :data="$value['sitemap'] ?? []"/>
                </section>
            </x-lareon::box>
        </div>
    </div>

</x-lareon::accordion.box>
