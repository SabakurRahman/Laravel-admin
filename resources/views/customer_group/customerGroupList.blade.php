@extends('frontend.layouts.master')
@section('content')
    {{--    @include('global_partials.validation_error_display')--}}

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">name</th>
            <th scope="col">Discount Percent</th>
            <th scope="col">Discount Fixed</th>
            <th scope="col">status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerGroupList as $list)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$list->name}}</td>
                <td>{{ $list->discount_percent}}</td>
                <td>{{ $list->discount_fixed}}</td>
                <td>{{App\Models\CustomerGroup::STATUS_LIST[$list->status]}}</td>
                <td class="d-flex">
                    <a href="{{ route('customer-group.edit',$list->id) }}">

                        <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                    </a>
                    {!!Form::open(['route'=> ['customer-group.destroy',  $list->id], 'method'=>'delete'])!!}
                    {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}

                    {!!Form::close()!!}

                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

@endsection


