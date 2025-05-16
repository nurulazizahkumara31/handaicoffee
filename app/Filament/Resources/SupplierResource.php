<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput; //kita menggunakan textinput
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_supplier')
                    ->default(fn () => Supplier::getKodeSupplier())
                    ->placeholder('Masukkan Kode Supplier')
                    ->label('Kode Supplier')
                    ->required()
                    ->readonly(),
                        
                        TextInput::make('nama_supplier')
                            ->required()
                            ->placeholder('Masukkan Nama Supplier')
                            ->label('Nama Supplier'),
                        
                        TextInput::make('no_telp')
                            ->required()
                            ->placeholder('Masukkan No Telepon Supplier')
                            ->label('No Telepon'),
                        
                        TextInput::make('alamat')
                            ->required()
                            ->placeholder('Masukkan Alamat Supplier')
                            ->label('Alamat'),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                    TextColumn::make('kode_supplier')
                        ->label('Kode Supplier')
                        ->sortable()
                        ->searchable(),
                    
                    TextColumn::make('nama_supplier')
                        ->label('Nama Supplier')
                        ->sortable()
                        ->searchable(),
    
                    TextColumn::make('no_telp')
                        ->label('No Telepon')
                        ->sortable(),
    
                    TextColumn::make('alamat')
                        ->label('Alamat')
                        ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
