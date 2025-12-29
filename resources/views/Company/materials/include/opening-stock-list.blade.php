  {{-- <div class="main-card mb-3 card">
      <div class="card-body">
          <h5 class="card-title">List Materials Details</h5>
          <div class="scrollable_table">
              <table class="mb-0 table  dataTable_scrolling" id="dataTable_scrolling">
                  <thead> --}}
  <div class="comp-body">
      <div class="row">
          <div class="col-lg-12">
              <div class="main-card mb-3 card">
                  <div class="card-body">
                      <h5 class="card-title">List Materials Details</h5>
                      <div class="table-responsive">
                          <table class="mb-0 table dataTable">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Project Name</th>
                                      <th>Store/ Warehouse</th>
                                      <th>Class of Materials</th>
                                      <th>Materials Code</th>
                                      <th>Materials Name</th>
                                      <th>Specification</th>
                                      <th>Unit</th>
                                      <th>Opening Date</th>
                                      <th>Opening QTY</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  {{-- @dd($openingMaterials) --}}
                                  {{-- <tbody class="datatable_body"> --}}
                                  @if ($openingMaterials)
                                      @forelse($openingMaterials as $key => $data)
                                          <tr>
                                              <td>
                                                  <p>#{{ $key + 1 }}</p>
                                              </td>
                                              <td>
                                                  <p>{{ $data->projects->project_name ?? '' }}
                                                  </p>
                                              </td>
                                              <td>
                                                  <p>{{ $data->stores->name ?? '' }}</p>
                                              </td>
                                              <td>
                                                  <p>{{ $data->materials->class ?? '' }}
                                                  </p>
                                              </td>
                                              <td>
                                                  <p>{{ $data->materials->code ?? '' }}
                                                  </p>
                                              </td>
                                              <td>
                                                  <p>{{ $data->materials->name ?? '' }}
                                                  </p>
                                              </td>
                                              <td>
                                                  <p>{{ $data->materials->specification ?? '' }}
                                                  </p>
                                              </td>
                                              <td>
                                                  <p>{{ $data->materials->units->unit ?? '' }}
                                                  </p>
                                              </td>
                                              <td>
                                                  <p>{{ $data->opeing_stock_date ?? '' }}
                                                  </p>
                                              </td>
                                              <td>
                                                  <p>{{ $data->qty ?? '' }}
                                                  </p>
                                              </td>
                                              <td>
                                                  <a href="{{ route('company.materials.stockedit', $data->uuid) }}"><i
                                                          class="fa fa-edit" style="cursor: pointer;"
                                                          title="Edit"></i></a>

                                                  <!-- <a href="{{ route('company.materials.issuestockedit', $data->uuid) }}"><i
                                                    class="fa fa-edit" style="cursor: pointer;" title="Edit"></i></a> -->

                                                  <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}"
                                                      data-table="material_opening_stocks" data-model="company"
                                                      href="javascript:void(0)"><i class="fa fa-trash-alt"
                                                          style="cursor: pointer;" title="Remove">
                                                      </i></a>
                                              </td>
                                          </tr>
                                      @empty
                                          <p>!No Data Found</p>
                                      @endforelse
                                  @endif
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
