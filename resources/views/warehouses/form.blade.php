<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Warehouse Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('name', 'Warehouse Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Warehouse Name']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\Warehouse::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('street_address', 'Address',['class'=>'label-style']) !!}
            {!! Form::text('street_address', null, ['class'=>'form-control', 'placeholder'=>'Enter Address']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('phone', 'Phone',['class'=>'label-style']) !!}
            {!! Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>'Phone Number']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('city', 'City',['class'=>'label-style']) !!}
            {!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>'Enter City']) !!}
        </div>


        <div class="col-md-12">
            {!! Form::label('admin_comment', 'Admin Comment',['class'=>'label-style']) !!}
            {!! Form::textarea('admin_comment', null, ['class'=>'form-control', 'placeholder'=>'Enter Comment']) !!}
        </div>

    </div>
</fieldset>



