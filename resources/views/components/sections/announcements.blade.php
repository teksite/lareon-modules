@props(['value'=>[]])
<x-lareon::box class="">
    <h3 >
        {{__('send admin notification via')}}
    </h3>
    <x-lareon::sections.text :title="__('emails')" :value="$value['emails'] ?? ''" name="announcements[emails]" :placeholder="__('separate with ,')" dir="ltr" type="text"/>
    <x-lareon::sections.text :title="__('phones')" :value="$value['phones'] ?? ''" name="announcements[phones]" :placeholder="__('separate with ,')" dir="ltr" type="text"/>
    <x-lareon::sections.text :title="__('urls')" :value="$value['urls'] ?? ''" name="announcements[urls]" :placeholder="__('separate with ,')" dir="ltr" type="text"/>
    <x-lareon::sections.text :title="__('telegram ids')" :value="$value['telegram_ids'] ?? ''" name="announcements[telegram_ids]" :placeholder="__('separate with ,')" dir="ltr" type="text"/>
</x-lareon::box>
