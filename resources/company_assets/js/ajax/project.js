    $(document).ready(function() {
        $('.own_project_or_contractor').on('click', function(e) {
            e.preventDefault();
            if ($(this).val() == 'yes') {
                $('.bodyAdd').html(` <div class="client-name-add">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_company_name" class="">Client Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('client_company_name',$data->client_company_name??'') }}"
                                            name="client_company_name" id="client_company_name"
                                            placeholder=" Enter Your Client Name">
                                        @if($errors->has('client_company_name'))
                                        <div class="error">{{ $errors->first('client_company_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_company_address" class="">Client Address</label>
                                        <input type="text" name="client_company_address" id="client_company_address"
                                            class="form-control"
                                            value="{{ old('client_company_address',$data->client_company_address??'') }}"
                                            placeholder=" Enter Client Address">
                                        @if($errors->has('client_company_address'))
                                        <div class="error">{{ $errors->first('client_company_address') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="point-contact">
                            <h5>Client Point of Contact</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_name" class="">Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('client_name',$data->client[0]->client_name??'') }}"
                                            name="client_name" id="client_name"
                                            placeholder=" Enter Your client_pontin Name">
                                        @if($errors->has('client_name'))
                                        <div class="error">{{ $errors->first('client_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_designation" class="">Designation</label>
                                        <input type="text" class="form-control" name="client_designation"
                                            value="{{ old('client_designation',$data->client[0]->client_designation??'') }}"
                                            id="client_designation" placeholder="Enter Your Designation">
                                        @if($errors->has('client_designation'))
                                        <div class="error">{{ $errors->first('client_designation') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_email" class="">Email</label>
                                        <input type="email" class="form-control"
                                            value="{{ old('client_email',$data->client[0]->client_email??'') }}"
                                            name="client_email" id="client_email" placeholder=" Enter Your Email">
                                        @if($errors->has('client_email'))
                                        <div class="error">{{ $errors->first('client_email') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_phone" class="">Phone Number</label>
                                        <input type="text" class="form-control" name="client_phone"
                                            value="{{ old('client_phone',$data->client[0]->client_phone??'') }}"
                                            id="client_phone" placeholder="Enter Your Phone Number">
                                        @if($errors->has('client_phone'))
                                        <div class="error">{{ $errors->first('client_phone') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="client_mobile" class="">Mobile Number</label>
                                        <input type="text" class="form-control" name="client_mobile"
                                            value="{{ old('client_mobile',$data->client[0]->client_mobile??'') }}"
                                            id="client_mobile" placeholder="Enter Your Mobile Number">
                                        @if($errors->has('client_mobile'))
                                        <div class="error">{{ $errors->first('client_mobile') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>`);
            }else{
                $('.bodyAdd').html(` `);
            }
        });
    });
