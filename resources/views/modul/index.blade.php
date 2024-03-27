@extends('layout.index')

@section('content')
    <x-card>
        <x-row>
            <x-col md="6" lg="6" xl="6">
                <x-input type="search" placeholder="cari..." class="dt-input" :required="false" />
            </x-col>
            <x-col md="6" lg="6" xl="6">
                <form action="" method="get">
                    <select name="type" id="type" class="form-select" onchange="$(this).closest('form').submit()">
                        @foreach ($types as $key => $type)
                            <option value="{{ $key }}" @selected($key == session()->get('type'))>{{ $type }}</option>
                        @endforeach
                    </select>
                </form>
            </x-col>
        </x-row>
        <x-slot:header class="d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">List Modul</h6>
            <x-button href="{{ route('web.modul.create') }}" size="sm"><x-icon name="fa-solid fa-plus me-2" /> Tambah
                Modul</x-button>
        </x-slot:header>
        <x-table :isComplete="true" id="modulDatatable">
            <x-slot:thead>
                <th>No</th>
                <th>Nama Modul</th>
                <th>Icon Modul</th>
                <th>Status Modul</th>
                <th>Aksi</th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($moduls as $modul)
                    <tr>
                        <td>{{ $modul->sort }}</td>
                        <td>{{ $modul->name }}</td>
                        <td>
                            <img src="{{ asset("storage/$modul->icon") }}" height="50" width="50"
                                onerror="this.src=null, this.src='{{ asset('assets/img/img-product-default.png') }}'">
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" class="switch-input" id="changeStatus" data-id="{{ $modul->id }}"
                                    @checked($modul->status)>
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <small @class(['switch-label', 'text-success' => $modul->status])>{{ $modul->status ? 'Aktif' : 'Tidak Aktif' }}</small>
                            </label>
                        </td>
                        <td nowrap>
                            <x-button route="web.modul.update.sort" :parameter="['currentModul' => $modul->sort, 'nextModul' => $modul->sort - 1]" size="sm" color="success me-2"
                                @class(['disabled' => $modul->sort == 1])><x-icon name="fa-solid fa-arrow-up" /></x-button>
                            <x-button route="web.modul.update.sort" :parameter="['currentModul' => $modul->sort, 'nextModul' => $modul->sort + 1]" size="sm" color="success me-2"
                                @class(['disabled' => $moduls->last()->sort == $modul->sort])><x-icon name="fa-solid fa-arrow-down" /></x-button>
                            <x-button route="web.modul.edit" :parameter="$modul" size="sm" color="warning me-2"><x-icon
                                    name="fa-solid fa-edit me-2" /> Edit</x-button>
                            <form action="{{ route('web.modul.destroy', $modul) }}" method="post" class="d-inline">
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

@push('js')
    <script>
        $(function() {
            $("#modulDatatable").DataTable({
                dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6 dataTables_pager'p>>",
                columnDefs: [{
                    "orderable": false,
                    "targets": "_all"
                }],
                orderCellsTop: false,
            })

            $('input.dt-input').on('keyup', function() {
                filterColumn($(this).val(), "#modulDatatable", 1);
            });

            $("body").on("click", "#changeStatus", function() {
                $.ajax({
                    url: "{{ url('modul/update-status/') }}/" + $(this).data('id'),
                    type: "post",
                    data: {
                        _method: 'put',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload()
                    }
                })
            })

            $('select.dt-select').trigger('change')
        })
    </script>
@endpush
