@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow p-8 text-center">
        <h2 class="text-2xl font-bold mb-4">Complete Your Payment</h2>

        <p class="text-gray-600 mb-6">
            Amount to pay:
            <span class="text-orange-500 font-semibold">
                BDT {{ $amount }}
            </span>
        </p>

        <form action="{{ route('payment.create') }}" method="POST">
            @csrf
            <button class="w-full py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600">
                Pay with Stripe
            </button>
        </form>
    </div>
</div>
@endsection
