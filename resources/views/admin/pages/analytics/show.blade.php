<x-lareon::admin-layout>
    @section('title', __('forms analytics'))
    @section('description', __('analytics help provide a comprehensive overview at a glance'))
    <form action="{{route('admin.questionnaire.inboxes.analytics.show')}}" method="GET">
        <x-lareon::box class="flex items-center gap-6 mb-12">
            <div>
                <x-lareon::input.label  for="fromDate" :title="__('from date')"/>
                <x-lareon::input.text  id="fromDate" name="fromDate" type="date" value="{{request()->fromDate ?? now()->startOfMonth()->format('Y-m-d')}}"/>
            </div>
            <div>
                <x-lareon::input.label  for="toDate" :title="__('until date')"/>
                <x-lareon::input.text  id="toDate" name="toDate" type="date" value="{{request()->toDate ?? now()->endOfMonth()->format('Y-m-d')}}"/>
            </div>
            <div>
                <x-lareon::input.label  for="range" :title="__('range')"/>
                <x-lareon::input.select  id="range" name="range">
                    <option value="month" {{request()->range=='month' ? 'selected' :''}}>{{__('month')}}</option>
                    <option value="year" {{request()->range=='year' ? 'selected' :''}}>{{__('year')}}</option>
                    <option value="week" {{request()->range=='week' ? 'selected' :''}}>{{__('week')}}</option>
                    <option value="day" {{request()->range=='day' ? 'selected' :''}}>{{__('day')}}</option>
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
        <canvas id="inboxLine"></canvas>
    </div>
    @push('footerScripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('inboxLine').getContext('2d');
            const chartData = @json($chartData);
            let delayed;

            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Submissions'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-lareon::admin-layout>
