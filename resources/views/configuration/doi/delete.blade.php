@foreach ($data as $doi)
    <div class="modal fade" id="delete_doi{{ $doi->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Delete Days Of Inventory</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('doi-percentage.destroy', $doi->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <p>Are you sure want to delete Days Of Inventory with name <b>{{ $doi->min_days }} -
                                {{ $doi->max_days }} Days</b> and percentage <b>{{ $doi->percentage }}%</b> with remarks
                            <b>{{ $doi->label }}</b> ?
                        </p>
                        <button type="submit" class="btn btn-gradient-primary me-2">Delete</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        {{-- @endif --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endforeach
