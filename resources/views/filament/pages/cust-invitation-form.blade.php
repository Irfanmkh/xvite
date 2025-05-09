<x-filament-panels::page>
    @if ($this->Pesanan)
        <form wire:submit.prevent="submitForm">
            {{ $this->form }}

            <div class="mt-6">
                <x-filament::button type="submit" form="submitForm">
                    Simpan Data Undangan
                </x-filament::button>
            </div>
        </form>

        {{-- Tombol untuk preview (jika ada URL preview) --}}
        @if($this->Pesanan->unique_slug)
            <div class="mt-4">
                <a href="{{ route('invitation.show', $this->Pesanan->unique_slug) }}" {{-- Ganti 'invitation.show' dengan nama route Anda --}}
                   target="_blank"
                   class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Lihat Pratinjau Undangan
                </a>
            </div>
        @endif
    @else
        <div class="p-4 text-center text-gray-500 bg-white rounded-lg shadow">
            <p>Tidak ada data undangan yang bisa diedit atau terjadi kesalahan.</p>
            {{-- Link kembali ke dashboard atau daftar undangan customer --}}
            {{-- Contoh: <a href="{{ route('filament.customer.pages.dashboard') }}" class="text-primary-600 hover:underline">Kembali ke Dashboard</a> --}}
        </div>
    @endif
</x-filament-panels::page>
