@if ($datas)
    @forelse($datas as $key => $data)
        @if (count($data->StoreWarehouse) != 0)
            <div class="company-details">
                <h5><span>Project Name: -
                    </span>{{ $data->project_name }}</h5>
            </div>
        @endif
        <div class="accordion company_box" id="constGroup">
            @if ($data->StoreWarehouse)
                @forelse($data->StoreWarehouse as $key => $storehouse)
                    <div class="company-info">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="constgOne">
                                <div class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="companyn_img">
                                        <img src="{{ $data->ProfilePicture }}" class="img-fluid" alt="">
                                    </div>
                                    <h3 class="companyn_txt">
                                        {{ $storehouse->name }}
                                    </h3>
                                </div>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="constgOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body company_details">
                                    <h4><span> Name -
                                        </span>{{ $storehouse->name }}</h4>
                                    <h4><span>Location -
                                        </span>{{ $storehouse->location }}</h4>
                                    <h4><span>Project Name</span> -
                                        {{ $data->project_name }}
                                    </h4>
                                    <div class="compaction_btn">
                                        <a href="{{ route('company.storeWarehouse.edit', $storehouse->uuid) }}"
                                            class="btn btn-primary">Edit</a>
                                        <a class="deleteData text-danger btn btn-secondary" data-model="company"
                                            data-uuid="{{ $storehouse->uuid }}" data-table="store_warehouses"
                                            href="javascript:void(0)">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            @endif
        </div>
    @empty
    @endforelse
@endif
