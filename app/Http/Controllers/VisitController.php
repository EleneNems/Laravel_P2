<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Appointment;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with(['appointment.patient.user', 'appointment.doctor.user'])->paginate(20);
        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $appointments = Appointment::where('status', 'approved')->get();
        return view('visits.create', compact('appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id'=> 'required|exists:appointments,id',
            'diagnosis'=> 'required|string',
            'treatment'=> 'required|string',
            'prescription'=> 'nullable|string',
            'visit_date'=> 'required|date',
        ]);

        $appointment = Appointment::find($validated['appointment_id']);

        if (!in_array($appointment->status, ['approved', 'completed'])) {
            return back()->withErrors(['appointment_id' => 'Visit must be for an approved appointment']);
        }

        Visit::create($validated);

        return redirect()->route('visits.index')->with('success', 'Visit recorded');
    }

    public function show(Visit $visit)
    {
        return view('visits.show', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        return view('visits.edit', compact('visit'));
    }

    public function update(Request $request, Visit $visit)
    {
        $validated = $request->validate([
            'diagnosis'=> 'required|string',
            'treatment'=> 'required|string',
            'prescription'=> 'nullable|string',
            'visit_date'=> 'required|date',
        ]);

        $visit->update($validated);

        return redirect()->route('visits.index')->with('success', 'Updated');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();
        return redirect()->route('visits.index')->with('success', 'Deleted');
    }
}
