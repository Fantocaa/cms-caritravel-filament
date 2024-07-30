<?php

namespace App\Filament\Resources;

use Filament\Forms;
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
use Filament\Forms\Components\Textarea;
use App\Models\User;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Concerns\Translatable;

class TravelPackageResource extends Resource
{
    use Translatable;

    protected static ?string $model = TravelPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Select::make('countries')
                        ->label('Negara')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->live()
                        // ->dehydrated(false)
                        ->required()
                        ->relationship(
                            name: 'countries',
                            titleAttribute: 'name',
                        )
                    // ->options(countries::all()->pluck('name', "iso2"))
                    ,

                    Select::make('cities')
                        ->label('Kota')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        // ->required()
                        ->live()
                    // ->options(fn (Get $get): Collection =>
                    // !empty($get('countries')) ?
                    //     cities::query()
                    //     ->whereIn('country_code', $get('countries'))
                    //     ->limit(1000)
                    //     ->pluck('name', 'id') :
                    //     collect([]))
                    ,

                    Group::make()->schema([
                        TextInput::make('traveler')
                            ->label('Traveler')
                            ->numeric(),

                        TextInput::make('duration')
                            ->label('Duration (Days)')
                            ->numeric(),

                        TextInput::make('duration_night')
                            ->label('Duration (Nights)')
                            ->numeric(),
                    ])->columns(3),

                    Group::make()->schema([
                        DatePicker::make('start_date')
                            ->label('Start Date')
                        // ->required()
                        ,

                        DatePicker::make('end_date')
                            ->label('End Date')
                        // ->required(),
                    ])->columns(2),

                    TextInput::make('price')
                        ->label('Harga')
                        ->prefix('Rp.')
                        ->numeric(),

                    Select::make('author')
                        ->label('Author')
                        ->options(User::all()->pluck('name', 'id'))
                        ->preload()
                        ->live(),

                    FileUpload::make('image_name')
                        ->multiple()
                        ->maxFiles(10)
                        ->label('Upload File JPG, PNG, MP4 (Maksimal 10 Item)')
                        ->acceptedFileTypes(['image/jpeg', 'image/png'])
                        // ->disk('public')
                        ->previewable()
                ])->columns(1),


                Group::make()->schema([
                    Section::make()
                        ->schema([
                            TextInput::make('title')
                                ->label('Title'),

                            RichEditor::make('general_info')
                                ->label('Informasi Umum')
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
                TextColumn::make('countries')
                    ->label('Country'),
                TextColumn::make('cities')
                    ->label('Cities'),
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
            'index' => Pages\ListTravelPackages::route('/'),
            'create' => Pages\CreateTravelPackage::route('/create'),
            'edit' => Pages\EditTravelPackage::route('/{record}/edit'),
        ];
    }
}
