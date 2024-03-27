@extends('layout.index')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
@endpush

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form action="{{ route('web.store.product.store', $store) }}" method="post" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf
        <x-card>
            <x-slot:header class="d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Tambah Produk Baru</h6>
            </x-slot:header>

            <x-input id="name" label="Nama Produk" required :value="old('name')" autofocus />
            <x-select id="modul_ids[]" label="Kategori Produk" multiple class="select2" required>
                @foreach ($moduls as $modul)
                    <option value="{{ $modul->id }}">{{ $modul->name }}</option>
                @endforeach
            </x-select>
            <x-input id="price" label="Harga Produk" required :value="old('price')" />
            <x-input id="stock" type="number" label="Stok Produk" required :value="old('stock')" />
            <x-textarea label="Deskripsi" id="description" required value="{{ old('description') }}" />
            <div>
                <x-label>Unggah Foto Produk <small class="text-danger">(* foto boleh lebih dari 1)</small></x-label>
                <x-input id="images[]" accept="image/png, image/jpg, image/jpeg" type="file" multiple required />
            </div>

            <x-slot:footer>
                <x-button size="sm" color="secondary" route="web.store.show" :parameter="$store">Batal</x-button>
                <x-button type="submit" size="sm" color="primary">Simpan</x-button>
            </x-slot:footer>
        </x-card>
    </form>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script>
        $(function() {
            new Cleave($("#price"), {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });

            $(".select2").wrap('<div class="position-relative"></div>').select2({
                placeholder: '',
                dropdownParent: $(".select2").parent(),
                containerCssClass: function(e) {
                    return $(".select2").attr('required') ? 'is-invalid' : 'is-valid';
                }
            });
        })
    </script>
@endpush
