<?php

namespace App\Helpers;

class HtmlSanitizer
{
    /**
     * Daftar tag HTML yang diizinkan (aman untuk output CKEditor).
     */
    private static array $allowedTags = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
        'ul', 'ol', 'li',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'a', 'img', 'figure', 'figcaption',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td',
        'blockquote', 'pre', 'code',
        'span', 'div', 'hr', 'sub', 'sup',
    ];

    /**
     * Atribut HTML yang diizinkan per tag.
     */
    private static array $allowedAttributes = [
        'a'     => ['href', 'target', 'rel', 'title'],
        'img'   => ['src', 'alt', 'width', 'height', 'style', 'class'],
        'td'    => ['colspan', 'rowspan', 'style'],
        'th'    => ['colspan', 'rowspan', 'style', 'scope'],
        'table' => ['style', 'class', 'border'],
        'span'  => ['style', 'class'],
        'div'   => ['style', 'class'],
        'figure'=> ['style', 'class'],
        'p'     => ['style', 'class'],
        'h1'    => ['style', 'class'],
        'h2'    => ['style', 'class'],
        'h3'    => ['style', 'class'],
        'h4'    => ['style', 'class'],
        'h5'    => ['style', 'class'],
        'h6'    => ['style', 'class'],
        'ol'    => ['style', 'class', 'type'],
        'ul'    => ['style', 'class'],
        'li'    => ['style', 'class'],
        'blockquote' => ['style', 'class'],
        'pre'   => ['class'],
        'code'  => ['class'],
    ];

    /**
     * Sanitasi HTML dari CKEditor — hapus tag dan atribut berbahaya.
     */
    public static function sanitize(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // 1. Hapus blok script/style dan tag HTML berbahaya lainnya.
        $html = preg_replace('/<(script|style)\b[^>]*>.*?<\/\1>/is', '', $html);

        $tagList = implode('><', self::$allowedTags);
        $html = strip_tags($html, '<' . $tagList . '>');

        // 2. Hapus semua event handler (on*) dan javascript: URI
        $html = self::removeEventHandlers($html);

        // 3. Hapus atribut yang tidak diizinkan
        $html = self::filterAttributes($html);

        return $html;
    }

    /**
     * Hapus semua atribut event handler JavaScript (onclick, onerror, onload, dll.)
     * dan URI javascript: dari href/src.
     */
    private static function removeEventHandlers(string $html): string
    {
        // Hapus on* event handlers (onclick, onerror, onload, onmouseover, dll.)
        $html = preg_replace(
            '/\s+on\w+\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]*)/i',
            '',
            $html
        );

        // Hapus href="javascript:..." dan src="javascript:..."
        $html = preg_replace(
            '/(href|src)\s*=\s*(?:"|\')?\s*javascript\s*:[^"\'>\s]*/i',
            '$1=""',
            $html
        );

        // Hapus data: URI pada src (kecuali data:image yang aman)
        $html = preg_replace(
            '/src\s*=\s*(?:"|\')?\s*data\s*:(?!image\/)[^"\'>\s]*/i',
            'src=""',
            $html
        );

        // Hapus expression() dan url(javascript:) dalam style
        $html = preg_replace(
            '/style\s*=\s*"[^"]*expression\s*\([^)]*\)[^"]*"/i',
            '',
            $html
        );

        $html = preg_replace(
            '/style\s*=\s*"[^"]*javascript\s*:[^"]*"/i',
            '',
            $html
        );

        return $html;
    }

    /**
     * Filter atribut HTML — hanya izinkan atribut yang ada di whitelist.
     */
    private static function filterAttributes(string $html): string
    {
        // Proses setiap tag HTML yang ditemukan
        return preg_replace_callback(
            '/<(\w+)((?:\s+[^>]*?)?)(\s*\/?\s*>)/s',
            function ($matches) {
                $tag = strtolower($matches[1]);
                $attributes = $matches[2];
                $closing = $matches[3];

                // Jika tag tidak punya atribut yang diizinkan, hapus semua atribut
                if (!isset(self::$allowedAttributes[$tag])) {
                    return '<' . $tag . $closing;
                }

                $allowed = self::$allowedAttributes[$tag];
                $cleanAttributes = '';

                // Extract dan filter atribut
                preg_match_all(
                    '/\s+(\w[\w-]*)\s*=\s*(?:"([^"]*)"|\'([^\']*)\'|(\S+))/s',
                    $attributes,
                    $attrMatches,
                    PREG_SET_ORDER
                );

                foreach ($attrMatches as $attr) {
                    $attrName = strtolower($attr[1]);
                    $attrValue = $attr[2] ?? $attr[3] ?? $attr[4] ?? '';

                    if (in_array($attrName, $allowed)) {
                        // Sanitasi nilai style untuk mencegah CSS injection
                        if ($attrName === 'style') {
                            $attrValue = self::sanitizeStyle($attrValue);
                        }

                        // Sanitasi href untuk mencegah javascript: URI
                        if ($attrName === 'href' || $attrName === 'src') {
                            if (preg_match('/^\s*javascript\s*:/i', $attrValue)) {
                                continue;
                            }
                        }

                        $cleanAttributes .= ' ' . $attrName . '="' . htmlspecialchars($attrValue, ENT_QUOTES, 'UTF-8', false) . '"';
                    }
                }

                return '<' . $tag . $cleanAttributes . $closing;
            },
            $html
        );
    }

    /**
     * Sanitasi nilai CSS style — hapus expression(), javascript:, dll.
     */
    private static function sanitizeStyle(string $style): string
    {
        // Hapus expression()
        $style = preg_replace('/expression\s*\([^)]*\)/i', '', $style);
        // Hapus javascript: dan vbscript:
        $style = preg_replace('/(?:javascript|vbscript)\s*:/i', '', $style);
        // Hapus behavior:
        $style = preg_replace('/behavior\s*:/i', '', $style);
        // Hapus -moz-binding
        $style = preg_replace('/-moz-binding\s*:/i', '', $style);
        // Hapus url() yang mencurigakan
        $style = preg_replace('/url\s*\(\s*["\']?\s*(?:javascript|data(?!:image))[^)]*\)/i', '', $style);

        return $style;
    }
}
