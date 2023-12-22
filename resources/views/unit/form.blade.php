<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Unit Information</legend>
    <div class="row">
      <div class="col-md-6">
            {!! Form::label('name', 'Unit Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Unit Name']) !!}
      </div>
      <div class="col-md-6">
            {!! Form::label('short_name', 'Short Name') !!}
            {!! Form::text('short_name', null, ['class'=>'form-control', 'placeholder'=>'Short Name']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\Unit::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
       
    </div>
</fieldset>




