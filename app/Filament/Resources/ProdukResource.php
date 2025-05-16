<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;
    protected static ?string $slug = 'produk';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralModelLabel = 'Produk';

    public static function getNavigationGroup(): ?string
{
    return 'Master Produk';
}



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Choose file')
                    ->image()
                    ->directory('produk')
                    ->required()
                    ->maxSize(2048),
                
                Forms\Components\TextInput::make('code_product')
                    ->label('Product Code')
                    ->unique()
                    ->required()
                    ->maxLength(15),
                
                Forms\Components\TextInput::make('name_product')
                    ->label('Product Name')
                    ->required(),
                
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->required(),

                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()
                    ->required(),

                Forms\Components\DatePicker::make('expire_date')
                    ->label('Expire Date')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code_product')->sortable()->label('Code'),
                Tables\Columns\TextColumn::make('name_product')->sortable()->searchable()->label('Name'),
                Tables\Columns\TextColumn::make('description')->label('Desc'),
                Tables\Columns\TextColumn::make('price')->label('Price'),
                Tables\Columns\TextColumn::make('stock')->label('Stock'),
                Tables\Columns\TextColumn::make('expire_date')->label('Expire Date'),
                Tables\Columns\ImageColumn::make('image')->label('Image')->size(50),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
