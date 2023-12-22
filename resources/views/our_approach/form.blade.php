<fieldset>
    <legend>Basic Information</legend>
<div class="row">
    <div class="col-md-6">
        {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Page Name']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('slug', 'Slug', ['class' => 'form-label']) !!}
        {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter Slug']) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {!! Form::label('serial', 'Serial', ['class' => 'form-label']) !!}
        {!! Form::number('serial', null, ['class' => 'form-control', 'placeholder' => 'Enter page serial']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('Status', 'Status') !!}
        {!! Form::select('status', App\Models\OurApproach::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}

</div>

    <div class="row">
        <div class="col-md-12">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', null, ['class'=>'form-control tinymce', 'placeholder'=>'Enter Description']) !!}
        </div>


<div class="row">
    <div class="col-md-6">
        {!! Form::label('banner', 'Banner',['class'=>'label-style']) !!}
        {!! Form::file('banner', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description']) !!}
        <div class="photo-preview-area">
            <i class="ri-camera-line"></i>
            <div class="overly"></div>
            <img
                src="{{isset($ourApproach->banner) ? asset(\App\Models\OurApproach::BANNER_UPLOAD_PATH.$ourApproach->banner)  : asset('uploads/canvas.webp')}}"
                alt="photo display area" class="photo photo-preview-area-photo"/>
        </div>
    </div>
    <div class="col-md-6">
        {!! Form::label('our_approach_category_id', 'Our Approach category') !!}
        {!! Form::select('our_approach_category_id', $ourApproachCategoryOptions, null, ['class'=>'form-select', 'placeholder'=>'Select Faq Pages']) !!}
    </div>



     </div>
    </div>

</div>
</fieldset>
