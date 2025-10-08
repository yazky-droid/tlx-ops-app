<?php

namespace App\Filament\Resources\ShipmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TrackingLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'trackingLogs';
    protected static ?string $title = 'Riwayat Pelacakan & Status Update';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status_name') 
                ->required()
                ->label('Status Baru')
                ->options([
                    'Booked' => 'Booked',
                    'Cargo Picked Up' => 'Cargo Picked Up',
                    'In Transit' => 'In Transit',
                    'Clearance Process' => 'Clearance Process',
                    'Delivered' => 'Delivered',
                    'Cancelled' => 'Cancelled',
                ])
                ->searchable(),
                TextInput::make('location')->required()->label('Lokasi Tracking'),
                Textarea::make('notes')->columnSpan('full')->label('Catatan Tambahan'),
                // updated_by di handle di model
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tracking_timestamp')->dateTime()->sortable()->label('Waktu'),
                TextColumn::make('status_name')->searchable()->label('Status'),
                TextColumn::make('location')->searchable()->label('Lokasi'),
                TextColumn::make('updatedBy.name')->label('Diupdate Oleh'),
            ])
            ->defaultSort('tracking_timestamp', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

}
