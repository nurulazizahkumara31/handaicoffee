<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BahanBakuResource\Pages;
use App\Filament\Resources\BahanBakuResource\RelationManagers;
use App\Models\BahanBaku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// komponen input fornm
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;

//komponen table
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

class BahanBakuResource extends Resource
{
    protected static ?string $model = BahanBaku::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_bahan_baku')
                    ->default(fn () => BahanBaku::getKodeBahanBaku()) // Ambil default dari method getKodeBarang
                    ->label('Kode Bahan Baku')
                    ->required()
                    ->readonly() // Membuat field menjadi read-only
                ,
                TextInput::make('nama_bahan_baku')
                    ->required()
                    ->placeholder('Masukkan nama bahan baku') // Placeholder untuk membantu pengguna
                ,
                Select::make('satuan')
                ->label('Satuan')
                ->options([
                    'Kg' => 'Kg',
                    'Liter' => 'Liter',
                    'Pcs' => 'Pcs',
                    'Gram' => 'Gram',
                ])
                ->required(),

                TextInput::make('harga_satuan')
                    ->required()
                    ->minValue(0) // Nilai minimal 0 (opsional jika tidak ingin ada harga negatif)
                    ->reactive() // Menjadikan input reaktif terhadap perubahan
                    ->extraAttributes(['id' => 'harga-bahan baku']) // Tambahkan ID untuk pengikatan JavaScript
                    ->placeholder('Masukkan harga bahan baku') // Placeholder untuk membantu pengguna
                    ->live()
                    ->afterStateUpdated(fn ($state, callable $set) => 
                        $set('harga_satuan', number_format((int) str_replace('.', '', $state), 0, ',', '.'))
                      )
                ,
                TextInput::make('jumlah')
                    ->required()
                    ->placeholder('Masukkan stok bahan baku') // Placeholder untuk membantu pengguna
                    ->minValue(0)
                ,
                FileUpload::make('gambar')
                ->label('Gambar')
                ->image()
                ->directory('images')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_bahan_baku')
                    ->searchable(),
                // agar bisa di search
                TextColumn::make('nama_bahan_baku')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('satuan')
                ->label('satuan')
                ->color(fn (string $state): string => match ($state) {
                    'Kg' => 'gray',
                    'Liter' => 'yellow',
                    'Pcs' => 'success',
                    'Gram' => 'Danger',
                }),
                TextColumn::make('harga_satuan')
                    ->label('Harga Barang')
                    ->formatStateUsing(fn (string|int|null $state): string => rupiah($state))
                    ->extraAttributes(['class' => 'text-right']) // Tambahkan kelas CSS untuk rata kanan
                    ->sortable()
                ,
                TextColumn::make('jumlah'),
                ImageColumn::make('gambar') // Menampilkan gambar di tabel
                ->label('Gambar')
                ->size(50), // Menyesuaikan ukuran thumbnail
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
            'index' => Pages\ListBahanBakus::route('/'),
            'create' => Pages\CreateBahanBaku::route('/create'),
            'edit' => Pages\EditBahanBaku::route('/{record}/edit'),
        ];
    }
}
