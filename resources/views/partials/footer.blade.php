<!-- plugins:js -->
<script src="{{ asset('purple/src/assets/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('purple/src/assets/vendors/chart.js/chart.umd.js') }}"></script>
{{-- <script src="{{ asset('purple/src/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script> --}}
<script src="{{ asset('purple/src/assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('purple/src/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('purple/src/assets/vendors/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('purple/src/assets/vendors/jquery.avgrund/jquery.avgrund.min.js') }}"></script>
<script src="{{ asset('purple/src/assets/vendors/summernote/summernote-bs5.min.js') }}"></script>
<script src="{{ asset('purple/src/assets/vendors/select2/select2.min.js') }}"></script>


<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('purple/src/assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('purple/src/assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('purple/src/assets/js/misc.js') }}"></script>
<script src="{{ asset('purple/src/assets/js/settings.js') }}"></script>
<script src="{{ asset('purple/src/assets/js/todolist.js') }}"></script>
<script src="{{ asset('purple/src/assets/js/jquery.cookie.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('purple/src/assets/js/dashboard.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<!-- Custom js for this page -->
<script src="{{ asset('purple/src/assets/js/data-table.js') }}"></script>
<script src="{{ asset('purple/src/assets/js/paginate.js') }}"></script>
<script src="{{ asset('purple/src/assets/js/alerts.js') }}"></script>
<script src="{{ asset('purple/src/assets/js/avgrund.js') }}"></script>
<script src="{{ asset('purple/src/assets/js/editorDemo.js') }}"></script>
@include('sweetalert::alert')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Init untuk elemen yang sudah terlihat (jika ada)
        $('.summernote').each(function() {
            if (!$(this).data('summernote')) {
                $(this).summernote({
                    height: 100,
                    dialogsInBody: true
                });
            }
        });

        // Lazy init ketika modal dibuka
        $(document).on('shown.bs.modal', '.modal', function() {
            $(this).find('.summernote').each(function() {
                if (!$(this).data('summernote')) {
                    $(this).summernote({
                        height: 100,
                        dialogsInBody: true
                    });
                }
            });
        });

        // (Opsional) destroy saat modal ditutup biar ringan & hindari duplikasi
        $(document).on('hidden.bs.modal', '.modal', function() {
            $(this).find('.summernote').each(function() {
                if ($(this).data('summernote')) {
                    $(this).summernote('destroy');
                }
            });
        });

        // (Jaga-jaga) pastikan value textarea ter-sync saat submit
        $(document).on('submit', 'form', function() {
            $(this).find('.summernote').each(function() {
                if ($(this).data('summernote')) {
                    $(this).val($(this).summernote('code'));
                }
            });
        });

        // Gunakan $ di sini untuk jQuery
        $('#select2').select2();
        $('.select2').select2();
    });
</script>

<script>
    $(document).ready(function() {
        $('#price-list-table').DataTable({
            order: [], // jangan sort ulang dari DataTables
            aaSorting: [], // fallback untuk versi DataTables lama
            autoWidth: false,
            responsive: false,
            pageLength: 10
        });
    });
</script>

@stack('scripts')

<!-- End custom js for this page -->
</body>

</html>
