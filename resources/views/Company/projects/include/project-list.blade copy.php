@if ($datas)
    @forelse($datas as $key => $data)
        {{-- @dd($data) --}}

        <div class="company-info">
            <div class="accordion-item">
                <h2 class="accordion-header" id="constgOne">
                    <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        <div class="companyn_img">
                            <img src="{{ $data->ProfilePicture }}" class="img-fluid" alt="">
                        </div>
                        <h3 class="companyn_txt">
                            {{ $data->project_name }}
                        </h3>
                    </div>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="constgOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="company_details">
                                    <h4><span>Project Name -
                                        </span>{{ $data->project_name }}</h4>
                                    <h4><span> Address -
                                        </span>
                                        {{ $data->address }}
                                    </h4>
                                    <h4><span> Planned Start
                                            date
                                            - </span>
                                        {{ $data->planned_start_date }}
                                    </h4>
                                    <h4><span> Planned End
                                            Date
                                            -</span>
                                        {{ $data->planned_end_date }}
                                    </h4>
                                    <h4><span> Project Owner
                                            -
                                        </span>
                                        {{ $data->own_project_or_contractor == 'yes' ? 'Owner' : 'Contractor' }}
                                    </h4>
                                    <h4><span>Client Name -
                                        </span>

                                        {{ $data->client->client_company_name ?? '' }}
                                    </h4>
                                    <h4><span> Address -
                                        </span>{{ $data->client->client_company_address ?? '' }}
                                    </h4>

                                </div>
                            </div>
                            <div class="col-md-6">
                                @if ($data->client)
                                    <div class="company_details">
                                        <h5 class="client_hd">
                                            Client Point of Contact
                                        </h5>
                                        <div class="clientpoint_box">
                                            <div class="clientp_boxleft">
                                                <h4><span>Name -
                                                    </span>
                                                    {{ $data->client->client_name ?? '' }}
                                                </h4>
                                                <h4><span>Designation -
                                                    </span>
                                                    {{ $data->client->client_designation ?? '' }}
                                                </h4>
                                                <h4><span>Email -
                                                    </span>
                                                    {{ $data->client->client_email ?? '' }}
                                                </h4>
                                                <h4><span>Phone-
                                                    </span>
                                                    {{ $data->client->client_phone ?? '' }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="tag_company">
                                    <h6><span>Tag Company -</span> </h6>
                                    <a href="#"
                                        class="tag-com">{{ $data->companys->registration_name ?? '' }}</a>
                                </div>
                                <div class="tag_company">
                                    <h6><span>Tag Project Manager -</span> </h6>
                                    @if ($data?->members)
                                        @foreach ($data->members as $member)
                                            <a href="#" class="tag-com">{{ $member->name }}</a>
                                        @endforeach
                                    @else
                                        <p>No members found</p>
                                    @endif
                                </div>
                                {{-- @dd($data) --}}
                                <div class="tag_company">
                                    <h6><span>PR Approval Members-</span> </h6>

                                    {{-- @dd($sdfg); --}}
                                    @if (count($data?->prApprovalMemebers) > 0)
                                        @foreach ($data?->prApprovalMemebers as $member)
                                            <a href="#" class="tag-com">{{ $member?->user?->name }}</a>
                                        @endforeach
                                        <p><a href="{{ route('company.pr.approval.edit', $data->id) }}"
                                                class="text-decoration-underline">
                                                Edit
                                            </a></p>
                                    @else
                                        <p>No members found <a
                                                href="{{ route('company.pr.approval.edit', $data->id) }}"
                                                class="text-decoration-underline">
                                                Setup
                                            </a></p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <div class="compaction_btn">
                                    <a href="{{ route('company.project.edit', $data->uuid ?? '') }}"
                                        class="btn btn-primary">Edit</a>
                                    <a class="btn btn-secondary deleteData text-danger" data-model="company"
                                        data-uuid="{{ $data->uuid ?? '' }}" data-table="projects"
                                        href="javascript:void(0)">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>!No Data Found!!!</p>
    @endforelse
    <div class="pagination">
        {{ $datas->links() }}
    </div>
@endif
