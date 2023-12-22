@extends('frontend.layouts.master')
@section('content')
    <div class="row">

        <div class="col-xl-12">

            <div class="card">

                <div class="card-body">
                    <div>
                        <form action="{{ route('couriers.store') }}" method="POST" id="myForm">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="basicpill-firstname-input">Courier
                                            Name</label>
                                        <input type="text" class="form-control" id="basicpill-firstname-input"
                                               name="courier_name" value="{{ old('courier_name') }}"
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
                                               name="inside_courier_charge" value="{{ old('inside_courier_charge') }}"
                                               placeholder="Enter Inside Courier Charge (TK)">
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
                                               name="outside_courier_charge" value="{{ old('outside_courier_charge') }}"
                                               placeholder="Enter Outside Courier Charge (TK)">
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
                                               value="{{ old('inside_condition_charge') }}"
                                               placeholder="Enter Inside Condition Charge (%)">
                                        @error('inside_condition_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="basicpill-firstname-input">Outside Dhaka
                                            Condition Charge (%)</label>
                                        <input type="text" class="form-control" id="basicpill-firstname-input"
                                               name="outside_condition_charge"
                                               value="{{ old('outside_condition_charge') }}"
                                               placeholder="Enter outside Condition Charge (%)">
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
                                               name="inside_return_charge" value="{{ old('inside_return_charge') }}"
                                               placeholder="Enter outside Condition Charge (%)">
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
                                               name="outside_return_charge" value="{{ old('outside_return_charge') }}"
                                               placeholder="Enter outside Condition Charge  (%)">
                                        @error('outside_return_charge')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="">
                                        <label for="validationCustom03" class="form-label">Status</label>
                                        <select class="form-select" name="status" required>
                                            <option selected disabled value="">Choose</option>
                                            @foreach (App\Models\Courier::STATUS_LIST as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Division</label>
                                        @foreach ($divisions as $division)
                                            <div class="form-check form-check-custom form-check-warning font-size-16">
                                                <div class="form-check">
                                                    <input class="form-check-input division-check" type="checkbox"
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
                                        <label class="form-label">City</label>
                                        <div class="d-none" id="cities_data"
                                             data-cities="{{json_encode($cities)}}"></div>
                                        <div id="city_area"></div>
                                        {{--                                        @foreach ($cities as $city)--}}
                                        {{--                                        <div class="form-check form-check-custom form-check-success font-size-16">--}}
                                        {{--                                            <div class="form-check">--}}
                                        {{--                                                <input class="form-check-input" type="checkbox" name="city_id[]" value="{{ $city->id }}"--}}
                                        {{--                                                id="city-{{ $city->id }}" data-division="{{ $city->division_id }}">--}}
                                        {{--                                                <label class="form-check-label" for="city-{{ $city->id }}">{{ $city->name }}</label>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                    @endforeach--}}
                                        @error('city_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Zone</label>
                                        <div class="d-none" id="zone_data" data-zones="{{json_encode($zones)}}"></div>
                                        <div id="zone_area"></div>
                                        {{--                                        @foreach ($zones as $zone)--}}
                                        {{--                                        <div class="form-check form-check-custom form-check-primary font-size-16">--}}
                                        {{--                                            <div class="form-check zone-checkboxes" data-city="{{ $zone->city_id }}">--}}
                                        {{--                                                <input class="form-check-input" type="checkbox" name="zone_id[]" value="{{ $zone->id }}"--}}
                                        {{--                                                id="zone-{{ $zone->id }}" data-city="{{ $zone->city_id }}">--}}
                                        {{--                                                <label class="form-check-label" for="zone-{{ $zone->id }}">{{ $zone->name }}</label>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                      @endforeach--}}
                                        @error('zone_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button id="courier_create" type="submit" class="btn btn-success mt-2">Create Courier</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @push('script')
            <script>

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
            </script>
    @endpush







