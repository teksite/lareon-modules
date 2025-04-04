@props(['categories'=>[]])
@if(count($categories))
    <div class="categories-box">
        <ul class="space-y-3">
            @foreach($categories as $category)
                <li>
                    <div class="flex items-center justify-between gap-3 mb-3">
                        <div class="font-bold w-fit flex items-center gap-3">
                              <span class="whitespace-nowrap p">
                                  {{ $loop->depth ? str_repeat('↲' , $loop->depth -1) : ''}}
                              </span>
                            <span class="min-w-fit w-fit text-nowrap">
                                    {{$category->title}}
                            </span>
                        </div>
                        <hr class="border-t border-dotted w-full">
                        <div class="flex items-center justify-end gap-3 w-fit">
                            @if($category->label == null)
                                <x-lareon::link.edit :href="route('admin.blog.categories.edit', $category)" title="{{$category->title}}" can="admin.blog.category.edit"/>
                                <x-lareon::link.delete :href="route('admin.blog.categories.destroy', $category)" title="{{$category->title}}" can="admin.blog.category.delete"/>
                            @endif
                        </div>
                    </div>

                        <x-blog::categories-tree-layout  :categories="$category->children"/>
                    @if( $loop->depth < 2)
                        <hr class="my-6">
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif
