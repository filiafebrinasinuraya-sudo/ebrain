@extends('layouts.admin')

@section('content')

<h2 class="text-xl font-bold mb-4">Tambah Program</h2>

<form action="/admin/program" method="POST">
@csrf

<div class="mb-3">
    <label>Nama Program</label>
    <input type="text" name="nama_program"
           class="w-full border p-2 rounded"
           required>
</div>

<button class="bg-blue-500 text-white px-4 py-2 rounded">
    Simpan
</button>

<a href="/admin/program"
   class="ml-2 bg-gray-300 px-4 py-2 rounded">
    Kembali
</a>

</form>

@endsection