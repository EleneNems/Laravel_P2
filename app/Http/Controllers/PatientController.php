<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
{
    $query = Patient::with('user');

    if ($request->keyword) {
        $query->where(function ($q) use ($request) {
            $q->whereHas('user', function ($u) use ($request) {
                $u->where('name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('email', 'like', '%' . $request->keyword . '%');
            })
            ->orWhere('insurance_number', 'like', '%' . $request->keyword . '%');
        });
    }

    $patients = $query->paginate(10);

    return view('patients.index', compact('patients'));
}


    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users,email',
            'phone'=> 'nullable|string',
            'address'=> 'nullable|string',
            'insurance_number'=> 'nullable|string',
            'emergency_contact'=> 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt('password'),
            'role'     => 'patient',
            'phone'    => $validated['phone'] ?? null,
            'address'  => $validated['address'] ?? null,
        ]);

        Patient::create([
            'user_id' => $user->id,
            'insurance_number' => $validated['insurance_number'] ?? null,
            'emergency_contact'=> $validated['emergency_contact'] ?? null,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient created');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'insurance_number'=> 'nullable|string',
            'emergency_contact'=> 'nullable|string',
        ]);

        $patient->update($validated);
        return redirect()->route('patients.index')->with('success', 'Updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->user->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted');
    }
}
