<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Client Logo Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Client Name']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\ClientLogo::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
        {{-- <div class="col-md-6">
            {!! Form::label('photo', 'Logo',['class'=>'label-style']) !!}
            {!! Form::file('photo', ['class'=>'form-control', 'placeholder'=>'Enter logo']) !!}
        </div> --}}
        <div class="col-md-6">
            {!! Form::label('photo', 'Logo',['class'=>'label-style']) !!}
            {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
            <div class="photo-preview-area">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($clientLogo->photo) ? asset(\App\Models\ClientLogo::PHOTO_UPLOAD_PATH.$clientLogo->photo)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
    </div>
</fieldset>



