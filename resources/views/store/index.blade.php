@extends('layout.index')

@section('content')
    <x-card>
        <x-slot:header class="d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">List Toko</h6>
            <x-button href="{{ route('web.store.create') }}" size="sm"><x-icon name="fa-solid fa-plus me-2" /> Tambah
                Toko</x-button>
        </x-slot:header>
        <x-table :isComplete="true" id="defaultDatatable">
            <x-slot:thead>
                <th>No</th>
                <th>Nama Toko</th>
                <th>Kategori Toko</th>
                <th>Customer</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($stores as $store)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $store->name }}</td>
                        <td>{{ $store->tags }}</td>
                        <td>{{ $store->user->name }}</td>
                        <td>{{ Str::limit($store->description, 100, '...') }}</td>
                        <td nowrap>
                            <x-button href="{{ route('web.store.product.create', $store) }}" color="primary me-2"
                                size="sm"><x-icon name="fa-solid fa-plus me-2" /> Tambah Produk</x-button>
                            <x-button href="{{ route('web.store.show', $store) }}" size="sm" color="info me-2">
                                <x-icon name="fa-solid fa-eye me-2" />
                                Detail</x-button>
                            <x-button href="{{ route('web.store.edit', $store) }}" size="sm" color="warning me-2">
                                <x-icon name="fa-solid fa-edit me-2" />
                                Edit</x-button>
                            <form action="{{ route('web.store.destroy', $store) }}" method="post" class="d-inline">
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
