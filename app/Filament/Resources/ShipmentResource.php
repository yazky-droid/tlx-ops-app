<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Filament\Resources\ShipmentResource\RelationManagers;
use App\Filament\Resources\ShipmentResource\RelationManagers\TrackingLogsRelationManager;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Operasional';
    protected static ?string $modelLabel = 'Kiriman (Shipment)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Card::make()
                    ->columns(3)
                    ->schema([
                        TextInput::make('reference_no')
                            ->required()
                            ->default('(Auto-Generated)')
                            ->readOnly()
                            ->dehydrated(true)
                            ->label('No. Referensi/Resi'),

                        // Relasi Klien
                        Select::make('shipper_id')
                            ->relationship('shipper', 'name', 
                                fn (Builder $query) => $query->where('is_shipper', true))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Shipper (Pengirim)')
                            ->createOptionForm(self::getClientForm(true, false)),
                        
                        Select::make('consignee_id')
                            ->relationship('consignee', 'name', 
                                fn (Builder $query) => $query->where('is_consignee', true))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Consignee (Penerima)')
                            ->createOptionForm(self::getClientForm(false, true)), 
                    ]),

                // Detail Kargo
                Fieldset::make('Detail Kargo')
                    ->columns(3)
                    ->schema([
                        TextInput::make('cargo_description')->required()->label('Deskripsi Kargo'),
                        TextInput::make('weight_kg')->required()->numeric()->suffix('Kg')->label('Berat Total (Kg)'),
                        TextInput::make('volume_cbm')->required()->numeric()->suffix('CBM')->label('Volume (m³)'),
                        TextInput::make('goods_value')->numeric()->prefix('Rp')->label('Nilai Barang (Customs Value)'),
                        Select::make('service_type')
                            ->options([
                                'Air Freight' => 'Air Freight',
                            ])
                            ->required()
                            ->label('Jenis Layanan'),
                        TextInput::make('cargo_condition')->columnSpan('full')->label('Kondisi / Catatan Khusus'),
                    ]),

                // Jadwal dan Status
                Fieldset::make('Status & Jadwal')
                    ->columns(3)
                    ->schema([
                        TextInput::make('destination_port')->required()->label('Bandara Tujuan'),
                        DatePicker::make('etd')->label('ETD (Tgl Keberangkatan)'),
                        DatePicker::make('eta')->label('ETA (Tgl Kedatangan)'),
                        TextInput::make('current_status')
                            ->label('Status Saat Ini')
                            ->default('Booked')
                            ->readOnly()
                            ->columnSpan('full')
                            ->helperText('Status di-update otomatis melalui Tracking Log.')
                            
                            ->afterStateHydrated(function (TextInput $component, ?Shipment $record) {
                                // Pastikan tipe argumennya adalah TextInput
                                if (!$record) { 
                                    $component->state('Booked');
                                }
                            }),
                    ])
            ]);
    }

    public static function getClientForm(bool $isShipperDefault, bool $isConsigneeDefault): array
    {
        return [
            Card::make()
                ->columns(2)
                ->schema([
                    TextInput::make('name')->required()->label('Nama Perusahaan/Klien'),
                    TextInput::make('contact_person')->label('Contact Person'),
                    TextInput::make('email')->email(),
                    TextInput::make('phone')->tel()->label('Telepon'),
                    TextInput::make('address')->columnSpan('full')->label('Alamat Lengkap'),
                    
                    // Set default status berdasarkan panggilan
                    Toggle::make('is_shipper')
                        ->default($isShipperDefault)
                        ->required()
                        ->label('Bisa Menjadi Shipper'),
                    Toggle::make('is_consignee')
                        ->default($isConsigneeDefault)
                        ->required()
                        ->label('Bisa Menjadi Consignee'),
                ])
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_no')->searchable()->sortable()->label('No. Ref'),
                TextColumn::make('current_status')->badge()->sortable()->label('Status'),
                TextColumn::make('shipper.name')->sortable()->label('Shipper'),
                TextColumn::make('destination_port')->searchable()->label('Tujuan'),
                TextColumn::make('consignee.address')->searchable()->label('Alamat Consignee (Penerima)'),
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
            TrackingLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}
