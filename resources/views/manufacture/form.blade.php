<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Manufacture Information</legend>
    <div class="row">
        <div class="col-md-4">
            {!! Form::label('name', 'Manufacture Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Manufacture Name']) !!}
        </div>
        <div class="col-md-4">
            {!! Form::label('serial', 'Serial') !!}
            {!! Form::number('serial', null, ['class'=>'form-control', 'placeholder'=>'Enter page serial']) !!}
        </div>
        <div class="col-md-4">
            {!! Form::label('Status', 'Status',['class'=>'label-style']) !!}
            {!! Form::select('status', \App\Models\Manufacture::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('description', 'Description',['class'=>'label-style']) !!}
            {!! Form::textarea('description', null, ['class'=>'form-control tinymce', 'placeholder'=>'Enter Description']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
            {!! Form::file('photo', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
            <div class="photo-preview-area">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($manufacture->photo) ? asset(\App\Models\Manufacture::PHOTO_UPLOAD_PATH.$manufacture->photo)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>


    </div>
</fieldset>



