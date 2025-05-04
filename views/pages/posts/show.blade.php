<x-client-layout>
    {!! $post->body !!}
    <x-comment.section :model="$post" />
</x-client-layout>
