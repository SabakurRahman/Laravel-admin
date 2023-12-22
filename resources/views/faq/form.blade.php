<fieldset>
    <legend>Basic Information</legend>
    <div class="row">
    <div class="col-md-6">
        {!! Form::label('question_title', 'Question') !!}
        {!! Form::text('question_title', null, ['class'=>'form-control', 'placeholder'=>'Enter Faq Title']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('description', 'Answer') !!}
        {!! Form::text('description', null, ['class'=>'form-control', 'placeholder'=>'Enter Description']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('Status', 'Status') !!}
        {!! Form::select('status', \App\Models\Faq::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('faqable_id', 'Faq Page') !!}
        {!! Form::select('faqable_id', $faqPageOptions, null, ['class'=>'form-select', 'placeholder'=>'Select Faq Pages']) !!}
        {!! Form::hidden('faqable_type', $faqableType) !!}
    </div>
</div>
</fieldset>

