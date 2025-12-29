  <div class="main-card mb-3 card">
      <div class="card-body">
          <h5 class="card-title">List Asset/Machinery Opening Details</h5>
          <div class="scrollable_table">
              <table class="mb-0 table dataTable dataTable_scrolling" id="dataTable_scrolling">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Project Name</th>
                          <th>Store/ Warehouse</th>
                          <th>Name</th>
                          <th>Code</th>
                          <th>Specification</th>
                          <th>Unit</th>
                          <th>Opening QTY</th>
                          <th>Opening Date</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody class="datatable_body">
                      @if ($openingAsstes)
                          @forelse($openingAsstes as $key => $data)
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
                                      <p>{{ $data->assets->name ?? '' }}
                                      </p>
                                  </td>
                                  <td>
                                      <p>{{ $data->assets->code ?? '' }}
                                      </p>
                                  </td>
                                  <td>
                                      <p>{{ $data->assets->specification ?? '' }}
                                      </p>
                                  </td>
                                  <td>
                                      <p>{{ $data->assets->units->unit ?? '' }}
                                      </p>
                                  </td>
                                  <td>
                                      <p>{{ $data->quantity ?? '' }}
                                      </p>
                                  </td>
                                  <td>
                                      <p>{{ $data->opeing_stock_date ?? '' }}
                                      </p>
                                  </td>
                                  <td>
                                      <a href="{{ route('company.assets.stockedit', $data->uuid) }}"><i class="fa fa-edit"
                                              style="cursor: pointer;" title="Edit"></i></a>

                                      <a class="deleteData text-danger" data-uuid="{{ $data->uuid }}"
                                          data-table="assets_opening_stocks" data-model="company"
                                          href="javascript:void(0)"><i class="fa fa-trash-alt" style="cursor: pointer;"
                                              title="Remove">
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
