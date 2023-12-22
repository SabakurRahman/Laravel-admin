<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Estimate Package Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('name', 'Estimate Package Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Estimate Package']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('slug', 'Slug') !!}
            {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter Slug']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\EstimatePackage::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
    </div>
</fieldset>