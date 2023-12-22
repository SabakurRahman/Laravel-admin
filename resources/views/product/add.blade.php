@extends('frontend.layouts.master')
@section('content')
       @include('global_partials.validation_error_display')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(['route'=>'product.store', 'method'=>'post','files'=>true]) !!}
                @include('product.form')
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="d-grid">
                        {!! Form::button('Create New Product', ['class' => 'btn btn-outline-theme mt-4', 'type'=>'submit']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="d-none" data-attribute-value="{{json_encode($attribute_values)}}" id="attribute_values"></div>
    <div class="d-none" data-attribute-name="{{json_encode($attributes)}}" id="attribute_names"></div>
@endsection
{{-- @include('product.partials.script') --}}
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
        /* justify-content:space-between; */
        margin-right:5px!important;
    }
    .border-area{
        padding:2px 10px 5px 10px!important;
    }
    .delete-design{
        display: block;
        margin-left:auto;
    }
</style>
@push("script")
    {{-- for Faq --}}
    <script>
        $(document).ready(function () {
            var faqCount = {{ count($product->faqs) }}; // Initialize the count to the number of existing FAQs

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
                    
                        <div class="col-md-6">
                            {!! Form::label('Status', 'Status') !!}
                            {!! Form::select('faqs[${faqCount}][status]', \App\Models\Faq::STATUS_LIST, null, ['class' => 'form-select', 'placeholder' => 'Select Status']) !!}
                        </div>

                        <div class="col-md-1 delete-design">
                            <button type="button" class="btn btn-danger delete-faq-row"><i style="color:white" class="ri-delete-bin-line"></i></button>
                        </div>
                    </div>
                `;

                $('#faq-container').append(faqHtml);

                // Attach a click event handler to the delete button
                $('.delete-faq-row').click(function () {
                    // Remove the entire FAQ group when the delete button is clicked
                    $(this).closest('.faq-group').remove();
                });
            }

            // Add FAQ input fields when the "Add FAQ" button is clicked
            $('#add-faq').click(function () {
                addFAQInputFields();
            });
        });
    </script>

    {{-- For Specification --}}
    <script>
        $(document).ready(function () {
            var specificationCount = {{ count($product->specifications) }}; 

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
                    $(this).closest('.specification-group').remove();
                });
            }

            $('#add-specification').click(function () {
                addSpecificationInputFields();
            });
        });
    </script>

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

    <script>
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
    </script>
    {{-- for product photo --}}
    <script>
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
            
    </script>

     


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

        </script> --}}
        {{-- <script>
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
        </script> --}}
        {{-- <script>
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
                