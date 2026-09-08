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
 * javascript: URIs, and keeps only the `text-align` CSS property from
 * inline styles (which is how Quill.js expresses paragraph alignment).
 */
class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
        'a', 'img',
        'ul', 'ol', 'li',
        'blockquote',
        'h2', 'h3', 'h4',
        'span', 'div',
    ];

    private const ALLOWED_ATTRS = [
        'a' => ['href', 'target', 'rel'],
        'img' => ['src', 'alt', 'width', 'height'],
    ];

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
        if (preg_match('/text-align\s*:\s*(left|right|center|justify)/i', $style, $m)) {
            return 'text-align: '.strtolower($m[1]).';';
        }

        return '';
    }
}
