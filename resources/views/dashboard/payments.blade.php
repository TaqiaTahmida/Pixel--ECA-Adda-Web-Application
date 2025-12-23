@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Billing</p>
            <h2 class="text-2xl font-semibold text-gray-900">Payment History</h2>
            <p class="text-gray-600">Review your recent transactions and package details.</p>
        </div>
        <a href="{{ route('dashboard.index') }}"
           class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
            Back to Dashboard
        </a>
    </div>

    @if($payments->isEmpty())
        <p class="text-gray-500">No payment records found.</p>
    @else
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="p-4 text-left">Package</th>
                        <th class="p-4 text-left">Amount</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr class="border-t">
                            <td class="p-4">{{ strtoupper($payment->package_type) }}</td>
                            <td class="p-4">৳ {{ $payment->amount }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    {{ $payment->status === 'paid'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="p-4">{{ $payment->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
