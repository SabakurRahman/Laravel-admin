@push('script')
    <script>
        const generateDisplayRow = (index, photo, display_order, alt, id = undefined) => {
            return `<div class="row align-items-center mb-4" id="photo_preview_row_${index}">
                <div class="col-md-3">
                    <img src="${photo}" alt="preview photo" class="img-thumbnail product-image-upload-display"/>
                     <input type="hidden" name="photos[${index}][photo]" value="${photo}">
                     <input type="hidden" name="photos[${index}][id]" value="${id != undefined ? id : null}">
                </div>
                <div class="col-md-9">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="w-100 mb-0">
                                Display Order
                                <input name="photos[${index}][serial]" value="${display_order}" type="number" class="form-control">
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="w-100 mb-0">
                                Alt Text
                                <input name="photos[${index}][alt_text]" value="${alt}" type="text" class="form-control">
                            </label>
                        </div>
                        <div class="col-md-4">
                            <label class="w-100 mb-0">
                                Title
                                <input name="photos[${index}][title]" value="${alt}" type="text" class="form-control">
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
            $('#product_photo_display_row').html(element)
        }


        let element = ``

        let photos = JSON.parse($('#photo_container').attr('data-photos'))
        photos.map((photo, index)=>{
            let display_order = photo.serial
            let alt = photo.alt_text
            let product_photo = '{{url(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB)}}'+'/'+photo.photo
            element += generateDisplayRow(photo.serial - 1, product_photo, display_order, alt, photo.id)
            display_order++
            handleElement(element)
        })

        let display_order = Object.keys(photos).length
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
@endpush