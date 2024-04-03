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
            <div class="mb-3">
                <x-label>Gunakan Variant</x-label>
                <br>
                <label class="switch">
                    <input type="checkbox" class="switch-input" value="1" name="enable_variant"
                        @checked($product->enable_variant)>
                    <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                    </span>
                </label>
            </div>

            <div @class(['form-repeater', 'd-none' => $product->variants->count() < 1])>
                <div data-repeater-list="variant">
                    @forelse ($product->variants as $key => $variant)
                        <div data-repeater-item>
                            <x-row>
                                <x-col lg="3" xl="3" md="3">
                                    <x-input id="variant[{{ $key }}][name]" label="Nama Variant"
                                        value="{{ $variant->name }}" />
                                </x-col>
                                <x-col lg="3" xl="3" md="3">
                                    <x-input type="number" id="variant[{{ $key }}][stock]" label="Stok Variant"
                                        value="{{ $variant->stock }}" />
                                </x-col>
                                <x-col lg="3" xl="3" md="3">
                                    <x-input id="variant[{{ $key }}][price]" label="Harga Variant"
                                        value="{{ $variant->price }}" />
                                </x-col>
                                <x-col lg="3" xl="3" md="3">
                                    <a href="javascript:void(0);" class="btn btn-label-danger mt-4 w-100"
                                        data-repeater-delete>
                                        <i class="ti ti-x ti-xs me-1"></i>
                                        <span class="align-middle">Delete</span>
                                    </a>
                                </x-col>
                            </x-row>
                            <hr />
                        </div>
                    @empty
                        <div data-repeater-item>
                            <x-row>
                                <x-col lg="3" xl="3" md="3">
                                    <x-input id="name" label="Nama Variant" />
                                </x-col>
                                <x-col lg="3" xl="3" md="3">
                                    <x-input type="number" id="stock" label="Stok Variant" />
                                </x-col>
                                <x-col lg="3" xl="3" md="3">
                                    <x-input id="price" label="Harga Variant" />
                                </x-col>
                                <x-col lg="3" xl="3" md="3">
                                    <a href="javascript:void(0);" class="btn btn-label-danger mt-4 w-100"
                                        data-repeater-delete>
                                        <i class="ti ti-x ti-xs me-1"></i>
                                        <span class="align-middle">Delete</span>
                                    </a>
                                </x-col>
                            </x-row>
                            <hr />
                        </div>
                    @endforelse
                </div>
                <div class="mb-0">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-repeater-create>
                        <i class="ti ti-plus me-1"></i>
                        <span class="align-middle">Tambah Variant</span>
                    </a>
                </div>
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
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script>
        $(function() {
            new Cleave($("#price"), {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });

            $("input[name='enable_variant']").on("click", function() {
                if ($("input[name='enable_variant']:checked").length) {
                    $(".form-repeater").removeClass('d-none')
                    $(".form-repeater input").attr("required", true)
                } else {
                    $(".form-repeater").addClass('d-none')
                    $(".form-repeater input").attr("required", false)
                }
            })

            if ($(".form-repeater").length) {
                var row = 2;
                var col = 1;
                $(".form-repeater").on('submit', function(e) {
                    e.preventDefault();
                });
                $(".form-repeater").repeater({
                    show: function() {
                        var fromControl = $(this).find('.form-control, .form-select');
                        var formLabel = $(this).find('.form-label');

                        fromControl.each(function(i) {
                            var id = 'form-repeater-' + row + '-' + col;
                            $(fromControl[i]).attr('id', id);
                            $(formLabel[i]).attr('for', id);
                            col++;
                        });

                        row++;

                        $(this).slideDown();
                    },
                    hide: function(e) {
                        $(this).slideUp(e);
                    }
                });
            }
        })
    </script>
@endpush
