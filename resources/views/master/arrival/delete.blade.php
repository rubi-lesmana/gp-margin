@foreach ($data as $arrival)
    <div class="modal fade" id="delete_arrival{{ $arrival->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Delete Inventory Arrival</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('arrival-inventory.destroy', $arrival->id) }}" method="POST">
                        @method('DELETE')
                        @csrf

                        {{-- @if ($arrival->course_count > 0)
                            <p>Market Price with name <b>{{ $arrival->description }}</b> cannot be deleted because it has
                                associated.</p>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        @else --}}
                            <p>Are you sure want to delete Inventory Arrival with name <b>{{ $arrival->item->description }}</b> ? </p>
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
