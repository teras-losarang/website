@if ($user)
    @method('put')
@endif
<x-input id="name" label="Nama Lengkap" required :value="$user ? $user->name : old('name')" />
<x-input id="email" label="Email Pengguna" required :value="$user ? $user->email : old('email')" />
@if (!$user)
    <x-input id="password" label="Password Pengguna" readonly value="password" />
@endif
