<?php
//bismillah
namespace App\Filament\Resources;

use App\Filament\Resources\PresensiResource\Pages;
use App\Models\Presensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Widgets\PresensiChart;


class PresensiResource extends Resource
{
    protected static ?string $model = Presensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Presensi';
    protected static ?string $pluralModelLabel = 'Presensi';
    protected static ?string $navigationGroup = 'Presensi Karyawan';

    public static function form(Form $form): Form
{

    return $form
        ->schema([
            Forms\Components\Select::make('user_id')
                ->label('Pegawai')
                ->relationship('pegawai', 'nama_pegawai') // pastikan relasi ini benar
                ->required(),

            Forms\Components\DatePicker::make('tanggal')
                ->default(now())
                ->required(),

            Forms\Components\TimePicker::make('jam_masuk'),

            Forms\Components\TimePicker::make('jam_keluar'),

            Select::make('status')
    ->label('Status Kehadiran')
    ->options([
        'Hadir' => 'Hadir',
        'Alfa' => 'Alfa',
        'Izin' => 'Izin',
        'Sakit' => 'Sakit',
    ])
    ->required()
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jam_masuk')
                    ->label('Jam Masuk')
                    ->time(),

                Tables\Columns\TextColumn::make('jam_keluar')
                    ->label('Jam Keluar')
                    ->time(),
                    Tables\Columns\TextColumn::make('pegawai.nama_pegawai')->label('Nama Pegawai'),
                    Tables\Columns\TextColumn::make('tanggal')->date(),
                    Tables\Columns\TextColumn::make('jam_masuk')->time(),
                    Tables\Columns\TextColumn::make('jam_keluar')->time(),

                 BadgeColumn::make('status')
    ->label('Status')
    ->colors([
        'success' => 'Hadir',
        'danger' => 'Alfa',
        'warning' => 'Izin',
        'info' => 'Sakit',
    ]),   
            ])
            ->filters([
                Tables\Filters\Filter::make('Hari Ini')
                    ->query(fn (Builder $query) => $query->where('tanggal', now()->toDateString())),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPresensis::route('/'),
            'create' => Pages\CreatePresensi::route('/create'),
            'edit' => Pages\EditPresensi::route('/{record}/edit'),
        ];
    }

    
}

