<?php

namespace App\Helpers; // Put functions in a namespaced bucket to avoid collisions.

/**
 * Build an HTML tag (<link> or <script>) for a public asset and append a
 * cache-busting query (v=<filemtime>) to its URL.
 *
 * Usage in Blade (after registering the directive):
 *   @asset('css/app.css')
 *   @asset('js/app.js', ['type' => 'module', 'defer' => true])
 */
function asset_tag(string $path, array $attributes = []): string
{
    // Resolve the absolute filesystem path under public/ (to read mtime).
    $full = public_path($path);

    // Build the public URL (without version yet), e.g. https://example.com/css/app.css
    $url = asset($path);

    // If the file exists on disk, append a version query using its modification time.
    if (is_file($full)) {
        $v = filemtime($full);                    // UNIX timestamp (changes when file changes)
        $sep = str_contains($url, '?') ? '&' : '?'; // Choose & if URL already has a query
        $url .= $sep . 'v=' . $v;                 // Append ?v=123456789 (or &v=...)
    }

    // Decide which HTML tag to render based on the file extension.
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    if ($ext === 'css') {
        // Defaults for <link>: rel=stylesheet and href=<url>.
        $attrs = array_merge(['rel' => 'stylesheet', 'href' => $url], $attributes);
        return '<link ' . html_attributes($attrs) . '>';
    }

    if ($ext === 'js' || $ext === 'mjs') {
        // Defaults for <script>: src=<url> and boolean defer=true (omit to run immediately).
        $attrs = array_merge(['src' => $url, 'defer' => true], $attributes);
        return '<script ' . html_attributes($attrs) . '></script>';
    }

    // Fallback for unknown extensions: just return the URL string so it’s visible/debuggable.
    return $url;
}

/**
 * Turn an associative array into a safe HTML attribute string.
 *
 * Rules:
 * - true  → output as a boolean attribute without value (e.g., defer)
 * - false or null → omit the attribute entirely
 * - other values → key="escaped value"
 */
function html_attributes(array $attributes): string
{
    $parts = []; // Collect rendered attributes here.

    foreach ($attributes as $key => $value) {
        if ($value === false || $value === null) {
            continue; // Skip attributes explicitly set to false or null.
        }

        if ($value === true) {
            // Boolean attribute: just print the key (HTML5 boolean attribute form).
            $parts[] = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
            continue;
        }

        // Normal attribute: key="value", both key and value HTML-escaped.
        $parts[] = sprintf(
            '%s="%s"',
            htmlspecialchars($key, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8')
        );
    }

    // Join the pieces with single spaces, ready to insert into a tag.
    return implode(' ', $parts);
}
