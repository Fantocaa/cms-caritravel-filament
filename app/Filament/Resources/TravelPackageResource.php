<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\cities;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\countries;
use Filament\Tables\Table;
use App\Models\TravelPackage;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\TravelPackageResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;

class TravelPackageResource extends Resource
{
    use Translatable;

    protected static ?string $model = TravelPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';
    protected static ?string $navigationLabel = 'Travel Packages';
    protected static ?string $modelLabel = 'Travel Packages';
    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Group::Make()->schema([
                        Select::make('countries')
                            ->label('Negara')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->options(countries::all()->pluck('name', "iso2")),
                        Select::make('cities')
                            ->label('Kota')
                            ->searchable()
                            ->preload()
                            ->multiple()
                            ->required()
                            ->live()
                            ->options(fn(Get $get): Collection =>
                            !empty($get('countries')) ?
                                cities::query()
                                ->whereIn('country_code', $get('countries'))
                                ->pluck('name', 'id') :
                                collect([])),
                    ])->columns(2),

                    Group::make()->schema([
                        TextInput::make('traveler')
                            ->label('Traveler')
                            ->numeric()
                            ->required(),
                        TextInput::make('duration')
                            ->label('Duration (Day)')
                            ->numeric()
                            ->required(),
                        TextInput::make('duration_night')
                            ->label('Duration (Night)')
                            ->numeric()
                            ->required(),
                    ])->columns(3),

                    Group::make()->schema([
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->required(),
                    ])->columns(2),

                    Group::make()->schema([
                        TextInput::make('price')
                            ->label('Harga')
                            ->prefix('Rp.')
                            ->numeric()
                            ->required(),
                        Select::make('author')
                            ->label('Author')
                            ->options(User::all()->pluck('name', 'id'))
                            ->preload()
                            ->live()
                            ->reactive()
                            ->required(),
                    ])->columns(2),

                    FileUpload::make('image_name')
                        ->multiple()
                        ->maxFiles(8)
                        ->minFiles(5)
                        ->label('Upload File JPG, JPEG, PNG, (Maksimal 8 Item)')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                        ->maxSize(1024)
                        ->required()
                        ->previewable(),

                    Section::make()
                        ->schema([
                            TextInput::make('yt_links')
                                ->label('(Opsional) Video Link (Youtube)')
                                ->prefix('www.')
                                ->live()
                                ->reactive(),

                            FileUpload::make('thumb_img')
                                ->maxFiles(1)
                                ->label('Thumbnail Video (JPG, JPEG, PNG)')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                                ->previewable()
                                ->live()
                                ->maxSize(1024)
                                ->reactive(),
                        ]),
                ])->columns(1),


                Group::make()->schema([
                    Section::make()
                        ->schema([
                            TextInput::make('title')
                                ->label('Title')
                                ->required(),
                            RichEditor::make('general_info')
                                ->label('Informasi Umum')
                                ->required()
                                ->toolbarButtons([
                                    'attachFiles',
                                    'bold',
                                    'bulletList',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'underline',
                                ]),

                            RichEditor::make('travel_schedule')
                                ->label('Informasi Paket')
                                ->required()
                                ->toolbarButtons([
                                    'attachFiles',
                                    'bold',
                                    'bulletList',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'underline',
                                ]),

                            RichEditor::make('additional_info')
                                ->label('Informasi Lainnya')
                                ->toolbarButtons([
                                    'attachFiles',
                                    'bold',
                                    'bulletList',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'underline',
                                ]),

                        ])->columns(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        // Batasi teks menjadi maksimal 25 karakter, tambahkan "..." jika dipotong
                        return Str::limit($state, 25, '...');
                    }),
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

                        // Batasi jumlah kata yang ditampilkan, misal maksimal 3 kata
                        $limitedCityNames = Str::words($countryNames, 2, '...');

                        return $limitedCityNames;
                    }),
                // TextColumn::make('cities')
                //     ->label('Kota')
                //     ->searchable()
                //     ->sortable()
                //     ->formatStateUsing(function ($state) {
                //         // Pisahkan kode iso2 menjadi array
                //         $idCodes = explode(', ', $state);

                //         // Dapatkan nama negara berdasarkan kode iso2
                //         $countries = cities::whereIn('id', $idCodes)->pluck('name', 'id');

                //         // Gabungkan nama negara menjadi string dengan pemisah koma
                //         $countryNames = $countries->values()->implode(', ');

                //         // Batasi jumlah kata yang ditampilkan, misal maksimal 3 kata
                //         $limitedCityNames = Str::words($countryNames, 3, '...');

                //         return $limitedCityNames;
                //     }),
                // TextColumn::make('title')
                //     ->label('Judul'),
                ImageColumn::make('image_name')
                    ->label('Foto Produk')
                    ->limit(3)
                    ->limitedRemainingText()
                    ->circular()
                    ->stacked(),
                ToggleColumn::make('status'),
                ToggleColumn::make('recomendation')
                    ->label('Rekomendasi')

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
            'index' => Pages\ListTravelPackages::route('/'),
            'create' => Pages\CreateTravelPackage::route('/create'),
            'edit' => Pages\EditTravelPackage::route('/{record}/edit'),
        ];
    }
}
