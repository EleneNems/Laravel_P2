<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
{
    $query = Appointment::with(['doctor.user', 'patient.user']);

    // doctor filter
    if ($request->doctor_id) {
        $query->where('doctor_id', $request->doctor_id);
    }

    // patient filter
    if ($request->patient_id) {
        $query->where('patient_id', $request->patient_id);
    }

    // status filter
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // date range filter
    if ($request->date_from) {
        $query->whereDate('appointment_date', '>=', $request->date_from);
    }
    if ($request->date_to) {
        $query->whereDate('appointment_date', '<=', $request->date_to);
    }

    // search keyword in: notes, patient name, doctor name
    if ($request->keyword) {
        $query->where(function ($q) use ($request) {
            $q->where('notes', 'like', '%' . $request->keyword . '%')
              ->orWhereHas('doctor.user', function ($q) use ($request) {
                  $q->where('name', 'like', '%' . $request->keyword . '%');
              })
              ->orWhereHas('patient.user', function ($q) use ($request) {
                  $q->where('name', 'like', '%' . $request->keyword . '%');
              });
        });
    }

    $appointments = $query->paginate(10)->appends($request->query());

    return view('appointments.index', [
        'appointments' => $appointments,
        'doctors' => Doctor::with('user')->get(),
        'patients' => Patient::with('user')->get(),
    ]);
}


    public function create()
    {
        return view('appointments.create', [
            'patients' => Patient::with('user')->get(),
            'doctors' => Doctor::with('user')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'=> 'required|exists:patients,id',
            'doctor_id'=> 'required|exists:doctors,id',
            'appointment_date'=> 'required|date',
            'notes'=> 'nullable|string',
        ]);

        // double booking
        $exists = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->whereNot('status', 'canceled')
            ->exists();

        if ($exists)
            return back()->withErrors(['appointment_date' => 'Doctor already booked at this time']);

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment created');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'appointment_date'=> 'date',
            'status'=> 'in:pending,approved,canceled,completed',
            'notes'=> 'nullable|string',
        ]);

        $appointment->update($validated);
        return redirect()->route('appointments.index')->with('success', 'Updated');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Deleted');
    }
}
