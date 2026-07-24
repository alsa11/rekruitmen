<?php
namespace App\Imports;
use App\Models\Kandidat;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithSheetNames;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class KandidatArisaImport implements WithMultipleSheets
{
    protected string $pic;
    protected array $sheetNames;

    public function __construct(string $pic, array $sheetNames)
    {
        $this->pic        = $pic;
        $this->sheetNames = $sheetNames;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->sheetNames as $name) {
            $sheets[$name] = new KandidatArisaSheetImport($this->pic, $name);
        }
        return $sheets;
    }
}

class KandidatArisaSheetImport implements ToCollection
{
    protected string $pic;
    protected string $posisi;

    public function __construct(string $pic, string $posisi)
    {
        $this->pic    = $pic;
        $this->posisi = $posisi;
    }

    public function collection(Collection $rows): void
    {
        if ($rows->count() < 2) return;

        $headers = collect($rows->first())->map(
            fn($h) => strtolower(trim(str_replace([' ','/'], ['_','_'], $h ?? '')))
        );

        foreach ($rows->skip(1) as $row) {
            $row = collect($row);
            if ($row->filter()->isEmpty()) continue;

            $data = [];
            foreach ($headers as $i => $key) {
                $data[$key] = $row->get($i);
            }

            $nama = trim($data['nama'] ?? '');
            if (empty($nama) || is_numeric($nama)) continue;

            $noWa    = trim($data['nomor'] ?? '');
            $tanggal = $this->parseDate($data['start_date'] ?? null);

            $onlineRaw = strtolower(trim($data['konfirmasi_kehadiran_online'] ?? ''));
            $online = 'belum';
            if (str_contains($onlineRaw,'tidak')) $online = 'tidak_hadir';
            elseif (str_contains($onlineRaw,'reschedule') || str_contains($onlineRaw,'reschadul')) $online = 'reschedule';
            elseif (str_contains($onlineRaw,'hadir')) $online = 'hadir';

            $hasilOnlineRaw = strtolower(trim($data['hasil_interview_online'] ?? ''));
            $hasilOnline = 'belum';
            if (str_contains($hasilOnlineRaw,'pertimbang')) $hasilOnline = 'dipertimbangkan';
            elseif (str_contains($hasilOnlineRaw,'alihkan')) $hasilOnline = 'dialihkan';
            elseif (str_contains($hasilOnlineRaw,'ng')) $hasilOnline = 'ng';
            elseif (str_contains($hasilOnlineRaw,'ok')) $hasilOnline = 'ok';

            $appFormRaw = strtolower(trim($data['aplikasi_form'] ?? ''));
            $appForm = 'belum';
            if (str_contains($appFormRaw,'ready') || str_contains($appFormRaw,'terkirim')) $appForm = 'terkirim';

            $statusAkhir = 'proses';
            if ($hasilOnline === 'ng') $statusAkhir = 'ditolak';

            Kandidat::updateOrCreate(
                ['nama' => $nama, 'no_wa' => $noWa],
                [
                    'posisi'                => $this->posisi,
                    'tanggal_interview'     => $tanggal,
                    'jam_interview'         => trim($data['jam'] ?? ''),
                    'pic'                   => $this->pic,
                    'sumber_sheet'          => $this->posisi,
                    'interview_online'      => $online,
                    'hasil_interview_online'=> $hasilOnline,
                    'app_form'              => $appForm,
                    'app_form_hasil_test'   => trim($data['hasil_test'] ?? ''),
                    'catatan'               => trim($data['notes'] ?? ''),
                    'status_akhir'          => $statusAkhir,
                ]
            );
        }
    }

    private function parseDate($val): ?string
    {
        if (!$val) return null;
        try {
            if (is_numeric($val)) return Carbon::createFromFormat('Y-m-d','1899-12-30')->addDays((int)$val)->format('Y-m-d');
            return Carbon::parse($val)->format('Y-m-d');
        } catch (\Exception $e) { return null; }
    }
}
