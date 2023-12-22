<fieldset>
    <legend>Basic Information</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>'Enter blog category title']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('slug', 'Slug') !!}
            {!! Form::text('slug', null, ['class'=>'form-control', 'placeholder'=>'Enter slug']) !!}
        </div>
        <div class="col-md-12">
            {!! Form::label('description', 'Description') !!}
            {!! Form::textarea('description', null, ['class'=>'form-control tinymce', 'placeholder'=>'Enter Description']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('blog_category_id', 'Blog Category ') !!}
            {!! Form::select('blog_category_id',$blog_category_name , null, ['class'=>'form-select', 'placeholder'=>'Select blog category']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('Status', 'Status') !!}

        </div>

        <div class="col-md-6">
            {!! Form::label('type', 'Type') !!}
            {!! Form::select('type', \App\Models\BlogPost::BLOG_TYPE , null, ['class'=>'form-select', 'placeholder'=>'Select type']) !!}
        </div>


        <div class="col-md-6 video-input d-none">
            {!! Form::label('video', 'Video') !!}
            {!! Form::text('video', null, ['class' => 'form-control', 'placeholder' => 'Enter video']) !!}
        </div>


        <div class="row">
            <div class="col-md-3">
                {!! Form::label('photo', 'Photo',['class'=>'label-style']) !!}
                {!! Form::file('photos[]', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Enter Description','multiple' => true, 'id' => 'photo-input']) !!}
                <div class="photo-preview-area">
                    <i class="ri-camera-line"></i>
                    <div class="overly"></div>
                    <img
                        src="{{asset('uploads/canvas.webp')}}"
                        alt="photo display area" class="photo photo-preview-area-photo"/>
                    {{-- <img
                        src="{{isset($projectPhoto->photo) ? asset(\App\Models\ProjectPhoto::PHOTO_UPLOAD_PATH.$projectPhoto->photo)  : asset('uploads/canvas.webp')}}"
                        alt="photo display area" class="photo photo-preview-area-photo"/> --}}
                </div>

            </div>

            <div class="col-md-9">
                <div class="row mt-5">
                    @isset($blogPost)
                    @foreach ($blogPost->blogPhoto as $photo)
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <img style="max-width: 100% ; height: auto" src="{{ asset(\App\Models\BlogPost::PHOTO_UPLOAD_PATH . $photo->photo) }}" width="100%" class="card-img-top" alt="Blog Photo">
                            </div>
                        </div>
                    @endforeach
                    @endisset
                </div>
            </div>

            <div style="margin-top:30px!important;"class="col-md-12">
                <div id="selected-photo-preview" style="display: none;">
                    <p><strong>Selected Photos:</strong></p>
                    <div id="photo-preview-container"></div>
                </div>

            </div>

        </div>

    </div>
</fieldset>
<fieldset class="mt-4">
    <legend>SEO</legend>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('meta_title', ' Seo Title') !!}
            {!! Form::text('meta_title',$blogPost->seos->title ?? null, ['class'=>'form-control', 'placeholder'=>'Enter blog category title']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_title_bn', 'Seo Title_bn') !!}
            {!! Form::text('meta_title_bn',$blogPost->seos->title_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter seo title bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_keywords', 'Keywords') !!}
            {!! Form::text('meta_keywords', $blogPost->seos->keywords ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::label('meta_keywords_bn', 'Keywords bn') !!}
            {!! Form::text('meta_keywords_bn', $blogPost->seos->keywords_bn ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Keywords bn']) !!}
        </div>
        <div class="col-md-6">
            {!! Form::label('meta_description', 'Seo Description ') !!}
            {!! Form::text('meta_description', $blogPost->seos->description ?? null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description']) !!}
        </div> <div class="col-md-6">
            {!! Form::label('meta_description_bn', 'Seo Description bn ') !!}
            {!! Form::text('meta_description_bn', $blogPost->seos->description_bn ??null, ['class'=>'form-control', 'placeholder'=>'Enter Seo Description bn ']) !!}
        </div>

        <div class="col-md-8">
            {!! Form::label('og_image', 'Og image',['class'=>'label-style']) !!}
            {!! Form::file('og_image', ['class'=>'form-control d-none photo-input', 'placeholder'=>'Og image']) !!}
            <div class="photo-preview-area" style="width: 250px; height: 150px">
                <i class="ri-camera-line"></i>
                <div class="overly"></div>
                <img
                    src="{{isset($blogPost->seos->og_image) ? asset(\App\Models\Seo::Seo_PHOTO_UPLOAD_PATH . $blogPost->seos->og_image)  : asset('uploads/canvas.webp')}}"
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
    let serial_number = 0;

    photoInput.addEventListener('change', (event) => {
        photoPreviewContainer.innerHTML = ''; // Clear the existing content
        const selectedFiles = event.target.files;
        if (selectedFiles.length > 0) {
            photoPreview.style.display = 'block';
            const imagesRow = document.createElement('div'); // Create a parent container for images
            imagesRow.style.display = 'flex'; // Set it to display images in one row
            imagesRow.style.flexWrap = 'wrap'; // Allow wrapping if there are too many images
            for (const file of selectedFiles) {
                const imageContainer = document.createElement('div');
                const image = document.createElement('img');
                image.style.height = '120px';
                image.style.width = '200px';
                imageContainer.style.border = '1px solid #ddd';
                imageContainer.style.borderRadius = '1px';
                imageContainer.style.padding = '10px';
                imageContainer.style.display = 'flex';
                imageContainer.style.marginTop = '20px';
                serial_number++;
                imageContainer.classList.add('col-md-3');
                image.src = URL.createObjectURL(file);
                imageContainer.appendChild(image);
                // Add the image container to the parent container
                imagesRow.appendChild(imageContainer);
            }
            // Add the parent container to the preview container
            photoPreviewContainer.appendChild(imagesRow);
        } else {
            photoPreview.style.display = 'none';
        }
    });
</script>








