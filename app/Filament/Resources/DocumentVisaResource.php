<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentVisaResource\Pages;
use App\Models\countries;
use App\Models\Document;
use App\Models\DocumentVisa;
use App\Models\User;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class DocumentVisaResource extends Resource
{
    use Translatable;

    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Visa Document';
    protected static ?string $modelLabel = 'Visa Document';
    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    TextInput::make('category')
                        ->label("Kategori Persyaratan"),
                    Select::make('author')
                        ->label('Author')
                        ->options(User::all()->pluck('name', 'id'))
                        ->preload()
                        ->live()
                        ->reactive()
                        ->required(),
                    TableRepeater::make('country')
                        ->label('Country')
                        ->headers([
                            Header::make('country')->width('150px')
                                ->label('Silahkan Pilih Negara'),
                        ])
                        ->schema([
                            Select::make('country')
                                ->label('Negara')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->options(countries::all()->pluck('name', 'id')),
                        ])
                        ->columnSpan('1'),
                ])->columnSpan('1'),

                RichEditor::make('info')
                    ->label('Informasi Kategori')
                    ->toolbarButtons([
                        'attachFiles',
                        'bold',
                        'bulletList',
                        'italic',
                        'link',
                        'orderedList',
                        'underline',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category'),
                // TextColumn::make('country')
                //     ->searchable()
                //     ->sortable()
                //     ->color('secondary')
                //     ->alignLeft(),
                ToggleColumn::make('status'),

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
