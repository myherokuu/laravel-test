<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\InfoPhpController;

class InfoPhpControllerTest extends TestCase
{
    /**
     * index() returns the infophp.index view with the expected data.
     */
    public function test_index_returns_infophp_view_with_php_info_data()
    {
        $controller = new InfoPhpController();

        $view = $controller->index();

        $this->assertEquals('infophp.index', $view->name());

        $data = $view->getData();

        $this->assertEquals(phpversion(), $data['phpVersion']);
        $this->assertEquals(PHP_OS, $data['phpOs']);
        $this->assertEquals(php_sapi_name(), $data['phpSapi']);
        $this->assertEquals(PHP_BINARY, $data['phpBinary']);
    }

    /**
     * index() provides non-empty extensions and key ini settings.
     */
    public function test_index_provides_extensions_and_ini_settings()
    {
        $controller = new InfoPhpController();

        $data = $controller->index()->getData();

        $this->assertIsArray($data['extensions']);
        $this->assertNotEmpty($data['extensions']);
        $this->assertContains('date', $data['extensions']);

        $this->assertIsArray($data['iniSettings']);
        $this->assertArrayHasKey('memory_limit', $data['iniSettings']);
        $this->assertEquals(ini_get('memory_limit'), $data['iniSettings']['memory_limit']);
    }
}