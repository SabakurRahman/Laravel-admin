<div class="row">
    <div class="col-md-6">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter Customer Group Name']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('Status', 'Status') !!}
        {!! Form::select('status', \App\Models\CustomerGroup::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('discount_percent', 'Discount Percent') !!}
        {!! Form::text('discount_percent', null, ['class' => 'form-control', 'placeholder' => 'Enter Discount Percent']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('discount_fixed', 'Discount Fixed') !!}
        {!! Form::text('discount_fixed', null, ['class' => 'form-control', 'placeholder' => 'Enter Discount Percent']) !!}
    </div>


</div>
