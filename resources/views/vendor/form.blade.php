<div class="row">
    <div class="col-md-6">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('name_bn', 'Name BN') !!}
        {!! Form::text('name_bn', null, ['class'=>'form-control', 'placeholder'=>'Enter Name BN']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('slug', 'Slug') !!}
        {!! Form::text('slug', null, ['class'=>'form-control', 'placeholder'=>'Enter Slug']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('email', 'Email') !!}
        {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Enter email']) !!}
    </div>
    <div class="col-md-12">
        {!! Form::label('description', 'Description') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control tinymce', 'placeholder'=>'Enter Description']) !!}
    </div>
    <div class="col-md-12">
        {!! Form::label('description_bn', 'Description BN') !!}
        {!! Form::textarea('description_bn', null, ['class'=>'form-control tinymce', 'placeholder'=>'Enter Description BN']) !!}
    </div>

    <div class="col-md-6">
        {!! Form::label('Status', 'Status') !!}
        {!! Form::select('status', \App\Models\Vendor::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('serial', 'Serial') !!}
        {!! Form::number('serial', null, ['class'=>'form-control', 'placeholder'=>'Enter page serial']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
        {!! Form::file('photo', ['class'=>'form-control form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
        <div class="photo-preview-area" style="width: 250px; height: 150px">
            <i class="ri-camera-line"></i>
            <div class="overly"></div>
            <img
                src="{{isset($vendor->photo) ? asset(\App\Models\Vendor::PHOTO_UPLOAD_PATH.$vendor->photo)  : asset('uploads/canvas.webp')}}"
                alt="photo display area" class="photo photo-preview-area-photo"/>
        </div>
    </div>


</div>
