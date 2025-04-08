<?php

namespace App\Filament\Pages;

use App\Models\mempelai;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Illuminate\Database\QueryException;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;

class DataMempelai extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.data-mempelai';
    protected static ?string $title = 'Data Mempelai';
    protected static ?string $slug = 'mempelai';


    public $mempelai;

    public function mount(): void
    {
        $mempelai = mempelai::where('user_id', Auth::id())->first();

        $this->form->fill([
            'mempelai' => [
                'fullname_pria' => $mempelai?->fullname_pria ?? '',
                'fullname_wanita' => $mempelai?->fullname_wanita ?? '',
                'nickname_pria' => $mempelai?->nickname_pria ?? '',
                'nickname_wanita' => $mempelai?->nickname_wanita ?? '',
                'ig_pria' => $mempelai?->ig_pria ?? '',
                'ig_wanita' => $mempelai?->ig_wanita ?? '',
                'namaAyah_pria' => $mempelai?->namaAyah_pria ?? '',
                'namaIbu_pria' => $mempelai?->namaIbu_pria ?? '',
                'namaAyah_wanita' => $mempelai?->namaAyah_wanita ?? '',
                'namaIbu_wanita' => $mempelai?->namaIbu_wanita ?? '',
                'anakKe_wanita' => $mempelai?->anakKe_wanita ?? '',
                'anakKe_pria' => $mempelai?->anakKe_pria ?? '',
            ]
        ]);
    }

    public function form(Form $form): Form
{
    return $form->schema([
        // Section: Data Kedua Mempelai
        Section::make('Data Kedua Mempelai')
            ->description('Informasi lengkap tentang mempelai pria dan wanita')
            ->extraAttributes(['class' => 'text-center'])
            ->schema([
                Grid::make(2)->schema([
                    // Kolom Kiri - Mempelai Pria
                    Section::make('Mempelai Pria')
                        ->description('Data pribadi mempelai pria')
                        ->schema([
                            TextInput::make('mempelai.fullname_pria')
                                ->label('Nama Lengkap (Mempelai Pria)')
                                ->placeholder('Contoh: Muhammad Aliando Nugroho, S.Pd.')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('mempelai.nickname_pria')
                                ->label('Nama Panggilan')
                                ->placeholder('Contoh: Ali')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('mempelai.anakKe_pria')
                                ->label('Anak Ke-')
                                ->placeholder('Contoh: 1')
                                ->numeric(),

                            TextInput::make('mempelai.ig_pria')
                                ->label('Instagram (Opsional)')
                                ->placeholder('https://instagram.com/aliandoo_')
                                ->url(),
                        ])
                        ->columnSpan(1),

                    // Kolom Kanan - Mempelai Wanita
                    Section::make('Mempelai Wanita')
                        ->description('Data pribadi mempelai wanita')
                        ->schema([
                            TextInput::make('mempelai.fullname_wanita')
                                ->label('Nama Lengkap (Mempelai Wanita)')
                                ->placeholder('Contoh: Anggun Cantika')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('mempelai.nickname_wanita')
                                ->label('Nama Panggilan')
                                ->placeholder('Contoh: Anggun')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('mempelai.anakKe_wanita')
                                ->label('Anak Ke-')
                                ->placeholder('Contoh: 2')
                                ->numeric(),

                            TextInput::make('mempelai.ig_wanita')
                                ->label('Instagram (Opsional)')
                                ->placeholder('https://instagram.com/angguncntk_')
                                ->url(),
                        ])
                        ->columnSpan(1),
                ]),
            ]),

        // Section: Data Orang Tua Kedua Mempelai
        Section::make('Data Orang Tua Kedua Mempelai')
            ->description('Nama lengkap orang tua dari masing-masing mempelai')
            ->extraAttributes(['class' => 'text-center'])
            ->schema([
                Grid::make(2)->schema([
                    // Kolom Kiri - Orang Tua Pria
                    Section::make('Orang Tua Mempelai Pria')
                        ->schema([
                            TextInput::make('mempelai.namaAyah_pria')
                                ->label('Nama Ayah')
                                ->placeholder('Contoh: H. Abdullah, M.Ag.')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('mempelai.namaIbu_pria')
                                ->label('Nama Ibu')
                                ->placeholder('Contoh: Hj. Nur Aini')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->columnSpan(1),

                    // Kolom Kanan - Orang Tua Wanita
                    Section::make('Orang Tua Mempelai Wanita')
                        ->schema([
                            TextInput::make('mempelai.namaAyah_wanita')
                                ->label('Nama Ayah')
                                ->placeholder('Contoh: H. Ahmad Basri')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('mempelai.namaIbu_wanita')
                                ->label('Nama Ibu')
                                ->placeholder('Contoh: Hj. Siti Rohmah')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->columnSpan(1),
                ]),
            ]),

        // Actions
        Actions::make([
            Action::make('save')
                ->label('Simpan Data')
                ->extraAttributes(['class' => 'w-full'])
                ->action(fn() => $this->save()),
        ]),
    ]);
}


    public function save(): void
    {
       $formData = $this->getData();

    try {
        $userId = Auth::id();

        // Cek apakah data mempelai untuk user ini sudah ada
        $mempelai = mempelai::where('user_id', $userId)->first();

        if (!$mempelai) {
            // Jika belum ada, buat data baru dengan default kosong
            $mempelai = new mempelai();
            $mempelai->user_id = $userId;
            $mempelai->fullname_pria = '';
            $mempelai->fullname_wanita = '';
            $mempelai->nickname_pria = '';
            $mempelai->nickname_wanita = '';
            $mempelai->ig_pria = '';
            $mempelai->ig_wanita = '';
            $mempelai->namaAyah_pria = '';
            $mempelai->namaIbu_pria = '';
            $mempelai->namaAyah_wanita = '';
            $mempelai->namaIbu_wanita = '';
            $mempelai->anakKe_wanita = '';
            $mempelai->anakKe_pria = '';
            $mempelai->save();
        }

        // Update data mempelai berdasarkan input form
        $mempelai->update([
            'fullname_pria' => $formData['mempelai']['fullname_pria'] ?? '',
            'fullname_wanita' => $formData['mempelai']['fullname_wanita'] ?? '',
            'nickname_pria' => $formData['mempelai']['nickname_pria'] ?? '',
            'nickname_wanita' => $formData['mempelai']['nickname_wanita'] ?? '',
            'ig_pria' => $formData['mempelai']['ig_pria'] ?? '',
            'ig_wanita' => $formData['mempelai']['ig_wanita'] ?? '',
            'namaAyah_pria' => $formData['mempelai']['namaAyah_pria'] ?? '',
            'namaIbu_pria' => $formData['mempelai']['namaIbu_pria'] ?? '',
            'namaAyah_wanita' => $formData['mempelai']['namaAyah_wanita'] ?? '',
            'namaIbu_wanita' => $formData['mempelai']['namaIbu_wanita'] ?? '',
            'anakKe_pria' => $formData['mempelai']['anakKe_pria'] ?? '',
            'anakKe_wanita' => $formData['mempelai']['anakKe_wanita'] ?? '',
        ]);
 

            $this->mount();

            Notification::make()
                ->title('Berhasil disimpan')
                ->success()
                ->send();
        } catch (QueryException $e) {
            Notification::make()
                ->title('Gagal menyimpan perubahan')
                ->danger()
                ->body('Terjadi kesalahan saat menyimpan perubahan. Silakan coba lagi.')
                ->body($e->getMessage())
                ->send();

            Log::error('Database error saving settings: ' . $e->getMessage());
        }
    }

    public function getData(): array
    {
        return $this->form->getState();
    }
}
