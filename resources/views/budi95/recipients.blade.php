@extends('budi95.layout')
@section('title', 'Penerima - BUDI95')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Senarai Penerima</h2>
            <p class="mt-1 text-sm text-gray-500">Senarai penuh penerima subsidi petrol BUDI95</p>
        </div>
        <div class="mt-3 sm:mt-0 flex space-x-3">
            <form method="GET" action="{{ route('budi95.recipients') }}" class="flex space-x-2">
                <select name="state" class="rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                    <option value="all">Semua Negeri</option>
                    @foreach($states as $s)
                        <option value="{{ $s }}" {{ $selectedState === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition-colors">
                    Tapis
                </button>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Jumlah Penerima</p>
            <p class="text-2xl font-bold text-gray-900">{{ count($recipients) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Layak</p>
            <p class="text-2xl font-bold text-green-600">{{ count(array_filter($recipients, fn($r) => $r['status'] === 'Layak')) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Tidak Layak</p>
            <p class="text-2xl font-bold text-red-600">{{ count(array_filter($recipients, fn($r) => $r['status'] !== 'Layak')) }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. MyKad</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Negeri</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kuota (Liter)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Digunakan (Liter)</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Baki (Liter)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recipients as $i => $recipient)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $recipient['name'] }}</div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600 font-mono">{{ $recipient['mykad'] }}</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ $recipient['state'] }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($recipient['status'] === 'Layak')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Layak
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Tidak Layak
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ number_format($recipient['quota']) }}L</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-600">{{ number_format($recipient['used']) }}L</td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm font-medium">
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
                        <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">
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
