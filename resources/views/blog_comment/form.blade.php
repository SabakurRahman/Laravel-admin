<div class="row">
    <div class="col-md-6">
        {!! Form::label('comment', 'Comment') !!}
        {!! Form::text('comment', null, ['class'=>'form-control', 'placeholder'=>'Enter your comment']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('Status', 'Status') !!}
        {!! Form::select('status', \App\Models\BlogComment::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
    </div>

</div>
