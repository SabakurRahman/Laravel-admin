<fieldset>
    <legend>Basic Information</legend>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('name_bn', 'Name Bn') !!}
                {!! Form::text('name_bn', null, ['class' => 'form-control', 'placeholder' => 'Enter Name Bn']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('attribute', 'Attribute', ['class' => 'form-label']) !!}
                {!! Form::select('attribute_id',$attributeOptions, null, ['class' => 'form-select', 'placeholder' => 'Select Attribute']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('status', 'Status') !!}
                {!! Form::select('status', \app\Models\AttributeValue::STATUS_LIST, null, ['class' => 'form-select', 'placeholder' => 'Select Status']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('display_order', 'Display Order') !!}
                {!! Form::number('display_order', null, ['class' => 'form-control', 'placeholder' => 'Enter Display Order']) !!}
            </div>
        </div>
    </div>
</div>
</fieldset>
