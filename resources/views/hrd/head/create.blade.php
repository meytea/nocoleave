@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Tambah Head Divisi
        </h1>

        <form action="{{ route('head.store') }}"
            method="POST"
            class="space-y-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Departemen
                    </label>

                    <input
                        type="text"
                        name="nama_departemen"
                        value="{{ old('nama_departemen') }}"                        
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                    @error('nama_departemen')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

                {{-- User Head --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Head
                    </label>



                    <select name="user_id"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                        <option value="">
                            Pilih Head
                        </option>

                        @foreach($users as $user)

                        <option value="{{ $user->id }}"
                            {{ old('user_id') == $user->id ? 'selected' : '' }}>

                            {{ $user->name }}

                        </option>

                        @endforeach

                    </select>

                    @error('user_id')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror

                </div>



                {{-- Divisi --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Divisi
                    </label>

                    <select name="divisi_id"
                        class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                        <option value="">
                            Pilih Divisi
                        </option>

                        @foreach($divisi as $item)

                        <option value="{{ $item->id }}"
                            {{ old('divisi_id') == $item->id ? 'selected' : '' }}>

                            {{ $item->nama_divisi }}

                        </option>

                        @endforeach

                    </select>

                    @error('divisi_id')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

            </div>

            <div class="flex items-center gap-4 pt-4">

                <button type="submit"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl font-medium transition">

                    Simpan

                </button>

                <a href="{{ route('head.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection