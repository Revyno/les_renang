<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistrationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $registrations;

    // Constructor untuk menerima data yang akan di-export
    public function __construct($registrations = null)
    {
        $this->registrations = $registrations ?: Registration::with(['user', 'class', 'program'])->get();
    }

    public function collection()
    {
        return $this->registrations;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Orang Tua',
            'Email Orang Tua',
            'Telepon Orang Tua',
            'Nama Siswa',
            'Usia Siswa',
            'Jenis Kelamin',
            'Program',
            'Kelas',
            'Harga Kelas',
            'Status Pendaftaran',
            'Status Pembayaran',
            'Tanggal Pendaftaran'
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->id,
            $registration->parent_name,
            $registration->parent_email,
            $registration->parent_phone,
            $registration->student_name,
            $registration->student_age,
            $registration->student_gender == 'male' ? 'Laki-laki' : 'Perempuan',
            $registration->program->name ?? '-',
            $registration->class->title ?? '-',
            'Rp ' . number_format($registration->class->price ?? 0, 0, ',', '.'),
            $this->translateStatus($registration->status),
            $registration->payment_status,
            $registration->registration_date->format('d/m/Y')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:M' => ['autoSize' => true],
        ];
    }

    protected function translateStatus($status)
    {
        $statuses = [
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            'completed' => 'Selesai'
        ];
        
        return $statuses[$status] ?? $status;
    }
}