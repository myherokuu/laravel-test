<?php

namespace Tests\Feature;

use Tests\TestCase;

class Artifact721726Test extends TestCase
{
    private string $path;

    protected function setUp(): void
    {
        parent::setUp();
        $this->path = base_path('artifact-721726.html');
    }

    public function test_artifact_file_exists(): void
    {
        $this->assertFileExists($this->path, 'artifact-721726.html must exist at project root');
    }

    public function test_artifact_is_self_contained_html(): void
    {
        $html = file_get_contents($this->path);
        $this->assertStringContainsString('<!doctype html>', strtolower($html));
        $this->assertStringContainsString('<style>', $html);
        $this->assertStringContainsString('</html>', $html);
        // no external framework CDN required — self-contained
        $this->assertGreaterThan(10000, strlen($html), 'Artifact should be inlined and not trivially small');
    }

    public function test_artifact_contains_three_column_layout_and_header(): void
    {
        $html = file_get_contents($this->path);
        $this->assertStringContainsString('Prokhas AI', $html);
        $this->assertStringContainsString('Online Chat', $html);
        $this->assertStringContainsString('Knowledge Items', $html);
        $this->assertStringContainsString('Prokhas AI Assistant', $html);
        $this->assertStringContainsString('Search conversations', $html);
        $this->assertStringContainsString('Search knowledge items', $html);
    }

    public function test_artifact_contains_expected_colors_and_components(): void
    {
        $html = file_get_contents($this->path);
        // primary/secondary/background
        $this->assertStringContainsString('#6366F1', $html);
        $this->assertStringContainsString('#7C3AED', $html);
        $this->assertStringContainsString('#F1F5F9', $html);
        // key components
        $this->assertStringContainsString('Super Admin', $html);
        $this->assertStringContainsString('Logout', $html);
        $this->assertStringContainsString('Public Chat Visitor', $html);
        $this->assertStringContainsString('Prokhas Bot', $html);
        $this->assertStringContainsString('Viewing in read-only mode', $html);
    }

    public function test_artifact_contains_knowledge_cards(): void
    {
        $html = file_get_contents($this->path);
        $this->assertStringContainsString('How to report an IT issue', $html);
        $this->assertStringContainsString('IT support contact', $html);
        $this->assertStringContainsString('Leave policy', $html);
        $this->assertStringContainsString('On', $html);
        $this->assertStringContainsString('IT Department', $html);
    }
}
