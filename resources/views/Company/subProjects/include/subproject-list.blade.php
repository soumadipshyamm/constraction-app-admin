@if ($datas)
@forelse($datas as $key => $data)
@if (count($data->subProject) != 0)
<div class="company-details">
    <h5><span>Project Name: -
        </span>{{ $data->project_name }}</h5>
</div>
@endif
<div class="accordion company_box" id="constGroup">
    @if ($data->subProject)
    @foreach ($data->subProject as $key => $subproject)
    <div class="company-info">
        <div class="accordion-item">
            <h2 class="accordion-header" id="constgOne">
                <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target=".collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <div class="companyn_img">
                        <img src="{{ $data->ProfilePicture }}" class="img-fluid" alt="">
                    </div>
                    <h3 class="companyn_txt">
                        {{ $subproject->name }}
                    </h3>
                </div>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse collapseOne show" aria-labelledby="constgOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body company_details">
                    <h4><span>Project Name -
                        </span>{{ $data->project_name ?? '' }}</h4>
                    <h4><span>Sub-Project Name -</span>{{ $subproject?->name }}</h4>
                    <h4><span>Start Date</span> - {{ $subproject?->start_date }}
                    </h4>
                    <h4><span>End Date</span> - {{ $subproject->end_date }}</h4>
                    <div class="compaction_btn">
                        <a href="{{ route('company.subProject.edit', $subproject->uuid) }}"
                            class="btn btn-primary">Edit</a>
                        <a class="deleteData text-danger btn btn-secondary" data-model="company"
                            data-uuid="{{ $subproject->uuid }}" data-table="sub_projects"
                            href="javascript:void(0)">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
@empty
@endforelse
@endif
