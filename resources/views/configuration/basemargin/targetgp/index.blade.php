<div class="tab-pane fade" id="targetgp" role="tabpanel" aria-labelledby="targetgp-tab">
    <div class="table-responsive px-4">
        <div class="row mb-3">
            <div class="col">
            </div>
            <div class="col d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#add_tgpmargin">
                    Add Data<i class=" mdi mdi-plus-box ms-1"></i>
                </button>
            </div>
        </div>
        <table class="table table-striped dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th class="text-center">No #</th>
                    <th>Margin Percentage</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_tgp as $tgpmargin)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $tgpmargin->margin_percentage_format }}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)"
                                class="btn btn-gradient-success btn-rounded btn-icon position-relative"
                                data-bs-toggle="modal" data-bs-target="#edit_tgp{{ $tgpmargin->id }}" title="Edit">
                                <i
                                    class="mdi mdi-pencil-outline position-absolute top-50 start-50 translate-middle"></i>
                            </a>

                            <a href="javascript:void(0)"
                                class="btn btn-gradient-danger btn-rounded btn-icon position-relative"
                                data-bs-toggle="modal" data-bs-target="#delete_tgp{{ $tgpmargin->id }}" title="Delete">
                                <i
                                    class="mdi mdi-delete-outline position-absolute top-50 start-50 translate-middle"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Modal Includes --}}
        @include('configuration.basemargin.targetgp.create')
        @include('configuration.basemargin.targetgp.update')
        @include('configuration.basemargin.targetgp.delete')
    </div>
</div>
