@foreach ($data as $supplier)
    <div class="modal fade" id="delete_supplier{{ $supplier->safe_id_supplier }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel-2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-2">Delete Supplier</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample" action="{{ route('suppliers.destroy', $supplier->id_supplier) }}"
                        method="POST">
                        @method('DELETE')
                        @csrf
                        <p>Are you sure want to delete <b>Supplier {{ $supplier->id_supplier }} -
                                {{ $supplier->supplier_name }}</b> ? </p>
                        <button type="submit" class="btn btn-gradient-primary me-2">Delete</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endforeach
