@props(['model' ,'id'=>rand(10,100)])
<x-modal name="reply-comment" :show="$errors?->userDeletion->isNotEmpty()" maxWidth="5xl" id="{{$id}}">
        <h3 class="!mb-1">
            {{__('reply to')}}
        </h3>
       <div class="grid md:grid-cols-2 gap-3">
          <div>
             <figure class="flex gap-1 items-center">
                 <img src="" alt="" width="50" height="50" id="replyToAvatar" loading="lazy" fetchpriority="low" decoding="async">
                 <span id="replyToAuthor" class="h3 font-bold"></span>
             </figure>
              <p id="replyToMessage" class="!mb-1 mt-3 text-sm"></p>
          </div>
           <div>
               <x-comment::client.new :model="$model" />
           </div>
       </div>
</x-modal>
