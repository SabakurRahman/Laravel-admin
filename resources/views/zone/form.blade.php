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
            {!! Form::select('status', \App\Models\Zone::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select status']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('is_inside_dhaka', ' Inside dhaka') !!}
            {!! Form::select('is_inside_dhaka', \App\Models\Zone::IS_INSIDE_DHAKA_OR_NOT_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select status']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('city_id', 'City') !!}
            {!! Form::select('city_id',$cityOptions, null, ['class'=>'form-select', 'placeholder'=>'Select City']) !!}
        </div>
    </div>
</fieldset>












