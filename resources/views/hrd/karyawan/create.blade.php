@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Tambah Karyawan
        </h1>

        <form action="{{ route('karyawan.store') }}"
              method="POST"
              class="space-y-6">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        NIK
                    </label>

                    <input type="text"
                           name="nik"
                           value="{{ old('nik') }}"
                           class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin
                    </label>

                    <select name="jenis_kelamin"
                            class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                        <option value="">Pilih</option>
                        <option value="laki-laki">Laki-Laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Divisi
                    </label>

                    <select name="divisi_id"
                            class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                        <option value="">Pilih Divisi</option>

                        @foreach ($divisi as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_divisi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Role
                    </label>

                    <select name="role"
                            class="w-full rounded-xl border-gray-300 focus:border-cyan-500 focus:ring-cyan-500">
                        <option value="">Pilih Role</option>

                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="flex items-center gap-4 pt-4">

                <button type="submit"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl font-medium transition">
                    Simpan
                </button>

                <a href="{{ route('karyawan.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-medium transition">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
