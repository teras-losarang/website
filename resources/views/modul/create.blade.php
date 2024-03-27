@extends('layout.index')

@section('content')
    <form action="{{ route('web.modul.store') }}" method="post" enctype="multipart/form-data" novalidate
        class="needs-validation">
        @csrf
        <x-card>
            <x-slot:header class="d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Tambah Modul</h6>
            </x-slot:header>

            <x-select label="Tipe Modul" placeholder=" " id="type" required>
                @foreach ($types as $key => $type)
                    <option value="{{ $key }}">{{ $type }}</option>
                @endforeach
            </x-select>
            <x-input label="Nama" id="name" required />
            <x-input type="file" label="Icon" id="icon_file" required accept="image/jpg, image/png, image/jpeg" />

            <x-slot:footer class="d-flex align-items-center justify-content-between">
                <x-button color="secondary" size="sm" route="web.modul.index">Batal</x-button>
                <x-button type="submit" size="sm">Simpan</x-button>
            </x-slot:footer>
        </x-card>
    </form>
@endsection
