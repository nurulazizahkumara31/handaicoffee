<?php

namespace App\Filament\Resources;

use App\Models\Jasa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\NumberInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class JasaResource extends Resource
{
    protected static ?string $model = Jasa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';

    // Form untuk menambah atau mengedit jasa
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('kode_jasa')
                    ->default(fn () => Jasa::getKodeJasa()) // Ambil default dari method getKodeBarang
                    ->label('Kode Jasa')
                    ->required()
                    ->readonly(),

            TextInput::make('nama_jasa')
                ->label('Nama Jasa')
                ->required()
                ->maxLength(255),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->required(),

            TextInput::make('harga')
                ->required()
                ->numeric()
                ->minValue(0)           
                ->type('number')
                ->placeholder('Masukkan harga jasa')
                ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format((int)$state, 0, ',', '.') : '')
                ->dehydrateStateUsing(function ($state) {
                    return (int) preg_replace('/[^0-9]/', '', $state);
                }),

            Select::make('status')
                ->label('Status')
                ->options([
                    'aktif' => 'Aktif',
                    'non-aktif' => 'Non-Aktif',
                ])
                ->default('aktif')
                ->required(),
        ]);
    }

    // Menampilkan tabel jasa dengan kolom-kolom yang ada
    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('kode_jasa')
                ->label('Kode Jasa')
                ->sortable()
                ->searchable(),

            TextColumn::make('nama_jasa')
                ->label('Nama Jasa')
                ->sortable()
                ->searchable(),

            TextColumn::make('deskripsi')
                ->label('Deskripsi')
                ->limit(50),

            TextColumn::make('harga')
                ->label('Harga')
                ->money('IDR'),

            SelectColumn::make('status')
                ->label('Status')
                ->options([
                    'aktif' => 'Aktif',
                    'non-aktif' => 'Non-Aktif',
                ]),
        ])
        ->filters([
            // Tambahkan filter jika diperlukan
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    // Mendefinisikan halaman untuk List, Create, dan Edit
    public static function getPages(): array
    {
        return [
            'index' => JasaResource\Pages\ListJasas::route('/'),
            'create' => JasaResource\Pages\CreateJasa::route('/create'),
            'edit' => JasaResource\Pages\EditJasa::route('/{record}/edit'),
        ];
    }
}
