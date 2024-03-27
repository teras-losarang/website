@extends('layout.index')

@section('content')
    <x-card>
        <x-slot:header class="d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">List Produk</h6>
        </x-slot:header>
        <x-table :isComplete="true" id="defaultDatatable">
            <x-slot:thead>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori Produk</th>
                <th>Nama Toko</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Total Penjualan</th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($products as $product)
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
                        <td><a href="{{ route('web.store.show', $product->store) }}">{{ $product->store->name }}</a></td>
                        <td>Rp {{ Number::format($product->price, locale: 'id') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td nowrap>
                        </td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-table>
    </x-card>
@endsection
