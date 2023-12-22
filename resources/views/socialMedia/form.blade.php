<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Social Media Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('name', 'Social Media Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Social Media']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\SocialMedia::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('url', 'Account Url',['class'=>'label-style']) !!}
            {!! Form::text('url', null, ['class'=>'form-control', 'placeholder'=>'Enter Account Url']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
            {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
            <div class="photo-preview-area">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($social->photo) ? asset(\App\Models\SocialMedia::PHOTO_UPLOAD_PATH.$social->photo)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
    </div>
</fieldset>



