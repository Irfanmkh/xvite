<?php

namespace App\Filament\Pages;

use App\Models\Tema;
use App\Models\Pesanan;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Models\Formfields;
use App\Models\Formresponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustInvitationForm extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.cust-invitation-form';



    // public ?Pesanan $Pesanan = null;
    public ?array $formData = []; // Untuk menampung data form

    // Override judul halaman
    public function getTitle(): string
    {
        return $this->Pesanan ? 'Edit Undangan: ' . $this->Pesanan->tema->nama_tema : 'Edit Undangan';
    }

    public function mount(): void
    {
        $pesanan = Pesanan::where('user_id', auth()->id())->latest()->first();

        if (! $pesanan) {
            abort(403, 'Pesanan tidak ditemukan.');
        }

        $temaId = request()->input('tema_id');

        $tema = Tema::findOrFail($temaId);
        $fields = $tema->fields;

        $this->formSchema = $this->buildFormSchema($fields);
    }

    // ...


    protected function buildFormSchema($fields): array
    {
        $schema = [];

        foreach ($fields as $fieldId) {
            $formfield = Formfields::find($fieldId);
            if (! $formfield) continue;

            $schema[] = match ($formfield->tipe) {
                'text' => TextInput::make($formfield->nama)->label($formfield->label)->required($formfield->is_required),
                'textarea' => Textarea::make($formfield->nama)->label($formfield->label)->required($formfield->is_required),
                'file' => FileUpload::make($formfield->nama)->label($formfield->label)->required($formfield->is_required),
                'date' => DatePicker::make($formfield->nama)->label($formfield->label)->required($formfield->is_required),
                default => null
            };
        }

        return array_filter($schema);
    }
    public function submit()
{
    $pesanan = Pesanan::where('user_id', auth()->id())->latest()->first();

    if (! $pesanan) {
        abort(403, 'Pesanan tidak ditemukan.');
    }

    Formresponse::create([
        'user_id' => auth()->id(),
        'tema_id' => $pesanan->tema_id,
        'isian' => json_encode($this->form->getState()),
    ]);

    session()->flash('success', 'Form berhasil disimpan.');
    return redirect()->route('welcome'); // atau redirect lain
}


    
}

