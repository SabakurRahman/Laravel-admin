<fieldset>
    <legend>Basic Information</legend>
<div class="row">
    <div class="col-md-6">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter Page Name']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('slug', 'Slug') !!}
        {!! Form::text('slug', null, ['class'=>'form-control', 'placeholder'=>'Enter Slug']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('serial', 'Serial') !!}
        {!! Form::number('serial', null, ['class'=>'form-control', 'placeholder'=>'Enter page serial']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('Status', 'Status') !!}
        {!! Form::select('status', \App\Models\FaqPage::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
    </div>
</div>
</fieldset>
