<?php

namespace App\Filament\Pages;

use App\Models\acara;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Illuminate\Database\QueryException;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Actions\Action;

class DataAcara extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.data-acara';

    protected static ?string $slug = 'acara';

    protected static ?string $title = 'Acara';

    public $acara;

    public function mount(): void
    {
        $acara = acara::where('user_id', Auth::id())->first();

        $this->form->fill([
            'acara' => [
                'tgl_resepsi' => $acara?->tgl_resepsi ?? null,
                'tgl_akad' => $acara?->tgl_akad ?? null,
                'jam_akad' => $acara->jam_akad ?? null,
                'jam_resepsi' => $acara->jam_resepsi ?? null,
                'venue' => $acara->venue ?? '',
                'venue_akad' => $acara->venue_akad ?? '',
                'link_maps' => $acara->link_maps ?? '',
                'zona_waktuAkad' => $acara->zona_waktuAkad ?? '',
                'zona_waktuResepsi' => $acara->zona_waktuResepsi ?? '',
            ],
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Waktu Acara')
                ->description('Isi data jadwal akad dan resepsi pernikahan dengan lengkap')
                ->extraAttributes(['class' => 'text-center'])
                ->schema([
                    Grid::make(2)->schema([

                        Section::make('Waktu Akad')
                            ->description('Informasi waktu dan lokasi akad nikah')
                            ->schema([
                                DatePicker::make('acara.tgl_akad')
                                    ->label('Tanggal Akad Nikah')
                                    ->format('Y-m-d')
                                    ->required(),

                                Grid::make(2)->schema([
                                    TimePicker::make('acara.jam_akad')
                                        ->label('Jam Akad')
                                        ->native(false)
                                        ->displayFormat('H:i')
                                        ->format('H:i')
                                        ->seconds(false)
                                        ->required(),

                                    Select::make('acara.zona_waktuAkad')
                                        ->label('Zona Waktu')
                                        ->options([
                                            'WIB' => 'WIB (Waktu Indonesia Barat)',
                                            'WITA' => 'WITA (Waktu Indonesia Tengah)',
                                            'WIT' => 'WIT (Waktu Indonesia Timur)',
                                        ])
                                        ->required()
                                        ->native(false),
                                ]),

                                TextInput::make('acara.venue_akad')
                                    ->label('Tempat/Lokasi Akad')
                                    ->placeholder('Contoh: Masjid Al-Hikmah, Sidoarjo')
                                    ->required(),
                            ])
                            ->columnSpan(1),

                        Section::make('Waktu Resepsi')
                            ->description('Informasi waktu dan lokasi resepsi pernikahan')
                            ->schema([
                                DatePicker::make('acara.tgl_resepsi')
                                    ->label('Tanggal Resepsi')
                                    ->format('Y-m-d')
                                    ->required(),

                                Grid::make(2)->schema([
                                    TimePicker::make('acara.jam_resepsi')
                                        ->label('Jam Resepsi (Kosongkan = Bebas)')
                                        ->native(false)
                                        ->displayFormat('H:i')
                                        ->format('H:i')
                                        ->seconds(false),

                                    Select::make('acara.zona_waktuResepsi')
                                        ->label('Zona Waktu')
                                        ->options([
                                            'WIB' => 'WIB (Waktu Indonesia Barat)',
                                            'WITA' => 'WITA (Waktu Indonesia Tengah)',
                                            'WIT' => 'WIT (Waktu Indonesia Timur)',
                                        ])
                                        ->native(false),
                                ]),

                                Grid::make(2)->schema([
                                    TextInput::make('acara.venue')
                                        ->label('Tempat/Lokasi Resepsi')
                                        ->placeholder('Contoh: Gedung Serbaguna Kencana, Surabaya')
                                        ->required(),

                                    TextInput::make('acara.link_maps')
                                        ->label('Link Google Maps')
                                        ->url()
                                        ->placeholder('https://goo.gl/maps/...'),
                                ]),
                            ])
                            ->columnSpan(1),
                    ]),
                ]),

            Actions::make([
                Action::make('save')
                    ->label('Simpan Data Acara')
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

            $acara = acara::where('user_id', $userId)->first();

            if (!$acara) {
                $acara = new acara();
                $acara->user_id = $userId;
                $acara->tgl_akad = null;
                $acara->tgl_resepsi = null;
                $acara->venue = '';
                $acara->jam_akad = null;
                $acara->jam_resepsi = null;
                $acara->venue_akad = '';
                $acara->link_maps = '';
                $acara->zona_waktuAkad = '';
                $acara->zona_waktuResepsi = '';
                $acara->save();
            }

            $acara->update([
                'tgl_akad' => $formData['acara']['tgl_akad'] ?: null,
                'tgl_resepsi' => $formData['acara']['tgl_resepsi'] ?: null,
                'venue' => $formData['acara']['venue'] ?? '',
                'venue_akad' => $formData['acara']['venue_akad'] ?? '',
                'jam_akad' => $formData['acara']['jam_akad'] ?: null,
                'jam_resepsi' => $formData['acara']['jam_resepsi'] ?: null,
                'link_maps' => $formData['acara']['link_maps'] ?? '',
                'zona_waktuAkad' => $formData['acara']['zona_waktuAkad'] ?? '',
                'zona_waktuResepsi' => $formData['acara']['zona_waktuResepsi'] ?? '',
            ]);

            $this->mount();

            Notification::make()->title('Berhasil disimpan')->success()->send();
        } catch (QueryException $e) {
            Notification::make()
                ->title('Gagal menyimpan perubahan')
                ->danger()
                ->body('Terjadi kesalahan saat menyimpan perubahan. Silakan coba lagi. ' . $e->getMessage())
                ->send();

            Log::error('Database error saving settings: ' . $e->getMessage());
        }
    }

    public function getData(): array
    {
        return $this->form->getState();
    }
}
