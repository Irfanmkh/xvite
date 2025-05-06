<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Formfields;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\FormfieldsResource\Pages;
use App\Filament\Admin\Resources\FormfieldsResource\RelationManagers;

class FormfieldsResource extends Resource
{
    protected static ?string $model = Formfields::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
      return $form->schema([

        // Nama Field (digunakan sebagai key di database)
        Forms\Components\TextInput::make('nama')
            ->label('Nama Field')
            ->placeholder('Contoh: Nama Mempelai Pria, Nama Mempelai Wanita, Tanggal Resepsi')
            ->helperText('Nama field harus Title Case. Digunakan untuk penyimpanan data.')
            ->required()
            ->columnSpanFull(),

        // Label Field (untuk ditampilkan di form user)
        Forms\Components\TextInput::make('label')
            ->label('Label Field')
            ->placeholder('Contoh: Nama Mempelai')
            ->helperText('Label/judul field yang akan muncul di form pengguna.')
            ->required()
            ->columnSpanFull(),

        // Tipe Input Field
        Forms\Components\Select::make('tipe')
            ->label('Tipe Input')
            ->options([
                'text' => 'Text (Input Satu Baris)',
                'textarea' => 'Textarea (Input Beberapa Baris)',
                'file' => 'File Upload (Gambar/Foto/Media yg lain)',
                'date' => 'Tanggal',
            ])
            ->placeholder('Pilih tipe input')
            ->required()
            ->columnSpanFull(),

        // Apakah Field Wajib Diisi?
        Forms\Components\Toggle::make('is_required')
            ->label('Wajib Diisi?')
            ->onIcon('heroicon-s-check-circle')
            ->offIcon('heroicon-s-x-circle')
            ->helperText('Aktifkan jika field wajib diisi oleh pengguna.')
            ->inline(false)
            ->columnSpanFull(),

        // Urutan Field dalam Form
        Forms\Components\TextInput::make('order')
            ->label('Urutan Tampilan')
            ->numeric()
            ->placeholder('Contoh: 1, 2, 3...')
            ->helperText('Menentukan urutan field di halaman form (angka lebih kecil tampil lebih atas).')
            ->columnSpanFull(),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('nama')->searchable(), Tables\Columns\TextColumn::make('label')->searchable(), Tables\Columns\TextColumn::make('tipe'), Tables\Columns\IconColumn::make('is_required')->boolean(), Tables\Columns\TextColumn::make('order')->numeric()->sortable(), Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true), Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormfields::route('/'),
            'create' => Pages\CreateFormfields::route('/create'),
            'edit' => Pages\EditFormfields::route('/{record}/edit'),
        ];
    }
}
