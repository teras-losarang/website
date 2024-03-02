@extends('layout.index')

@section('content')
    <x-row>
        @include('user.menu')
        <x-col sm="8" lg="8" xl="8" md="8" class="mt-sm-0 mt-3">
            <x-card>
                <x-slot:header class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">List Kurir</h6>
                    <x-button toggle="modal" target="#addNewUser" size="sm"><x-icon name="fa-solid fa-plus me-2" /> Tambah
                        Kurir</x-button>
                </x-slot:header>
                <x-table :isComplete="true">
                    <x-slot:thead>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        <tr>
                            <th>1</th>
                            <td>Hakim Asrori</td>
                            <td>hakim@mailinator.com</td>
                            <td nowrap>
                                <x-button href="{{ route('web.user.admin.edit', 1) }}" size="sm" color="warning me-2"
                                    toggle="modal" target="#addNewUser">
                                    <x-icon name="fa-solid fa-edit me-2" />
                                    Edit</x-button>
                                <form action="{{ route('web.user.admin.destroy', 1) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <x-button type="submit" size="sm" color="danger btn-delete"> <x-icon
                                            name="fa-solid fa-trash me-2" />
                                        Hapus</x-button>
                                </form>
                            </td>
                        </tr>
                    </x-slot:tbody>
                </x-table>
            </x-card>
        </x-col>
    </x-row>
@endsection

@push('modal')
    <x-modal id="addNewUser" title="Form Admin" :form="true">
        <x-input id="name" label="Nama Lengkap" />
        <x-input id="email" label="Email Pengguna" />
        <x-input id="password" label="Password Pengguna" readonly value="password" />
        <x-slot:footer>
            <x-button size="sm" color="secondary" dismiss="modal">Batal</x-button>
        </x-slot:footer>
    </x-modal>
@endpush
