@foreach ($data as $mp)
    <div class="modal fade" id="delete_mp{{ $mp->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Delete Market Price</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('market-price.destroy', $mp->id) }}" method="POST">
                        @method('DELETE')
                        @csrf

                        {{-- @if ($mp->course_count > 0)
                            <p>Market Price with name <b>{{ $mp->description }}</b> cannot be deleted because it has
                                associated.</p>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        @else --}}
                            <p>Are you sure want to delete Market Price with name <b>{{ $mp->item->description }}</b> ? </p>
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
