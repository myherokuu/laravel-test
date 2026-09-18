<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Budi95DashboardTest extends TestCase
{
    /**
     * Test that unauthenticated users are redirected to login.
     */
    public function test_unauthenticated_redirect_to_login()
    {
        $response = $this->get('/budi95');
        $response->assertRedirect('/login');
    }

    /**
     * Test that authenticated users can access the dashboard.
     */
    public function test_authenticated_can_access_dashboard()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95');
        $response->assertStatus(200);
        $response->assertSee('Ringkasan BUDI95');
        $response->assertSee('Jumlah Penerima');
        $response->assertSee('Jumlah Subsidi');
        $response->assertSee('Penggunaan Petrol');
        $response->assertSee('Baki Kelayakan');
    }

    /**
     * Test that dashboard contains summary cards.
     */
    public function test_dashboard_has_summary_cards()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95');
        $response->assertStatus(200);
        $response->assertSee('card-hover');
        $response->assertSee('Jumlah Penerima');
        $response->assertSee('(RM)');
        $response->assertSee('(Liter)');
    }

    /**
     * Test that dashboard has chart canvases.
     */
    public function test_dashboard_has_charts()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95');
        $response->assertStatus(200);
        $response->assertSee('monthlyUsageChart');
        $response->assertSee('subsidyByStateChart');
        $response->assertSee('Penggunaan Petrol Bulanan');
        $response->assertSee('Taburan Subsidi Mengikut Negeri');
    }

    /**
     * Test that dashboard has filter form.
     */
    public function test_dashboard_has_filters()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95');
        $response->assertStatus(200);
        $response->assertSee('Tapisan');
        $response->assertSee('Bulan');
        $response->assertSee('Tahun');
        $response->assertSee('Negeri');
        $response->assertSee('Semua Bulan');
        $response->assertSee('Semua Negeri');
    }

    /**
     * Test that state filter works.
     */
    public function test_state_filter_works()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95?state=Selangor');
        $response->assertStatus(200);
        $response->assertSee('Selangor');
        $response->assertSee('selected');
    }

    /**
     * Test that dashboard has recipient table.
     */
    public function test_dashboard_has_recipient_table()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95');
        $response->assertStatus(200);
        $response->assertSee('Senarai Penerima Terkini');
        $response->assertSee('Ahmad bin Abdullah');
        $response->assertSee('Layak');
        $response->assertSee('Tidak Layak');
        // MyKad numbers should be present (masked format)
        $response->assertSee('800101-01-1234');
    }

    /**
     * Test recipients page loads correctly.
     */
    public function test_recipients_page()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95/recipients');
        $response->assertStatus(200);
        $response->assertSee('Senarai Penerima');
        $response->assertSee('Ahmad bin Abdullah');
        $response->assertSee('Layak');
    }

    /**
     * Test recipients page filter.
     */
    public function test_recipients_page_filter()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95/recipients?state=Kuala Lumpur');
        $response->assertStatus(200);
        $response->assertSee('Kuala Lumpur');
        $response->assertSee('selected');
    }

    /**
     * Test transactions page loads correctly.
     */
    public function test_transactions_page()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95/transactions');
        $response->assertStatus(200);
        $response->assertSee('Transaksi');
        $response->assertSee('TXN-001');
        $response->assertSee('Petronas KLCC');
    }

    /**
     * Test reports page loads correctly.
     */
    public function test_reports_page()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95/reports');
        $response->assertStatus(200);
        $response->assertSee('Laporan');
        $response->assertSee('Peraturan');
        $response->assertSee('Kuota Bulanan');
    }

    /**
     * Test sidebar navigation links are present.
     */
    public function test_sidebar_has_navigation()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/budi95');
        $response->assertStatus(200);
        $response->assertSee('Ringkasan');
        $response->assertSee('Penerima');
        $response->assertSee('Transaksi');
        $response->assertSee('Laporan');
        $response->assertSee('Log Keluar');
    }

    /**
     * Test dashboard redirect from /dashboard.
     */
    public function test_dashboard_redirect()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertRedirect('/budi95');
    }
}
