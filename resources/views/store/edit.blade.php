@extends('layout.index')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/tagify/tagify.css') }}" />
@endpush

@section('content')
    <form action="{{ route('web.store.update', $store) }}" method="post" class="needs-validation" novalidate
        enctype="multipart/form-data">
        @csrf
        @method('put')
        <x-card>
            <x-slot:header class="d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Edit Toko</h6>
            </x-slot:header>

            <x-input id="name" label="Nama Toko" required :value="old('name') ?? $store->name" />
            <x-input id="tags" label="Kategori Toko" required :value="old('tags') ?? $store->tags" />
            <x-input id="address" label="Alamat Toko" required :value="old('address') ?? $store->address" />
            <x-textarea label="Deskripsi" id="description" required :value="old('description') ?? $store->description" />
            <x-input id="file_thumbnail" accept="image/png, image/jpg, image/jpeg" type="file"
                label="Unggah Foto Toko" />
            <div class="mb-3">
                <img src="{{ asset("storage/$store->thumbnail") }}" alt="{{ $store->name }}" height="100" width="100">
            </div>
            <div class="mb-3">
                <label>Jam Operasional</label>
                <x-table class="table-bordered" :isComplete="true">
                    <x-slot:thead>
                        <th>Hari</th>
                        <th>Jam Buka</th>
                        <th>Jam Tutup</th>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach (json_decode($store->operational_hour) as $day)
                            <tr>
                                <th>{{ $day->day }} <input type="hidden" value="{{ $day->day }}" name="day[]">
                                </th>
                                <td><x-input margin="mb-0" type="time" :value="$day->opening_time" id="opening_time[]" /></td>
                                <td><x-input margin="mb-0" type="time" :value="$day->closing_time" id="closing_time[]" /></td>
                            </tr>
                        @endforeach
                    </x-slot:tbody>
                </x-table>
            </div>

            <x-slot:footer>
                <x-button size="sm" color="secondary" href="#" onclick="history.back(-1)">Batal</x-button>
                <x-button type="submit" size="sm" color="primary">Simpan</x-button>
            </x-slot:footer>
        </x-card>
    </form>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script>
        $(function() {
            new Tagify(document.getElementById('tags'), {
                whitelist: {!! json_encode($tags) !!},
                maxTags: 10,
                dropdown: {
                    maxItems: 20,
                    classname: 'tags-inline',
                    enabled: 0,
                    closeOnSelect: false
                }
            })
        })
    </script>
@endpush
