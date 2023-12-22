@extends('frontend.layouts.master')
@section('content')
    @include('visitor.partials.statistics')
    @include('visitor.partials.search')
    <table class="table table-striped mt-4">
        <thead>
        <tr>
            <th>SL</th>
            <th>IP</th>
            <th>Location</th>
            <th>Browser</th>
            <th>OS</th>
            <th>Device</th>
            <th>Device Type</th>
            <th>User</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody>
        @forelse($visitors as $visitor)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$visitor->ip}}</td>
                <td>
                    <p class="mb-0">
                        <small>
                            {{$visitor->country}}, {{$visitor->region}}, {{$visitor->city}}, {{$visitor->zip}}
                        </small>
                    </p>
                    <p class="mb-0">
                        <small>
                            Log: {{$visitor->long}}, Lat: {{$visitor->lat}},
                            Time Zone: {{$visitor->timeZone}}
                        </small>
                    </p>
                </td>
                <td>{{$visitor->browser}}</td>
                <td>{{$visitor->os}}</td>
                <td>{{$visitor->device}}</td>
                <td>{{$visitor->device_type}}</td>
                <td>{{$visitor->user?->name ?? '-'}}</td>
                <td>{{$visitor->created_at->toDayDateTimeString()}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9"><p class="text-danger text-center my-4">No data found</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{$visitors->onEachSide(1)->links()}}

@endsection
@push('script')
    <script>
        $('#reset_fields').on('click', function () {
            resetFilters()
        })
    </script>
@endpush


