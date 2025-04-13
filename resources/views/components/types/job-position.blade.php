@props(['value'=>[]])
<section>
    <input id="seo_type" name="seo[meta][seo_type]" value="JobPosition" class="hidden"  type="hidden"/>
    <input id="seo_type" name="seo[schema][seo_type]" value="JobPosition" class="hidden"  type="hidden"/>
    {{--Title and Image--}}
    <div class="grid gap-3 md:grid-cols-2 mb-3">
        <div class="">
            <x-lareon::input.label title="{{__('title')}}" for="schema_title"/>
            <x-lareon::input.text id="schema_title" name="seo[schema][title]" class="block w-full mb-3" value="{{$value['title'] ?? $value['name'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.title')"/>
        </div>
        <div class="">
            <x-lareon::input.label title="{{__('image')}}" for="schema_image"/>
            <x-lareon::input.text text="url" dir="ltr" id="schema_image" name="seo[schema][image]" class="block w-full mb-3" value="{{$value['image'] ?? ''}}" :placeholder="__('leave it empty to read from :title',['title'=>__('featured image')])"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.image')"/>
        </div>
    </div>
    {{--Description--}}
    <div class="mb-3">
        <x-lareon::input.label title="{{__('description')}}" for="schema_description"/>
        <x-lareon::input.textarea id="schema_description" name="seo[schema][description]" class="block w-full mb-3">{{$value['description'] ?? ''}}</x-lareon::input.textarea>
        <x-lareon::input.error :messages="$errors->get('seo.schema.description')"/>
    </div>
    {{--Posted and Until Date--}}
    <div class="grid gap-3 md:grid-cols-2 mb-3">
        <div class="">
            <x-lareon::input.label title="{{__('date posted')}}" for="schema_datePosted"/>
            <x-lareon::input.text type="date" dir="ltr" id="schema_datePosted" name="seo[schema][datePosted]" class="block w-full mb-3" value="{{$value['datePosted'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.datePosted')"/>
        </div>
        <div class="">
            <x-lareon::input.label title="{{__('valid through')}}" for="schema_validThrough"/>
            <x-lareon::input.text type="date" dir="ltr" id="schema_validThrough" name="seo[schema][validThrough]" class="block w-full mb-3" value="{{$value['validThrough'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.validThrough')"/>
        </div>
    </div>
{{--  educationRequirements  --}}
    <div class="grid gap-3 md:grid-cols-2 mb-3">
        <div>
            <x-lareon::input.label :title="__('education requirements')"  for="educationRequirements"/>
            <x-lareon::input.select id="unit-educationRequirements" class="block w-full" name="seo[schema][educationRequirements]">
                @foreach(config('education') ?? [] as $type=>$title)
                    <option value="{{$type}}" {{isset($value['educationRequirements']) && $value['educationRequirements'] == $type ? 'selected' : ''}}>{{__($title)}}</option>
                @endforeach
            </x-lareon::input.select>
        </div>
        <div class="">
            <x-lareon::input.label title="{{__('experience requirements')}} . ({{__('month')}})" for="schema_experienceRequirements"/>
            <x-lareon::input.text type="number" dir="ltr" id="schema_experienceRequirements" name="seo[schema][experienceRequirements]" min="0" class="block w-full mb-3" value="{{$value['experienceRequirements'] ?? ''}}"/>
            <x-lareon::input.error :messages="$errors->get('seo.schema.experienceRequirements')"/>
        </div>
    </div>
    <div class="mb-3">
        <x-lareon::input.label title="{{__('industry')}}" for="schema_industry"/>
        <x-lareon::input.text  id="schema_industry" name="seo[schema][industry]" class="block w-full mb-3" value="{{$value['industry'] ?? ''}}"/>
        <x-lareon::input.error :messages="$errors->get('seo.schema.industry')"/>
    </div>
    {{--  SKILSS responsibilities --}}
   <div class="mb-3 grid gap-3 md:grid-cols-2">
    {{--  SKILSS  --}}
       <div class="">
           <x-lareon::input.label title="{{__('skills')}}" for="schema_skills"/>
           <x-lareon::input.text  id="schema_skills" name="seo[schema][skills]" class="block w-full mb-3" value="{{$value['skills'] ?? ''}}" :placeholder="__('separate with ,')"/>
           <x-lareon::input.error :messages="$errors->get('seo.schema.skills')"/>
       </div>
       <div class="">
           {{--  responsibilities  --}}
           <x-lareon::input.label title="{{__('responsibilities')}}" for="responsibilities"/>
           <x-lareon::input.text  id="responsibilities" name="seo[schema][responsibilities]" class="block w-full mb-3" value="{{$value['responsibilities'] ?? ''}}" :placeholder="__('separate with ,')"/>
           <x-lareon::input.error :messages="$errors->get('seo.schema.responsibilities')"/>
       </div>
   </div>
    {{--applicantLocationRequirements--}}
    <div class="mb-3 grid gap-3 md:grid-cols-2 items-center">
        {{--employmentType--}}
        <div>
            <x-lareon::input.label :title="__('type')"  for="employmentType"/>
            <x-lareon::input.select id="employmentType" class="block w-full" name="seo[schema][employmentType]">
                @foreach(config('seo.schema-type.pageType.JobPosition.employmentType') as $type=>$title)
                    <option value="{{$type}}" {{isset($value['employmentType'] ) && $value['employmentType']== $type ? 'selected' : ''}}>{{__($title)}}</option>
                @endforeach
            </x-lareon::input.select>
        </div>
        {{--applicantLocationRequirements | employmentType--}}
        <div class="">
            <div class="flex items-center gap-3">
                <x-lareon::input.checkbox  id="applicantLocationRequirements" name="seo[schema][applicantLocationRequirements]" value="1" :checked="isset($value['applicantLocationRequirements'])"/>
                <x-lareon::input.label title="{{__('remote')}}" for="applicantLocationRequirements" />
            </div>
            <x-lareon::input.error :messages="$errors->get('seo.schema.applicantLocationRequirements')"/>
        </div>

    </div>
    <fieldset class="fieldset">
        <legend class="legend">{{__('salary')}}</legend>
        <div class="mb-3 grid md:grid-cols-2 gap-3">
            <div>
                <x-lareon::input.label :title="__('currency')"  for="unit-baseSalary"/>
                <x-lareon::input.select id="unit-baseSalary" class="block w-full" name="seo[schema][baseSalary][unit]">
                    @foreach(config('seo.schema-type.pageType.JobPosition.salaryUnit') as $type=>$title)
                        <option value="{{$type}}" {{isset($value['baseSalary']['unit'] ) && $value['baseSalary']['unit'] == $type ? 'selected' : ''}}>{{__($title)}}</option>
                    @endforeach
                </x-lareon::input.select>
            </div>
            <div>
                <x-lareon::input.label :title="__('unit')"  for="unit-unitText"/>
                <x-lareon::input.select id="unit-unitText" class="block w-full" name="seo[schema][baseSalary][unitText]">
                    @foreach(config('currency') as $type=>$title)
                        <option value="{{$type}}" {{isset($value['baseSalary']['unitText'] ) && $value['baseSalary']['unitText'] == $type ? 'selected' : ''}}>{{__($title)}}</option>
                    @endforeach
                </x-lareon::input.select>
            </div>
            <div>
                <x-lareon::input.label  :title="__('min salary')" for="salary-minSalary"/>
                <x-lareon::input.text type="number" dir="ltr" id="salary-minSalary" class="block w-full"  name="seo[schema][baseSalary][minValue]" :value="$value['baseSalary']['minValue'] ?? ''"/>
            </div>
            <div>
                <x-lareon::input.label  :title="__('max salary')" for="salary-maxSalary"/>
                <x-lareon::input.text type="number" dir="ltr" id="salary-maxSalary" class="block w-full"  name="seo[schema][baseSalary][maxValue]" :value="$value['baseSalary']['maxValue'] ?? ''"/>
            </div>
        </div>
    </fieldset>
    {{--compant--}}
    <x-seo::sections.organization :value="$value['company'] ?? []" name="seo[schema]"/>

    {{--Location--}}
    <x-seo::sections.location :value="$value['location'] ?? []" name="seo[schema]"/>


</section>
