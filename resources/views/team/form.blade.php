<fieldset>
    <legend>Basic Information</legend>
<div class="row">
    <div class="col-md-6">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
    </div>
    <div class="col-md-12">
        {!! Form::label('description', 'Description') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control tinymce', 'placeholder'=>'Enter Description']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
        {!! Form::file('photo', ['class'=>'form-control form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
        <div class="photo-preview-area" style="width: 250px; height: 150px">
            <i class="ri-camera-line"></i>
            <div class="overly"></div>
            <img
                src="{{isset($team->photo) ? asset(\App\Models\Team::PHOTO_UPLOAD_PATH.$team->photo)  : asset('uploads/canvas.webp')}}"
                alt="photo display area" class="photo photo-preview-area-photo"/>
        </div>
    </div>
    <div class="col-md-6">
        {!! Form::label('Status', 'Status') !!}
        {!! Form::select('status', \App\Models\Team::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
    </div>

</div>
</fieldset>
