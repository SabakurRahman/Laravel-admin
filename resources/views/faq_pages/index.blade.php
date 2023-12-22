@extends('frontend.layouts.master')
@section('content')
{{--    @include('global_partials.validation_error_display')--}}
@include('faq_pages.partials.search')

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">name</th>
        <th scope="col">slug</th>
        <th scope="col">serial</th>
        <th scope="col">status</th>
        <th scope="col">created at</th>
        <th scope="col">Action</th>

    </tr>
    </thead>
    <tbody>
    @foreach($faqPageList as $list)
    <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{$list->name}}</td>
        <td>{{$list->slug}}</td>
        <td>{{$list->serial}}</td>
        <td>{{ \App\Models\FaqPage::STATUS_LIST[$list->status]}}</td>
        <td>{{ $list->created_at->format('D, M j, Y g:i A') }}</td>

        <td>
            <div  class="d-flex">
                <a href="{{ route('faq-pages.show',$list->id) }}">
                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                </a>
                <a href="{{ route('faq-pages.edit',$list->id) }}">
                    <button class="btn btn-sm btn-warning mx-1"><i class="ri-edit-box-line"></i></button>
                </a>
                {!!Form::open(['route'=> ['faq-pages.destroy',  $list->id], 'method'=>'delete'])!!}
                {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm delete-button btn-danger']) !!}

                {!!Form::close()!!}
            </div>


        </td>

    </tr>
    @endforeach
    </tbody>
</table>
{{ $faqPageList->links() }}
@endsection

