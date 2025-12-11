<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    /**
     * Menampilkan daftar pengajuan verifikasi
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        // Validasi status
        if (!in_array($status, ['pending', 'verified', 'rejected'])) {
            $status = 'pending';
        }

        $pendingSellers = Seller::with(['user', 'region'])
            ->where('verification_status', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung untuk sidebar (hanya pending)
        $verifCount = Seller::where('verification_status', 'pending')->count();
        
        // Hitung untuk button tabs
        $stats = [
            'pending' => Seller::where('verification_status', 'pending')->count(),
            'verified' => Seller::where('verification_status', 'verified')->count(),
            'rejected' => Seller::where('verification_status', 'rejected')->count()
        ];

        return view('admin.verifikasi.verifikasi', compact('pendingSellers', 'verifCount', 'status', 'stats'));
    }

    /**
     * Menampilkan detail pengajuan verifikasi
     */
    public function show($id)
    {
        $seller = Seller::with(['user', 'region'])
            ->findOrFail($id);

        // Hitung jumlah pending verifikasi untuk sidebar
        $verifCount = Seller::where('verification_status', 'pending')->count();

        // Format data untuk view
        $applicant = [
            'id' => $seller->id,
            'nama_toko' => $seller->shop_name,
            'deskripsi_toko' => $seller->shop_description ?? '-',
            'nama_pic' => $seller->user->name,
            'no_hp_pic' => $seller->phone,
            'email_pic' => $seller->user->email,
            'jalan' => $seller->address,
            'rt' => '-',
            'rw' => '-',
            'kelurahan' => '-',
            'kota' => $seller->region->name ?? '-',
            'provinsi' => $seller->region->province ?? '-',
            'no_ktp' => '-',
            'foto_pic_name' => $seller->shop_image ?? 'default.jpg',
            'file_ktp_name' => '-',
            'status' => $seller->verification_status,
            'created_at' => $seller->created_at->format('d M Y H:i')
        ];

        return view('admin.verifikasi.detailverifikasi', compact('applicant', 'verifCount', 'seller'));
    }

    /**
     * Menyetujui pengajuan verifikasi
     */
    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $seller = Seller::findOrFail($id);
            
            $seller->verification_status = 'verified';
            $seller->is_active = true;
            $seller->verified_at = now();
            $seller->verified_by = auth()->id();
            $seller->rejection_reason = null;
            $seller->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil disetujui!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menolak pengajuan verifikasi
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10|max:500'
        ], [
            'reason.required' => 'Alasan penolakan wajib diisi',
            'reason.min' => 'Alasan penolakan minimal 10 karakter',
            'reason.max' => 'Alasan penolakan maksimal 500 karakter'
        ]);

        try {
            DB::beginTransaction();

            $seller = Seller::findOrFail($id);
            
            $seller->verification_status = 'rejected';
            $seller->is_active = false;
            $seller->rejection_reason = $request->reason;
            $seller->verified_at = now();
            $seller->verified_by = auth()->id();
            $seller->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil ditolak!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mendapatkan statistik verifikasi
     */
    public function statistics()
    {
        $stats = [
            'pending' => Seller::where('verification_status', 'pending')->count(),
            'verified' => Seller::where('verification_status', 'verified')->count(),
            'rejected' => Seller::where('verification_status', 'rejected')->count(),
            'total' => Seller::count()
        ];

        return response()->json($stats);
    }
}