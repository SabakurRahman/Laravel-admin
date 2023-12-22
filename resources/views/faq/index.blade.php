@extends('frontend.layouts.master')
@section('content')
{{--    @include('global_partials.flash')--}}
    @include('faq.partials.search')

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">title</th>
            <th scope="col">description</th>
            {{-- <th scope="col">Faq Pages</th> --}}
            <th scope="col">status</th>
            <th scope="col">created at</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($faqList as $list)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$list->question_title}}</td>
                <td>{{ Str::limit(strip_tags( $list->description))}}</td>
                {{-- <td>{{$list?->faq_page?->name}}</td> --}}
                <td>{{ \App\Models\FaqPage::STATUS_LIST[$list->status]}}</td>
                <td>{{ $list->created_at->format('D, M j, Y g:i A') }}</td>

                <td>
                    <div class="d-flex">
                        <a href="{{ route('faq.show',$list->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('faq.edit',$list->id) }}">

                            <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                        </a>
                        {!!Form::open(['route'=> ['faq.destroy',  $list->id], 'method'=>'delete'])!!}
                        {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}

                        {!!Form::close()!!}

                    </div>

                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
{{ $faqList->links() }}
@endsection


