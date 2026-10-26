<?php

namespace App\Http\Requests\Leave;

use App\Models\LeaveType;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        // Pastikan tabel master leave_types tidak kosong
        if (LeaveType::count() === 0) {
            (new \Database\Seeders\LeaveTypeSeeder())->run();
        }

        $rawInput = $this->input('leave_type_id') 
            ?? $this->input('leave_type') 
            ?? $this->input('leave_type_code');

        $type = null;

        if ($rawInput) {
            // 1. Cek apakah ID numerik yang valid di database
            if (is_numeric($rawInput)) {
                $type = LeaveType::find((int) $rawInput);
            }

            // 2. Cek berdasarkan kode (ANNUAL, SICK, MATERNITY)
            if (!$type) {
                $type = LeaveType::where('code', strtoupper(trim($rawInput)))->first();
            }

            // 3. Cek berdasarkan nama cuti (misal: "Cuti Tahunan")
            if (!$type) {
                $type = LeaveType::where('name', 'like', '%' . trim($rawInput) . '%')->first();
            }

            // 4. Deteksi kata kunci umum jika format string bebas
            if (!$type) {
                $lower = strtolower($rawInput);
                if (str_contains($lower, 'tahun') || str_contains($lower, 'annual')) {
                    $type = LeaveType::where('code', 'ANNUAL')->first();
                } elseif (str_contains($lower, 'salin') || str_contains($lower, 'matern')) {
                    $type = LeaveType::where('code', 'MATERNITY')->first();
                } elseif (str_contains($lower, 'sakit') || str_contains($lower, 'sick')) {
                    $type = LeaveType::where('code', 'SICK')->first();
                }
            }
        }

        if ($type) {
            $this->merge([
                'leave_type_id' => $type->id,
                'leave_type' => $type->code,
                'leave_type_code' => $type->code,
            ]);
        }

        // Dukung nama field upload file_pendukung dari form prototype
        if (!$this->hasFile('attachment') && $this->hasFile('file_pendukung')) {
            $this->files->set('attachment', $this->file('file_pendukung'));
        }
    }

    public function rules(): array
    {
        return [
            'leave_type_id' => ['required', 'exists:leave_types,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'min:5', 'max:1000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'], // Maks 2MB
            'emergency_contact' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'leave_type_id.required' => 'Pilih jenis cuti terlebih dahulu.',
            'leave_type_id.exists' => 'Jenis cuti yang dipilih tidak valid.',
            'start_date.required' => 'Tanggal mulai cuti wajib diisi.',
            'start_date.after_or_equal' => 'Tanggal mulai cuti tidak boleh di masa lampau.',
            'end_date.required' => 'Tanggal selesai cuti wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'reason.required' => 'Alasan pengajuan cuti wajib diisi.',
            'reason.min' => 'Alasan pengajuan minimal 5 karakter.',
            'attachment.mimes' => 'Lampiran harus berupa file PDF, JPG, JPEG, atau PNG.',
            'attachment.max' => 'Ukuran lampiran maksimal 2MB.',
        ];
    }
}
