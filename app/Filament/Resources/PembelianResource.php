<?php

namespace App\Filament\Resources;

if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}


use App\Filament\Resources\PembelianResource\Pages;
use App\Filament\Resources\PembelianResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Relations\Relation;
use Filament\Forms\Components\Grid;

// model
use App\Models\Pembelian;
use App\Models\BahanBaku;
use App\Models\Supplier;
use App\Models\DetailPembelian;

// komponen input fornm
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

//komponen table
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

// tambahan untuk tombol unduh pdf
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf; // Kalau kamu pakai DomPDF
use Illuminate\Support\Facades\Storage;

class PembelianResource extends Resource
{
    protected static ?string $model = Pembelian::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Wizard::make([
                Forms\Components\Wizard\Step::make('Informasi Pembelian')
                    ->schema([
                        Forms\Components\TextInput::make('no_invoice')
                            ->label('No Invoice')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->required(),

                        Forms\Components\Select::make('kode_supplier')
                            ->label('Nama Supplier')
                            ->relationship('supplier', 'nama_supplier')
                            ->options(Supplier::all()->pluck('nama_supplier', 'id'))
                            ->searchable()
                            ->required(),
    
                    ]),

                Forms\Components\Wizard\Step::make('Detail Bahan Baku')
                    ->schema([
                        Forms\Components\HasManyRepeater::make('detailPembelian')
                            ->relationship()
                            ->schema([
                        Forms\Components\Select::make('kode_bahan_baku')
                            ->label('Nama Bahan Baku')
                            ->relationship('BahanBaku', 'nama_bahan_baku')
                            ->options(BahanBaku::all()->pluck('nama_bahan_baku', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $harga = BahanBaku::find($state)?->harga_satuan ?? 0;
                                $set('harga_satuan', $harga);
                                $bahanBaku = BahanBaku::find($state);
                                $set('satuan', $bahanBaku?->satuan);

                            // Hitung ulang subtotal jika jumlah sudah diisi
                                $jumlah = $get('jumlah');
                                if ($jumlah) {
                                    $set('subtotal', $harga * $jumlah);
                                    }
                                })
                                
                            ->required(),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $harga = $get('harga_satuan') ?? 0;
                                $set('subtotal', $state * $harga);
                                }),

                        Forms\Components\TextInput::make('satuan')
                            ->label('Satuan')
                            ->required(),

                        Forms\Components\TextInput::make('harga_satuan')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(), // agar tetap tersimpan di database

                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->default(0),
                            ])
                            ->defaultItems(1)
                            ->reorderable(false),
                            
                            ]),

                Forms\Components\Wizard\Step::make('Konfirmasi')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'belum lengkap' => 'Belum Lengkap',
                                'lengkap' => 'Lengkap',
                            ])
                            ->required(),

                        Forms\Components\FileUpload::make('foto_faktur')
                        ->label('Foto Faktur')
                        ->image()
                        ->required()
                        ->directory('faktur'),
                    ])
                    ])->columnSpanFull(),
                            ]);
                        }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_invoice')
                ->label('#️⃣No Invoice')
                ->searchable(),

                Tables\Columns\TextColumn::make('supplier.nama_supplier')
                ->label('✏️Nama Supplier')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('tanggal')
                ->label('🗓Tanggal')
                ->date(),

                Tables\Columns\TextColumn::make('total')
                ->label('💰Total')
                ->formatStateUsing(fn (string|int|null $state): string => rupiah($state))
                ->sortable()
                ->alignment('end'),

                Tables\Columns\BadgeColumn::make('status')
                ->label('✅Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                        'lengkap' => 'success',
                        'belum lengkap' => 'warning',
                    })
                ->icons([
                    'heroicon-o-check-circle' => 'lengkap',
                    'heroicon-o-x-circle' => 'belum lengkap',
                ]),

                Tables\Columns\ImageColumn::make('foto_faktur')
                ->label('🧾Foto Faktur')
                ->disk('public') // atau sesuaikan dengan disk yang kamu gunakan
                ->height(50), // atau sesuaikan ukuran tampilan gambar
                    
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tanggal')
                ->form([
                DatePicker::make('from'),
                DatePicker::make('to'),
                ])
            ->query(function ($query, array $data) {
                return $query
                    ->when($data['from'], fn ($q) => $q->where('tanggal', '>=', $data['from']))
                    ->when($data['to'], fn ($q) => $q->where('tanggal', '<=', $data['to']));
            })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            // tombol tambahan
            ->headerActions([
                // tombol tambahan export pdf
                // ✅ Tombol Unduh PDF
                Action::make('downloadPdf')
                ->label('Unduh PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    $pembelian = Pembelian::all();

                    $pdf = Pdf::loadView('pdf.pembelian', ['pembelian' => $pembelian]);

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'pembelian-list.pdf'
                    );
                })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembelians::route('/'),
            'create' => Pages\CreatePembelian::route('/create'),
            'edit' => Pages\EditPembelian::route('/{record}/edit'),
        ];
    }
}
