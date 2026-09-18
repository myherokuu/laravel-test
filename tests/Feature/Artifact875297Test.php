<?php

namespace Tests\Feature;

use Tests\TestCase;

class Artifact875297Test extends TestCase
{
    private string $path;

    protected function setUp(): void
    {
        parent::setUp();
        $this->path = base_path('artifact-875297.html');
    }

    public function test_artifact_file_exists(): void
    {
        $this->assertFileExists($this->path, 'artifact-875297.html must exist at project root');
    }

    public function test_artifact_is_self_contained_minimal_html(): void
    {
        $html = file_get_contents($this->path);
        $this->assertStringContainsString('<!doctype html>', strtolower($html));
        $this->assertStringContainsString('<style>', $html);
        $this->assertStringContainsString('</style>', $html);
        $this->assertStringEndsWith('</html>', $html);
        // no external resources: everything inlined in a single self-contained file
        $this->assertStringNotContainsString('<link', $html);
        $this->assertStringNotContainsString('src=', $html);
    }

    public function test_artifact_has_exactly_one_h1_hello_world(): void
    {
        $html = file_get_contents($this->path);
        $this->assertSame(1, substr_count($html, '<h1>'), 'exactly one h1');
        $this->assertSame(1, substr_count($html, '</h1>'), 'exactly one closing h1');
        $this->assertStringContainsString('<h1>Hello World</h1>', $html);
        $this->assertSame(1, substr_count($html, '<h1>Hello World</h1>'), 'the heading text appears once in the heading itself');
    }

    public function test_artifact_has_no_javascript(): void
    {
        $html = file_get_contents($this->path);
        $this->assertStringNotContainsString('<script', strtolower($html), 'no JS per requirement');
        $this->assertStringNotContainsString('javascript:', strtolower($html));
    }

    public function test_artifact_uses_no_css_framework_or_responsive_defaults(): void
    {
        $html = file_get_contents($this->path);
        // no framework-specific class names or CDN stylesheet pulls
        $this->assertStringNotContainsString('tailwind', strtolower($html));
        $this->assertStringNotContainsString('bootstrap', strtolower($html));
        $this->assertStringNotContainsString('https://', strtolower($html));
        $this->assertLessThan(3000, strlen($html), 'page must stay minimal in size');
    }
}