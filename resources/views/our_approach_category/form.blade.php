
<fieldset>
    <legend>Basic Information</legend>
<div class="row">
    <div class="col-md-6">
        @csrf
        <div class="mb-3">
            {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter  Name']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('slug', 'Slug', ['class' => 'form-label']) !!}
            {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter Slug']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('serial', 'Serial', ['class' => 'form-label']) !!}
            {!! Form::number('serial', null, ['class' => 'form-control', 'placeholder' => 'Enter  serial']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', app\Models\OurApproachCategory::STATUS_LIST, null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
    </div>
</div>
    <div class="col-md-12">
        {!! Form::label('description', 'Description') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control tinymce', 'placeholder'=>'Enter Description']) !!}
    </div>

<div class="col-md-6">
    {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
    {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
    <div class="photo-preview-area">
        <i class="ri-camera-line"></i>
        <div class="overly"></div>
        <img
            src="{{isset($approachCategory->photo) ? asset(\App\Models\OurApproachCategory::PHOTO_UPLOAD_PATH.$approachCategory->photo)  : asset('uploads/canvas.webp')}}"
            alt="photo display area" class="photo photo-preview-area-photo"/>
    </div>
</div>
</fieldset>




