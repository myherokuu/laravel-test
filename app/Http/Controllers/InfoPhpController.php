<?php

namespace App\Http\Controllers;

class InfoPhpController extends Controller
{
    /**
     * Key ini settings surfaced on the info page.
     */
    protected $keyIniSettings = [
        'memory_limit',
        'max_execution_time',
        'max_input_time',
        'upload_max_filesize',
        'post_max_size',
        'date.timezone',
        'display_errors',
        'error_reporting',
        'log_errors',
        'file_uploads',
        'allow_url_fopen',
        'opcache.enable',
        'opcache.enable_cli',
    ];

    /**
     * Show PHP runtime information: version, OS, SAPI, loaded extensions
     * and a few key ini settings.
     */
    public function index()
    {
        $settings = [];

        foreach ($this->keyIniSettings as $key) {
            if (($value = ini_get($key)) !== false) {
                $settings[$key] = $value;
            }
        }

        return view('infophp.index', [
            'phpVersion'  => phpversion(),
            'phpOs'       => PHP_OS,
            'phpSapi'     => php_sapi_name(),
            'phpBinary'   => PHP_BINARY,
            'extensions'  => get_loaded_extensions(),
            'iniSettings' => $settings,
        ]);
    }
}