@extends('frontend.layouts.master')
@section('content')
<div class="row">
    <div class="col-md-6">
        <h2>Project Details</h2>
        <p><strong>Name:</strong>{{$ourProject->name}}</p>
        <p><strong>Client Name:</strong> {{$ourProject->client_name}}</p>
        <p><strong>Project Location:</strong> {{$ourProject->project_location}}</p>
        <p><strong>Description:</strong> {{$ourProject->project_description}}</p>
        <p><strong>Project Category:</strong> {{$ourProject->project_category->name}}</p>
        <p><strong>Total Area:</strong> {{$ourProject->total_area}}</p>
        <p><strong>Total Cost:</strong>{{$ourProject->total_cost}}</p>
    </div>
    <div class="col-md-6">
        <h2>Photos</h2>
        @foreach ($ourProject->photos_all as $photo)
        <div class="mb-3">
            <img src="{{asset(app\Models\ProjectPhoto::PHOTO_UPLOAD_PATH. $photo['photo'])}}" width="50px">
        </div>
        @endforeach
    </div>
    @if($ourProject->primary_photo)
    <div class="col-md-12">
        <h2>Primary Photo</h2>
       <img src="{{asset(app\Models\ProjectPhoto::PHOTO_UPLOAD_PATH.$ourProject->primary_photo['photo'])}}" width="100px">
    </div>
    @endif
</div>
</div>
</div>
  
@endsection
@push('script')
    <script>
        $('#name').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })

    </script>
@endpush
