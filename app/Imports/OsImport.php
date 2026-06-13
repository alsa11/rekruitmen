<?php
namespace App\Imports;
use App\Models\Os;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class OsImport implements ToCollection, WithHeadingRow
{
    public function headingRow(): int { return 2; }

    public function collection(Collection $rows): void
    {
        $currentPosisi = '';
        $currentPlacement = '';
        $currentQty = 0;
        $currentOs = 0;
        $currentPic = '';
        $currentKet = '';

        foreach ($rows as $row) {
            $posisi    = trim($row['position'] ?? '');
            $nama      = trim($row['name'] ?? '');
            $pic       = trim($row['pic'] ?? '');
            $qty       = is_numeric($row['qty'] ?? null) ? (int)$row['qty'] : null;
            $os        = is_numeric($row['os'] ?? null) ? (int)$row['os'] : null;
            $placement = trim($row['placement'] ?? '');
            $ket       = trim($row['keterangan'] ?? '');

            // Skip baris total/header kosong semua
            if (empty($posisi) && empty($nama)) continue;
            $upperPosisi = strtoupper($posisi);
            if (in_array($upperPosisi, ['TOTAL','MAN POWER NEW','MAN POWER NISA','MAN POWER GHISNA','POSITION'])) continue;

            // Update state kalau ada posisi baru
            if (!empty($posisi)) {
                $currentPosisi = $posisi;
                if (!empty($placement)) $currentPlacement = $placement;
                if ($qty !== null) $currentQty = $qty;
                if ($os !== null) $currentOs = $os;
                if (!empty($ket)) $currentKet = $ket;
            }
            if (!empty($pic)) $currentPic = $pic;

            // Skip kalau tidak ada nama atau posisi
            if (empty($nama) || in_array($nama, ['-','?']) || empty($currentPosisi)) continue;

            // Tentukan status dari nama atau joined
            $joined = trim($row['joined'] ?? '');
            $statusAkhir = 'diterima';

            // Cek nama mengandung status
            $namaUpper = strtoupper($nama);
            if (preg_match('/BATAL|TIDAK JADI|RESIGN/i', $namaUpper)) {
                $statusAkhir = 'batal';
            } elseif (preg_match('/HOLD/i', $namaUpper)) {
                $statusAkhir = 'hold';
            }

            // Cek joined mengandung status
            if (!empty($joined)) {
                $joinedUpper = strtoupper($joined);
                if (preg_match('/KELUAR|MUNDUR|TIDAK LANJUT|MANGKIR/i', $joinedUpper)) {
                    $statusAkhir = 'keluar';
                } elseif (preg_match('/BATAL/i', $joinedUpper)) {
                    $statusAkhir = 'batal';
                } elseif (preg_match('/ON PROCESS/i', $joinedUpper)) {
                    $statusAkhir = 'proses';
                }
            }

            // Cek keterangan mengandung status
            $ketUpper = strtoupper($currentKet);
            if (preg_match('/HOLD/i', $ketUpper)) $statusAkhir = 'hold';
            if (preg_match('/FINISH|CLOSE/i', $ketUpper)) $statusAkhir = 'selesai';
            if (preg_match('/RESIGN/i', $ketUpper)) $statusAkhir = 'batal';

            // Parse tanggal join
            $joinDate = null;
            if (!empty($joined)) {
                $cleanJoined = preg_replace('/(KELUAR|BATAL|MUNDUR|TIDAK[^0-9]*|ON PROCESS|\/[A-Z].+)/i', '', $joined);
                $cleanJoined = trim($cleanJoined);
                try {
                    if (is_numeric($cleanJoined) && strlen($cleanJoined) < 6) {
                        $joinDate = Carbon::createFromFormat('Y-m-d','1899-12-30')->addDays((int)$cleanJoined)->format('Y-m-d');
                    } elseif (!empty($cleanJoined) && preg_match('/\d/', $cleanJoined)) {
                        $joinDate = Carbon::parse($cleanJoined)->format('Y-m-d');
                    }
                } catch (\Exception $e) {}
            }

            Os::create([
                'posisi'       => $currentPosisi,
                'placement'    => $currentPlacement ?: null,
                'qty'          => $currentQty,
                'os_filled'    => $currentOs,
                'nama'         => $nama,
                'pic'          => $currentPic ?: null,
                'keterangan'   => $currentKet ?: ($ket ?: null),
                'tanggal_join' => $joinDate,
                'status_akhir' => $statusAkhir,
            ]);
        }
    }
}
