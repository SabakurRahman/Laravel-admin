@extends('frontend.layouts.master')
@section('content')
        {{-- @include('global_partials.flash') --}}
        @include('newsLetter.partials.search')
 
        <table class="table table-striped">
            <thead class="table-topbar">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col" style="text-align:center">Email</th> 
                    <th scope="col" style="text-align:center">IP</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col" style="padding-left:30px;">Action</th>
                </tr>
            </thead>
                <!-- end thead -->
            <tbody>
                @forelse($newsLetters as $newsLetter)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$newsLetter->name}}</td>
                        <td>{{$newsLetter->email}}</td> 
                        <td>{{$newsLetter->ip}}</td>
                        <td>{{ \App\Models\NewsLetter::STATUS_LIST[$newsLetter->status]}}</td>
                        <td style="width:150px">{{$newsLetter->created_at->toDayDateTimeString()}}</td>
                        <td style="width:150px">{{$newsLetter->updated_at->toDayDateTimeString()}}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('news-letter.show',$newsLetter->id) }}">
                                    <button class="btn btn-sm btn-info"><i class="ri-eye-line"></i></button>
                                </a>
                                <a href="{{ route('news-letter.edit',$newsLetter->id) }}">
                                    <button class="mx-1 btn btn-sm btn-warning"><i class="ri-edit-box-line"></i></button>
                                </a>
                                {!!Form::open(['route'=> ['news-letter.destroy', $newsLetter->id], 'method'=>'delete'])!!}
                                {!! Form::button(' <i class="ri-delete-bin-6-line"></i>', ['class' => 'btn btn-sm  delete-button btn-danger']) !!}
                                {!!Form::close()!!}
                                
                            </div>                
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12">
                            <p class="text-center text-danger">{{ __('No Data found') }}</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
       {{$newsLetters->links()}}
@endsection

