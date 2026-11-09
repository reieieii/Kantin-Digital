<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetRequest;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = PasswordResetRequest::with(['user', 'admin'])->orderByDesc('created_at');

        if ($status && in_array($status, ['pending', 'approved', 'rejected', 'completed'])) {
            $query->where('status', $status);
        }

        $requests = $query->paginate(15)->withQueryString();

        $counts = [
            'total'     => PasswordResetRequest::count(),
            'pending'   => PasswordResetRequest::where('status', 'pending')->count(),
            'approved'  => PasswordResetRequest::where('status', 'approved')->count(),
            'completed' => PasswordResetRequest::where('status', 'completed')->count(),
            'rejected'  => PasswordResetRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.password-resets.index', compact('requests', 'counts', 'status'));
    }

    public function approve($id)
    {
        $resetReq = PasswordResetRequest::with('user')->findOrFail($id);

        if ($resetReq->status === 'completed') {
            return back()->with('error', 'Permintaan ini sudah selesai diproses sebelumnya.');
        }

        $resetReq->update([
            'status'      => 'approved',
            'admin_id'    => Auth::id(),
            'approved_at' => Carbon::now(),
        ]);

        return back()->with('success', "Permintaan reset password untuk {$resetReq->name} ({$resetReq->email}) berhasil disetujui! Pengguna kini dapat langsung mengganti password.");
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:255'],
        ]);

        $resetReq = PasswordResetRequest::with('user')->findOrFail($id);

        $notes = $request->input('admin_notes', 'Permintaan tidak dapat dikonfirmasi oleh admin.');

        $resetReq->update([
            'status'      => 'rejected',
            'admin_notes' => $notes,
            'admin_id'    => Auth::id(),
        ]);

        // Kirim Notifikasi ke User
        UserNotification::create([
            'user_id' => $resetReq->user_id,
            'title'   => 'Permintaan Reset Password Ditolak ⚠️',
            'message' => 'Admin menolak permintaan reset password Anda. Alasan: ' . ($notes ?: 'Tidak memenuhi ketentuan.'),
            'type'    => 'password_rejected',
        ]);

        return back()->with('info', "Permintaan reset password untuk {$resetReq->name} telah ditolak.");
    }

    public function destroy($id)
    {
        $resetReq = PasswordResetRequest::findOrFail($id);
        $name = $resetReq->name;
        $resetReq->delete();

        return back()->with('success', "Data permintaan reset password untuk {$name} berhasil dihapus.");
    }
}

