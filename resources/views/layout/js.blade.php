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
        $(".btn-delete").click(function(e) {
            e.preventDefault();

            let form = $(this).closest("form");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
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
@stack('js')
