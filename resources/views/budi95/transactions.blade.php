@extends('budi95.layout')
@section('title', 'Transaksi - BUDI95')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Transaksi</h2>
        <p class="mt-1 text-sm text-gray-500">Senarai transaksi subsidi petrol BUDI95 terkini</p>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @php
            $totalLitres = array_sum(array_column($transactions, 'litres'));
            $totalAmount = array_sum(array_column($transactions, 'amount'));
            $totalSubsidies = array_sum(array_column($transactions, 'subsidy'));
        @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Jumlah Liter Dijual</p>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalLitres, 1) }}L</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Jumlah Jualan (RM)</p>
            <p class="text-2xl font-bold text-gray-900">RM {{ number_format($totalAmount, 2) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Jumlah Subsidi (RM)</p>
            <p class="text-2xl font-bold text-emerald-600">RM {{ number_format($totalSubsidies, 2) }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tarikh</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penerima</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stesen Minyak</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Liter</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah (RM)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subsidi (RM)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $txn)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap text-sm font-mono text-gray-600">{{ $txn['id'] }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ $txn['date'] }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $txn['recipient'] }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ $txn['station'] }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ number_format($txn['litres'], 1) }}L</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">RM {{ number_format($txn['amount'], 2) }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm font-medium text-emerald-600">RM {{ number_format($txn['subsidy'], 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                            Tiada transaksi ditemui.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
