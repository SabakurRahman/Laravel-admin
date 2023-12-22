<style>
    .label-style{
        margin-top:20px;
    }
</style>
<fieldset>
    <legend>Banner Size Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('banner_name', 'Banner Name') !!}
            {!! Form::text('banner_name', null, ['class'=>'form-control', 'placeholder'=>'Banner Name']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('location', 'Location') !!}
            {!! Form::text('location', null, ['class'=>'form-control', 'placeholder'=>'Enter Location']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('height', 'Height',['class'=>'label-style']) !!}
            {!! Form::number('height', null, ['class'=>'form-control', 'placeholder'=>'Enter Banner Height']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('width', 'Width',['class'=>'label-style']) !!}
            {!! Form::number('width', null, ['class'=>'form-control', 'placeholder'=>'Enter Banner Width']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status',['class'=>'label-style']) !!}
            {!! Form::select('status', \App\Models\BannerSize::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
        </div>
        
        
    </div>
</fieldset>



