<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Newsletter Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('name', 'Newsletter Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter Newsletter Name']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Enter E-mail']) !!}
        </div>
        {{-- <div class="col-md-6">
            {!! Form::label('ip', 'IP Address') !!}
            {!! Form::text('ip', null, ['class'=>'form-control', 'placeholder'=>'Enter Your Ip Address']) !!}
        </div> --}}
        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}
            {!! Form::select('status', \App\Models\NewsLetter::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>


    
    </div>
</fieldset>



