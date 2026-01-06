<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcaEnrollment;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        $status = in_array($status, ['pending', 'enrolled'], true) ? $status : 'pending';

        $query = EcaEnrollment::with(['user', 'eca'])->orderByDesc('created_at');

        if ($status === 'pending') {
            $query->where('status', 'pending');
        } else {
            $query->whereIn('status', ['enrolled', 'done']);
        }

        $enrollments = $query->paginate(10)->withQueryString();

        $counts = [
            'pending' => EcaEnrollment::where('status', 'pending')->count(),
            'enrolled' => EcaEnrollment::whereIn('status', ['enrolled', 'done'])->count(),
        ];

        return view('admin.enrollments.index', compact('enrollments', 'status', 'counts'));
    }

    public function markDone(EcaEnrollment $enrollment)
    {
        $enrollment->update(['status' => 'enrolled']);

        return back()->with('success', 'Enrollment approved.');
    }

    public function rollback(EcaEnrollment $enrollment)
    {
        $enrollment->update(['status' => 'pending']);

        return back()->with('success', 'Enrollment moved back to pending.');
    }
}
