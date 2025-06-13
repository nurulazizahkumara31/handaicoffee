@extends('layouts.app')

@section('content')
<style>
  :root {
    --primary-green: #0d9145;
    --light-green: #e7f8ed;
  }

  body {
    background-color: var(--light-green);
    font-family: 'Poppins', sans-serif;
  }
</style>

<div class="max-w-2xl mx-auto mt-12 bg-white border border-[var(--primary-green)] rounded-3xl shadow-xl overflow-hidden">
  <div class="px-8 py-10">
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-3xl font-bold text-[var(--primary-green)] tracking-tight">Profil Pengguna</h2>
      <a href="/dashboard" class="flex items-center gap-1 text-sm text-[var(--primary-green)] font-semibold hover:text-green-700 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
      </a>
    </div>

    @if (session('success'))
      <div class="mb-6 px-4 py-2 bg-green-100 text-green-800 rounded-md text-sm font-semibold shadow">
        {{ session('success') }}
      </div>
    @endif

    <!-- View Mode -->
    <div id="profile-view" class="space-y-6">
      <div>
        <p class="text-sm text-gray-500">Nama Lengkap</p>
        <h3 class="text-lg font-medium text-gray-900">{{ Auth::user()->name }}</h3>
      </div>
      <div>
        <p class="text-sm text-gray-500">Email</p>
        <h3 class="text-lg font-medium text-gray-900">{{ Auth::user()->email }}</h3>
      </div>
      <div>
        <p class="text-sm text-gray-500">Tanggal Bergabung</p>
        <h3 class="text-lg font-medium text-gray-900">{{ Auth::user()->created_at->format('d M Y') }}</h3>
      </div>
      <button onclick="toggleEdit()" class="mt-6 w-full bg-[var(--primary-green)] hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-md transition">
        Edit Profil
      </button>
    </div>

    <!-- Edit Mode -->
    <form id="profile-form" action="{{ route('profile.update') }}" method="POST" class="hidden space-y-5 mt-2">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-sm text-gray-600 mb-1 font-medium">Nama</label>
        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--primary-green)]">
        @error('name') <small class="text-red-500">{{ $message }}</small> @enderror
      </div>

      <div>
        <label class="block text-sm text-gray-600 mb-1 font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--primary-green)]">
        @error('email') <small class="text-red-500">{{ $message }}</small> @enderror
      </div>

      <div>
        <label class="block text-sm text-gray-600 mb-1 font-medium">Password Baru <span class="text-gray-400">(opsional)</span></label>
        <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--primary-green)]">
        @error('password') <small class="text-red-500">{{ $message }}</small> @enderror
      </div>

      <div class="flex items-center justify-between pt-2">
        <button type="submit" class="bg-[var(--primary-green)] hover:bg-green-700 text-white px-5 py-2 rounded-lg font-semibold shadow-md transition">
          Simpan
        </button>
        <button type="button" onclick="toggleEdit()" class="text-sm text-[var(--primary-green)] hover:underline">
          Batal
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleEdit() {
    document.getElementById('profile-form').classList.toggle('hidden');
    document.getElementById('profile-view').classList.toggle('hidden');
  }
</script>
@endsection
