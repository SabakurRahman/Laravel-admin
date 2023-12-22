<fieldset>
    <legend>Basic Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter division name']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('name_bn', 'Name Bn') !!}
            {!! Form::text('name_bn', null, ['class'=>'form-control', 'placeholder'=>'Enter division name bn']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\City::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select status']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('division_id', 'Division') !!}
            {!! Form::select('division_id',$divisionOptions, null, ['class'=>'form-select', 'placeholder'=>'Select division']) !!}
        </div>
    </div>
</fieldset>












