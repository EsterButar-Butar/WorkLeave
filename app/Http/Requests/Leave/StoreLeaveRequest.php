<?php

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
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
