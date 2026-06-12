<?php
namespace App\Filament\Resources\Kandidats\Schemas;
use App\Models\Posisi;
use App\Models\Divisi;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class KandidatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')->label('Nama')->required(),
            TextInput::make('no_wa')->label('No WA'),
            Select::make('posisi')->label('Posisi')->required()
                ->options(Posisi::pluck('nama','nama'))
                ->searchable()
                ->createOptionForm([TextInput::make('nama')->required(), TextInput::make('departemen')])
                ->createOptionUsing(fn($data) => Posisi::create($data)->nama),
            Select::make('departemen')->label('Departemen')
                ->options(Divisi::pluck('nama','nama'))
                ->searchable()
                ->createOptionForm([TextInput::make('nama')->required()])
                ->createOptionUsing(fn($data) => Divisi::create($data)->nama),
            DatePicker::make('tanggal_interview')->label('Tgl Interview'),
            TextInput::make('jam_interview')->label('Jam Interview'),
            Select::make('pic')->label('PIC')
                ->options(['Ghisna'=>'Ghisna','Nisa'=>'Nisa','Wiwit'=>'Wiwit']),
            TextInput::make('user_interviewer')->label('User Interviewer'),

            // Upload CV
            FileUpload::make('cv_file')
                ->label('Upload CV (PDF/Word)')
                ->acceptedFileTypes(['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                ->maxSize(10240)
                ->disk('public')->directory('cv-kandidat')->preserveFilenames()
                ->downloadable()
                
                ->columnSpanFull(),

            // Upload App Form
            FileUpload::make('app_form_file')
                ->label('Upload App Form (PDF/Word)')
                ->acceptedFileTypes(['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                ->maxSize(10240)
                ->disk('public')->directory('app-form-kandidat')->preserveFilenames()
                ->downloadable()
                
                ->columnSpanFull(),

            Select::make('interview_online')->label('Interview Online')
                ->options(['belum'=>'Belum','hadir'=>'Hadir','tidak_hadir'=>'Tidak Hadir','reschedule'=>'Reschedule','sudah_dalam_proses'=>'Sudah Dalam Proses','belum_lolos'=>'Belum Lolos'])
                ->default('belum'),
            Textarea::make('ket_interview_online')->label('Ket. Interview Online')->columnSpanFull(),
            Select::make('app_form')->label('Status App Form')
                ->options(['belum'=>'Belum','terkirim'=>'Terkirim','lanjut_offline'=>'Lanjut Offline','lanjut_user'=>'Lanjut User','dialihkan'=>'Dialihkan','mundur'=>'Mundur'])
                ->default('belum'),
            Textarea::make('ket_app_form')->label('Ket. App Form')->columnSpanFull(),
            Select::make('interview_offline')->label('Interview Offline')
                ->options(['belum'=>'Belum','hadir'=>'Hadir','tidak_hadir'=>'Tidak Hadir','reschedule'=>'Reschedule','tidak_respon'=>'Tidak Respon'])
                ->default('belum'),
            Select::make('hasil_offline')->label('Hasil Offline')
                ->options(['belum'=>'Belum','ok'=>'OK','ng'=>'NG','dipertimbangkan'=>'Dipertimbangkan'])
                ->default('belum'),
            Textarea::make('ket_offline')->label('Ket. Offline')->columnSpanFull(),
            Select::make('psikotest')->label('Psikotest')
                ->options(['belum'=>'Belum','ok'=>'OK','ng'=>'NG','dipertimbangkan'=>'Dipertimbangkan','mundur'=>'Mundur'])
                ->default('belum'),
            Textarea::make('ket_psikotest')->label('Ket. Psikotest')->columnSpanFull(),
            Select::make('status_akhir')->label('Status Akhir')
                ->options(['proses'=>'Proses','diterima'=>'Diterima','ditolak'=>'Ditolak','dipertimbangkan'=>'Dipertimbangkan','mundur'=>'Mundur','dialihkan'=>'Dialihkan'])
                ->default('proses'),
            DatePicker::make('tanggal_join')->label('Tanggal Join'),
            Textarea::make('catatan')->label('Catatan')->columnSpanFull(),
        ]);
    }
}
