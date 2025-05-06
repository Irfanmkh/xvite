<?php

namespace App\Filament\Admin\Resources;

use App\Models\Formfields;
use Filament\Forms;
use App\Models\Tema;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\TemaResource\Pages;
use App\Filament\Admin\Resources\TemaResource\RelationManagers;

class TemaResource extends Resource
{
    protected static ?string $model = Tema::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_tema')->required()->maxLength(255)->label('Nama Tema')->placeholder('Masukkan nama tema undangan')// ->helperText('Contoh: Elegant Rustic, Modern Minimalis, dll.')
            ->columnSpan(2),

            // Grid untuk memilih fields yang ada
            Select::make('fields')
                ->options( Formfields::all()->pluck('label', 'id'))
                ->multiple()
                ->native()
                ->searchable()
                ->label('Fields yang Dibutuhkan')
                ->placeholder('Pilih field yang ingin ditampilkan di tema ini')
                ->columnSpan(2),

            Forms\Components\TextInput::make('harga')
                ->required()
                ->numeric()
                // ->default(0.0)

                ->label('Harga Tema')
                ->placeholder('Contoh: 150000')
                ->helperText('Masukkan harga tema dalam format IDR. Contoh: 150000 untuk Rp150.000')
                ->columnSpan(2),

            Forms\Components\Textarea::make('code')
                ->required()
                ->label('Kode Undangan Digital')
                ->rows(15)
                ->placeholder('Masukkan HTML/CSS/JS undangan digital di sini...')
                ->helperText('Isi dengan kode HTML, CSS, atau JavaScript untuk template undangan digital')
                ->columnSpan(2)
                ->extraAttributes(['style' => 'font-family: monospace; background-color: #1f2937; color: white; border: 1px solid #374151;']),

                Grid::make(3)->schema([
                    FileUpload::make('ss1')
                    ->label('Foto 1')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('carousel1'),
                    
                    FileUpload::make('ss2')
                    ->label('Foto 2')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('carousel2'),
                    
                    FileUpload::make('ss3')
                    ->label('Foto 3')
                    ->required()
                    ->image()
                    ->disk('public')
                    ->directory('carousel2'),

                    ])
       
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('nama_tema')->searchable(), Tables\Columns\TextColumn::make('fields')->searchable(), Tables\Columns\TextColumn::make('harga')->numeric()->sortable(), Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true), Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)])
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
            'index' => Pages\ListTemas::route('/'),
            'create' => Pages\CreateTema::route('/create'),
            'edit' => Pages\EditTema::route('/{record}/edit'),
        ];
    }
}
