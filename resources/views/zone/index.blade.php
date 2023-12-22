@extends('frontend.layouts.master')
@section('content')
    {{--    @include('blog.partials.search')--}}
    <table class="table table-striped">
        <thead>
        <tr>
            <th>SL</th>
            <th>name</th>
            <th>name_bn</th>
            <th>city Name</th>
            <th>Is Inside Dhaka</th>
            <th>status</th>

            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($zone as $list)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$list->name}}</td>
                <td>{{$list->name_bn}}</td>
                <td>{{$list?->city?->name}}</td>
                <td>{{ \App\Models\Zone::IS_INSIDE_DHAKA_OR_NOT_LIST[$list->is_inside_dhaka] ?? null}}</td>
                <td>{{ \App\Models\Zone::STATUS_LIST[$list->status] ?? null }}</td>
                <td>
                    <div class="d-flex">

                        <a href="{{ route('zone.edit',$list->id) }}">
                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                    {!!Form::open(['route'=> ['zone.destroy',  $list->id], 'method'=>'delete'])!!}
                    {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                    {!!Form::close()!!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $zone->links() }}


@endsection


