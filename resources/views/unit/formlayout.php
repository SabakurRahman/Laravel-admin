<div class="col-md-6">
@csrf
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter Page Name']) !!}
  </div>
  <div class="col-md-6">
  {!! Form::label('serial', 'Serial') !!}
        {!! Form::number('serial', null, ['class'=>'form-control', 'placeholder'=>'Enter page serial']) !!}
  </div>
  <div class="col-12">
  {!! Form::label('Status', 'Status') !!}
        {!! Form::select('status', \App\Models\FaqPage::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
  </div>
  <div class="col-12">

  <label for="our_project_id">Project</label>
        <select name="our_project_id" id="our_project_id" class="form-control">
            <option value="" disabled selected>Select a Project</option>
            @foreach($all_our_projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
  </div>