<x-lareon::admin-layout>
    @section('title', __('forms analytics'))
    @section('description', __('analytics help provide a comprehensive overview at a glance'))

    <form action="{{route('admin.questionnaire.inboxes.analytics.show')}}" method="GET">
        <x-lareon::box class="flex items-center gap-6 mb-12">
            <div>
                <x-lareon::input.label  for="fromDate" :title="__('from date')"/>
                <x-lareon::input.text  id="fromDate" name="fromDate" type="date" value="{{$startDate}}"/>
            </div>
            <div>
                <x-lareon::input.label  for="toDate" :title="__('until date')"/>
                <x-lareon::input.text  id="toDate" name="toDate" type="date" value="{{$endDate}}"/>
            </div>
            <div>
                <x-lareon::input.label  for="range" :title="__('range')"/>
                <x-lareon::input.select  id="range" name="range">
                    <option value="month" {{$range=='month' ? 'selected' :''}}>{{__('month')}}</option>
                    <option value="year" {{$range=='year' ? 'selected' :''}}>{{__('year')}}</option>
                    <option value="week" {{$range=='week' ? 'selected' :''}}>{{__('week')}}</option>
                    <option value="day" {{$range=='day' ? 'selected' :''}}>{{__('day')}}</option>

                </x-lareon::input.select>
            </div>
            <div class="self-end">
                <x-lareon::button.solid >
                    {{__('search')}}
                </x-lareon::button.solid>
            </div>
        </x-lareon::box>

    </form>
    <div>
        <canvas id="myChart"></canvas>
    </div>
    @push('footerScripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('myChart');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! $label !!},
                    datasets: {!! $dataSet !!}
                },
                options: {
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0,
                            loop: true
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                precision: 0,  // Round to whole numbers
                                beginAtZero: true // Start y-axis at 0
                            }

                        }
                    }
                }
            });
        </script>
    @endpush
</x-lareon::admin-layout>
