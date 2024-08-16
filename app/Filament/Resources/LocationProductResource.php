<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationProductResource\Pages;
use App\Filament\Resources\LocationProductResource\RelationManagers;
use App\Models\cities;
use App\Models\countries;
use App\Models\LocationProduct;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;

class LocationProductResource extends Resource
{
    protected static ?string $model = LocationProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Location Product';
    protected static ?string $modelLabel = 'Location Product';
    protected static ?string $navigationGroup = 'Section Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('countries')
                    ->label('Negara')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->options(countries::all()->pluck('name', 'iso2')),

                Select::make('cities')
                    ->label('Kota')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->options(fn(Get $get): Collection =>
                    !empty($get('countries')) ?
                        cities::query()
                        ->where(function ($query) use ($get) {
                            $countries = $get('countries');
                            if (is_array($countries)) {
                                $query->whereIn('country_code', $countries);
                            } else {
                                $query->where('country_code', $countries);
                            }
                        })
                        ->limit(1000)
                        ->pluck('name', 'id') :
                        collect([])),

                FileUpload::make('img_name')
                    ->maxFiles(1)
                    ->label('Thumbnail Foto Lokasi (JPG, JPEG, PNG)')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                    ->previewable()
                    ->maxSize(1024)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('countries')
                    ->label('Negara')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        // Pisahkan kode iso2 menjadi array
                        $iso2Codes = explode(', ', $state);

                        // Dapatkan nama negara berdasarkan kode iso2
                        $countries = countries::whereIn('iso2', $iso2Codes)->pluck('name', 'iso2');

                        // Gabungkan nama negara menjadi string dengan pemisah koma
                        $countryNames = $countries->values()->implode(', ');

                        return $countryNames;
                    }),
                TextColumn::make('cities')
                    ->label('Kota')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        // Pisahkan kode iso2 menjadi array
                        $idCodes = explode(', ', $state);

                        // Dapatkan nama negara berdasarkan kode iso2
                        $countries = cities::whereIn('id', $idCodes)->pluck('name', 'id');

                        // Gabungkan nama negara menjadi string dengan pemisah koma
                        $countryNames = $countries->values()->implode(', ');

                        return $countryNames;
                    }),
                ImageColumn::make('img_name')
                    ->label('Foto Produk'),
                ToggleColumn::make('status')
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
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
            'index' => Pages\ListLocationProducts::route('/'),
            'create' => Pages\CreateLocationProduct::route('/create'),
            'edit' => Pages\EditLocationProduct::route('/{record}/edit'),
        ];
    }
}
