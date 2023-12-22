@push('script')
    <script>

        let product_attributes = JSON.parse($('#product_attribute_data_container').attr('data-product-attribute'))

        let indexs = [0]
        const generateElement = (index, data, attribute = undefined) => {
            return `<div class="row mt-3 align-items-end" id="attribute_single_row_${index}">
            <div class="col-md-11">
                <div class="row">
                <div class="col-md-6">
                    <label class="w-100 mb-0">
                        Select Attribute Name
                        <select name="attribute[${index}][product_attribute_id]" type="text" class="form-select">
                            <option disabled selected>Select Product Attribute</option>
                            ${data}
                        </select>
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="w-100 mb-0">
                        Attribute Value
                        <input value="${attribute != undefined ? attribute.value : ''}"  name="attribute[${index}][value]" type="text" class="form-control">
                    </label>
                </div>
            </div>
            </div>
            <div class="col-md-1">
              <button type="button" data-index="${index}" class="btn btn-outline-danger remove-attribute">
                <i class="ri-delete-bin-line"></i>
              </button>
            </div>
        </div>`
        }

        const displayElement = (attribute = undefined) => {
            let field_element = $('#attribute_fields')
            let data = JSON.parse(field_element.attr('data-attribute'))
            let attribute_element_data = generateElement(indexs[indexs.length - 1], prepareOptions(data, attribute), attribute)
            field_element.append(attribute_element_data)
        }


        const prepareOptions = (data, attribute= undefined) => {
            let options = ``
            for (const [key, value] of Object.entries(data)) {
                options += `<option ${attribute != undefined  && attribute.product_attribute_id == key ? 'selected' : ''} value="${key}">${value}</option>`
            }
            return options
        }


        $('#add_more_attribute_field').on('click', function () {
            indexs.push(indexs[indexs.length - 1] + 1)
            displayElement()
        })

        // displayElement()

        $(document).on('click', '.remove-attribute', function () {
            let id = $(this).attr('data-index')
            $(`#attribute_single_row_${id}`).remove()
            indexs.splice(id, 1)
        })


        product_attributes.map((attribute, index)=>{
            indexs.push(indexs[indexs.length - 1] + 1)
            displayElement(attribute)
        })


    </script>
@endpush
