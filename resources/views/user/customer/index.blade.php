@extends('layout.index')

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

    <x-row>
        @include('user.menu')
        <x-col sm="8" lg="8" xl="8" md="8" class="mt-sm-0 mt-3">
            <x-card>
                <x-slot:header class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">List Customer</h6>
                    <x-button toggle="modal" target="#addNewUser" size="sm"
                        data-action="{{ route('web.user.customer.store') }}"><x-icon name="fa-solid fa-plus me-2" /> Tambah
                        Customer</x-button>
                </x-slot:header>
                <x-table :isComplete="true" id="defaultDatatable">
                    <x-slot:thead>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td nowrap>
                                    @if ($user->id != 1)
                                        <x-button href="{{ route('web.user.customer.update', 1) }}" size="sm"
                                            color="warning me-2" toggle="modal" target="#editNewUser"
                                            data-action="{{ route('web.user.customer.update', $user) }}">
                                            <x-icon name="fa-solid fa-edit me-2" />
                                            Edit</x-button>
                                        <form action="{{ route('web.user.customer.destroy', $user) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <x-button type="submit" size="sm" color="danger btn-delete"> <x-icon
                                                    name="fa-solid fa-trash me-2" />
                                                Hapus</x-button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-slot:tbody>
                </x-table>
            </x-card>
        </x-col>
    </x-row>
@endsection

@push('modal')
    <x-modal id="addNewUser" title="Tambah Customer Baru" :form="true">
        <div id="fetched-data"></div>
        <x-slot:footer>
            <x-button size="sm" color="secondary" dismiss="modal">Batal</x-button>
            <x-button type="submit" size="sm" color="primary">Simpan</x-button>
        </x-slot:footer>
    </x-modal>
    <x-modal id="editNewUser" title="Edit Customer" :form="true">
        <div id="fetched-data"></div>
        <x-slot:footer>
            <x-button size="sm" color="secondary" dismiss="modal">Batal</x-button>
            <x-button type="submit" size="sm" color="primary">Simpan</x-button>
        </x-slot:footer>
    </x-modal>
@endpush

@push('js')
    <script>
        $(function() {
            $("button[data-bs-target='#addNewUser']").on("click", function() {
                $("#addNewUser form").attr("action", $(this).data('action'))
                $.ajax({
                    url: "{{ route('web.user.admin.create') }}",
                    type: "get",
                    success: function(response) {
                        $("#addNewUser #fetched-data").html(response)
                    }
                })
            })

            $("a[data-bs-target='#editNewUser']").on("click", function() {
                $("#editNewUser form").attr("action", $(this).data('action'))
                $.ajax({
                    url: $(this).data('action') + "/edit",
                    type: "get",
                    success: function(response) {
                        $("#editNewUser #fetched-data").html(response)
                    }
                })
            })
        })
    </script>
@endpush
