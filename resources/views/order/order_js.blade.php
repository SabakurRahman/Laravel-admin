@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"
            integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>


        let division_id
        let city_id
        let courier_cities = []
        let courier_zones = []
        let payments = JSON.parse($('#payments_data_container').attr('data-payment'))
        let couriers = JSON.parse($('#courier_data').attr('data-courier'))

        $('#courier_id').on('change', function () {
            $('#zone_select').empty()
            $('#city_select').empty()
            $('#division_select').empty()
            let selected_courier_id = $(this).val()
            let selected_courier = couriers.find((courier, ind) => {
                return selected_courier_id == courier.id
            })

            //set division
            if (selected_courier.divisions != undefined) {
                courier_cities = selected_courier.cities
                courier_zones = selected_courier.zones
                let division_element = $('#division_select')
                division_element.empty()
                division_element.append(`<option selected disabled value="">Select Division</option>`)
                selected_courier.divisions.map((division, divInd) => {
                    division_element.removeAttr('disabled').append(`<option value="${division.id}">${division.name}</option>`)
                })
            }
        })


        $('#division_select').on('change', function () {
            $('#zone_select').empty()
            let selected_division_id = $(this).val()
            let city_element = $('#city_select')
            city_element.empty()
            city_element.append(`<option value="">Select City</option>`)
            courier_cities.filter((element, index) => {
                if (element.division_id == selected_division_id) {
                    city_element.removeAttr('disabled').append(`<option value="${element.id}">${element.name}</option>`)
                }
            })
        })

        $('#city_select').on('change', function () {
            console.log(courier_zones, 'out')
            let city_id = $(this).val()
            let zone_element = $('#zone_select')
            zone_element.empty().removeAttr('disabled')
            zone_element.append(`<option value="">Select Zone</option>`)
            console.log(courier_zones, 'out')
            courier_zones.filter((element, index) => {
                console.log(element, 'in')
                if (element.city_id == city_id) {
                    console.log(element, 'in if')
                    zone_element.append(`<option  value="${element.id}">${element.name}</option>`)
                }
            })

        })


        let address = JSON.parse($('#data_customer_address').attr('data-address'))
        if (address != undefined) {
            let cities = JSON.parse($('#city_data_container').attr('data-city'))
            let city_element = $('#city_select')
            cities.filter((element, index) => {
                if (element.division_id == address.division_id) {
                    city_element.removeAttr('disabled').append(`<option ${address.city_id == element.id ? 'selected' : ''}  value="${element.id}">${element.name}</option>`)
                }
            })

            let zones = JSON.parse($('#zone_data_container').attr('data-zone'))
            let zone_element = $('#zone_select')
            zone_element.empty().removeAttr('disabled')
            zones.filter((element, index) => {
                if (element.city_id == address.city_id) {
                    zone_element.append(`<option  ${address.zone_id == element.id ? 'selected' : ''} value="${element.id}">${element.name}</option>`)
                }
            })

        }




        let quantity = 1
        let amount = 0
        let unit_price = 0
        let product_id
        let products = JSON.parse($('#product_data_container').attr('data-product'))
        let selected_product

        // total
        let sub_total = 0
        let delivery_charge = 60
        let discount = 0
        let payment = 0
        let total = 0

        $('#quantity').val(quantity)
        $('#product_id').on('change', function () {
            product_id = $(this).val()
            selected_product = products.find((item, index) => (
                item.id == product_id
            ))
            if (selected_product?.product_variations != undefined) {
                let obj = {}
                const ans = selected_product?.product_variations.map((currentValue, ind) => {
                    currentValue?.variation_attributes?.map((ele, index) => {
                        if (obj.hasOwnProperty(ele?.product_attribute?.name)) {
                            obj[ele?.product_attribute?.name].push(ele.value)
                        } else {
                            obj[ele?.product_attribute?.name] = []
                            obj[ele?.product_attribute?.name].push(ele.value)
                        }
                        obj[ele?.product_attribute?.name] = [...new Set([...obj[ele?.product_attribute?.name]])]
                    });
                }, []);
                generate_attribute_fields(obj)
            }
            unit_price = selected_product?.prices[0]?.price
            $('#unit_price').val(unit_price)
            calculate_price()
        })
        $('#quantity').on('input', function () {
            quantity = $(this).val()
            calculate_price()
        })
        $('#unit_price').on('input', function () {
            unit_price = $(this).val()
            calculate_price()
        })
        const calculate_price = () => {
            amount = quantity * unit_price
            $('#amount').val(amount)
        }

        let table_element = ``

        const generate_attribute_string = (attributes) => {
            let string = ``
            if (attributes != undefined) {
                for (const key in attributes) {
                    string += `<p style="font-size: 12px"><strong class="text-success">${key}</strong> : ${attributes[key]} </p>`
                }
            }
            return string
        }
        const generate_table_element = (data, index) => {
            return `<tr>
                                    <td>${data.name}</td>
                                    <td>${data.quantity}</td>
                                    <td>${data.unit_price}</td>
                                    <td>${data.amount}</td>
                                    <td>${generate_attribute_string(data.attributes)}</td>
                                    <td><i data-index=${index} class="ri-delete-bin-line text-danger cursor-pointer remove-product-from-list"></i></td>
                                </tr>`
        }

        const areObjectsEqual = (obj1, obj2) => {
            const keys1 = Object.keys(obj1);
            const keys2 = Object.keys(obj2);

            if (keys1.length !== keys2.length) {
                return false;
            }

            for (const key of keys1) {
                if (obj1[key] !== obj2[key]) {
                    return false;
                }
            }

            return true;
        }

        let data = []
        $('#add_product').on('click', function () {
            let selected_attributes = {}
            $(document).find('.element-selector').each(function (index, element) {
                selected_attributes[$(this).attr('data-attribute-name')] = $(this).val()
            })

            // selected_product['productVariations'].map((selected, index) => {
            //     let selected_data = JSON.parse(selected['data'])
            //     selected_data = JSON.parse(selected_data)
            //
            //     let isEqual = areObjectsEqual(selected_data, selected_attributes)
            //     if (isEqual) {
            //         unit_price = selected.price
            //         amount = unit_price * quantity
            //     }
            // })
            data = [
                ...data,
                {
                    id: selected_product?.id,
                    name: selected_product?.title,
                    quantity: quantity,
                    unit_price: unit_price,
                    amount: amount,
                    free_delivery: selected_product?.free_delivery,
                    size: '',
                    color: '',
                    delivery_charge_inside_dhaka: selected_product?.product_shipping?.delivery_charge_inside_dhaka != undefined ? selected_product?.product_shipping?.delivery_charge_inside_dhaka : 0,
                    delivery_charge_outside_dhaka: selected_product?.product_shipping?.delivery_charge_outside_dhaka != undefined ? selected_product?.product_shipping?.delivery_charge_outside_dhaka : 0,
                    attributes: typeof selected_attributes !== 'undefined' ? selected_attributes : null,
                },
            ]
            tableGenerationFormData()
            calculateTotalPrices()
        })


        $(document).on('click', '.remove-product-from-list', function () {
            let index = $(this).attr('data-index')
            data.splice(index, 1)
            tableGenerationFormData()
            calculateTotalPrices()
        })

        const tableGenerationFormData = () => {

            table_element = ``
            data.map((items, index) => (
                table_element += generate_table_element(items, index)
            ))
            $('#product_list').html(table_element)
        }

        $('#discount').on('input', function () {
            discount = $(this).val()
            calculateTotalPrices()
        })
        $('#payment').on('input', function () {
            payment = $(this).val()
            calculateTotalPrices()
        })

        const calculate_delivery_charge = (data) => {
            let courier_charge = 0;
            let temp_charge = [];
            let temp_courier_charge = 0;
            let temp_product_wise_additional_charge = 0
            let location = $('#location').val()
            let courier_data = JSON.parse($('#courier_data').attr('data-courier'))
            let selected_courier_id = $('#courier_id').val()
            if (location != undefined && selected_courier_id != undefined && courier_data != undefined) {
                let selected_courier = courier_data.find((courier, index) => {
                    return courier.id == selected_courier_id
                })
                if (location == '{{\App\Models\Order::SHIPPING_LOCATION_DHAKA}}') {
                    temp_courier_charge = parseFloat(selected_courier.inside_courier_charge)
                    temp_charge.push(temp_courier_charge)
                } else if (location == '{{\App\Models\Order::SHIPPING_LOCATION_OUTSIDE_DHAKA}}') {
                    temp_courier_charge = parseFloat(selected_courier.outside_courier_charge)
                    temp_charge.push(temp_courier_charge)
                }

                data.map((item, ind) => {
                    temp_product_wise_additional_charge = 0
                    if (item.free_delivery != 1){
                        if (location == '{{\App\Models\Order::SHIPPING_LOCATION_DHAKA}}') {
                            temp_product_wise_additional_charge = temp_courier_charge + parseFloat(item.delivery_charge_inside_dhaka)
                        } else if (location == '{{\App\Models\Order::SHIPPING_LOCATION_OUTSIDE_DHAKA}}') {
                            temp_product_wise_additional_charge = temp_courier_charge + parseFloat(item.delivery_charge_outside_dhaka)
                        }
                    }
                    temp_charge.push(temp_product_wise_additional_charge)
                })
                courier_charge = Math.max(...temp_charge)
                if (Object.keys(data).length == 1 && data[0].free_delivery != undefined && data[0].free_delivery == 1) {
                    courier_charge = 0;
                }
            }
            return courier_charge
        }

        const calculateTotalPrices = () => {
            sub_total = 0
            delivery_charge = 0
            total = 0

            // quantity: quantity,
            // unit_price: unit_price,
            // amount: amount,
            // courier_id

            delivery_charge = calculate_delivery_charge(data)
            data.map((item, index) => {
                sub_total += item.unit_price * item.quantity
                total += item.unit_price * item.quantity
                amount += item.unit_price * item.quantity
            })
            total -= discount
            total += delivery_charge
            total -= payment

            $('#sub_total').val(sub_total)
            $('#delivery_charge').val(delivery_charge)
            $('#discount').val(discount)
            $('#payment').val(payment)
            $('#total').val(total)
            $('#selected_products').val(JSON.stringify(data))
        }


        $('#payment_method_id').on('change', function () {
            let payment_method_id = $(this).val()
            let payment_element = $('#payment_account')
            payment_element.empty()
            payments.filter((element, index) => {
                if (element.payment_method_id == payment_method_id) {
                    payment_element.append(`<option value="${element.id}">${element.payment_number}</option>`)
                }
            })
        })

        const generate_attribute_fields = (obj) => {
            let elements = ``
            Object.keys(obj).map((element, index) => {
                //  console.log(element, obj[element])
                elements += `<div class="row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="form-label" for="${element}">${element}</label>
                            </div>
                            <div class="col-md-8">
                                <select data-attribute-name="${element}" class="form-select select2 element-selector" name="${element.toLowerCase()}">
                                ${generateVariationOptions(obj[element])}
                                </select>
                </div>
            </div>`
            })
            $('#variation_attribute_area').html(elements)
        }

        const generateVariationOptions = (data) => {
            let options = ``
            data.map((option, index) => (
                options += `<option value="${option}">${option}</option>`
            ))
            return options
        }

        $('#location, #courier_id').on('change', function () {
            calculateTotalPrices()
        })


        // const now = new Date()
        // const formattedDateTime = now.toISOString().slice(0, 16)
        // $('#order_time').val(formattedDateTime)


        let order_selected_product = JSON.parse($('#data_selected_product').attr('data-selected-product'))

        if (order_selected_product != undefined){
            order_selected_product.map((item, index)=>{

                let selected_attributes = {}
                if (item.order_items_attributes != undefined){
                    item.order_items_attributes.map((attribute, inde)=>{
                        selected_attributes[attribute.name] = attribute.value
                    })
                }

                data = [
                    ...data,
                    {
                        id: item?.product_id,
                        name: item?.name,
                        quantity: item.quantity,
                        unit_price: item.unit_price,
                        amount: item.total_amount,
                        free_delivery: item?.product?.free_delivery,
                        size: '',
                        color: '',
                        delivery_charge_inside_dhaka: item?.product?.product_shipping?.delivery_charge_inside_dhaka != undefined ? item?.product?.product_shipping?.delivery_charge_inside_dhaka : 0,
                        delivery_charge_outside_dhaka: item?.product?.product_shipping?.delivery_charge_outside_dhaka != undefined ? item?.product?.product_shipping?.delivery_charge_outside_dhaka : 0,
                        attributes: selected_attributes,
                    },
                    // {
                    //     id: item?.product_id,
                    //     name: item?.name,
                    //     quantity: item.quantity,
                    //     unit_price: item.unit_price,
                    //     amount: item.total_amount,
                    //     size: '',
                    //     color: ''
                    // },
                ]
                tableGenerationFormData()
                calculateTotalPrices()
            })
        }

        $('#submitButton').on('click', function () {
            $('#quick_order_form').submit()
        })

    </script>
@endpush
