<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $modelLabel = 'Invoice';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->columns(3)
                    ->schema([
                        TextInput::make('invoice_number')
                            ->required() 
                            ->default('(Auto-Generated)')
                            ->readOnly()
                            ->dehydrated(false)
                            ->label('Nomor Invoice'),
                        Select::make('shipment_id')
                            ->relationship('shipment', 'reference_no')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Kiriman Terkait')
                            ->default(fn () => request()->query('shipmentId'))
                            ->disabled(fn () => request()->query('shipmentId')),
                        Select::make('client_id')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Ditujukan Kepada (Billed To)')
                            ->default(fn () => request()
                            ->query('clientId')),
                        
                        TextInput::make('total_amount')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Total Tagihan'),
                        Select::make('status')
                            ->options(['Draft' => 'Draft', 'Pending' => 'Pending', 'Paid' => 'Paid', 'Canceled' => 'Canceled'])
                            ->default('Draft')
                            ->required()
                            ->label('Status Pembayaran'),
                        
                        DatePicker::make('issue_date')
                            ->required()
                            ->default(now())
                            ->label('Tanggal Terbit'),
                        DatePicker::make('due_date')
                            ->label('Tanggal Jatuh Tempo'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')->searchable()->sortable()->label('No. Invoice'),
                TextColumn::make('shipment.reference_no')->label('Ref Kiriman'),
                TextColumn::make('client.name')->searchable()->label('Klien'),
                TextColumn::make('total_amount')->money('IDR')->label('Jumlah'),
                TextColumn::make('status')->badge()->label('Status'),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
