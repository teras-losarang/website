@extends('layout.index')

@section('content')
    <form action="{{ route('web.modul.update', $modul) }}" method="post" enctype="multipart/form-data" novalidate
        class="needs-validation">
        @csrf
        @method('put')
        <x-card>
            <x-slot:header class="d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Tambah Modul</h6>
            </x-slot:header>

            <x-input label="Nama" id="name" required :value="$modul->name" />
            <x-input type="file" label="Icon" id="icon_file" required accept="image/jpg, image/png, image/jpeg" />
            @if ($modul->icon)
                <div class="mb-3">
                    <img src="{{ asset("storage/$modul->icon") }}" height="50" width="50"
                        onerror="this.src=null, this.src='{{ asset('assets/img/img-product-default.png') }}'">
                </div>
            @endif

            <x-slot:footer class="d-flex align-items-center justify-content-between">
                <x-button color="secondary" size="sm" route="web.modul.index">Batal</x-button>
                <x-button type="submit" size="sm">Simpan</x-button>
            </x-slot:footer>
        </x-card>
    </form>
@endsection
