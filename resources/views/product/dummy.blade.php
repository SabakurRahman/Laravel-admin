<div class="row custom-input-group">
    <div>
        {!! Form::label('#', 'Product Specification') !!}
    </div>
    <div class="specification-div-style ">
        <div class="row custom-input-group" id="specification-container">
            @foreach ($product->specifications as $index => $specification)
                <div class="specification-group">
                    <div class="d-flex "> 
                        <div class="mt-3 col-md-5 space">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text("specifications[${index}][name]", $specification->name, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
                        </div>
                        <div class="mt-3 col-md-5">
                            {!! Form::label('value', 'Value') !!}
                            {!! Form::text("specifications[${index}][value]", $specification->value, ['class' => 'form-control', 'placeholder' => 'Enter Value']) !!}
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger delete-specification-row" data-index="{{ $index }}"><i style="color:white" class="ri-delete-bin-line"></i></button>
                        </div>
                    </div>                             
                </div>

            @endforeach
                {{-- </div> --}}
            <button style="display:block;margin:auto;" type="button" class="mt-1 btn btn-outline-theme" id="add-specification"><i style="font-size:15px" class="ri-add-line"></i></button>
                                                
        </div>
    </div>
</div>











                                                                <div class="tab-pane" id="specification" role="tabpanel">
                                <fieldset>
                                    <div class="row custom-input-group" id="specification-container">
                                        @foreach ($product->specifications as $index => $specification)
                                            <div class="specification-group border-area">
                                                <div class="d-flex "> 
                                                    <div class="mt-3 col-md-6 space">
                                                        {!! Form::label('name', 'Name') !!}
                                                        {!! Form::text("specifications[${index}][name]", $specification->name, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
                                                    </div>
                                                    <div class="mt-3 col-md-6">
                                                        {!! Form::label('value', 'Value') !!}
                                                        {!! Form::text("specifications[${index}][value]", $specification->value, ['class' => 'form-control', 'placeholder' => 'Enter Value']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-1 delete-design">
                                                    <button type="button" class="btn btn-danger delete-specification-row" data-index="{{ $index }}"><i style="color:white" class="ri-delete-bin-line"></i></button>
                                                </div>
                                            </div>
                                         @endforeach
                                    
                                    </div>
                                    <button style="display:block;margin:auto;" type="button" class="mt-3 btn btn-outline-theme" id="add-specification"><i style="font-size:15px" class="ri-add-line"></i></button>
                                </fieldset>
                            </div>




                             // <div class="specification-group border-area">
                    //     <div class="d-flex"> 
                    //         <div class="mt-3 col-md-5 space">
                    //             {!! FORM::label('name', 'Name') !!}
                    //             {!! FORM::text('specifications[${specificationCount}][name]', null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
                    //         </div>
                    //         <div class="mt-3 col-md-5">
                    //             {!! Form::label('value', 'Value') !!}
                    //             {!! FORM::text('specifications[${specificationCount}][value]', null, ['class' => 'form-control', 'placeholder' => 'Enter Value']) !!}
                    //         </div>
                    //         <div class="mt-2 col-md-2 delete-design">
                    //             <button type="button" class="btn btn-danger delete-specification-row"><i style="color:white" class="ri-delete-bin-line"></i></button>
                    //         </div>
                    //     </div>
                    // </div>