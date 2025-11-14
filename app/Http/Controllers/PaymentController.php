<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Visit;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('visit')->paginate(20);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $visits = Visit::with('appointment.patient.user')->get();
        return view('payments.create', compact('visits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,insurance',
        ]);

        Payment::create([
            'visit_id' => $validated['visit_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'paid',
        ]);

        return redirect()->route('payments.index')->with('success', 'Payment recorded');
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'numeric',
            'payment_method' => 'in:cash,card,insurance',
            'status' => 'in:paid,unpaid',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'Updated');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Deleted');
    }
}
