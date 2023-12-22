 <div class="row">
    <div class="col-md-6">
        @csrf
        <div class="mb-3">
            {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Project Name']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('project_location', 'Project Location', ['class' => 'form-label']) !!}
            {!! Form::text('project_location', null, ['class' => 'form-control', 'placeholder' => 'Enter Project Location']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('client_name', 'Client Name', ['class' => 'form-label']) !!}
            {!! Form::text('client_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Client Name']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('total_area', 'Total Area', ['class' => 'form-label']) !!}
            {!! Form::number('total_area', null, ['class' => 'form-control', 'placeholder' => 'Enter Total Area']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('total_cost', 'Total Cost', ['class' => 'form-label']) !!}
            {!! Form::number('total_cost', null, ['class' => 'form-control', 'placeholder' => 'Enter Total Cost']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('project_description', 'Description', ['class' => 'form-label']) !!}
            {!! Form::textarea('project_description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'rows' => 4]) !!}
        </div>
    </div>
</div>






{{-- @if($ourproject->photos_all)

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="photo">Existing Photos</label>
            <div class="row">
                @foreach($ourproject->photos_all as $photo)
                    <div class="col-md-4">
                        <img src="{{asset(app\Models\ProjectPhoto::PHOTO_UPLOAD_PATH. $photo['photo'])}}" alt="" class="img-fluid">
                        {!! Form::text('title[]', old('title.'.$loop->index, $photo['title']), ['class' => 'form-control', 'placeholder' => 'Enter title']) !!}
                        {!! Form::hidden('photo_id[]', $photo['id']) !!}
                        <input type="number" name="serial[]" class="form-control" placeholder="Enter Serial" value="{{old('serial.'.$loop->index, $photo['serial'])}}">


                        {!! Form::select('is_primary[]', \App\Models\ProjectPhoto::STATUS_LIST, old('is_primary.'.$loop->index, $photo['is_primary']), ['class'=>'form-select', 'placeholder'=>'Select Status']) !!}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if($ourproject->primary_photo)
    <div class="col-md-6">
        <div class="mb-3">
            <label for="primary_photo">Primary Photo</label>
            <div class="row">
                <div class="col-md-4">
                    <img src="{{asset(app\Models\ProjectPhoto::PHOTO_UPLOAD_PATH.$ourproject->primary_photo['photo'])}}" width="50px">
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endif --}}





    <div class="col-md-6">
        <div class="mb-3">
            <label for="project_category_id">Project Category</label>
            <select name="project_category_id" id="project_category_id" class="form-control">
                <option value="" disabled selected>Select a category</option>
                @foreach($all_category as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{-- photo --}}

    <div class="d-none" id="photo_container" data-photos="{{json_encode($ourproject->photos_all)}}"></div>
    
    <div class="tab-pane fade" id="images" role="tabpanel">
        <div id="product_photo_display_row">
            <!-- Display dynamically generated photo rows here -->
        </div>
    </div>

    <div class="row justify-content-center my-5">
        <div class="col-md-4">
            <label class="w-100 mb-0">
                Please Select Images
                <input id="imagesfile" type="file" class="form-control" multiple>
            </label>
        </div>
    </div>
    <div id="photo-show">
    </div>
    
</div>

<!-- Include any necessary JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Other libraries and scripts you might need -->

<script>
    const generateDisplayRow = (index, photo, display_order, alt, id = undefined) => {
        return `<div class="row align-items-center mb-4" id="photo-show${index}">
            <div class="col-md-3">
                <img src="${photo}" alt="preview photo" class="img-thumbnail product-image-upload-display"/>
                 <input type="hidden" name="photo[${index}]" value="${photo}">
                 <input type="hidden" name="photo_id[${index}]" value="${id != undefined ? id : null}">
                 <h1>${index}</h1>
            </div>
            <div class="col-md-9">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="w-100 mb-0">
                           Serial
                            <input name="serial[${index}]" value="${display_order}" type="number" class="form-control">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="w-100 mb-0">
                            Title
                            <input name="title[${index}]" value="${alt}" type="text" class="form-control">
                        </label>
                    </div>
                    <div class="col-md-1">
                        <button type="button" data-index="${index}" class="btn btn-outline-danger delete-product-display-row"><i class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
            </div>
        </div>`
}

    const handleElement = (element) => {
        // $('#product_photo_display_row').html(element);
            $('#photo-show').html(element);
        
    }

    let element = '';

    // Load existing photos from the data attribute
    const photoData = document.getElementById('photo_container').getAttribute('data-photos');
    const photos = JSON.parse(photoData);
    
    // photos.forEach(photo => {
    //     console.log('foreach, photo:' + photo.photo);
        
    // });

    photos.map((photo, index)=>{
        console.log(photo);
        // let display_order = photo.serial;
        let totallenght = Object.keys(photos).length;
        let display_order = index+1;
        let alt = photo.title;
        let product_photo = '{{ url(\App\Models\ProjectPhoto::PHOTO_UPLOAD_PATH) }}' + '/' + photo.photo;
        element += generateDisplayRow(display_order, product_photo, display_order, alt, photo.id);


       
        display_order++;
        handleElement(element);
    });

    let display_order = Object.keys(photos).length;

    $('#imagesfile').on('change', function (e) {
        let alt = $('#name').val();
        let files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            let reader = new FileReader();
            reader.onloadend = function () {
                if (reader.readyState === FileReader.DONE) {
                    if (reader.error) {
                        console.log('Error occurred while reading the file.');
                        return;
                    }
                    element += generateDisplayRow(display_order, reader.result, display_order, alt);
                     console.log(generateDisplayRow);
                    display_order++;
                    handleElement(element);

                }
            }
            reader.readAsDataURL(files[i]);
        }
    });

    $(document).on('click', '.delete-product-display-row', function () {
        let index = $(this).attr('data-index');
        console.log('clicked', index);
        $(`#photo-show${index}`).remove();
        let $temp_element = $(element);
        $temp_element.filter(`#photo-show_${index}`).html('');
        element = '';
        for (let i = 0; i < $temp_element.length; i++) {
            element += $temp_element[i].outerHTML;
        }
    });
</script>


