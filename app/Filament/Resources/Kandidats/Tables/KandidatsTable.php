<?php
namespace App\Filament\Resources\Kandidats\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class KandidatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama')->searchable()->sortable()->weight('bold'),
                TextColumn::make('no_wa')->label('No WA')->searchable()->copyable(),
                TextColumn::make('posisi')->label('Posisi')->searchable(),
                TextColumn::make('cv_file')->label('CV')
                    ->formatStateUsing(fn($state) => $state ? '📄 Lihat CV' : '-')
                    ->url(fn($record) => $record->cv_file ? asset('storage/'.$record->cv_file) : null)
                    ->openUrlInNewTab()
                    ->color(fn($state) => $state ? 'info' : 'gray'),
                TextColumn::make('app_form_file')->label('App Form')
                    ->formatStateUsing(fn($state) => $state ? '📋 Lihat Form' : '-')
                    ->url(fn($record) => $record->app_form_file ? asset('storage/'.$record->app_form_file) : null)
                    ->openUrlInNewTab()
                    ->color(fn($state) => $state ? 'success' : 'gray'),
                TextColumn::make('tanggal_interview')->label('Tgl Interview')->date('d/m/Y')->sortable(),
                TextColumn::make('jam_interview')->label('Jam')->searchable(),
                TextColumn::make('pic')->label('PIC')->badge()->color(fn($state) => match($state) {
                    'Ghisna' => 'info', 'Nisa' => 'success', 'Wiwit' => 'warning', default => 'gray',
                }),
                TextColumn::make('interview_online')->label('Int. Online')->badge()->color(fn($state) => match($state) {
                    'hadir' => 'success', 'tidak_hadir','belum_lolos' => 'danger', 'reschedule' => 'warning', default => 'gray',
                }),
                TextColumn::make('app_form')->label('App Form')->badge()->color(fn($state) => match($state) {
                    'terkirim','lanjut_offline','lanjut_user' => 'success', 'mundur','dialihkan' => 'danger', default => 'gray',
                }),
                TextColumn::make('interview_offline')->label('Int. Offline')->badge()->color(fn($state) => match($state) {
                    'hadir' => 'success', 'tidak_hadir','tidak_respon' => 'danger', 'reschedule' => 'warning', default => 'gray',
                }),
                TextColumn::make('psikotest')->label('Psikotest')->badge()->color(fn($state) => match($state) {
                    'ok','dipertimbangkan' => 'success', 'ng','mundur' => 'danger', default => 'gray',
                }),
                TextColumn::make('status_akhir')->label('Status')->badge()->color(fn($state) => match($state) {
                    'diterima' => 'success', 'ditolak' => 'danger', 'dipertimbangkan' => 'warning', 'proses' => 'info', default => 'gray',
                }),
            ])
            ->filters([
                SelectFilter::make('pic')->label('PIC')
                    ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit']),
                SelectFilter::make('posisi')->label('Posisi')
                    ->options(\App\Models\Posisi::pluck('nama','nama')->toArray())
                    ->searchable(),
                SelectFilter::make('status_akhir')->label('Status')
                    ->options(['proses'=>'Proses','diterima'=>'Diterima','ditolak'=>'Ditolak','dipertimbangkan'=>'Dipertimbangkan','mundur'=>'Mundur']),
                SelectFilter::make('interview_online')->label('Int. Online')
                    ->options(['belum'=>'Belum','hadir'=>'Hadir','tidak_hadir'=>'Tidak Hadir','reschedule'=>'Reschedule']),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('id','desc');
    }
}
