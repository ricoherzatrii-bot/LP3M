<?php

namespace Tests\Feature;

use App\Helpers\HtmlSanitizer;
use Tests\TestCase;

class XssSanitizationTest extends TestCase
{

    public function test_html_sanitizer_removes_script_and_event_handlers(): void
    {
        $payload = '<p onclick="alert(1)">Hello</p><script>alert("xss")</script><a href="javascript:alert(1)">click</a><img src="x" onerror="alert(1)">';

        $sanitized = HtmlSanitizer::sanitize($payload);

        $this->assertStringNotContainsString('<script', $sanitized);
        $this->assertStringNotContainsString('onclick=', $sanitized);
        $this->assertStringNotContainsString('javascript:', $sanitized);
        $this->assertStringNotContainsString('onerror=', $sanitized);
    }

    public function test_sanitized_content_is_safe_for_blade_rendering(): void
    {
        $payload = '<p class="text-red-500">Safe content</p><img src="/storage/test.png" alt="Test"><script>alert(1)</script>';

        $sanitized = HtmlSanitizer::sanitize($payload);

        $this->assertStringContainsString('Safe content', $sanitized);
        $this->assertStringContainsString('<img', $sanitized);
        $this->assertStringNotContainsString('<script', $sanitized);
        $this->assertStringNotContainsString('alert(1)', $sanitized);
    }

    public function test_csp_header_is_present_on_web_routes(): void
    {
        $response = $this->get('/');
        
        $response->assertHeader('Content-Security-Policy');
        $cspHeader = $response->headers->get('Content-Security-Policy');
        
        $this->assertStringContainsString("default-src 'self'", $cspHeader);
    }
    
    public function test_html_sanitizer_removes_dangerous_embed_tags(): void
    {
        $payload = '<iframe src="javascript:alert(1)"></iframe><object data="http://evil.com"></object><embed src="http://evil.com">';
        $sanitized = HtmlSanitizer::sanitize($payload);
        
        $this->assertStringNotContainsString('<iframe', $sanitized);
        $this->assertStringNotContainsString('<object', $sanitized);
        $this->assertStringNotContainsString('<embed', $sanitized);
    }
}
