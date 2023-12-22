@extends('frontend.layouts.master')
@section('content')
    @include('tag.partials.search')

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">SL</th>
                <th scope="col">name</th>
                <th scope="col">status</th>
                <th scope="col">created at</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tags as $tag)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{$tag->name}}</td>
                <td>{{ \App\Models\Tag::STATUS_LIST[$tag->status]}}</td>
                <td>{{ $tag->created_at?->toDayDateTimeString() }}</td>
                <td>
                    <div class="d-flex">
                        <a href="{{ route('tag.show',$tag->id) }}">
                            <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                        </a>
                        <a href="{{ route('tag.edit',$tag->id) }}">
                            <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                        </a>
                        {!!Form::open(['route'=> ['tag.destroy',$tag->id], 'method'=>'delete'])!!}
                        {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                        {!!Form::close()!!}
                    </div>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="12">
                        <p class="text-center text-danger">{{ __('Select status first') }}</p>
                    </td>
                </tr>
        @endforelse
        </tbody>
    </table>
    {{ $tags->links() }}
@endsection
