<?php

namespace App\Filament\Pages;

use App\Models\Pesanan;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustInvitationForm extends Page
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.cust-invitation-form';



    public ?Pesanan $Pesanan = null;
    public array $formData = []; // Untuk menampung data form

    // Override judul halaman
    public function getTitle(): string
    {
        return $this->Pesanan ? 'Edit Undangan: ' . $this->Pesanan->tema->nama_tema : 'Edit Undangan';
    }

    // Halaman ini akan diakses dengan ID undangan yang dibeli
    public function mount(int $invitationId): void
    {
        try {
            $this->Pesanan = Pesanan::where('id', $invitationId)
                ->where('user_id', Auth::id()) // Pastikan user hanya akses miliknya
                ->with('tema') // Eager load relasi tema
                ->firstOrFail();

            // Isi formData dari custom_data yang sudah ada
            $this->formData = $this->Pesanan->custom_data ? (array) $this->Pesanan->custom_data : [];
            $this->form->fill($this->formData);

        } catch (ModelNotFoundException $e) {
            Notification::make()
                ->title('Error Akses')
                ->body('Undangan tidak ditemukan atau Anda tidak memiliki izin.')
                ->danger()
                ->send();
            // Redirect atau tampilkan pesan error di view
            // $this->redirect(route('filament.customer.pages.dashboard')); // Ganti dengan route dashboard customer Anda
            $this->Pesanan = null; // Agar view bisa handle
        }
    }

    // Mendefinisikan skema form secara dinamis
    public function form(Form $form): Form
    {
        if (!$this->Pesanan || !$this->Pesanan->tema || !$this->Pesanan->tema->fields) {
            // Jika tidak ada undangan, tema, atau definisi field, tampilkan form kosong atau pesan
            return $form->schema([]);
        }

        $dynamicFields = [];
        // Ambil definisi field dari kolom JSON `fields` di model `Tema`
        // Urutkan berdasarkan 'order' jika ada
        $themeFieldsDefinition = collect($this->Pesanan->tema->fields)->sortBy('order')->all();

        foreach ($themeFieldsDefinition as $fieldDef) {
            $fieldName = $fieldDef['nama']; // 'nama' dari definisi JSON
            $label = $fieldDef['label'];
            $isRequired = $fieldDef['is_required'] ?? false;
            $fieldType = $fieldDef['tipe'];

            $component = null;
            switch ($fieldType) {
                case 'text':
                    $component = TextInput::make($fieldName)
                        ->label($label)
                        ->required($isRequired);
                    break;
                case 'textarea':
                    $component = Textarea::make($fieldName)
                        ->label($label)
                        ->required($isRequired)
                        ->rows(3); // Contoh
                    break;
                case 'date':
                    $component = DatePicker::make($fieldName)
                        ->label($label)
                        ->required($isRequired);
                    break;
                case 'file':
                    $component = FileUpload::make($fieldName)
                        ->label($label)
                        ->required($isRequired)
                        ->disk('public') // Pastikan storage 'public' terkonfigurasi dan ter-link
                        ->directory('invitation_uploads/' . $this->Pesanan->id); // Sub-direktori per undangan
                        // ->image() // Jika khusus gambar
                        // Tambahkan konfigurasi FileUpload lain jika perlu (validasi, ukuran, dll)
                    break;
                case 'boolean': // Contoh jika Anda punya tipe boolean
                    $component = Toggle::make($fieldName)
                        ->label($label)
                        ->required($isRequired);
                    break;
                // Tambahkan case untuk tipe field lain yang Anda definisikan (number, select, color, dll.)
                default:
                    Log::warning("Tipe field tidak dikenal: {$fieldType} untuk tema {$this->Pesanan->tema->id}");
                    $component = TextInput::make($fieldName) // Fallback ke text input
                        ->label($label . ' (Tipe tidak dikenal, default ke teks)')
                        ->required($isRequired);
                    break;
            }

            if ($component) {
                // Tambahkan helper text atau placeholder jika ada di definisi field
                if (!empty($fieldDef['placeholder'])) {
                    $component->placeholder($fieldDef['placeholder']);
                }
                if (!empty($fieldDef['helper_text'])) {
                    $component->helperText($fieldDef['helper_text']);
                }
                $dynamicFields[] = $component;
            }
        }

        return $form
            ->schema($dynamicFields)
            ->statePath('formData'); // Bind data ke $this->formData
    }

    // Aksi untuk menyimpan data
    public function submitForm(): void
    {
        if (!$this->Pesanan) {
            Notification::make()->danger()->title('Gagal')->body('Undangan tidak ditemukan.')->send();
            return;
        }

        $validatedData = $this->form->getState(); // Ambil data yang sudah divalidasi

        // Proses file upload jika ada
        // FileUpload Filament biasanya sudah menangani penyimpanan dan $validatedData[$fieldName] akan berisi path string atau array path.
        // Pastikan path ini yang Anda inginkan untuk disimpan di custom_data.

        $this->Pesanan->custom_data = $validatedData;
        $this->Pesanan->save();

        Notification::make()
            ->title('Sukses')
            ->body('Data undangan Anda telah berhasil diperbarui.')
            ->success()
            ->send();

        // Opsional: refresh form dengan data terbaru jika ada post-processing
        // $this->form->fill((array) $this->Pesanan->custom_data);
    }

    // Definisikan path untuk halaman ini dengan parameter
    public static function getRoutePath(): string
    {
        return 'my-invitations/{invitationId}/customize'; // {invitationId} akan di-pass ke mount()
    }
}

