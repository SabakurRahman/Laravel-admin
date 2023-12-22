@extends('frontend.layouts.master')
@section('content')
       @include('global_partials.validation_error_display')
    <div class="row">
        <div class="col-md-12">
            {!! Form::model($product, ['route'=>['product.update', $product->id], 'method'=>'put','files'=>true]) !!}
            @include('product.form')
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="d-grid">
                        {!! Form::button('Update Product Information', ['class' => 'btn btn-outline-theme mt-4', 'type'=>'submit']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <div id="variation_data" data-variation="{{json_encode($product->productVariations)}}"></div>
        </div>
    </div>
    <div class="d-none" data-attribute-value="{{json_encode($attribute_values)}}" id="attribute_values"></div>
    <div class="d-none" data-attribute-name="{{json_encode($attributes)}}" id="attribute_names"></div>
@endsection
{{-- @include('product.edit-partials.script') --}}
@push('css')
    <style>
        .select2-results__option[aria-selected=true] {
            display: none;
        }
    </style>
@endpush
<style>
    .justify-content-between{
        justify-content: space-between;
    }
    .space{
        margin-right:5px!important;
    }
    .delete-design{
        display: block;
        margin-left:auto;
    }
</style>
@push("script")
    {{-- faq --}}
    <script>
        $(document).ready(function () {
            // Initialize with the number of existing FAQs
            var faqCount = {{ count($product->faqs) }};

            $('#faq-container').on('click', '.delete-faq-row', function () {
                $(this).closest('.faq-group').remove();
            });

            // Function to add a new set of FAQ input fields
            function addFAQInputFields() {
                faqCount++;
                var faqHtml = `
                    <div class="faq-group border-area">
                        <div class="d-flex "> 
                            <div class="mt-3 col-md-6 space">
                                {!! FORM::label('question_title', 'Question') !!}
                                {!! FORM::text('faqs[${faqCount}][question_title]', null, ['class' => 'form-control', 'placeholder' => 'Enter Question']) !!}
                            </div>
                            <div class="mt-3 col-md-6">
                                {!! Form::label('description', 'Answer') !!}
                                {!! FORM::text('faqs[${faqCount}][description]', null, ['class' => 'form-control', 'placeholder' => 'Enter description']) !!}
                            </div>
                        </div>
                        <div class="mt-3 col-md-6">
                            {!! Form::label('Status', 'Status') !!}
                            {!! Form::select('faqs[${faqCount}][status]', \App\Models\Faq::STATUS_LIST, null, ['class' => 'form-select', 'placeholder' => 'Select Status']) !!}
                        </div>

                        <div class="col-md-1 delete-design">
                            <button type="button" class="btn btn-danger delete-faq-row"><i style="color:white" class="ri-delete-bin-line"></i></button>
                        </div>
                    </div>
                `;

                $('#faq-container').append(faqHtml);
            }

            // Add FAQ input fields when the "Add FAQ" button is clicked
            $('#add-faq').click(function () {
                addFAQInputFields();
            });
        });
    </script>

    {{-- for Specification --}}
    <script>
        $(document).ready(function () {
            var specificationCount = {{ count($product->specifications) ?? 0 }};

            // Function to add a new set of specification input fields
            function addSpecificationInputFields() {
                specificationCount++;
                var specificationHtml = `
                    <div class="specification-group border-area">
                        <div class="d-flex justify-content-between"> 
                            <div class="mx-2 col-md-5 space">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text("specifications[${specificationCount}][name]", null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
                            </div>
                            <div class="mx-2 col-md-5">
                                {!! Form::label('value', 'Value') !!}
                                {!! Form::text("specifications[${specificationCount}][value]", null, ['class' => 'form-control', 'placeholder' => 'Enter Value']) !!}
                            </div>
                            <div class="mx-2">
                                <button style="top: 35px;position: relative;"type="button" class="btn btn-danger delete-specification-row"><i style="color:white" class="ri-delete-bin-line"></i></button>
                            </div>
                        </div>
                    </div>
                `;

                // Prepend the specificationHtml to move it above the button
                $('#specification-container').prepend(specificationHtml);

                // Attach a click event handler to the delete button
                $('.delete-specification-row').click(function () {
                    // Remove the entire specification group when the delete button is clicked
                    $(this).closest('.specification-group').remove();
                });
            }

            // Add specification input fields when the "Add Specification" button is clicked
            $('#add-specification').click(function () {
                addSpecificationInputFields();
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function () {
            // Initialize with the number of existing specifications
            var specificationCount = {{ count($product->specifications) ?? 0 }};
            
            // Function to add a new set of specification input fields
            function addSpecificationInputFields() {
                specificationCount++;
                var specificationHtml = `
                    <div class="specification-group border-area">
                        <div class="d-flex justify-content-between"> 
                            <div class="mx-2 col-md-5 space">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text("specifications[${specificationCount}][name]", null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
                            </div>
                            <div class="mx-2 col-md-5">
                                {!! Form::label('value', 'Value') !!}
                                {!! Form::text("specifications[${specificationCount}][value]", null, ['class' => 'form-control', 'placeholder' => 'Enter Value']) !!}
                            </div>
                            <div class="mx-2">
                                <button style="top: 35px;position: relative;"type="button" class="btn btn-danger delete-specification-row"><i style="color:white" class="ri-delete-bin-line"></i></button>
                            </div>
                           
                        </div>
                    </div>
                `;

                $('#specification-container').append(specificationHtml);

                // Attach a click event handler to the delete button
                $('.delete-specification-row').click(function () {
                    // Remove the entire specification group when the delete button is clicked
                    $(this).closest('.specification-group').remove();
                });
            }

            // Add specification input fields when the "Add Specification" button is clicked
            $('#add-specification').click(function () {
                addSpecificationInputFields();
            });
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function () {
            // Initialize with the number of existing specifications
            var specificationCount = {{ count($product->specifications) ?? 0 }};
            
            // Function to add a new set of specification input fields
            function addSpecificationInputFields() {
                specificationCount++;
                var specificationHtml = `
                    <div class="specification-group border-area">
                        <div class="d-flex "> 
                            <div class="mt-3 col-md-6 space">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text("specifications[${specificationCount}][name]", null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
                            </div>
                            <div class="mt-3 col-md-6">
                                {!! Form::label('value', 'Value') !!}
                                {!! Form::text("specifications[${specificationCount}][value]", null, ['class' => 'form-control', 'placeholder' => 'Enter Value']) !!}
                            </div>
                        </div>
                        <div class="col-md-1 delete-design">
                            <button type="button" class="btn btn-danger delete-specification-row"><i style="color:white" class="ri-delete-bin-line"></i></button>
                        </div>
                    </div>
                `;

                $('#specification-container').append(specificationHtml);

                // Attach a click event handler to the delete button
                $('.delete-specification-row').click(function () {
                    // Remove the entire specification group when the delete button is clicked
                    $(this).closest('.specification-group').remove();
                });
            }

            // Add specification input fields when the "Add Specification" button is clicked
            $('#add-specification').click(function () {
                addSpecificationInputFields();
            });
        });
    </script> --}}

    <script>
            $('input[name="discount_type"]').on('change', function () {
                let value = $(this).val()
                if (value == 1) {
                    $('#automatic_discount').slideDown()
                    $('#manual_discount').slideUp()
                    $('#discount-panel').slideDown()
                } else if (value == 0){
                    $('#automatic_discount').slideUp()
                    $('#manual_discount').slideDown()
                    $('#discount-panel').slideDown()
                }else{
                    $('#discount-panel').slideUp()
                    $('#manual_discount').slideUp()
                    $('#automatic_discount').slideUp()
                }
            })
    </script>
    {{-- for slug --}}
    <script>
        $('#title').on('input', function () {
            $('#slug').val(formatSlug($(this).val()))
        })
    </script>

        {{-- <script>
            if ("") {
                Swal.fire({
                    position: 'top-end',
                    icon: "",
                    title: "",
                    showConfirmButton: false,
                    toast: true,
                    timer: 1500
                })
            }

            document.getElementById('submitButton').addEventListener('click', function () {
                document.getElementById('myForm').submit();
            });

                new TomSelect("#input-tags", {
                persist: false,
                createOnBlur: true,
                create: true
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        </script> --}}
{{-- <script>
    // Function to generate the display row for existing photos
    const generateDisplayRow = (index, photo, display_order, alt) => {
        return `<div class="mb-4 row align-items-center" id="photo_preview_row_${index}">
            <div class="col-md-3">
                <img src="${photo}" alt="preview photo" class="img-thumbnail product-image-upload-display"/>
                <input type="hidden" name="photos[${index}][photo]" value="${photo}">
            </div>
            <div class="col-md-9">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="mb-0 w-100">
                            Display Order
                            <input name="photos[${index}][serial]" value="${display_order}" type="number" class="form-control">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0 w-100">
                            Alt Text
                            <input name="photos[${index}][alt_text]" value="${alt}" type="text" class="form-control">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0 w-100">
                            Title
                            <input name="photos[${index}][title]" value="${alt}" type="text" class="form-control">
                        </label>
                    </div>
                    <div class="col-md-1">
                        <button type="button" data-index="${index}" class="btn btn-danger delete-product-display-row"><i style="color:white" class="ri-delete-bin-line"></i></button>
                    </div>
                </div>
            </div>
        </div>`;
    }

    // Function to handle file select for new photos
    const handleFileSelect = (files) => {
        const previewRow = document.getElementById('product_photo_display_row');
        let display_order = 1;

        for (const file of files) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Preview photo';
                img.classList.add('img-thumbnail', 'product-image-upload-display');

                // Append the new image to the preview row
                const newPhotoRow = document.createElement('div');
                newPhotoRow.classList.add('mb-4', 'row', 'align-items-center');
                newPhotoRow.innerHTML = `
                    <div class="col-md-3">
                        ${img.outerHTML}
                        <input type="hidden" name="new_photos[]" value="${e.target.result}">
                    </div>
                    <div class="col-md-9">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label class="mb-0 w-100">
                                    Display Order
                                    <input type="number" class="form-control" name="new_photo_serials[]" value="${display_order}">
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0 w-100">
                                    Alt Text
                                    <input type="text" class="form-control" name="new_photo_alt_texts[]" value="">
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0 w-100">
                                    Title
                                    <input type="text" class="form-control" name="new_photo_titles[]" value="">
                                </label>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger delete-new-photo-row">
                                    <i style="color:white" class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                previewRow.appendChild(newPhotoRow);
                display_order++;
            };

            reader.readAsDataURL(file);
        }
    }

    // Populate existing photos if available
    const existingPhotos = {!! json_encode($existingPhotos) !!};
    existingPhotos.forEach((photo, index) => {
        let alt = photo.alt_text; // Change this according to your data structure
        let display_order = photo.serial; // Change this according to your data structure
        let photoUrl = photo.photo; // Change this according to your data structure
        let element = generateDisplayRow(index, photoUrl, display_order, alt);
        document.getElementById('product_photo_display_row').insertAdjacentHTML('beforeend', element);
    });

    document.getElementById('images').addEventListener('change', function (e) {
        let alt = $('#name').val();
        let files = e.target.files;
        handleFileSelect(files);
    });
</script> --}}
{{-- custom script --}}
{{-- <script>
    document.getElementById('images').addEventListener('change', handleFileSelect);

    function handleFileSelect(event) {
        const files = event.target.files;
        const previewRow = document.getElementById('product_photo_display_row');

        for (const file of files) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Preview photo';
                img.classList.add('img-thumbnail', 'product-image-upload-display');

                // Append the new image to the preview row
                const newPhotoRow = document.createElement('div');
                newPhotoRow.classList.add('mb-4', 'row', 'align-items-center');
                newPhotoRow.innerHTML = `
                    <div class="col-md-3">
                        ${img.outerHTML}
                        <input type="hidden" name="new_photos[]" value="${e.target.result}">
                    </div>
                    <div class="col-md-9">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label class="mb-0 w-100">
                                    Display Order
                                    <input type="number" class="form-control" name="new_photo_serials[]" value="">
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0 w-100">
                                    Alt Text
                                    <input type="text" class="form-control" name="new_photo_alt_texts[]" value="">
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0 w-100">
                                    Title
                                    <input type="text" class="form-control" name="new_photo_titles[]" value="">
                                </label>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger delete-new-photo-row">
                                    <i style="color:white" class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                previewRow.appendChild(newPhotoRow);
            };

            reader.readAsDataURL(file);
        }
    }

    $(document).on('click', '.delete-new-photo-row', function () {
        $(this).closest('.row').parent().parent().remove();
    });
</script> --}}



{{-- for product photo --}}
{{-- <script>
    const generateDisplayRow = (index, photo, display_order, alt) => {
        return `<div class="mb-4 row align-items-center" id="photo_preview_row_${index}">
            <div class="col-md-3">
                <img src="${photo}" alt="Preview photo" class="img-thumbnail product-image-upload-display"/>
                <input type="hidden" name="photos[${index}][photo]" value="${photo}">
            </div>
            <div class="col-md-9">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="mb-0 w-100">
                            Display Order
                            <input name="photos[${index}][serial]" value="${display_order}" type="number" class="form-control">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0 w-100">
                            Alt Text
                            <input name="photos[${index}][alt_text]" value="${alt}" type="text" class="form-control">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="mb-0 w-100">
                            Title
                            <input name="photos[${index}][title]" value="${alt}" type="text" class="form-control">
                        </label>
                    </div>
                    <div class="col-md-1">
                        <button type="button" data-index="${index}" class="btn btn-danger delete-product-display-row">
                            <i style="color:white" class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
    }

    const handleElement = (element) => {
        $('#product_photo_display_row').html(element);
    }

    let element = ``;
    let display_order = 1;

    $('#images').on('change', function (e) {
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
                    let photo = reader.result;
                    element += generateDisplayRow(display_order - 1, photo, display_order, alt);
                    display_order++;
                    handleElement(element);

                    // Send the photo data to the server using AJAX
                    $.ajax({
                        url: '/store-photo',  // Replace with your server endpoint for storing photos
                        type: 'POST',
                        data: {
                            photo: photo,
                            alt: alt,
                            display_order: display_order - 1  // Adjust the display order
                        },
                        success: function (response) {
                            console.log('Photo data successfully sent to the server:', response);
                        },
                        error: function (error) {
                            console.error('Error sending photo data to the server:', error);
                        }
                    });
                }
            };
            reader.readAsDataURL(files[i]);
        }
    });

    $(document).on('click', '.delete-product-display-row', function () {
        let index = $(this).attr('data-index');
        $(`#photo_preview_row_${index}`).remove();

        // Handle indexing for new photos
        if (index.startsWith('new_')) {
            let newIndex = parseInt(index.split('_')[1]);
            let $temp_element = $(element);
            $temp_element.filter(`#photo_preview_row_new_${newIndex}`).html('');
            element = '';
            for (let i = 0; i < $temp_element.length; i++) {
                element += $temp_element[i].outerHTML.replace(`new_${newIndex}`, `new_${i}`);
            }
        }
    });
</script> --}}

    <script>
        let photos = @json($product->photos);
        let element = ``;
        let display_order = 1;
        // let display_order = photos.length + 1; 

        if (Array.isArray(photos) && photos.length > 0) {
            photos.forEach((photo, index) => {
                let photoIndex = index;
                let photoPath = photo.photo;
                let altText = photo.alt_text;
                let existingElement = generateDisplayRow(photoIndex, photoPath, display_order, altText);
                element += existingElement;
                display_order++;
            });
            handleElement(element);
        }

        // $('#images').on('change', function (e) {
        //     let alt = $('#name').val();
        //     let files = e.target.files;

        //     for (let i = 0; i < files.length; i++) {
        //         let reader = new FileReader();
        //         reader.onloadend = function () {
        //             if (reader.readyState === FileReader.DONE) {
        //                 if (reader.error) {
        //                     console.log('Error occurred while reading the file.');
        //                     return;
        //                 }
        //                 element += generateDisplayRow(display_order - 1, reader.result, display_order, alt);
        //                 display_order++;
        //                 handleElement(element);
        //             }
        //         };
        //         reader.readAsDataURL(files[i]);
        //     }
        // });

        // $(document).on('click', '.delete-product-display-row', function () {
        //     let index = $(this).attr('data-index');
        //     $(`#photo_preview_row_${index}`).remove();

        //     // Handle indexing for new photos
        //     if (index.startsWith('new_')) {
        //         let newIndex = parseInt(index.split('_')[1]);
        //         let $temp_element = $(element);
        //         $temp_element.filter(`#photo_preview_row_new_${newIndex}`).html('');
        //         element = '';
        //         for (let i = 0; i < $temp_element.length; i++) {
        //             element += $temp_element[i].outerHTML.replace(`new_${newIndex}`, `new_${i}`);
        //         }
        //     }
        // });

        function generateDisplayRow(index, photo, display_order, alt) {
            return `<div class="mb-4 row align-items-center" id="photo_preview_row_${index}">
                <div class="col-md-3">
                    <img src="${photo}" alt="Preview photo" class="img-thumbnail product-image-upload-display"/>
                    <input type="hidden" name="photos[${index}][photo]" value="${photo}">
                </div>
                <div class="col-md-9">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="mb-0 w-100">
                                Display Order
                                <input name="photos[${index}][serial]" value="${display_order}" type="number" class="form-control">
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="mb-0 w-100">
                                Alt Text
                                <input name="photos[${index}][alt_text]" value="${alt}" type="text" class="form-control">
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="mb-0 w-100">
                                Title
                                <input name="photos[${index}][title]" value="${alt}" type="text" class="form-control">
                            </label>
                        </div>
                        <div class="col-md-1">
                            <button type="button" data-index="${index}" class="btn btn-danger delete-product-display-row">
                                <i style="color:white" class="ri-delete-bin-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
        }
        function handleElement(element) {
            $('#product_photo_display_row').html(element);
        }
    
        

        $('#images').on('change', function (e) {
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
                        // element += generateDisplayRow(display_order - 1, reader.result, display_order, alt);
                        // display_order++;
                        // handleElement(element)
                        let photo = reader.result;
                        element += generateDisplayRow(display_order - 1, photo, display_order, alt);
                        display_order++;
                        handleElement(element);

                        // Send the photo data to the server using AJAX
                        $.ajax({
                            url: '/store-photo',  // Replace with your server endpoint for storing photos
                            type: 'POST',
                            data: {
                                photo: photo,
                                alt: alt,
                                display_order: display_order - 1  // Adjust the display order
                            },
                            success: function (response) {
                                console.log('Photo data successfully sent to the server:', response);
                            },
                            error: function (error) {
                                console.error('Error sending photo data to the server:', error);
                            }
                        });
                    }
                };
                reader.readAsDataURL(files[i]);
            }
            
        });
        $(document).on('click', '.delete-product-display-row', function () {
            let index = $(this).attr('data-index');
            $(`#photo_preview_row_${index}`).remove();

            // Handle indexing for new photos
            if (index.startsWith('new_')) {
                let newIndex = parseInt(index.split('_')[1]);
                let $temp_element = $(element);
                $temp_element.filter(`#photo_preview_row_new_${newIndex}`).html('');
                element = '';
                for (let i = 0; i < $temp_element.length; i++) {
                    element += $temp_element[i].outerHTML.replace(`new_${newIndex}`, `new_${i}`);
                }
            }
        });
        // ******************
         // JavaScript to handle image upload
        const imageInput = document.getElementById('images');

        imageInput.addEventListener('change', (event) => {
            const files = event.target.files;
            if (files) {
                const productPhotoDisplayRow = document.getElementById('product_photo_display_row');
                const formData = new FormData();
                // Loop through the selected files and append them to the FormData
                for (let i = 0; i < files.length; i++) {
                    formData.append('photos[]', files[i]);
                }
                // Loop through the selected files and display them
                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const imagePreview = document.createElement('img');
                        imagePreview.src = e.target.result;
                        imagePreview.classList.add('img-thumbnail', 'product-image-upload-display');

                        const photoIndex = `new_${i}`;
                        const photoRow = document.createElement('div');
                        photoRow.classList.add('mb-4', 'row', 'align-items-center');
                        photoRow.id = `photo_preview_row_${photoIndex}`;

                        // Add the input fields for display order, alt text, title
                        photoRow.innerHTML = `
                            <div class="col-md-3">
                                <input name="photos[${photoIndex}][photo]" value="${e.target.result}" type="hidden">
                                ${imagePreview.outerHTML}
                            </div>
                            <div class="col-md-9">
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <label class="mb-0 w-100">
                                            Display Order
                                            <input name="photos[${photoIndex}][serial]" value="" type="number" class="form-control">
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="mb-0 w-100">
                                            Alt Text
                                            <input name="photos[${photoIndex}][alt_text]" value="" type="text" class="form-control">
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="mb-0 w-100">
                                            Title
                                            <input name="photos[${photoIndex}][title]" value="" type="text" class="form-control">
                                        </label>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" data-index="${photoIndex}" class="btn btn-danger delete-product-display-row">
                                            <i style="color:white" class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;

                        productPhotoDisplayRow.appendChild(photoRow);
                    };

                    reader.readAsDataURL(files[i]);
                }
            }
        });
    </script>

        {{-- <script>
            let photos = @json($product->photos);

            if (Array.isArray(photos) && photos.length > 0) {
                console.log('Stored photos:', photos);

                const generateDisplayRow = (index, photo, display_order, alt) => {
                    return `<div class="mb-4 row align-items-center" id="photo_preview_row_${index}">
                        <div class="col-md-3">
                            <img src="${photo}" alt="preview photo" class="img-thumbnail product-image-upload-display"/>
                            <input type="hidden" name="photos[${index}][photo]" value="${photo}">
                        </div>
                        <div class="col-md-9">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label class="mb-0 w-100">
                                        Display Order
                                        <input name="photos[${index}][serial]" value="${display_order}" type="number" class="form-control">
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="mb-0 w-100">
                                        Alt Text
                                        <input name="photos[${index}][alt_text]" value="${alt}" type="text" class="form-control">
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="mb-0 w-100">
                                        Title
                                        <input name="photos[${index}][title]" value="${alt}" type="text" class="form-control">
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" data-index="${index}" class="btn btn-danger delete-product-display-row"><i style="color:white"class="ri-delete-bin-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>`
                }

                const handleElement = (element) => {
                    $('#product_photo_display_row').html(element);
                }

                let element = ``;
                let display_order = 1;

                photos.forEach((photo, index) => {
                    let photoIndex = index;
                    let photoPath = photo.photo;
                    let altText = photo.alt_text;
                    let existingElement = generateDisplayRow(photoIndex, photoPath, display_order, altText);
                    element += existingElement;
                    display_order++;
                });

                handleElement(element);

            }else {
                 const generateDisplayRow = (index, photo, display_order, alt) => {

                    return `<div class="mb-4 row align-items-center" id="photo_preview_row_${index}">
                        <div class="col-md-3">
                            <img src="${photo}" alt="preview photo" class="img-thumbnail product-image-upload-display"/>
                            <input type="hidden" name="photos[${index}][photo]" value="${photo}">
                        </div>
                        <div class="col-md-9">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label class="mb-0 w-100">
                                        Display Order
                                        <input name="photos[${index}][serial]" value="${display_order}" type="number" class="form-control">
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="mb-0 w-100">
                                        Alt Text
                                        <input name="photos[${index}][alt_text]" value="${alt}" type="text" class="form-control">
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="mb-0 w-100">
                                        Title
                                        <input name="photos[${index}][title]" value="${alt}" type="text" class="form-control">
                                    </label>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" data-index="${index}" class="btn btn-danger delete-product-display-row"><i style="color:white"class="ri-delete-bin-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>`
                }

                const handleElement = (element) => {
                    $('#product_photo_display_row').html(element)
                }


                let element = ``
                let display_order = 1
                $('#images').on('change', function (e) {
                    let alt = $('#name').val()
                    let files = e.target.files

                    for (let i = 0; i < files.length; i++) {
                        let reader = new FileReader();
                        reader.onloadend = function () {
                            if (reader.readyState === FileReader.DONE) {
                                if (reader.error) {
                                    console.log('Error occurred while reading the file.');
                                    return;
                                }
                                element += generateDisplayRow(display_order - 1, reader.result, display_order, alt)
                                display_order++
                                handleElement(element)
                            }
                        }
                        reader.readAsDataURL(files[i])
                    }
                })
                $(document).on('click', '.delete-product-display-row', function () {
                    let index = $(this).attr('data-index')
                    $(`#photo_preview_row_${index}`).remove()
                    let $temp_element = $(element)
                    $temp_element.filter(`#photo_preview_row_${index}`).html('');
                    element = ``
                    for (let i = 0; i < $temp_element.length; i++) {
                        element += $temp_element[i].outerHTML
                    }
                })
            }


        </script> --}}

        <script>
            $('#name').on('input', function (e) {
                $('#slug').val(formatSlug($(this).val()))
            })
            $('#name_bn').on('input', function (e) {
                $('#slug_bn').val(formatSlug($(this).val()))
            })
            $('#product_type').on('change', function () {
                let value = $(this).val()
                if (value == '2') {
                    $('#variant_menu').slideDown()
                } else {
                    $('#variant_menu').slideUp()
                }
            })

            $(document).ready(function() {
                $('#categories_select').select2();
            });
        </script>
        <script>
            $('#og_image').on('change', function (e) {
                let files = e.target.files
                let image = photo_preview(files, false)
                $('#photo_preview').attr('src', image).slideDown()
            })
            new TomSelect("#keywords", {
                persist: false,
                createOnBlur: true,
                create: true
            });
        </script>
        <script>
            tinyMCE.init({
                selector: '#description,#description_bn',
                height: 300,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor textcolor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | \
                                    alignleft aligncenter alignright alignjustify | \
                                    bullist numlist outdent indent | removeformat | help',
                // content_css: '//www.tiny.cloud/css/codepen.min.css'
            });

            img.onchange = evt => {
                const [file] = img.files
                if (file) {
                    prview.style.visibility = "visible";
                    prview.src = photo_preview(evt.target.files);
                }
            }

            img2.onchange = evt => {
                const [file] = img2.files
                if (file) {
                    prview2.style.visibility = "visible";
                    prview2.src = photo_preview(evt.target.files);
                }
            }

            img3.onchange = evt => {
                const [file] = img3.files
                if (file) {
                    prview3.style.visibility = "visible";
                    prview3.src = photo_preview(evt.target.files);
                }
            }
            $('#categories_select').select2({
                placeholder: 'Select Category',
            })



            const triggerTabList = document.querySelectorAll('#myTab button')
            triggerTabList.forEach(triggerEl => {
                const tabTrigger = new bootstrap.Tab(triggerEl)

                triggerEl.addEventListener('click', event => {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })
            const triggerEl = document.querySelector('#myTab button[data-bs-target="#profile"]')
            bootstrap.Tab.getInstance(triggerEl).show() // Select tab by name

            const triggerFirstTabEl = document.querySelector('#myTab li:first-child button')
            bootstrap.Tab.getInstance(triggerFirstTabEl).show() // Select first tab
        </script>
        {{-- <script>
            let indexs = [0]
            const displayElement = () => {
                let field_element = $('#attribute_fields')
                let data = JSON.parse(field_element.attr('data-attribute'))
                let attribute_element_data = generateElement(indexs[indexs.length - 1], prepareOptions(data))
                field_element.append(attribute_element_data)
            }


            const prepareOptions = (data) => {
                let options = ``
                for (const [key, value] of Object.entries(data)) {
                    options += `<option value="${key}">${value}</option>`
                }
                return options
            }


            $('#add_more_attribute_field').on('click', function () {
                indexs.push(indexs[indexs.length - 1] + 1)
                displayElement()
            })

            displayElement()

            $(document).on('click', '.remove-attribute', function () {
                let id = $(this).attr('data-index')
                $(`#attribute_single_row_${id}`).remove()
                indexs.splice(id, 1)
            })

        </script>
        <script>
            let sp_indexs = [0]

            const displaySpElement = () => {
                let field_element = $('#specifications_fields')
                let specification_element_data = generateSpElement(sp_indexs[sp_indexs.length - 1])
                field_element.append(specification_element_data)
            }

            $('#add_more_specifications_field').on('click', function () {
                sp_indexs.push(sp_indexs[sp_indexs.length - 1] + 1)
                displaySpElement()
            })

            displaySpElement()

            $(document).on('click', '.remove-specification', function () {
                let id = $(this).attr('data-index')
                $(`#specifications_single_row_${id}`).remove()
                sp_indexs.splice(id, 1)
            })

        </script> --}}
        {{-- <script>
            let var_indexs = [0]
            const handleProductPhotoToVariationPhoto = () => {
                return $(document).find('input[name="photos[0][photo]"]').val();
            }
            const displayVarElement = () => {
                let field_element = $('#var_fields')
                let data = JSON.parse(field_element.attr('data-attribute'))
                let var_element_data = generateVarElement(var_indexs[var_indexs.length - 1], prepareVarOptions(data))
                field_element.append(var_element_data)
            }


            const prepareVarOptions = (data) => {
                let options = ``
                for (const [key, value] of Object.entries(data)) {
                    options += `<option value="${key}">${value}</option>`
                }
                return options
            }


            $('#add_more_var_field').on('click', function () {
                let new_index = var_indexs[var_indexs.length - 1] + 1
                var_indexs.push(new_index)
                displayVarElement()
                handleTomSelect(`#tom_select_${new_index}`)
            })

            displayVarElement()

            $(document).on('click', '.remove-var', function () {
                let id = $(this).attr('data-index')
                $(`#var_single_row_${id}`).remove()
                var_indexs.splice(id, 1)
            })

            const handleTomSelect = (elem) => {
                new TomSelect(elem, {
                    persist: false,
                    createOnBlur: true,
                    create: true,
                    valueField: 'title',
                    labelField: 'title',
                    searchField: 'title',
                    options: [
                        {title: 'Red'},
                        {title: 'Green'},
                        {title: 'Blue'},
                        {title: 'L'},
                        {title: 'M'},
                        {title: 'S'},
                        {title: 'Cotton'},
                        {title: 'Artificial Fabric'},
                        {title: 'Almond'},
                        {title: 'Ginger Lime'},
                        {title: 'Pear'},
                    ],
                });
            }


            handleTomSelect(`#tom_select_0`)


            $('#generate_combination').on('click', function () {

                let image = handleProductPhotoToVariationPhoto()
                if (image == undefined) {
                    image = window.location.origin + '/images/default.webp'
                }
                let price = $('input[name="price"]').val()
                if (price == undefined) {
                    price = ''
                }
                let stock = $('input[name="stock"]').val()
                if (stock == undefined) {
                    stock = ''
                }


                let combination_data = {}
                $('.var_single_row').each(function (i, obj) {
                    let name_id = $(this).find('.attribute-variation-name').val()
                    let name_name = $(this).find('.attribute-variation-name').children(':selected').text()
                    let value = $(this).find('.attribute-variation-value').val()
                    combination_data[name_name] = value.split(',')
                });

                let combinations = []
                for (const [attr, values] of Object.entries(combination_data)) {
                    combinations.push(values.map(v => ({[attr]: v})));
                }
                combinations = combinations.reduce((a, b) => a.flatMap(d => b.map(e => ({...d, ...e}))));

                let variation_element_string = ``
                for (const index in Object.entries(combinations)) {
                    variation_element_string += generateVariationSingleRow(index, combinations[index], image, price, stock)
                }
                $('#variation_display_area').html(variation_element_string)

            })

            const prepareVariationTitle = (title_data) => {
                let string = ``
                for (const [attr, value] of Object.entries(title_data)) {
                    string += `<button type="button" class="btn btn-sm btn-secondary me-1">${attr} : ${value}</button>`
                }
                return string
            }

            //image handler
            $(document).on('click', '.variation_photo_display_trigger', function () {
                $(this).parent('.var-image-overly').siblings('input').trigger('click')
            })

            $(document).on('change', '.variation_photo_input', function (e) {
                let img = e.target.files[0]
                $(this).siblings('img').attr('src', URL.createObjectURL(img))
            })

            //handle default
            $(document).on('click', '.set-default', function () {
                $('.set-default').each(function (key, element) {
                    $(this).prop("checked", false)
                })
                $(this).prop('checked', true)
            })

            //during_edit
            let variation_data = JSON.parse($('#variation_data').attr('data-variation'))
            if (variation_data != undefined) {
                let variation_element_string = ``
                variation_data.map((variation, index) => {
                    let image = "https://deshify-backend.1putym.easypanel.host/images/uploads/product_thumb/" + variation?.product_variation_photo?.photo
                    let price = variation?.product_price?.price
                    let stock = variation?.product_inventory?.stock
                    let title_data = {}
                    variation?.variation_attributes.map((attribute, attr_ind) => {
                        let key = attribute?.product_attribute?.name
                        let value = attribute?.value
                        title_data = {...title_data, [key]: value}
                    })
                    variation_element_string += generateVariationSingleRow(index, title_data, image, price, stock)
                })
                $('#variation_display_area').html(variation_element_string)
            }
        </script> --}}
        {{-- <script>
            $('#logout_button').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out form admin panel",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, logout'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#logout_form').submit()
                    }
                })
            })
        </script>
        <script>
            $('#save_product').on('click', function () {
            $('#myForm').append(`<input type="hidden" value="1" name="is_saved" />`).submit()
            })
            $('#draft_product').on('click', function () {
            $('#myForm').append(`<input type="hidden" value="2" name="is_saved" />`).submit()
            })
            $('#preview').on('click', function () {
                Swal.fire('Please save/draft before preview')
            })
        </script> --}}
            
@endpush
          
        