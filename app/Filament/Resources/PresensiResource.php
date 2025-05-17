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
use Filament\Actions\Action;
use App\Filament\Resources\PegawaiResource;
use Illuminate\Support\Facades\Request;
use Filament\Forms\Components\TimePicker;


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
                    ->label('nama Pegawai')
                    ->relationship('pegawai', 'nama_pegawai') // relasi ke model User/Pegawai
                    ->required()
                    ->default(request()->query('user_id')), // <-- Autofill dari URL
                Forms\Components\DatePicker::make('tanggal')
                    ->default(now())
                    ->required(),
                Forms\Components\TimePicker::make('jam_masuk')
                ->displayFormat('H:i'),
                
                Forms\Components\TimePicker::make('jam_keluar'),
                Select::make('status')
                    ->label('Status Kehadiran')
                    ->options([
                        'Hadir' => 'Hadir',
                        'Alfa' => 'Alfa',
                        'Izin' => 'Izin',
                        'Sakit' => 'Sakit',
                    ])
                    ->required(),
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

Tables\Columns\TextColumn::make('pegawai.nama_pegawai')
    ->label('Nama Pegawai')
    ->sortable()
    ->searchable(),

Tables\Columns\TextColumn::make('jam_masuk')
    ->label('Jam Masuk')
    ->time(),

Tables\Columns\TextColumn::make('jam_keluar')
    ->label('Jam Keluar')
    ->time(),

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
            'index' => Pages\ListPresensis::route('/'),
            'create' => Pages\CreatePresensi::route('/create'),
            'edit' => Pages\EditPresensi::route('/{record}/edit'),
        ];
    }
    public function getHeaderActions(): array
{
    return [
        Action::make('createPresensi')
            ->label('New Pegawai')
            ->url(PresensiResource::getUrl('create', ['from_presensi' => true])) // tambahkan parameter khusus
            ->icon('heroicon-m-user-plus')
            ->color('warning'),

        Action::make('exportPdf')
            ->label('Unduh PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->url(fn () => route('presensi.export.pdf'))
            ->openUrlInNewTab()
            ->color('success'),
    ];
}
public function pegawai()
{
    return $this->belongsTo(User::class, 'pegawai_id'); // atau Pegawai::class jika beda model
}

}

