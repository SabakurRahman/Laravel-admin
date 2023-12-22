<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Photo Gallery Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Title Name']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\PhotoGallerie::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
            <div class="col-md-6">
            {!! Form::label('is_shown_on_slider', 'Slider Option',['class'=>'label-style']) !!}
            {!! Form::select('is_shown_on_slider', \App\Models\PhotoGallerie::SLIDER_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Slider Option']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
            {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
            <div class="photo-preview-area">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($photoGallerie->photo) ? asset(\App\Models\PhotoGallerie::PHOTO_UPLOAD_PATH.$photoGallerie->photo)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
    </div>
</fieldset>



