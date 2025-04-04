<x-lareon::admin-layout xmlns:x-lareon="http://www.w3.org/1999/html">
    @section('title', __('robot.txt'))
    @section('description', __('robots.txt file is a text file that tells search engine crawlers which pages or sections of a website they can or cannot access'))
    <section class="mb-6">
        <form method="POST">
            @csrf
            @method('patch')
            <x-lareon::box>
                <div>
                    <p class="mb-3">
                        <strong>{{__('robots.txt rules may not be supported by all search engines')}}.</strong>
                        <br>
                        {{__('the instructions in robots.txt files cannot enforce crawler behavior to your site; it\'s up to the crawler to obey them')}}
                    </p>
                </div>
                <x-lareon::input.label for="content" :title="__('content')" />
                <x-lareon::input.textarea dir="ltr" name="content" id="content" rows="20">{{old('content') ?? $content }}</x-lareon::input.textarea>
                <div class="mt-6">
                    <x-lareon::button.solid type="submit" role="button" title="save">{{__('update')}}</x-lareon::button.solid>
                </div>
            </x-lareon::box>
        </form>
    </section>
</x-lareon::admin-layout>
