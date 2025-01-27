<?php

namespace App\Imports;

use App\Models\DataKependudukan;
use Maatwebsite\Excel\Concerns\ToModel;

class DataKependudukanImport implements ToModel
{
    public function model(array $row)
    {
        // Skip the header row or empty rows
        if ($row[0] === 'NAMA' && $row[1] === 'NIK' || ($row[0] === null && $row[1] === null)) {
            return null;
        }

        // Convert date format from `DD|MM|YYYY` to `YYYY-MM-DD`
        $tanggal_lahir = null;
        if (!empty($row[4]) && preg_match('/\d{2}\|\d{2}\|\d{4}/', $row[4])) {
            $dateParts = explode('|', $row[4]);
            $tanggal_lahir = "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}"; // Rearrange to YYYY-MM-DD
        }

        // Map or clean the `status_kawin` value
        $validStatuses = ['KAWIN', 'BELUM KAWIN'];
        $status_kawin = in_array(strtoupper($row[10]), $validStatuses) ? strtoupper($row[10]) : 'BELUM KAWIN';

        // Determine the value for ktp_elektronik based on $row[14]
        $ktp_elektronik = ($row[14] === "Y") ? 1 : 0;

        // Check if the record with the same NIK exists
        $dataKependudukan = DataKependudukan::where('nik', $row[1])->first();

        if ($dataKependudukan) {
            // Update the existing record
            $dataKependudukan->update([
                'nama' => $row[0],
                'jenis_kelamin' => $row[2],
                'tempat_lahir' => $row[3],
                'tanggal_lahir' => $tanggal_lahir,
                'agama' => $row[5],
                'no_kk' => $row[6],
                'pendidikan' => $row[7],
                'pekerjaan' => $row[8],
                'golongan_darah' => $row[9],
                'status_kawin' => $status_kawin,
                'nama_ibu' => $row[11],
                'nama_bapak' => $row[12],
                'alamat' => $row[13],
                'ktp_elektronik' => $ktp_elektronik, // Set based on $row[14]
                'keterangan' => $row[15],
            ]);
        } else {
            // Create a new record
            DataKependudukan::create([
                'nama' => $row[0],
                'nik' => $row[1],
                'jenis_kelamin' => $row[2],
                'tempat_lahir' => $row[3],
                'tanggal_lahir' => $tanggal_lahir,
                'agama' => $row[5],
                'no_kk' => $row[6],
                'pendidikan' => $row[7],
                'pekerjaan' => $row[8],
                'golongan_darah' => $row[9],
                'status_kawin' => $status_kawin,
                'nama_ibu' => $row[11],
                'nama_bapak' => $row[12],
                'alamat' => $row[13],
                'ktp_elektronik' => $ktp_elektronik, // Set based on $row[14]
                'keterangan' => $row[15],
            ]);
        }
    }
}
