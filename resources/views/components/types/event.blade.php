@props(['value'=>[]] )
@php
    $rand=rand(10,1000).\Illuminate\Support\Str::random(8).rand(10,1000)
@endphp
<section>
    <input id="seo_type" name="seo[meta][seo_type]" value="Event" class="hidden"  type="hidden"/>
    <input id="seo_type" name="seo[schema][seo_type]" value="Event" class="hidden"  type="hidden"/>
    <div class="mb-3 grid md:grid-cols-2 gap-3">
       <div>
           <x-lareon::input.label :title="__('name')" for="{{$rand}}_schema_event_name"/>
           <x-lareon::input.text type="text" id="{{$rand}}_schema_event_name" name="seo[schema][name]" value="{{$value['name'] ?? $value['title'] ??''}}" class="block w-full mb-3"/>
           <x-lareon::input.error :messages="get_error($errors, 'seo[schema][name]')"/>
       </div>
        <div>
            <x-lareon::input.label :title="__('image')" for="{{$rand}}_schema_event_image"/>
            <x-lareon::input.text type="url" dir="ltr" id="{{$rand}}_schema_event_image" name="seo[schema][image]" value="{{$value['image']  ??''}}" class="block w-full mb-3"/>
            <x-lareon::input.error :messages="get_error($errors, 'seo[schema][image]')"/>
        </div>
    </div>
    <div class="mb-3 ">
        <x-lareon::input.label title="{{__('description')}}" for="{{$rand}}_schema_event_description"/>
        <x-lareon::input.textarea id="{{$rand}}_schema_event_description" name="seo[schema][description]" class="block w-full mb-3">{{$value['description'] ?? ''}}</x-lareon::input.textarea>
        <x-lareon::input.error :messages="get_error($errors ,'seo[schema][description]')"/>
    </div>

    <fieldset class="mb-3 fieldset">
        <legend>{{__('time and date')}}</legend>
       <section>
               <h4>{{__('start')}}</h4>
               <div class="grid gap-3 md:grid-cols-2">
                   <div class="mb-3">
                       <x-lareon::input.label :title="__('date')" for="{{$rand}}_start_date" />
                       <x-lareon::input.time type="date" name="seo[schema][date_time][start_date]" id="{{$rand}}_start_date" :title="__('start date')" :value="$value['date_time']['start_date']  ??''"/>
                       <x-lareon::input.error  :message="get_error($errors , 'seo[schema][date_time][start_date]')"/>
                   </div>
                   <div class="mb-3">
                       <x-lareon::input.label :title="__('time')"  for="{{$rand}}_start_time" />
                       <x-lareon::input.time type="time" name="seo[schema][date_time][start_time]" id="{{$rand}}_start_time" :title="__('start time')" :value="$value['date_time']['start_time']  ??''"/>
                       <x-lareon::input.error  :message="get_error($errors , 'seo[schema][date_time][start_time]')"/>
                   </div>
               </div>
       </section>
        <section>
            <h4>{{__('end')}}</h4>
            <div class="grid gap-3 md:grid-cols-2">
                <div class="mb-3">
                    <x-lareon::input.label :title="__('date')" for="{{$rand}}_end_date" />
                    <x-lareon::input.time type="date" name="seo[schema][date_time][end_date]" id="{{$rand}}_end_date" :title="__('end date')" :value="old('seo.schema.date_time.end_date') ?? $value['date_time']['end_date']  ??''"/>
                    <x-lareon::input.error  :message="get_error($errors , 'seo[schema][date_time][end_date]')"/>
                </div>
                <div class="mb-3">
                    <x-lareon::input.label :title="__('time')"  for="{{$rand}}_end_time" />
                    <x-lareon::input.time type="time" name="seo[schema][date_time][end_time]" id="{{$rand}}_end_time" :title="__('end time')" :value="old('seo.schema.date_time.end_time') ?? $value['date_time']['end_time']  ??''"/>
                    <x-lareon::input.error  :message="get_error($errors , 'seo[schema][date_time][end_time]')"/>
                </div>
            </div>
        </section>
        <div class="">
            <x-lareon::input.label :title="__('time zone')"  for="{{$rand}}_zone_time" />
            <x-lareon::input.text id="{{$rand}}_time_zone" name="seo[schema][date_time][time_zone]" list="timezones"
                                class="block w-full mb-3" value="{{old('seo[schema][date_time][time_zone]') ??$value['date_time']['time_zone'] ?? ''}}"/>
            <datalist id="timezones">
                @foreach(config('timezone') as $area=>$time)
                    <option value="{{$time}}">
                        {{__($area)}}
                    </option>
                @endforeach
            </datalist>
            <x-lareon::input.error  :message="get_error($errors , 'seo[schema][date_time][time_zone]')"/>
        </div>
    </fieldset>
    <fieldset class="mb-3 fieldset">
        <legend>{{__('performance')}}</legend>
           <div class="grid md:grid-cols-2 gap-3 mb-3">
               <div class="">
                   <x-lareon::input.label title="{{__('attendance mode')}}" for="{{$rand}}_schema_attendance"/>
                   <x-lareon::input.select id="{{$rand}}_schema_attendance" name="seo[schema][attendance_mode]" class="block w-full mb-3">
                       @foreach(config('seo.schema-type.attendanceMode') as $type=>$description)
                           <option value="{{$description}}" @selected(isset($value['attendance_mode']) && $value['attendance_mode']==$description) >
                               {{__($type)}}
                           </option>
                       @endforeach
                   </x-lareon::input.select>
                   <x-lareon::input.error :messages="$errors->get('seo.schema.attendance_mode')"/>
               </div>
               <div class="">
                   <x-lareon::input.label title="{{__('event status')}}" for="schema_eventStatus"/>
                   <x-lareon::input.select id="schema_eventStatus" name="seo[schema][eventStatus]" class="block w-full mb-3">
                       @foreach(config('seo.schema-type.eventStatus') as $type=>$description)
                           <option value="{{$description}}" @selected(isset($value['eventStatus']) && $value['eventStatus']== $description) >
                               {{__($type)}}
                           </option>
                       @endforeach
                   </x-lareon::input.select>
                   <x-lareon::input.error :messages="$errors->get('seo.schema.eventStatus')"/>
               </div>
           </div>
           <div class="grid md:grid-cols-2 gap-3 mb-3">
               <div class="">
                   <x-lareon::input.label title="{{__('event type')}}" for="{{$rand}}_schema_eventPerformance"/>
                   <x-lareon::input.select id="{{$rand}}_schema_eventPerformance" name="seo[schema][performer][type]" class="block w-full mb-3">
                       @foreach(config('seo.schema-type.eventPerformance') as $type=>$description)
                           <option value="{{$type}}" @selected(isset($value['performer']['type']) && $value['performer']['type']== $type ) >
                               {{__($description)}}
                           </option>
                       @endforeach

                   </x-lareon::input.select>
                   <x-lareon::input.error :messages="$errors->get('seo.schema.performer.type')"/>
               </div>
               <div class="">
                   <x-lareon::input.label title="{{__('performer name')}}" for="schema_performer_name" />
                   <x-lareon::input.text id="schema_performer_name" name="seo[schema][performer][name]" class="block w-full mb-3"
                                       :value="old('seo.schema.performer.name') ?? $value['performer']['name'] ?? ''" />
                   <x-lareon::input.error :messages="$errors->get('seo.schema.performer.name')"/>
               </div>

           </div>
            <x-lareon::input.error  :message="get_error($errors , 'seo[schema][date_time][time_zone]')"/>
    </fieldset>
    <div class="mb-3">
        <x-lareon::input.label :title="__('stream url')"  for="{{$rand}}_url" />
        <x-lareon::input.time type="url" dir="ltr" name="seo[schema][location][url]" id="{{$rand}}_url" :title="__('url')" :value="old('seo.schema.location.url') ?? $value['location']['url']  ??''"/>
        <x-lareon::input.error :message="get_error($errors , 'seo[schema][location][url]')"/>
    </div>
    <x-seo::sections.location name="seo[schema]" :value="$value['location'] ?? []"/>
</section>
