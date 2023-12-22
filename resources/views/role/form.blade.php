<style>
    .label-style{
        margin-top:20px;
    }
    .form-select{
        font-size: 14px!important;
    }
</style>
<fieldset>
    <legend>Role Information</legend>
    <div class="row">
        <div class="col-md-12">
            {!! Form::label('name', 'Role Name') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Role Name']) !!}
        </div>

    
    </div>
</fieldset>



