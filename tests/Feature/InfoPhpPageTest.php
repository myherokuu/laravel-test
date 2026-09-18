<?php

namespace Tests\Feature;

use Tests\TestCase;

class InfoPhpPageTest extends TestCase
{
    /**
     * The info page responds successfully.
     */
    public function test_infophp_page_returns_ok()
    {
        $this->get('/infophp')->assertStatus(200);
    }

    /**
     * The info page shows the PHP version, OS and SAPI.
     */
    public function test_infophp_page_shows_runtime_information()
    {
        $this->get('/infophp')
            ->assertSee(phpversion())
            ->assertSee(PHP_OS)
            ->assertSee(php_sapi_name());
    }

    /**
     * The info page lists loaded extensions.
     */
    public function test_infophp_page_shows_loaded_extensions()
    {
        $response = $this->get('/infophp');
        $response->assertSee('Loaded Extensions');

        foreach (array_slice(get_loaded_extensions(), 0, 5) as $extension) {
            $response->assertSee($extension);
        }
    }

    /**
     * The info page lists key ini settings with their current values.
     */
    public function test_infophp_page_shows_key_ini_settings()
    {
        $response = $this->get('/infophp');
        $response->assertSee('Key ini Settings');

        foreach (['memory_limit', 'max_execution_time', 'upload_max_filesize', 'post_max_size'] as $key) {
            $response->assertSee($key);
            $response->assertSee(ini_get($key));
        }
    }
}