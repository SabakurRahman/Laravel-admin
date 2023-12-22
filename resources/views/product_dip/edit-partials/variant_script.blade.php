@push('script')
    <script>
        let var_indexs = [0]
        const generateVarElement = (index, data) => {
            return `<div class="row mt-3 align-items-end var_single_row" id="var_single_row_${index}">
            <div class="col-md-11">
                <div class="row">
                <div class="col-md-6">
                    <label class="w-100 mb-0">
                        Select Attribute Name
                        <select name="var_attribute[${index}][product_attribute_id]" type="text" class="form-select attribute-variation-name">
                            <option disabled selected>Select Product Attribute</option>
                            ${data}
                        </select>
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="w-100 mb-0">
                        Attribute Value
                        <input name="var_attribute[${index}][value]" type="text" id="tom_select_${index}" class="tom-select attribute-variation-value">
                    </label>
                </div>
            </div>
            </div>
            <div class="col-md-1">
              <button type="button" data-index="${index}" class="btn btn-outline-danger remove-var">
                <i class="ri-delete-bin-line"></i>
              </button>
            </div>
        </div>`
        }
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
            console.log('title_data', title_data)
            let string = ``
            for (const [attr, value] of Object.entries(title_data)) {
                string += `<button type="button" class="btn btn-sm btn-secondary me-1">${attr} : ${value}</button>`
            }
            return string
        }

        const generateVariationSingleRow = (index, data, image, price, stock, id = undefined) => {
            return `<div class="card mt-4">
            <div class="card-header">
                <h6>${prepareVariationTitle(data)}</h6>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <input type="hidden" name="variations[${index}][data]" value='${JSON.stringify(data)}'>
                        <input type="hidden" name="variations[${index}][id]" value='${id != undefined ? id : null}'>
                        <div class="position-relative variation-image-display-area">
                            <img alt="preview photo" src="${image}"
                                     class="img-thumbnail product-image-upload-display"/>
                                <input name="variations[${index}][photo]" type="file" class="d-none variation_photo_input">
                            <div class="var-image-overly-black"></div>
                            <div class="var-image-overly"><button type="button" class="btn btn-success variation_photo_display_trigger">Change</button></div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="w-100">
                                    Price
                                    <input type="number" name="variations[${index}][price]" value="${price}" class="form-control">
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="w-100">
                                    Stock
                                    <input type="number" name="variations[${index}][stock]" value="${stock}" class="form-control">
                                </label>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input set-default" type="radio" name="variations[${index}][default]" id="default_set_${index}"
                                           value="1">
                                    <label class="form-check-label" for="default_set_${index}">Make Default</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-danger" id="remove_variation_row"><i
                                            class="ri-delete-bin-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`
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


        let product_variations = JSON.parse($('#product_variation_data_container').attr('data-product-variation-data'))
        let variation_element_string = ``
        product_variations.map((product_variation, index) => {
            console.log(product_variation)
            let photo = '{{url(\App\Models\ProductPhoto::PRODUCT_PHOTO_UPLOAD_PATH_THUMB)}}' + '/' + product_variation?.product_variation_photo?.photo
            let combo_data = {}

            for (let i in product_variation?.variation_attributes){
                let name  = product_variation.variation_attributes[i].product_attribute.name
                let temp = { [name] : product_variation.variation_attributes[i].value}
                combo_data = {...combo_data, ...temp}
            }

            variation_element_string += generateVariationSingleRow(
                index,
                combo_data,
                photo,
                product_variation?.product_price?.price,
                product_variation?.product_inventory?.stock,
                product_variation.id
            )
            $('#variation_display_area').html(variation_element_string)
        })

    </script>
@endpush
