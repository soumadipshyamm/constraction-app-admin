@if ($datas)
    @forelse($datas as $key => $data)
        <div class="company-info">
            <div class="accordion-item">
                <h2 class="accordion-header" id="constgOne">
                    <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        <div class="companyn_img">
                            <img src="{{ $data->ProfilePicture }}">
                        </div>
                        <h3 class="companyn_txt">
                            {{ $data->registration_name }}
                        </h3>
                    </div>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="constgOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body company_details">
                        <h4><span>Company Name -</span>{{ $data->registration_name }}</h4>
                        <h4><span>Registration no if any</span> -
                            {{ $data->company_registration_no }}
                        </h4>

                        <h4><span>Registered Address</span> - {{ $data->registered_address }}</h4>
                        {{-- <div class="compd_logo">
                    <h4><span>Company Logo -</span></h4>
                    <img src="{{ $data->ProfilePicture }}" width="50px" height="50px">
                </div> --}}
                        <div class="compaction_btn">
                            <a href="{{ route('company.companies.edit', $data->uuid) }}"
                                class="btn btn-primary">Edit</a>
                            <a class="btn btn-secondary deleteData " data-model="company"
                                data-uuid="{{ $data->uuid }}" data-table="companies"
                                href="javascript:void(0)">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty

        <p>!No Data Found</p>
    @endforelse
@endif

<div class="ajax-pagination-div d-flex justify-content-center">
    @if (isset($datas))
        {!! $datas->links() !!}
    @endif
</div>
