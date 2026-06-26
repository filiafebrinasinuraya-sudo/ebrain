@extends('layouts.siswa')

@section('content')

<div class="max-w-4xl mx-auto">

    <h2 class="text-2xl font-bold mb-6">
        Ubah Password
    </h2>

    <div class="bg-white rounded-xl shadow p-6">
        @include('profile.partials.update-password-form')
    </div>

</div>

@endsection