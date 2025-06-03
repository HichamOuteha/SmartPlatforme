<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generate(Course $course)
    {
        $enrollment = auth()->user()->enrollments()
            ->where('course_id', $course->id)
            ->firstOrFail();

        if (!$enrollment->completed) {
            return back()->with('error', 'Vous devez terminer le cours pour obtenir le certificat.');
        }

        // Vérifier si un certificat existe déjà
        $existingCertificate = Certificate::where([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
        ])->first();

        if ($existingCertificate) {
            return redirect()->route('certificates.show', $existingCertificate);
        }

        $certificate = Certificate::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'certificate_number' => Certificate::generateNumber(),
            'issued_at' => now(),
        ]);

        // Générer le PDF
        $pdf = PDF::loadView('certificates.template', [
            'certificate' => $certificate,
            'course' => $course,
            'user' => auth()->user(),
        ]);

        // Sauvegarder le PDF
        $filename = 'certificates/' . $certificate->certificate_number . '.pdf';
        Storage::disk('public')->put($filename, $pdf->output());
        
        $certificate->update(['pdf_path' => $filename]);

        return redirect()->route('certificates.show', $certificate)
            ->with('success', 'Votre certificat a été généré avec succès !');
    }

    public function show(Certificate $certificate)
    {
        $this->authorize('view', $certificate);

        return view('certificates.show', compact('certificate'));
    }

    public function download(Certificate $certificate)
    {
        $this->authorize('view', $certificate);

        return Storage::disk('public')->download($certificate->pdf_path);
    }

    public function verify($number)
    {
        $certificate = Certificate::where('certificate_number', $number)
            ->with(['user', 'course'])
            ->firstOrFail();

        return view('certificates.verify', compact('certificate'));
    }

    public function index()
    {
        $certificates = auth()->user()->certificates()
            ->with('course')
            ->latest()
            ->paginate(12);

        return view('certificates.index', compact('certificates'));
    }
}
