<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

/**
 * Minimal whitelist-based HTML sanitizer for rich-text article content.
 *
 * Built without a Composer dependency: strips anything that is not an
 * explicitly allowed tag/attribute, removes event handlers and
 * javascript: URIs, keeps only a small safe set of CSS properties from
 * inline styles (alignment and color, which is how Quill.js expresses
 * them), and keeps only known Quill-generated class names (size, font,
 * indent) — never arbitrary classes.
 */
class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'sub', 'sup',
        'a', 'img',
        'ul', 'ol', 'li',
        'blockquote', 'pre', 'code',
        'h2', 'h3', 'h4',
        'span', 'div',
    ];

    private const ALLOWED_ATTRS = [
        'a' => ['href', 'target', 'rel'],
        'img' => ['src', 'alt', 'width', 'height'],
        'span' => ['class'],
        'p' => ['class'],
        'li' => ['class'],
        'ol' => ['class'],
        'ul' => ['class'],
        'pre' => ['class'],
    ];

    private const ALLOWED_CLASS_PATTERN = '/^ql-(size-(small|large|huge)|font-(serif|monospace)|indent-[1-8])$/';

    /** Tags whose content is never safe/meaningful to keep — dropped entirely, not unwrapped. */
    private const STRIP_ENTIRELY = [
        'script', 'style', 'iframe', 'object', 'embed', 'noscript',
        'form', 'input', 'button', 'textarea', 'select', 'link', 'meta',
    ];

    public static function clean(?string $html): string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return '';
        }

        $dom = new DOMDocument();
        $previous = libxml_use_internal_errors(true);

        $wrapped = '<?xml encoding="utf-8" ?><div id="sanitizer-root">'.$html.'</div>';
        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $xpath = new DOMXPath($dom);
        $root = $xpath->query('//div[@id="sanitizer-root"]')->item(0);

        if (! $root) {
            return '';
        }

        self::cleanChildren($root);

        $inner = '';
        foreach ($root->childNodes as $child) {
            $inner .= $dom->saveHTML($child);
        }

        return trim($inner);
    }

    private static function cleanChildren(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (in_array($tag, self::STRIP_ENTIRELY, true)) {
                    $node->removeChild($child);

                    continue;
                }

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    // Unwrap other disallowed tags instead of deleting their content.
                    while ($child->firstChild) {
                        $node->insertBefore($child->firstChild, $child);
                    }
                    $node->removeChild($child);

                    continue;
                }

                self::sanitizeAttributes($child, $tag);
                self::cleanChildren($child);

                if ($tag === 'img' && ! $child->getAttribute('src')) {
                    $node->removeChild($child);
                }

                continue;
            }

            if (in_array($child->nodeType, [XML_COMMENT_NODE, XML_PI_NODE], true)) {
                $node->removeChild($child);
            }
        }
    }

    private static function sanitizeAttributes(DOMElement $el, string $tag): void
    {
        $allowed = self::ALLOWED_ATTRS[$tag] ?? [];

        foreach (iterator_to_array($el->attributes ?? []) as $attr) {
            $name = strtolower($attr->name);

            if ($name === 'style') {
                $clean = self::sanitizeStyle($attr->value);
                $clean === '' ? $el->removeAttribute('style') : $el->setAttribute('style', $clean);

                continue;
            }

            if ($name === 'class' && in_array('class', $allowed, true)) {
                $clean = self::sanitizeClass($attr->value);
                $clean === '' ? $el->removeAttribute('class') : $el->setAttribute('class', $clean);

                continue;
            }

            if (str_starts_with($name, 'on') || ! in_array($name, $allowed, true)) {
                $el->removeAttribute($attr->name);

                continue;
            }

            if (in_array($name, ['href', 'src'], true) && preg_match('/^\s*javascript:/i', $attr->value)) {
                $el->removeAttribute($attr->name);
            }
        }

        if ($tag === 'a') {
            $href = $el->getAttribute('href');

            if ($href === '' || preg_match('/^\s*javascript:/i', $href)) {
                $el->removeAttribute('href');
            }

            $el->setAttribute('rel', 'noopener noreferrer');
            $el->setAttribute('target', '_blank');
        }
    }

    private static function sanitizeStyle(string $style): string
    {
        $kept = [];

        foreach (explode(';', $style) as $declaration) {
            $declaration = trim($declaration);

            if ($declaration === '' || ! str_contains($declaration, ':')) {
                continue;
            }

            [$property, $value] = array_map('trim', explode(':', $declaration, 2));
            $property = strtolower($property);

            if ($property === 'text-align' && preg_match('/^(left|right|center|justify)$/i', $value)) {
                $kept[] = 'text-align: '.strtolower($value);

                continue;
            }

            if (in_array($property, ['color', 'background-color'], true) && self::isSafeColorValue($value)) {
                $kept[] = $property.': '.$value;
            }
        }

        return $kept === [] ? '' : implode('; ', $kept).';';
    }

    private static function sanitizeClass(string $class): string
    {
        $kept = array_filter(
            preg_split('/\s+/', trim($class)) ?: [],
            fn (string $token) => $token !== '' && preg_match(self::ALLOWED_CLASS_PATTERN, $token) === 1
        );

        return implode(' ', $kept);
    }

    private static function isSafeColorValue(string $value): bool
    {
        $value = trim($value);

        return (bool) preg_match(
            '/^(#[0-9a-f]{3}|#[0-9a-f]{6}|rgb\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}\s*\)|rgba\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*(0|1|0?\.\d+)\s*\)|[a-z]+)$/i',
            $value
        );
    }
}
