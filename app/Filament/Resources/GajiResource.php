<?php

namespace App\Filament\Resources;

use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\Presensi;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Repeater;

use Filament\Tables\Columns\TextColumn;

use App\Filament\Resources\GajiResource\Pages;

class GajiResource extends Resource
{
    protected static ?string $model = Gaji::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Gaji';
    protected static ?string $navigationGroup = 'Manajemen Karyawan';

    public static function form(Form $form): Form
    {
        $gajiData = Gaji::with('pegawai')->latest()->limit(5)->get()->map(function ($gaji) {
            return [
                'nama' => $gaji->pegawai->nama_pegawai ?? '-',
                'hadir' => $gaji->jumlah_hadir,
                'gaji' => 'Rp ' . number_format($gaji->gaji_per_hari, 0, ',', '.'),
                'total' => 'Rp ' . number_format($gaji->total_gaji, 0, ',', '.'),
            ];
        })->toArray();

        return $form
            ->schema([
                Wizard::make([
                    Step::make('Pilih Pegawai')->schema([
                        Select::make('pegawai_id')
                            ->label('Nama Pegawai')
                            ->options(Pegawai::pluck('nama_pegawai', 'id_pegawai'))
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $jumlahHadir = Presensi::where('user_id', $state)->count();
                                    $set('jumlah_hadir', $jumlahHadir);
                                    $set('total_gaji', $jumlahHadir * 100000);
                                }
                            }),
                    ]),

                    Step::make('Detail Gaji')->schema([
                        TextInput::make('jumlah_hadir')
                            ->label('Jumlah Hadir')
                            ->numeric()
                            ->disabled()
                            ->required()
                            ->dehydrated(true),

                        TextInput::make('gaji_per_hari')
                            ->label('Gaji per Hari')
                            ->default(100000)
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $set('total_gaji', $get('jumlah_hadir') * $state);
                            }),

                        TextInput::make('total_gaji')
                            ->label('Total Gaji')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(true),
                    ]),

                    Step::make('Ringkasan')->schema([
                        Repeater::make('ringkasan_gaji')
                            ->label('Ringkasan Gaji Terakhir')
                            ->schema([
                                TextInput::make('nama')->label('Nama')->disabled(),
                                TextInput::make('hadir')->label('Hadir')->disabled(),
                                TextInput::make('gaji')->label('Gaji/Hari')->disabled(),
                                TextInput::make('total')->label('Total')->disabled(),
                            ])
                            ->columns(4)
                            ->default($gajiData)
                            ->disabled()
                    ]),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pegawai.nama_pegawai')->label('Nama Pegawai'),
                TextColumn::make('jumlah_hadir'),
                TextColumn::make('gaji_per_hari')
                    ->label('Gaji Per Hari')
                    ->formatStateUsing(fn($state) => "Rp " . number_format($state, 0, ',', '.')),
                TextColumn::make('total_gaji')
                    ->label('Total Gaji')
                    ->formatStateUsing(fn($state) => "Rp " . number_format($state, 0, ',', '.')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGajis::route('/'),
            'create' => Pages\CreateGaji::route('/create'),
            'edit' => Pages\EditGaji::route('/{record}/edit'),
        ];
    }
}
