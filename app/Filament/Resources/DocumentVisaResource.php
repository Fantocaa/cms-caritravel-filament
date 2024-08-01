<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentVisaResource\Pages;
use App\Filament\Resources\DocumentVisaResource\RelationManagers;
use App\Models\countries;
use App\Models\Document;
use App\Models\DocumentVisa;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class DocumentVisaResource extends Resource
{
    use Translatable;

    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getTranslatableLocales(): array
    {
        return ['id', 'en'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('country')
                    ->label('Negara')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->options(countries::all()->pluck('name', 'id')),

                Repeater::make('categories')
                    ->schema([
                        TextInput::make('category')
                            ->label('Kategori Persyaratan')
                            ->required(),

                        RichEditor::make('info')
                            ->label('Informasi Umum')
                            ->toolbarButtons([
                                'bold',
                                'bulletList',
                                'italic',
                                'orderedList',
                                'underline',
                            ]),
                    ])
                    ->columns(2) // Mengatur layout untuk repeater
                    ->columnSpanFull() // Mengatur agar repeater menggunakan seluruh lebar kolom
                    ->label('Kategori & Info')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('country')
                    ->label('Negara')
                    ->formatStateUsing(function ($state) {
                        // Pisahkan kode id menjadi array
                        $idCodes = explode(', ', $state);

                        // Dapatkan nama negara berdasarkan kode id
                        $countries = countries::whereIn('id', $idCodes)->pluck('name', 'id');

                        // Gabungkan nama negara menjadi string dengan pemisah koma
                        $countryNames = $countries->values()->implode(', ');

                        return $countryNames;
                    }),
                // TextColumn::make('info')
                //     ->label('Content')
                //     ->formatStateUsing(function ($state) {
                //         // Jika data adalah string HTML langsung, tidak perlu json_decode
                //         $clean_text = strip_tags($state);

                //         // Kembalikan teks bersih
                //         return $clean_text;
                //     }),
                ToggleColumn::make('status')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListDocumentVisas::route('/'),
            'create' => Pages\CreateDocumentVisa::route('/create'),
            'edit' => Pages\EditDocumentVisa::route('/{record}/edit'),
        ];
    }
}
