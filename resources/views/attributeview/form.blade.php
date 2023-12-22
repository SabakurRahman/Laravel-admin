<fieldset>
    <legend>Basic Information</legend>
<div class="row">
      <div class="col-md-6">
          {!! Form::label('name', 'Name') !!}
          {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
      </div>
      <div class="col-md-6">
          {!! Form::label('name_bn', 'Name Bn') !!}
          {!! Form::text('name_bn', null, ['class' => 'form-control', 'placeholder' => 'Enter Name Bn']) !!}
      </div>

      <div class="col-md-12">
          {!! Form::label('description', 'Description') !!}
          {!! Form::textarea('description', null, ['class' => 'form-control tinymce', 'placeholder' => 'Enter Description']) !!}
      </div>
      <div class="col-md-12">
          {!! Form::label('description_bn', 'Description Bn') !!}
          {!! Form::textarea('description_bn', null, ['class' => 'form-control tinymce', 'placeholder' => 'Enter Description Bn']) !!}
      </div>
    <div class="col-md-6">
        {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
        {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
        <div class="photo-preview-area">
            <i class="ri-camera-line"></i>
            <div class="overly"></div>
            <img
                src="{{isset($attribute->photo) ? asset(\App\Models\Attribute::PHOTO_UPLOAD_PATH.$attribute->photo)  : asset('uploads/canvas.webp')}}"
                alt="photo display area" class="photo photo-preview-area-photo"/>
        </div>
    </div>

      <div class="col-md-6">
          {!! Form::label('status1', 'Status') !!}
          {!! Form::select('status', \app\Models\Attribute::STATUS_LIST, null, ['class' => 'form-select', 'placeholder' => 'Select Status']) !!}
      </div>
  </div>
</fieldset>
