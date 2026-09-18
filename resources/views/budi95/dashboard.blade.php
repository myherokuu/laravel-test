@extends('budi95.layout')
@section('title', 'Ringkasan - BUDI95')

@section('head')
<style>
    .card-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 25px -5px rgba(0,0,0,0.1); }
    .card-hover { transition: all 0.2s ease; }
</style>
@endsection

@section('content')
<div x-data="{ showFilters: true }" class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Ringkasan BUDI95</h2>
            <p class="mt-1 text-sm text-gray-500">Paparan ringkas program subsidi petrol BUDI95</p>
        </div>
        <div class="mt-3 sm:mt-0">
            <button @click="showFilters = !showFilters" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Tapisan
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div x-show="showFilters" x-transition class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:p-6">
        <form method="GET" action="{{ route('budi95.dashboard') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Month Filter -->
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                <select name="month" id="month" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                    <option value="">Semua Bulan</option>
                    @foreach($months as $i => $m)
                        <option value="{{ $i + 1 }}" {{ $selectedMonth == ($i + 1) ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Year Filter -->
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="year" id="year" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <!-- State Filter -->
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Negeri</label>
                <select name="state" id="state" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                    <option value="all">Semua Negeri</option>
                    @foreach($states as $s)
                        <option value="{{ $s }}" {{ $selectedState === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Apply Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <!-- Jumlah Penerima -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500">Jumlah Penerima</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalRecipients) }}</p>
                    <p class="text-xs text-green-600 mt-1">{{ number_format($eligibleRecipients) }} layak</p>
                </div>
            </div>
        </div>

        <!-- Jumlah Subsidi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500">Jumlah Subsidi (RM)</p>
                    <p class="text-2xl font-bold text-gray-900">RM {{ number_format($totalSubsidy, 2) }}</p>
                    <p class="text-xs text-gray-500 mt-1">@ RM{{ number_format($config['subsidy_rate_per_litre'], 2) }}/liter</p>
                </div>
            </div>
        </div>

        <!-- Penggunaan Petrol -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500">Penggunaan Petrol (Liter)</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalUsed) }}</p>
                    <p class="text-xs text-gray-500 mt-1">dipotong dari kuota</p>
                </div>
            </div>
        </div>

        <!-- Baki Kelayakan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500">Baki Kelayakan (Liter)</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($bakiKelayakan) }}</p>
                    <p class="text-xs text-gray-500 mt-1">kuota bulanan: {{ number_format($config['monthly_quota_litres']) }}L</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
        <!-- Monthly Petrol Usage Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 lg:p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Penggunaan Petrol Bulanan</h3>
            <div class="relative" style="height: 280px;">
                <canvas id="monthlyUsageChart"></canvas>
            </div>
        </div>

        <!-- Subsidy by State Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 lg:p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4">Taburan Subsidi Mengikut Negeri</h3>
            <div class="relative" style="height: 280px;">
                <canvas id="subsidyByStateChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recipient Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-5 lg:px-6 py-4 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-800">Senarai Penerima Terkini</h3>
            <p class="text-sm text-gray-500 mt-1">Senarai penerima subsidi petrol BUDI95</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                        <th class="px-5 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. MyKad</th>
                        <th class="px-5 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Negeri</th>
                        <th class="px-5 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-5 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kuota Bulanan</th>
                        <th class="px-5 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Petrol Digunakan</th>
                        <th class="px-5 lg:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Baki</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recipients as $recipient)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 lg:px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $recipient['name'] }}</div>
                        </td>
                        <td class="px-5 lg:px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600 font-mono">{{ $recipient['mykad'] }}</span>
                        </td>
                        <td class="px-5 lg:px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600">{{ $recipient['state'] }}</span>
                        </td>
                        <td class="px-5 lg:px-6 py-4 whitespace-nowrap">
                            @if($recipient['status'] === 'Layak')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Layak
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                    Tidak Layak
                                </span>
                            @endif
                        </td>
                        <td class="px-5 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ number_format($recipient['quota']) }}L
                        </td>
                        <td class="px-5 lg:px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ number_format($recipient['used']) }}L
                        </td>
                        <td class="px-5 lg:px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @php $baki = $recipient['quota'] - $recipient['used']; @endphp
                            @if($baki <= 0)
                                <span class="text-red-600">{{ number_format($baki) }}L</span>
                            @elseif($baki < 50)
                                <span class="text-amber-600">{{ number_format($baki) }}L</span>
                            @else
                                <span class="text-green-600">{{ number_format($baki) }}L</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                            Tiada data penerima ditemui.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('head')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Usage Chart
    const monthlyCtx = document.getElementById('monthlyUsageChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: @json(array_keys($monthlyUsage)),
            datasets: [{
                label: 'Penggunaan (Liter)',
                data: @json(array_values($monthlyUsage)),
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toLocaleString() + ' liter';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Subsidy by State Chart
    const stateCtx = document.getElementById('subsidyByStateChart').getContext('2d');
    const stateLabels = @json(array_keys($subsidyByState));
    const stateData = @json(array_values($subsidyByState));
    const colors = [
        '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6',
        '#06b6d4', '#f97316', '#ec4899', '#14b8a6', '#6366f1',
        '#84cc16', '#e11d48', '#0ea5e9'
    ];

    new Chart(stateCtx, {
        type: 'doughnut',
        data: {
            labels: stateLabels,
            datasets: [{
                data: stateData,
                backgroundColor: colors.slice(0, stateLabels.length),
                borderWidth: 2,
                borderColor: '#ffffff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        padding: 8,
                        font: { size: 11 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': RM ' + context.parsed.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
