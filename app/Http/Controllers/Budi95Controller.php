<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Budi95Controller extends Controller
{
    /**
     * Configurable demo values for quotas and eligibility rules.
     */
    protected $config = [
        'monthly_quota_litres'   => 300,   // max litres per recipient per month
        'subsidy_rate_per_litre' => 0.60,  // RM per litre subsidy
        'petrol_price_per_litre' => 2.05,  // market price
        'eligible_states'        => [
            'Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan',
            'Pahang', 'Perak', 'Perlis', 'Penang', 'Sabah',
            'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur',
            'Putrajaya', 'Labuan',
        ],
    ];

    /**
     * Malaysian states list.
     */
    protected $states = [
        'Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan',
        'Pahang', 'Perak', 'Perlis', 'Penang', 'Sabah',
        'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur',
        'Putrajaya', 'Labuan',
    ];

    /**
     * Dummy recipients data.
     */
    protected function getRecipients(): array
    {
        return [
            ['name' => 'Ahmad bin Abdullah',      'mykad' => '800101-01-1234', 'state' => 'Kuala Lumpur',   'status' => 'Layak',      'quota' => 300, 'used' => 245],
            ['name' => 'Siti Nurhaliza binti Mohd', 'mykad' => '850312-05-5678', 'state' => 'Selangor',     'status' => 'Layak',      'quota' => 300, 'used' => 180],
            ['name' => 'Muhammad Irfan bin Razak',  'mykad' => '900515-08-9012', 'state' => 'Johor',       'status' => 'Layak',      'quota' => 300, 'used' => 290],
            ['name' => 'Fatimah binti Yusof',       'mykad' => '780620-10-3456', 'state' => 'Kedah',       'status' => 'Tidak Layak','quota' => 0,   'used' => 0],
            ['name' => 'Mohd Faiz bin Kamarudin',   'mykad' => '920730-06-7890', 'state' => 'Kelantan',    'status' => 'Layak',      'quota' => 300, 'used' => 150],
            ['name' => 'Nurul Aisyah binti Hamid',  'mykad' => '880901-03-2345', 'state' => 'Penang',      'status' => 'Layak',      'quota' => 300, 'used' => 275],
            ['name' => 'Azman bin Hassan',          'mykad' => '750425-07-6789', 'state' => 'Pahang',      'status' => 'Tidak Layak','quota' => 0,   'used' => 0],
            ['name' => 'Nur Syafiqah binti Ali',    'mykad' => '950110-02-0123', 'state' => 'Perak',       'status' => 'Layak',      'quota' => 300, 'used' => 95],
            ['name' => 'Muhammad Hilmi bin Omar',   'mykad' => '820318-04-4567', 'state' => 'Negeri Sembilan','status' => 'Layak',    'quota' => 300, 'used' => 210],
            ['name' => 'Aisha binti Ismail',        'mykad' => '910622-09-8901', 'state' => 'Malacca',     'status' => 'Layak',      'quota' => 300, 'used' => 165],
            ['name' => 'Rizal bin Mahmud',          'mykad' => '860805-11-2345', 'state' => 'Sabah',       'status' => 'Layak',      'quota' => 300, 'used' => 190],
            ['name' => 'Siti Sarah binti Razak',    'mykad' => '930915-06-6789', 'state' => 'Sarawak',     'status' => 'Layak',      'quota' => 300, 'used' => 220],
            ['name' => 'Amirul Hisham bin Zain',    'mykad' => '870214-08-0123', 'state' => 'Terengganu',  'status' => 'Tidak Layak','quota' => 0,   'used' => 0],
            ['name' => 'Nur Aqilah binti Rashid',   'mykad' => '960501-07-4567', 'state' => 'Kuala Lumpur','status' => 'Layak',      'quota' => 300, 'used' => 260],
            ['name' => 'Hafiz bin Ibrahim',         'mykad' => '840610-05-8901', 'state' => 'Selangor',    'status' => 'Layak',      'quota' => 300, 'used' => 175],
            ['name' => 'Nurul Izzah binti Mansor',  'mykad' => '900305-09-2345', 'state' => 'Johor',       'status' => 'Layak',      'quota' => 300, 'used' => 300],
            ['name' => 'Farhan bin Aziz',           'mykad' => '810728-03-6789', 'state' => 'Kedah',       'status' => 'Layak',      'quota' => 300, 'used' => 140],
            ['name' => 'Nurul Huda binti Omar',     'mykad' => '940812-01-0123', 'state' => 'Kelantan',    'status' => 'Layak',      'quota' => 300, 'used' => 200],
            ['name' => 'Azrul bin Mohd Nor',        'mykad' => '830120-10-4567', 'state' => 'Penang',      'status' => 'Layak',      'quota' => 300, 'used' => 255],
            ['name' => 'Nur Syahirah binti Zakaria','mykad' => '970228-06-8901', 'state' => 'Pahang',      'status' => 'Tidak Layak','quota' => 0,   'used' => 0],
        ];
    }

    /**
     * Monthly usage data for charts.
     */
    protected function getMonthlyUsage(): array
    {
        return [
            'Jan'  => 4200,
            'Feb'  => 3800,
            'Mac'  => 4500,
            'Apr'  => 3950,
            'Mei'  => 4300,
            'Jun'  => 4100,
            'Julai'=> 4650,
            'Ogos' => 4400,
            'Sep'  => 4250,
            'Okt'  => 4000,
            'Nov'  => 3700,
            'Dis'  => 4550,
        ];
    }

    /**
     * Subsidy distribution by state for charts.
     */
    protected function getSubsidyByState(): array
    {
        return [
            'Kuala Lumpur'   => 125000,
            'Selangor'       => 180000,
            'Johor'          => 155000,
            'Kedah'          => 95000,
            'Kelantan'       => 85000,
            'Penang'         => 110000,
            'Pahang'         => 78000,
            'Perak'          => 92000,
            'Negeri Sembilan'=> 68000,
            'Malacca'        => 55000,
            'Sabah'          => 72000,
            'Sarawak'        => 82000,
            'Terengganu'     => 48000,
        ];
    }

    /**
     * Transaction data for the transactions page.
     */
    protected function getTransactions(): array
    {
        return [
            ['id' => 'TXN-001', 'date' => '2026-09-01', 'recipient' => 'Ahmad bin Abdullah',       'station' => 'Petronas KLCC',      'litres' => 40.5, 'amount' => 83.03, 'subsidy' => 24.30],
            ['id' => 'TXN-002', 'date' => '2026-09-01', 'recipient' => 'Siti Nurhaliza binti Mohd', 'station' => 'Shell Damansara',    'litres' => 35.0, 'amount' => 71.75, 'subsidy' => 21.00],
            ['id' => 'TXN-003', 'date' => '2026-09-02', 'recipient' => 'Muhammad Irfan bin Razak',  'station' => 'Caltex JB Sentral',  'litres' => 50.0, 'amount' => 102.50,'subsidy' => 30.00],
            ['id' => 'TXN-004', 'date' => '2026-09-02', 'recipient' => 'Nurul Aisyah binti Hamid',  'station' => 'Petronas George Town','litres' => 45.0, 'amount' => 92.25, 'subsidy' => 27.00],
            ['id' => 'TXN-005', 'date' => '2026-09-03', 'recipient' => 'Nur Syafiqah binti Ali',    'station' => 'Shell Melaka',       'litres' => 38.0, 'amount' => 77.90, 'subsidy' => 22.80],
            ['id' => 'TXN-006', 'date' => '2026-09-03', 'recipient' => 'Muhammad Hilmi bin Omar',   'station' => 'Petronas Seremban',  'litres' => 42.5, 'amount' => 87.13, 'subsidy' => 25.50],
            ['id' => 'TXN-007', 'date' => '2026-09-04', 'recipient' => 'Rizal bin Mahmud',          'station' => 'Shell Kota Kinabalu', 'litres' => 30.0, 'amount' => 61.50, 'subsidy' => 18.00],
            ['id' => 'TXN-008', 'date' => '2026-09-04', 'recipient' => 'Siti Sarah binti Razak',    'station' => 'Caltex Kuching',     'litres' => 55.0, 'amount' => 112.75,'subsidy' => 33.00],
            ['id' => 'TXN-009', 'date' => '2026-09-05', 'recipient' => 'Nur Aqilah binti Rashid',   'station' => 'Petronas Bukit Bintang','litres' => 48.0,'amount' => 98.40, 'subsidy' => 28.80],
            ['id' => 'TXN-010', 'date' => '2026-09-05', 'recipient' => 'Hafiz bin Ibrahim',         'station' => 'Shell Shah Alam',    'litres' => 32.0, 'amount' => 65.60, 'subsidy' => 19.20],
            ['id' => 'TXN-011', 'date' => '2026-09-06', 'recipient' => 'Farhan bin Aziz',           'station' => 'Petronas Alor Setar', 'litres' => 28.0,'amount' => 57.40, 'subsidy' => 16.80],
            ['id' => 'TXN-012', 'date' => '2026-09-06', 'recipient' => 'Nurul Huda binti Omar',     'station' => 'Shell Kota Bharu',   'litres' => 44.0, 'amount' => 90.20, 'subsidy' => 26.40],
        ];
    }

    /**
     * Show the BUDI95 overview dashboard.
     */
    public function index(Request $request)
    {
        $recipients = $this->getRecipients();
        $monthlyUsage = $this->getMonthlyUsage();
        $subsidyByState = $this->getSubsidyByState();

        // Filter by state if provided
        $state = $request->input('state');
        if ($state && $state !== 'all') {
            $recipients = array_filter($recipients, fn($r) => $r['state'] === $state);
            // Adjust monthly usage proportionally for filtered state
            $stateRatio = count($recipients) / max(1, count($this->getRecipients()));
            $monthlyUsage = array_map(fn($v) => (int)($v * $stateRatio), $monthlyUsage);
            $subsidyByState = array_filter($subsidyByState, fn($k) => $k === $state, ARRAY_FILTER_USE_KEY);
        }

        $totalRecipients = count($recipients);
        $eligibleRecipients = count(array_filter($recipients, fn($r) => $r['status'] === 'Layak'));
        $totalUsed = array_sum(array_column($recipients, 'used'));
        $totalQuota = array_sum(array_column($recipients, 'quota'));
        $totalSubsidy = round($totalUsed * $this->config['subsidy_rate_per_litre'], 2);
        $bakiKelayakan = $totalQuota - $totalUsed;

        $months = ['Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'];
        $years = [2024, 2025, 2026];

        return view('budi95.dashboard', [
            'totalRecipients'    => $totalRecipients,
            'eligibleRecipients' => $eligibleRecipients,
            'totalSubsidy'       => $totalSubsidy,
            'totalUsed'          => $totalUsed,
            'bakiKelayakan'      => $bakiKelayakan,
            'monthlyUsage'       => $monthlyUsage,
            'subsidyByState'     => $subsidyByState,
            'recipients'         => array_values($recipients),
            'states'             => $this->states,
            'months'             => $months,
            'years'              => $years,
            'selectedState'      => $state ?? 'all',
            'selectedMonth'      => $request->input('month', ''),
            'selectedYear'       => $request->input('year', date('Y')),
            'config'             => $this->config,
        ]);
    }

    /**
     * Show recipients list.
     */
    public function recipients(Request $request)
    {
        $recipients = $this->getRecipients();

        $state = $request->input('state');
        if ($state && $state !== 'all') {
            $recipients = array_filter($recipients, fn($r) => $r['state'] === $state);
        }

        return view('budi95.recipients', [
            'recipients'    => array_values($recipients),
            'states'        => $this->states,
            'selectedState' => $state ?? 'all',
        ]);
    }

    /**
     * Show transactions.
     */
    public function transactions(Request $request)
    {
        $transactions = $this->getTransactions();

        return view('budi95.transactions', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * Show reports.
     */
    public function reports()
    {
        $subsidyByState = $this->getSubsidyByState();
        $totalSubsidy = array_sum($subsidyByState);

        return view('budi95.reports', [
            'subsidyByState' => $subsidyByState,
            'totalSubsidy'   => $totalSubsidy,
            'config'         => $this->config,
        ]);
    }
}
