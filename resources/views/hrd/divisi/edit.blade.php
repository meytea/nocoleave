@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Edit Divisi
        </h1>

        <form action="{{ route('divisi.update', $divisi->id) }}"
              method="POST"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Divisi
                </label>

                <input type="text"
                       name="nama_divisi"
                       value="{{ old('nama_divisi', $divisi->nama_divisi) }}"
                       class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">

                @error('nama_divisi')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center gap-4">

                <button type="submit"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl font-medium transition">
                    Update
                </button>

                <a href="{{ route('divisi.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection