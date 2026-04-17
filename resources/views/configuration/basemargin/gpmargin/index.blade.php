<div class="tab-pane fade show active" id="gpmargin" role="tabpanel" aria-labelledby="home-tab">
    <div class="table-responsive px-4">
        <div class="row mb-3">
            <div class="col">
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#add_basemargin">
                    Add Data<i class=" mdi mdi-plus-box ms-1"></i>
                </button>
            </div>
        </div>
        <table id="order-listing" class="table table-striped dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th class="text-center">No #</th>
                    <th>Margin Percentage</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $basemargin)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $basemargin->margin_percentage_format }}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)"
                                class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                data-bs-toggle="modal" data-bs-target="#edit_item{{ $basemargin->id }}" title="Edit">
                                <i
                                    class="mdi mdi-pencil-outline position-absolute top-50 start-50 translate-middle"></i>
                            </a>

                            <a href="javascript:void(0)"
                                class="btn btn-gradient-danger btn-rounded btn-icon position-relative"
                                data-bs-toggle="modal" data-bs-target="#delete_item{{ $basemargin->id }}"
                                title="Delete">
                                <i
                                    class="mdi mdi-delete-outline position-absolute top-50 start-50 translate-middle"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Modal Includes --}}
        @include('configuration.basemargin.gpmargin.create')
        @include('configuration.basemargin.gpmargin.update')
        @include('configuration.basemargin.gpmargin.delete')
    </div>
</div>
