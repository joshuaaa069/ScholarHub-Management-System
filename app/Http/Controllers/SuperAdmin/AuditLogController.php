<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * READ: list audit log entries, newest first, with optional search.
     *
     * Note: audit logs are intentionally system-generated only (no manual
     * "create" or "edit" here) - allowing edits would defeat the purpose of
     * an audit trail. Delete is still supported for cleanup/retention.
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('action', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        $logs = $query->latest()->paginate(20)->withQueryString();

        return view('superadmin.audit-logs', compact('logs'));
    }

    /**
     * DELETE: remove a single audit log entry.
     */
    public function destroy(AuditLog $auditLog)
    {
        $auditLog->delete();

        return redirect()->route('superadmin.audit-logs')
            ->with('success', 'Log entry deleted.');
    }

    /**
     * DELETE: clear every audit log entry at once.
     */
    public function clear()
    {
        AuditLog::query()->delete();

        return redirect()->route('superadmin.audit-logs')
            ->with('success', 'All audit logs have been cleared.');
    }
}
