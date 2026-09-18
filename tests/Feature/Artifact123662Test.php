<?php

namespace Tests\Feature;

use Tests\TestCase;

class Artifact123662Test extends TestCase
{
    private string $path;

    protected function setUp(): void
    {
        parent::setUp();
        $this->path = base_path('artifact-123662.html');
    }

    public function test_artifact_file_exists(): void
    {
        $this->assertFileExists($this->path, 'artifact-123662.html must exist at project root');
    }

    public function test_artifact_is_self_contained_html(): void
    {
        $html = file_get_contents($this->path);
        $this->assertStringContainsString('<!doctype html>', strtolower($html));
        $this->assertStringContainsString('<style>', $html);
        $this->assertStringContainsString('<div id=root></div>', $html);
        $this->assertStringContainsString('</script>', $html);
        $this->assertGreaterThan(10000, strlen($html), 'Artifact should be inlined and not trivially small');
    }

    public function test_artifact_contains_harimalaysia_content(): void
    {
        $html = file_get_contents($this->path);
        $this->assertStringContainsString('HARI MALAYSIA', $html);
        $this->assertStringContainsString('Selamat Hari Malaysia', $html);
        $this->assertStringContainsString('Happy Malaysia Day', $html);
    }

    public function test_main_heading_color_is_pure_red(): void
    {
        $html = file_get_contents($this->path);
        // the hero h1 must carry an explicit pure-red inline color
        $this->assertStringContainsString('clamp(3.4rem, 9vw, 8.2rem)",color:"#ff0000"', $html);
        // the h1 must no longer depend on the dark-jalur-red utility class for its base color
        $this->assertStringNotContainsString(
            'font-display leading-[0.92] text-jalur-red"',
            $html,
            'h1 base color was changed to #ff0000; only the decorative "." accent may stay jalur-red'
        );
    }

    public function test_heading_accent_dot_still_uses_jalur_red(): void
    {
        $html = file_get_contents($this->path);
        // the trailing "." accent inside the heading (and the brand mark) keeps the Jalur Gemilang red
        $this->assertStringContainsString('"text-jalur-red",children:"."', $html);
        // the colour token itself must still be defined in the stylesheet
        $this->assertStringContainsString('.text-jalur-red{', $html);
    }
}