@extends('frontend.layouts.master')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <form action="{{ route('couriers.update',$courier->id) }}" method="POST" id="myForm">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="basicpill-firstname-input">Courier
                                            Name</label>
                                        <input type="text" class="form-control" id="basicpill-firstname-input"
                                               name="courier_name" value="{{ $courier->name }}"
                                               placeholder="Enter courier Name">
                                        @error('courier_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="basicpill-firstname-input">Inside Dhaka Courier
                                            Charge (TK)</label>
                                        <input type="text" class="form-control" id="basicpill-firstname-input"
                                               name="inside_courier_charge"
                                               value="{{ $courier->inside_courier_charge }}"
                                               placeholder="Enter Inside Courier Charge">
                                        @error('inside_courier_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="basicpill-firstname-input">Outside Dhaka Courier
                                            Charge (TK)</label>
                                        <input type="text" class="form-control" id="basicpill-firstname-input"
                                               name="outside_courier_charge"
                                               value="{{ $courier->outside_courier_charge }}"
                                               placeholder="Enter Outside Courier Charge">
                                        @error('outside_courier_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="basicpill-firstname-input">Inside Dhaka Condition
                                            Charge (%)</label>
                                        <input type="text" class="form-control" id="basicpill-firstname-input"
                                               name="inside_condition_charge"
                                               value="{{ $courier->inside_condition_charge }}"
                                               placeholder="Enter Inside Condition Charge">
                                        @error('inside_condition_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="basicpill-firstname-input">Outside Dhaka
                                            Condition
                                            Charge (%)</label>
                                        <input type="text" class="form-control" id="basicpill-firstname-input"
                                               name="outside_condition_charge"
                                               value="{{ $courier->outside_condition_charge }}"
                                               placeholder="Enter outside Condition Charge">
                                        @error('outside_condition_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="basicpill-firstname-input">Inside Dhaka Return
                                            Charge (%)</label>
                                        <input type="text" class="form-control" id="basicpill-firstname-input"
                                               name="inside_return_charge" value="{{ $courier->inside_return_charge }}"
                                               placeholder="Enter outside Condition Charge">
                                        @error('inside_return_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="basicpill-firstname-input">Outside Dhaka Return
                                            Charge (%)</label>
                                        <input type="text" class="form-control" id="basicpill-firstname-input"
                                               name="outside_return_charge"
                                               value="{{ $courier->outside_return_charge }}"
                                               placeholder="Enter outside Condition Charge">
                                        @error('outside_return_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="validationCustom03" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">Select</option>
                                            @foreach (App\Models\Courier::STATUS_LIST as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $key == $courier->status ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-lg-4">--}}
                            {{--                                    <div class="mb-3">--}}
                            {{--                                        <label class="form-label">Division</label>--}}
                            {{--                                        <div class="form-check form-check-custom form-check-warning font-size-16">--}}
                            {{--                                            <div class="form-check">--}}
                            {{--                                                <input class="form-check-input" type="checkbox" id="select-all-divisions">--}}
                            {{--                                                <label class="form-check-label" for="select-all-divisions">Select All</label>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                        @foreach ($divisions as $division)--}}
                            {{--                                            <div class="form-check form-check-custom form-check-warning font-size-16">--}}
                            {{--                                                <div class="form-check">--}}
                            {{--                                                    <input class="form-check-input" type="checkbox" name="division_id[]"--}}
                            {{--                                                        value="{{ $division->id }}" id="division-{{ $division->id }}"--}}
                            {{--                                                        {{ in_array($division->id, $selectedDivisions) ? 'checked' : '' }}>--}}
                            {{--                                                    <label class="form-check-label" for="division-{{ $division->id }}">{{ $division->name }}</label>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        @endforeach--}}
                            {{--                                        @error('division_id')--}}
                            {{--                                            <span class="text-danger">{{ $message }}</span>--}}
                            {{--                                        @enderror--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-lg-4">--}}
                            {{--                                    <div class="mb-3">--}}
                            {{--                                        <label class="form-label">City</label>--}}
                            {{--                                        @foreach ($cities as $city)--}}
                            {{--                                            <div class="form-check form-check-custom form-check-success font-size-16">--}}
                            {{--                                                <div class="form-check">--}}
                            {{--                                                    <input class="form-check-input" type="checkbox" name="city_id[]" value="{{ $city->id }}"--}}
                            {{--                                                        id="city-{{ $city->id }}" data-division="{{ $city->division_id }}"--}}
                            {{--                                                        {{ in_array($city->id, $selectedCities) ? 'checked' : '' }}>--}}
                            {{--                                                    <label class="form-check-label" for="city-{{ $city->id }}">{{ $city->name }}</label>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        @endforeach--}}
                            {{--                                        @error('city_id')--}}
                            {{--                                            <span class="text-danger">{{ $message }}</span>--}}
                            {{--                                        @enderror--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            {{--                                <div class="col-lg-4">--}}
                            {{--                                    <div class="mb-3">--}}
                            {{--                                        <label class="form-label">Zone</label>--}}
                            {{--                                        @foreach ($zones as $zone)--}}
                            {{--                                            <div class="form-check form-check-custom form-check-primary font-size-16">--}}
                            {{--                                                <div class="form-check zone-checkboxes" data-city="{{ $zone->city_id }}">--}}
                            {{--                                                    <input class="form-check-input" type="checkbox" name="zone_id[]" value="{{ $zone->id }}"--}}
                            {{--                                                        id="zone-{{ $zone->id }}" data-city="{{ $zone->city_id }}"--}}
                            {{--                                                        {{ in_array($zone->id, $selectedZones) ? 'checked' : '' }}>--}}
                            {{--                                                    <label class="form-check-label" for="zone-{{ $zone->id }}">{{ $zone->name }}</label>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        @endforeach--}}
                            {{--                                        @error('zone_id')--}}
                            {{--                                            <span class="text-danger">{{ $message }}</span>--}}
                            {{--                                        @enderror--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Division</label>
                                        {{--                                        <div class="form-check form-check-custom form-check-warning font-size-16">--}}
                                        {{--                                            <div class="form-check">--}}
                                        {{--                                                <input class="form-check-input" type="checkbox" id="select-all-divisions">--}}
                                        {{--                                                <label class="form-check-label" for="select-all-divisions">Select All</label>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        @foreach ($divisions as $division)
                                            <div class="form-check form-check-custom form-check-warning font-size-16">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input division-check division-check-{{ $division->id}}"
                                                        type="checkbox"
                                                        name="division_id[]"
                                                        value="{{ $division->id }}"
                                                        id="division-{{ $division->id }}">
                                                    <label class="form-check-label m-0"
                                                           for="division-{{ $division->id }}">{{ $division->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                        @error('division_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label m-0">City</label>
                                        <div class="d-none" id="cities_data"
                                             data-cities="{{json_encode($cities)}}"></div>
                                        <div id="city_area"></div>
{{--                                                                                @foreach ($cities as $city)--}}
{{--                                                                                <div class="form-check form-check-custom form-check-success font-size-16">--}}
{{--                                                                                    <div class="form-check">--}}
{{--                                                                                        <input class="form-check-input" type="checkbox" name="city_id[]" value="{{ $city->id }}"--}}
{{--                                                                                        id="city-{{ $city->id }}" data-division="{{ $city->division_id }}">--}}
{{--                                                                                        <label class="form-check-label m-0" for="city-{{ $city->id }}">{{ $city->name }}</label>--}}
{{--                                                                                    </div>--}}
{{--                                                                                </div>--}}
{{--                                                                            @endforeach--}}
                                        @error('city_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label m-0">Zone</label>
                                        <div class="d-none" id="zone_data" data-zones="{{json_encode($zones)}}"></div>
                                        <div id="zone_area"></div>
{{--                                                                          @foreach ($zones as $zone)--}}
{{--                                                                         <div class="form-check form-check-custom form-check-primary font-size-16">--}}
{{--                                                                               <div class="form-check zone-checkboxes" data-city="{{ $zone->city_id }}">--}}
{{--                                                                                   <input class="form-check-input" type="checkbox" name="zone_id[]" value="{{ $zone->id }}" id="zone-{{ $zone->id }}" data-city="{{ $zone->city_id }}">--}}
{{--                                                                                   <label class="form-check-label m-0" for="zone-{{ $zone->id }}">{{ $zone->name }}</label>--}}
{{--                                                                                </div>--}}
{{--                                                                              </div>--}}
{{--                                                                             @endforeach--}}
                                        @error('zone_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button id="courier_create" type="submit" class="btn btn-success mt-2">Update Courier</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="d-none" id="selected_divisions" data-selected-divisions="{{json_encode($selectedDivisions)}}"></div>
            <div class="d-none" id="selected_cities" data-selected-cities="{{json_encode($selectedCities)}}"></div>
            <div class="d-none" id="selected_zones" data-selected-zones="{{json_encode($selectedZones)}}"></div>
        </div>

        @endsection

        @push('script')
            <script>
                let previous_selected_divisions = JSON.parse($('#selected_divisions').attr('data-selected-divisions'))
                console.log(previous_selected_divisions);
                let previous_selected_cities = JSON.parse($('#selected_cities').attr('data-selected-cities'))
                let previous_selected_zones = JSON.parse($('#selected_zones').attr('data-selected-zones'))

                setTimeout(()=>{
                    if (previous_selected_divisions != undefined){
                        for (const div of previous_selected_divisions) {
                            const div_id = div.id;
                            $(`.division-check-${div_id}`).trigger('click')
                        }

                        if (previous_selected_cities != undefined){
                            for (const div of previous_selected_cities) {
                                const div_id = div.id;
                                $(`#city-${div_id}`).trigger('click')
                            }
                        }
                        if (previous_selected_zones != undefined){
                            for (const div of previous_selected_zones) {
                                const div_id = div.id;
                                $(`#zone-${div_id}`).trigger('click')
                            }
                        }
                    }
                }, 100)

                const generate_city_element = (data) => {
                    return `<div class="form-check form-check-custom form-check-success font-size-16 division-id-${data.division_id}">
                <div class="form-check">
                    <input class="form-check-input city-check" type="checkbox" name="city_id[]" value="${data.id}"
                    id="city-${data.id}" data-division="${data.division_id}">
                     <label class="form-check-label m-0" for="city-${data.id}">${data.name}</label>
                 </div>
            </div>`
                }

                const generate_zone_element = (data) => {
                    return `<div class="form-check form-check-custom form-check-primary font-size-16 city-id-${data.city_id}">
                <div class="form-check zone-checkboxes" data-city="${data.zone_id}">
                    <input class="form-check-input" type="checkbox" name="zone_id[]" value="${data.id}"
                        id="zone-${data.id}" data-city="${data.city_id}">
                    <label class="form-check-label m-0" for="zone-${data.id}">${data.name}</label>
                </div>
             </div>`
                }

                let selected_divisions = []
                let selected_cities = []
                let cities = JSON.parse($('#cities_data').attr('data-cities'))
                let zones = JSON.parse($('#zone_data').attr('data-zones'))

                $('.division-check').on('click', function () {
                    let is_checked = $(this).is(":checked")
                    let division_value = $(this).val()
                    if (is_checked) {
                        if (cities != undefined && !selected_divisions.includes(division_value)) {
                            selected_divisions.push(division_value)
                            let printed_city = cities.filter((city, index) => {
                                return division_value == city.division_id
                            })
                            printed_city.map((printed, ind) => {
                                let data = {
                                    'id': printed.id,
                                    'division_id': printed.division_id,
                                    'name': printed.name,
                                }
                                $('#city_area').append(generate_city_element(data))
                            })
                        }
                    } else {
                        $(`.division-id-${division_value}`).remove()
                        let city_under_division = cities.filter((city, ciIn) => {
                            return division_value == city.division_id
                        })
                        console.log(city_under_division)
                        let removed_division_id = []
                        city_under_division.map((city_data, indC) => {
                            $(`.city-id-${city_data.id}`).remove()
                            let index_c = selected_cities.indexOf(city_data.id);
                            selected_cities.splice(index_c, 1);
                        })
                        let index = selected_divisions.indexOf(division_value);
                        if (index !== -1) {
                            selected_divisions.splice(index, 1);
                        }
                    }
                })

                $(document).on('click', '.city-check', function () {
                    let is_checked = $(this).is(":checked")
                    let city_value = $(this).val()
                    if (is_checked) {
                        if (zones != undefined && !selected_cities.includes(city_value)) {
                            selected_cities.push(city_value)
                            let printed_zone = zones.filter((zone, index) => {
                                return city_value == zone.city_id
                            })
                            printed_zone.map((printed_zone, indx) => {
                                let data = {
                                    'id': printed_zone.id,
                                    'city_id': printed_zone.city_id,
                                    'name': printed_zone.name,
                                }
                                $('#zone_area').append(generate_zone_element(data))
                            })
                        }
                    } else {
                        $(`.city-id-${city_value}`).remove()
                        let index = selected_cities.indexOf(city_value);
                        if (index !== -1) {
                            selected_cities.splice(index, 1);
                        }
                    }
                })


                // $(document).ready(function () {
                //     // Select All Divisions
                //     $('#select-all-divisions').on('change', function () {
                //         var divisionCheckboxes = $('input[name="division_id[]"]');
                //         divisionCheckboxes.prop('checked', $(this).prop('checked'));
                //         divisionCheckboxes.trigger('change'); // Trigger division checkboxes change event
                //     });
                //
                //     // When a division is selected
                //     $('input[name="division_id[]"]').on('change', function () {
                //         var divisionId = $(this).val();
                //         var cityCheckboxes = $('input[name="city_id[]"][data-division="' + divisionId + '"]');
                //         cityCheckboxes.prop('checked', $(this).prop('checked'));
                //         cityCheckboxes.trigger('change'); // Trigger city checkboxes change event
                //     });
                //
                //     // When a city is selected
                //     $('input[name="city_id[]"]').on('change', function () {
                //         var cityId = $(this).val();
                //         var zoneCheckboxes = $('input[name="zone_id[]"][data-city="' + cityId + '"]');
                //         zoneCheckboxes.prop('checked', $(this).prop('checked'));
                //     });
                // });
            </script>
    @endpush








