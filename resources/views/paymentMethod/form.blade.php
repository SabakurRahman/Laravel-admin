<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Payment Method Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('name', 'Payment Method Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Payment Method']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\PaymentMethod::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('account_no', 'Account No',['class'=>'label-style']) !!}
            {!! Form::number('account_no', null, ['class'=>'form-control', 'placeholder'=>'Enter Account No']) !!}
        </div>
    </div>
</fieldset>



