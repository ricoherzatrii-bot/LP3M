<?php

namespace App\Http\Controllers;

class GalleryControllerBase extends Controller
{
    protected function withSecurityHeaders($response)
    {
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: blob:; font-src 'self' data:; connect-src 'self'; object-src 'none'; base-uri 'self'; frame-ancestors 'none'"
        );

        return $response;
    }

    protected function sanitizeText($value): string
    {
        if ($value === null) {
            return '';
        }

        $stringValue = strip_tags((string) $value);
        $stringValue = trim($stringValue);
        $stringValue = preg_replace('/[\x00-\x1F\x7F]/u', '', $stringValue);

        return $stringValue ?? '';
    }

    protected function sanitizeUrl($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $stringValue = $this->sanitizeText($value);
        if ($stringValue === '') {
            return null;
        }

        if (!preg_match('/^https?:\/\//i', $stringValue)) {
            return null;
        }

        return filter_var($stringValue, FILTER_VALIDATE_URL) ? $stringValue : null;
    }
}
