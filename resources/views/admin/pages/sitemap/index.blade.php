<x-lareon::admin-layout xmlns:x-lareon="http://www.w3.org/1999/html">
    @section('title', __('sitemap'))
    @section('description', __('a sitemap is a file that lists all the important URLs of a website, helping search engines efficiently crawl and index its content'))
    <section class="mb-6 grid gap-6 md:grid-cols-3">
        <x-lareon::box class="md:col-span-2">
            <p>
                {{__('to generate sitemap click on "update" button')}}.
            </p>
            <p>
                {{__('if any links are missing from the sitemap, contact your site administrator to resolve the issue')}}.
            </p>
            <form method="POST">
                @csrf
                @method('PATCH')
                <div class="mt-6 flex justify-end">
                    <x-lareon::button.solid color="blue" type="submit" role="button" title="generate">{{__('update')}}</x-lareon::button.solid>
                </div>
            </form>
        </x-lareon::box>
        <x-lareon::box>
            <div class="flex items-center justify-start gap-3">
               <span class="group group relative">
                   <span
                       class="hidden shadow group-hover:block absolute rounded-2xl bg-white w-96 p-3 start-0 end-auto lg:start-auto lg:end-0  text-sm p">
                       "auto":{{__('a robot automatically crawls the entire website, detects all URLs, and registers them in the sitemap')}}
                       <br>
                       "database":{{__('only URLs stored in the database are registered in the sitemap')}}
                       <br>
                       "single":{{__("a single file is created containing all URLs")}}
                       <br>
                       "index":{{__("a main sitemap file is created, along with multiple sitemap files for different parts of the app")}}
                   </span>
                   <i class="p-1 w-6 h-6 border border-blue-600 tkicon fill-none stroke-current regular-link rounded-full  "
                      data-icon="exclamation"></i>
               </span>
                <div>
                    <p>{{__('sitemap type')}}:
                        <span class="font-bold">{{config('lareon.cms.sitemap.file')}}</span>
                    </p>
                    <p>{{__('crawling type')}}:
                        <span class="font-bold">{{config('lareon.cms.sitemap.crawl')}}</span>
                    </p>
                </div>
            </div>
        </x-lareon::box>
    </section>
</x-lareon::admin-layout>
