@extends('layout.index')

@section('content')
    <x-card>
        <x-slot:header class="d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">Detail Toko</h6>
            <div class="d-flex gap-2 flex-sm-row flex-column">
                <x-button href="{{ route('web.store.index') }}" color="info" size="sm"><x-icon
                        name="fa-solid fa-arrow-left me-2" /> Kembali</x-button>
                <x-button href="{{ route('web.store.edit', $store) }}" color="warning" size="sm"><x-icon
                        name="fa-solid fa-edit me-2" /> Edit Toko</x-button>
                <x-button href="{{ route('web.store.product.create', $store) }}" color="primary" size="sm"><x-icon
                        name="fa-solid fa-plus me-2" /> Tambah Produk</x-button>
            </div>
        </x-slot:header>

        <x-row>
            <x-col lg="4" xl="4" md="4" class="mb-3">
                <img src="{{ $store->thumbnail ? asset("storage/$store->thumbnail") : asset($store::DEFAULT_IMAGE) }}"
                    onerror="this.src=null; this.src='{{ asset($store::DEFAULT_IMAGE) }}'" alt="{{ $store->name }}"
                    width="100%" height="250">
            </x-col>
            <x-col lg="8" xl="8" md="8" class="mb-3">
                <div class="mb-3">
                    <label>Nama Pemilik</label>
                    <h5>{{ $store->user->name }}</h5>
                </div>
                <div class="mb-3">
                    <label>Nama Toko</label>
                    <h5>{{ $store->name }}</h5>
                </div>
                <div class="mb-3">
                    <label>Alamat Toko</label>
                    <p>{{ $store->address }}</p>
                </div>
                <div class="mb-3">
                    <label>Deskripsi Toko</label>
                    <p>{{ $store->description }}</p>
                </div>
                <div class="mb-3">
                    <label>Jam Operational Toko</label>
                    <br>
                    <x-button size="sm" color="primary" toggle="modal" target="#lookHour"><i
                            class="fa-solid fa-eye me-2"></i> Lihat Jam</x-button>
                </div>
            </x-col>
        </x-row>

        <x-table :isComplete="true" id="productTable">
            <x-slot:thead>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori Produk</th>
                <th>Stok</th>
                <th>Harga (per produk)</th>
                <th>Aksi</th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($store->products as $product)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $product->name }}</td>
                        <td>
                            <ul class="ps-2">
                                @foreach ($product->categories as $category)
                                    <li>{{ $category->modul->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $product->stock }}</td>
                        <td>Rp {{ Number::format($product->price, locale: 'id') }}</td>
                        <td nowrap>
                            <x-button
                                href="{{ route('web.store.product.edit', ['store' => $store, 'product' => $product]) }}"
                                size="sm" color="warning me-2">
                                <x-icon name="fa-solid fa-edit me-2" />
                                Edit</x-button>
                            <form
                                action="{{ route('web.store.product.destroy', ['store' => $store, 'product' => $product]) }}"
                                method="post" class="d-inline">
                                @csrf
                                @method('delete')
                                <x-button type="submit" size="sm" color="danger btn-delete"> <x-icon
                                        name="fa-solid fa-trash me-2" />
                                    Hapus</x-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-table>
    </x-card>
@endsection

@push('modal')
    <x-modal id="lookHour" title="Jam Operational" :form="true">
        <x-table class="table-bordered" :isComplete="true">
            <x-slot:thead>
                <th>Hari</th>
                <th>Jam Buka</th>
                <th>Jam Tutup</th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach (json_decode($store->operational_hour) as $day)
                    <tr>
                        <th>{{ $day->day }}</th>
                        <td>{{ $day->opening_time }}</td>
                        <td>{{ $day->closing_time }}</td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-table>
        <x-slot:footer>
            <x-button size="sm" color="secondary" dismiss="modal">Tutup</x-button>
        </x-slot:footer>
    </x-modal>
@endpush

@push('js')
    <script>
        $(function() {
            $("#productTable").DataTable({
                scrollX: true,
            })
        })
    </script>
@endpush
