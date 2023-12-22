<fieldset>
    <legend>Basic Information</legend>
<div class="row"><div class="col-md-6">
    @csrf
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter Tag Name']) !!}
      </div>
      <div class="col-md-6">
      {!! Form::label('status', 'Status') !!}
            {!! Form::select('status', \App\Models\Tag::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
      </div>



</div>
</fieldset>
