@extends('frontend.layouts.master')
@section('content')
    @include('attributeview.partials.search')

    <table class="table table-striped">
        <thead>
        <tr>

            <th>SL</th>
            <th>Name</th>
            <th>Name in Bangla</th>
            <th>Display Order</th>
            <th>Attribute</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Action</th>

        </tr>

        </thead>
        <tbody>
        @foreach ($attributevalue as $list)
            <tr>

                <th>{{ $loop->iteration }}</th>
                <td>{{$list->name}}</td>
                <td>{{$list->name_bn}}</td>
                <td>{{$list->display_order}}</td>
                <td>{{$list->attribute->name}}</td>
                <td> {{App\Models\AttributeValue::STATUS_LIST[$list->status]}}</td>

                <td>{{ $list->created_at->toDayDateTimeString() }}</td>

                <td>
                    <div class="d-flex">
                        <a href="{{ route('attribute-value.show',$list->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('attribute-value.edit',$list->id) }}">
                            <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                        </a>
                        {!!Form::open(['route'=> ['attribute.destroy',  $list->id], 'method'=>'delete'])!!}
                        {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                        {!!Form::close()!!}
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

@endsection

