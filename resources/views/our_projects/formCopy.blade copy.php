<style>
    .summeryStyle {
        margin-right: 5px;
        margin-top:8px!important;
        width:120px;
    }
    .summaryDiv .form-select,.summaryDiv .form-control{
        width:70%!important;
    }
    .divMarginTop{
        margin-top:15px;
    }
    .legand-top{
        margin-top:15px;
    }
   .legendbottom{
      margin-bottom: 15px!important;
   }
   .checkboxStyle label {
        margin-top: 0!important;
        margin-right:15px!important;
    }
</style>
<fieldset>
    <legend>Project Information</legend>
    <div class="row">
        <div class="row">
            {{-- project Details --}}
            <div class="col-md-6">
                <fieldset class="legand-top">
                    <legend>Project Details</legend>
                    @csrf
                    <div class="mb-3">
                        {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Project Name']) !!}
                    </div>
                    <div class="mb-3">
                        {!! Form::label('slug', 'Slug', ['class' => 'form-label']) !!}
                        {!! Form::text('slug', null, ['class' => 'form-control', 'placeholder' => 'Enter Project Slug']) !!}
                    </div>
                    <div class="mb-3">
                    {!! Form::label('project_description', 'Description', ['class' => 'form-label']) !!}
                        {!! Form::textarea('project_description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'rows' => 4]) !!}
                    </div>
                </fieldset>
            </div>
            {{-- Project Summery --}}
            <div class="col-md-6 summaryDiv">
                <fieldset class="legand-top">
                    <legend class="legendbottom">Project Summery</legend>
                    <div class="row">
                        <div style="display:flex;">
                            <label class="summeryStyle" for="type">Project Type</label>
                            {!! Form::select('type', \App\Models\OurProjects::TYPE_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
                        </div>
                    </div>
                    <div class="row divMarginTop">
                        <div style="display:flex;">
                            <label class="summeryStyle" for="project_category_id">Project Category</label>
                            <select name="project_category_id" id="project_category_id" class="form-select">
                                <option value="" disabled selected>Select a category</option>
                                @foreach($all_category as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div  class="row divMarginTop">
                        <div style="display:flex;">
                            <label class="summeryStyle" for="client_name">Client Name</label>
                            {!! Form::text('client_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Client Name']) !!}
                        </div>
                    </div>
                    <div  class="row divMarginTop">
                        <div style="display:flex;">
                            <label class="summeryStyle" for="total_area">Total Area</label>
                            {!! Form::number('total_area', null, ['class' => 'form-control', 'placeholder' => 'Enter Total Area']) !!}
                    </div>
                    <div  class="row divMarginTop">
                        <div style="display:flex;">
                            <label class="summeryStyle" for="status">Total Cost</label>
                            {!! Form::number('total_cost', null, ['class' => 'form-control', 'placeholder' => 'Enter Total Cost']) !!}
                        </div>
                    </div>
                    <div  class="row divMarginTop">
                        <div style="display:flex;">
                            <label class="summeryStyle" for="project_location">Project Location</label>
                            {!! Form::text('project_location', null, ['class' => 'form-control', 'placeholder' => 'Enter Project Location']) !!}
                        </div>
                    </div>
                    
                    <div class="row divMarginTop">
                        <div style="display:flex;">
                            {!! Form::label('is_show_on_home_page', 'Show on Home page', ['class' => 'summeryStyle']) !!}
                            <div style="display:flex;"class="radio-buttons checkboxStyle">
                                <div class="form-check">
                                    {!! Form::radio('is_show_on_home_page', '1', null, ['class' => 'form-check-input', 'id' => 'show_on_home_yes']) !!}
                                    {!! Form::label('show_on_home_yes', 'Yes', ['class' => 'form-check-label']) !!}
                                </div>
                                <div class="form-check">
                                    {!! Form::radio('is_show_on_home_page', '2', null, ['class' => 'form-check-input', 'id' => 'show_on_home_no']) !!}
                                    {!! Form::label('show_on_home_no', 'No', ['class' => 'form-check-label']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="row divMarginTop">
                        <div style="display:flex;">
                            <label class="summeryStyle" for="status">Status</label>
                            {!! Form::select('status', \App\Models\OurProjects::STATUS_LIST , null, ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
                        </div>
                    </div>
                </fieldset>
            </div>
            {{-- TAG LISTS --}}
            <div class="col-md-12">
                <fieldset style="margin-right:20px!important;"class="legand-top">
                    <legend class="legendbottom">Project Tags</legend>
                            <div class="row">
                    <div class="col-md-6">
                        @foreach($tags->take($tags->count() / 2) as $tag)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}">
                                <label style="margin-top:0!important;font-size:15px!important" class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-6">
                        @foreach($tags->skip($tags->count() / 2) as $tag)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}">
                                <label style="margin-top:0!important;font-size:15px!important" class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                    {{-- <div class="row">
                        
                        <div class="col-md-6">
                            @php
                                $halfCount = ceil($tags->count() / 2);
                                $firstHalf = $tags->take($halfCount);
                            @endphp
                            @foreach($firstHalf as $tag)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}">
                                    <label style="margin-top:0!important;font-size:15px!important" class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            @php
                                $secondHalf = $tags->slice($halfCount);
                            @endphp
                            @foreach($secondHalf as $tag)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag_{{ $tag->id }}">
                                    <label style="margin-top:0!important;font-size:15px!important" class="form-check-label" for="tag_{{ $tag->id }}">{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div> --}}
                </fieldset>
        
            </div>
        </div>

        <div class="row">
            {{-- *************** --}}
            <div class="col-md-6">
                {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
                {!! Form::file('photo[]', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description','multiple' => true, 'id' => 'photo-input']) !!}
                <div class="photo-preview-area">
                    <i class="ri-camera-line"></i>
                    <div class="overly"></div>
                    <img
                        src="{{isset($projectPhoto->photo) ? asset(\App\Models\ProjectPhoto::PHOTO_UPLOAD_PATH.$projectPhoto->photo)  : asset('uploads/canvas.webp')}}"
                        alt="photo display area" class="photo photo-preview-area-photo"/>
                </div>
            </div>
            {{-- *********** --}}
            {{-- <div class="col-md-6">
                <div class="mb-3">
                    {!! Form::label('photo', 'Photos', ['class' => 'form-label']) !!}
                    {!! Form::file('photo[]', ['class' => 'form-control', 'multiple' => true, 'id' => 'photo-input']) !!}
                    
                </div>
            </div> --}}
            <div class="col-md-12">
                <div id="selected-photo-preview" style="display: none;">
                    <p><strong>Selected Photos:</strong></p>
                    <div id="photo-preview-container"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3"  style="display: none;" >
                    {!! Form::label('title', 'title', ['class' => 'form-label']) !!}
                    <div id='title'>
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="mb-3" style="display: none;" >
                    {!! Form::label('serial', 'serial', ['class' => 'form-label']) !!}
                    <div id='serial'>

                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class=""   id="is_primary" style="display: none;" >
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<fieldset class="mt-4">
    <legend>Seo</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('meta_title', ' Seo Title') !!}
            {!! Form::text('meta_title',$ourproject->seos->title ?? null, ['class'=>'form-control', 'placeholder'=>'Enter blog category title']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_title_bn', 'Seo Title_bn') !!}
            {!! Form::text('meta_title_bn',$ourproject->seos->title_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter seo title bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_keywords', 'Keywords') !!}
            {!! Form::text('meta_keywords', $ourproject->seos->keywords ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_keywords_bn', 'Keywords bn') !!}
            {!! Form::text('meta_keywords_bn', $ourproject->seos->keywords_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_description', 'Seo Description ') !!}
            {!! Form::text('meta_description', $ourproject->seos->description ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description']) !!}
        </div> <div class="col-md-6">
            {!! Form::label('meta_description_bn', 'Seo Description bn ') !!}
            {!! Form::text('meta_description_bn',$ourproject->seos->description_bn ??null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description bn ']) !!}
        </div>

        <div class="col-md-8">
            {!! Form::label('og_image', 'Og image',['class'=>'label-style']) !!}
            {!! Form::file('og_image', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Og image']) !!}
            <div class="photo-preview-area" style="width: 250px; height: 150px">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($ourproject?->seos?->og_image) ? asset(\App\Models\Seo::Seo_PHOTO_UPLOAD_PATH . $ourproject?->seos?->og_image)  : asset('uploads/canvas.webp')}}"
                    alt="photo display area" class="photo photo-preview-area-photo"/>
            </div>
        </div>
    </div>
</fieldset>


<script>
    const photoInput = document.getElementById('photo-input');
    const photoPreview = document.getElementById('selected-photo-preview');
    const photoPreviewContainer = document.getElementById('photo-preview-container');
    const is_primary = document.getElementById('is_primary');
    const title = document.getElementById('title');
    const serial = document.getElementById('serial');
    let serial_number = 0;

    photoInput.addEventListener('change', (event) => {
        photoPreviewContainer.innerHTML = '';
        const selectedFiles = event.target.files;
        if (selectedFiles.length > 0) {
            photoPreview.style.display = 'block';
            for (const file of selectedFiles) {
                const textcontainer= document.createElement('div');
                const imageContainer = document.createElement('div');
                const image = document.createElement('img');
                image.style.height = '30%';
                image.style.width = '30%';
                imageContainer.style.margin = '10px';
                imageContainer.style.height = '300px';
                imageContainer.style.width = '80%';
                imageContainer.style.border = '1px solid #ddd';
                imageContainer.style.borderRadius = '5px';
                imageContainer.style.padding = '10px';
                serial_number++;
                imageContainer.classList.add('col-md-3');
                image.src = URL.createObjectURL(file);
                const title = document.createElement('input');
                title.type = 'text';
                title.name = 'title[]';
                title.placeholder = 'Enter Title';
                title.classList.add('form-control', 'mb-2');
                const serial = document.createElement('input');
                serial.value = serial_number;
                serial.type = 'number';
                serial.name = 'serial[]';
                serial.placeholder = 'Enter Serial';
                serial.classList.add('form-control', 'mb-2');
                const is_primary = document.createElement('select');
                is_primary.name = 'is_primary[]';
                is_primary.classList.add('form-control', 'mb-2');
                const option1 = document.createElement('option');
                option1.value = '1';
                option1.innerHTML = 'Primary';
                const option2 = document.createElement('option');
                option2.value = '0';
                option2.innerHTML = 'Secondary';
                is_primary.appendChild(option1);
                is_primary.appendChild(option2);
                imageContainer.appendChild(title);
                imageContainer.appendChild(serial);
                imageContainer.appendChild(is_primary);


                imageContainer.appendChild(image);
                photoPreviewContainer.appendChild(imageContainer);
            }
        } else {
            photoPreview.style.display = 'none';
        }
    });

</script>

<script src="{{asset('tamplate/assets/js/pages/form-advanced.init.js')}}"></script>
<!-- JAVASCRIPT -->
<script src="{{asset('tamplate/assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('tamplate/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('tamplate/assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('tamplate/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('tamplate/assets/libs/node-waves/waves.min.js')}}"></script>

<script src="{{asset('tamplate/assets/libs/select2/js/select2.min.js')}}"></script>
<script src="{{asset('tamplate/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('tamplate/assets/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
<script src="{{asset('tamplate/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{asset('tamplate/assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js')}}"></script>
<script src="{{asset('tamplate/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
<script src="{{asset('tamplate/assets/js/pages/form-advanced.init.js')}}"></script>
<script src="{{asset('tamplate/assets/js/app.js')}}"></script>
