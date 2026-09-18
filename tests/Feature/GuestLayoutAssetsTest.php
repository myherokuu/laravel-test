<?php

namespace Tests\Feature;

use Tests\TestCase;

class GuestLayoutAssetsTest extends TestCase
{
    /**
     * T-003: The @vite directive is a Laravel 9.19+ feature. On Laravel 8 it is
     * rendered as literal text, so guest auth pages must reference compiled
     * assets through the Laravel 8-native mix() helper instead.
     *
     * @dataProvider guestAuthPageProvider
     * @return void
     */
    public function test_guest_auth_pages_link_compiled_mix_assets($path)
    {
        $response = $this->get($path);

        $response->assertStatus(200);
        $response->assertDontSee('@vite');
        $response->assertSee('<link rel="stylesheet" href="' . mix('css/app.css') . '">', false);
        $response->assertSee('<script src="' . mix('js/app.js') . '" defer></script>', false);
    }

    public function guestAuthPageProvider()
    {
        return [
            'login page'    => ['/login'],
            'register page' => ['/register'],
        ];
    }

    /**
     * T-003: The compiled assets referenced by the mix() helper must exist
     * on disk so pages render styled even without a watcher running.
     *
     * @return void
     */
    public function test_compiled_assets_exist_on_disk()
    {
        $manifest = json_decode(file_get_contents(public_path('mix-manifest.json')), true);

        $this->assertIsArray($manifest);
        $this->assertArrayHasKey('/js/app.js', $manifest);
        $this->assertArrayHasKey('/css/app.css', $manifest);

        $this->assertFileExists(public_path('css/app.css'));
        $this->assertFileExists(public_path('js/app.js'));

        // Tailwind directives must have been compiled, not passed through raw.
        $css = file_get_contents(public_path('css/app.css'));
        $this->assertStringNotContainsString('@tailwind base', $css);
        $this->assertStringContainsString('.font-sans', $css);
    }
}