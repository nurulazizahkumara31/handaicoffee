<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Filament\Resources\VoucherResource\RelationManagers;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Master Data';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode Voucher')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
                Forms\Components\TextInput::make('description')
                    ->label('Deskripsi')
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                        'percentage' => 'Persentase',
                        'fixed' => 'Nominal',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('value')
                    ->label('Nilai Diskon')
                    ->numeric()
                    ->required()
                    ->minValue(0),
                Forms\Components\TextInput::make('min_order')
                    ->label('Minimal Order')
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->nullable(),
                Forms\Components\DatePicker::make('expiry_date')
                    ->label('Tanggal Expired')
                    ->nullable(),
                Forms\Components\Toggle::make('active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Kode Voucher')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->label('Deskripsi')->limit(30),
                Tables\Columns\TextColumn::make('type')->label('Tipe Diskon'),
                Tables\Columns\TextColumn::make('value')->label('Nilai Diskon')->sortable(),
                Tables\Columns\TextColumn::make('min_order')->label('Minimal Order')->sortable(),
                Tables\Columns\BooleanColumn::make('active')->label('Aktif'),
                Tables\Columns\TextColumn::make('start_date')->date()->label('Mulai'),
                Tables\Columns\TextColumn::make('expiry_date')->date()->label('Kadaluarsa'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
        ];
    }
}

