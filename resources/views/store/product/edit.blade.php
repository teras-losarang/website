@extends('layout.index')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css') }}" />
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
    <form action="{{ route('web.store.product.update', ['store' => $store, 'product' => $product]) }}" method="post"
        class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        @method('put')
        <x-card>
            <x-slot:header class="d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Edit Produk</h6>
            </x-slot:header>

            <x-input id="name" label="Nama Produk" required :value="old('name') ?? $product->name" />
            <x-input id="price" label="Harga Produk" required :value="old('price') ?? $product->price" />
            <x-input id="stock" type="number" label="Stok Produk" required :value="old('stock') ?? $product->stock" />
            <x-textarea label="Deskripsi" id="description" required
                value="{{ old('description') ?? $product->description }}" />
            <div>
                <x-label>Unggah Foto Produk <small class="text-danger">(* foto boleh lebih dari 1)</small></x-label>
                <x-input id="images[]" accept="image/png, image/jpg, image/jpeg" type="file" multiple />
                <ul>
                    @foreach ($product->images as $image)
                        <li>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ asset("storage/$image->path_file") }}"
                                    target="_blank">{{ asset("storage/$image->path_file") }}</a>
                                <a href="{{ route('web.product.delete.image', $image) }}" class="text-danger"><i
                                        class="fa-solid fa-times"></i></a>
                            </div>
                        </li>
                    @endforeach
                </ul>
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
    <script>
        $(function() {
            new Cleave($("#price"), {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        })
    </script>
@endpush
