<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput; 
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\PegawaiResource\Pages;
use App\Models\Pegawai;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1) // Membuat hanya 1 kolom
                    ->schema([
                        TextInput::make('id_pegawai')
                            ->required()
                            ->placeholder('Masukkan ID Pegawai')
                            ->label('ID Pegawai'),
                        
                        TextInput::make('nama_pegawai')
                            ->required()
                            ->placeholder('Masukkan Nama Pegawai')
                            ->label('Nama Pegawai'),
                        
                        TextInput::make('nohp_pegawai')
                            ->required()
                            ->placeholder('Masukkan No HP Pegawai')
                            ->label('No HP'),
                        
                        TextInput::make('alamat')
                            ->required()
                            ->placeholder('Masukkan Alamat Pegawai')
                            ->label('Alamat'),
                        
                        TextInput::make('posisi')
                            ->required()
                            ->placeholder('Masukkan Posisi Pegawai')
                            ->label('Posisi'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_pegawai')
                    ->label('ID Pegawai')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('nama_pegawai')
                    ->label('Nama Pegawai')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nohp_pegawai')
                    ->label('No HP')
                    ->sortable(),

                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->sortable(),
                
                TextColumn::make('posisi')
                    ->label('Posisi')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('posisi')
                    ->label('Filter Posisi')
                    ->options([
                        'manager' => 'Manager',
                        'staff' => 'Staff',
                        'intern' => 'Intern',
                    ]),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawai::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}