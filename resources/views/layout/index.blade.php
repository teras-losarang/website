<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('/') }}assets/" data-template="vertical-menu-template">

@include('layout.head')

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('layout.side')

            <div class="layout-page">
                @include('layout.nav')

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @yield('content')
                    </div>

                    @include('layout.foot')

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>

        <div class="drag-target"></div>
    </div>

    @stack('modal')
    @include('layout.js')
</body>

</html>
