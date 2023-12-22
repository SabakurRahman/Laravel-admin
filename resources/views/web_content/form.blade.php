<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>BWeb Content Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('location', 'location',['class'=>'label-style']) !!}
            {!! Form::select('location', \App\Models\WebContent::LOCATION_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Location']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('content', 'content') !!}
            {!! Form::textarea('content', null, ['class'=>'form-control tinymce', 'placeholder'=>'Write here']) !!}
        </div>



    </div>
</fieldset>



