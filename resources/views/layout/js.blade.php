<script src="{{ asset('/') }}assets/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('/') }}assets/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('/') }}assets/vendor/js/bootstrap.js"></script>
<script src="{{ asset('/') }}assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="{{ asset('/') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ asset('/') }}assets/vendor/libs/hammer/hammer.js"></script>
<script src="{{ asset('/') }}assets/vendor/libs/i18n/i18n.js"></script>
<script src="{{ asset('/') }}assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="{{ asset('/') }}assets/vendor/js/menu.js"></script>

<script src="{{ asset('/') }}assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="{{ asset('/') }}assets/vendor/libs/swiper/swiper.js"></script>
<script src="{{ asset('/') }}assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

<script src="{{ asset('/') }}assets/js/main.js"></script>

<script src="{{ asset('/') }}assets/js/dashboards-analytics.js"></script>
<script src="{{ asset('/') }}assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

<script>
    $(function() {
        $("#defaultDatatable").DataTable({
            scrollX: true
        })

        $(".btn-delete").click(function(e) {
            e.preventDefault();
            $(".swal2-container .swal2-actions button.swal2-cancel").html("Batal")

            let form = $(this).closest("form");

            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Anda tidak akan dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelmButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    form.submit()
                }
            });
        })
    })
</script>
<script>
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@stack('js')
