<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerRegistrationReceived;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Seller;
use App\Models\Region;

class SellerRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255'],
            'deskripsi_toko' => ['nullable', 'string'],
            'nama_pic' => ['required', 'string', 'max:255'],
            'no_hp_pic' => ['required', 'regex:/^\d{10,15}$/', 'unique:users,number_phone'],
            'email_pic' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'jalan' => ['required', 'string', 'max:255'],
            'rt' => ['required', 'integer', 'min:0'],
            'rw' => ['required', 'integer', 'min:0'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'provinsi' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'digits:16', Rule::unique('sellers', 'nik')],
            'foto_pic' => ['required', 'image', 'max:2048'], // 2MB
            'file_ktp' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // 5MB
        ], [
            'no_hp_pic.regex' => 'Nomor HP harus 10-15 digit angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'no_ktp.digits' => 'Nomor KTP harus 16 digit.',
        ]);

        DB::beginTransaction();
        try {
            // Pastikan region (kota) ada
            $region = Region::firstOrCreate(['name' => $validated['kota']]);

            // Buat user baru untuk penjual
            $user = User::create([
                'name' => $validated['nama_pic'],
                'email' => $validated['email_pic'],
                'number_phone' => $validated['no_hp_pic'],
                'password' => $validated['password'], // akan di-hash oleh casts
                'role' => 'Penjual',
            ]);

            // Upload files
            $shopImagePath = $request->file('foto_pic')->store('sellers/pic', 'public');
            $ktpImagePath = $request->file('file_ktp')->store('sellers/ktp', 'public');

            // Susun alamat lengkap dari potongan input
            $address = sprintf(
                '%s, RT %s/RW %s, Kel. %s, %s, %s',
                $validated['jalan'], $validated['rt'], $validated['rw'], $validated['kelurahan'], $validated['kota'], $validated['provinsi']
            );

            // Buat record seller (status default pending, non-aktif hingga diverifikasi)
            $seller = Seller::create([
                'user_id' => $user->id,
                'shop_name' => $validated['nama_toko'],
                'shop_description' => $validated['deskripsi_toko'] ?? null,
                'shop_image' => $shopImagePath,
                'phone' => $validated['no_hp_pic'],
                'address' => $address,
                'is_active' => false,
                'verification_status' => 'pending',
                'region_id' => $region->id,
                'nik' => $validated['no_ktp'],
                'ktp_image' => $ktpImagePath,
            ]);

            DB::commit();

            // Kirim email pemberitahuan registrasi diterima
            try {
                Mail::to($user->email)->send(new SellerRegistrationReceived($seller));
            } catch (\Throwable $mailErr) {
                Log::warning('Gagal kirim email registrasi seller', ['error' => $mailErr->getMessage()]);
            }

            // Untuk permintaan AJAX, kembalikan JSON
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registrasi berhasil dikirim. Menunggu verifikasi admin.',
                    'redirect' => url('/login-seller')
                ]);
            }

            // Fallback normal submit
            return redirect('/login-seller')->with('success', 'Registrasi berhasil dikirim. Menunggu verifikasi admin.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal registrasi seller', ['error' => $e->getMessage()]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
            }

            return back()->withErrors(['general' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }
}
