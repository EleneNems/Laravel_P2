<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
{
    $query = Doctor::with('user');

    if ($request->specialization) {
        $query->where('specialization', 'like', '%' . $request->specialization . '%');
    }

    if ($request->keyword) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->keyword . '%');
        });
    }

    $doctors = $query->paginate(10);

    return view('doctors.index', compact('doctors'));
}


    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:users,email',
            'specialization'=> 'required|string',
            'room_number'=> 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt('password'),
            'role'     => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'specialization'=> $validated['specialization'],
            'room_number'=> $validated['room_number'] ?? null,
        ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor added');
    }

    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'specialization'=> 'required',
            'room_number'=> 'nullable|string',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctors.index')->with('success', 'Updated');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();
        return redirect()->route('doctors.index')->with('success', 'Deleted');
    }
}
