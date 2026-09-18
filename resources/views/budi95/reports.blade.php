@extends('budi95.layout')
@section('title', 'Laporan - BUDI95')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Laporan</h2>
        <p class="mt-1 text-sm text-gray-500">Laporan ringkasan program subsidi petrol BUDI95</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-500">Kadar Subsidi</p>
                    <p class="text-lg font-bold text-gray-900">RM {{ number_format($config['subsidy_rate_per_litre'], 2) }}/liter</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-500">Harga Pasaran</p>
                    <p class="text-lg font-bold text-gray-900">RM {{ number_format($config['petrol_price_per_litre'], 2) }}/liter</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-500">Jumlah Subsidi Keseluruhan</p>
                    <p class="text-lg font-bold text-gray-900">RM {{ number_format($totalSubsidy) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Subsidy Breakdown by State -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 lg:p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Pecahan Subsidi Mengikut Negeri</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Negeri</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Subsidi (RM)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peratus</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Anggaran Liter</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $sorted = collect($subsidyByState)->sortDesc()->toArray();
                    @endphp
                    @foreach($sorted as $state => $amount)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $state }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">RM {{ number_format($amount) }}</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ number_format(($amount / $totalSubsidy) * 100, 1) }}%</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ number_format($amount / $config['subsidy_rate_per_litre'], 0) }}L</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="2" class="px-5 py-4 text-sm font-bold text-gray-900">Jumlah</td>
                        <td class="px-5 py-4 text-sm font-bold text-gray-900">RM {{ number_format($totalSubsidy) }}</td>
                        <td class="px-5 py-4 text-sm font-bold text-gray-900">100%</td>
                        <td class="px-5 py-4 text-sm font-bold text-gray-900">{{ number_format($totalSubsidy / $config['subsidy_rate_per_litre'], 0) }}L</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Configurable Rules -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 lg:p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Peraturan & Konfigurasi Demo</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-500">Kuota Bulanan</p>
                <p class="text-lg font-semibold text-gray-900">{{ number_format($config['monthly_quota_litres']) }} liter / bulan</p>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-500">Kadar Subsidi</p>
                <p class="text-lg font-semibold text-gray-900">RM {{ number_format($config['subsidy_rate_per_litre'], 2) }} / liter</p>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-500">Harga Petrol Pasaran</p>
                <p class="text-lg font-semibold text-gray-900">RM {{ number_format($config['petrol_price_per_litre'], 2) }} / liter</p>
            </div>
            <div class="border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-500">Harga Selepas Subsidi</p>
                @php $hargaSelepas = $config['petrol_price_per_litre'] - $config['subsidy_rate_per_litre']; @endphp
                <p class="text-lg font-semibold text-green-600">RM {{ number_format($hargaSelepas, 2) }} / liter</p>
            </div>
        </div>
    </div>
</div>
@endsection
