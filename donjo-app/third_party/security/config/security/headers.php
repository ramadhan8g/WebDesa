<?php



defined('BASEPATH') || exit('No direct script access allowed');

$config = [
    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',

    // 'X-Frame-Options' => 'deny',

    'X-Content-Type-Options' => 'nosniff',

    // 'Content-Security-Policy' => "default-src 'self';form-action 'self';script-src 'self' *.facebook.net platform.twitter.com unpkg.com *.cloudflare.com *.jsdelivr.net  'unsafe-inline' 'unsafe-eval';style-src 'self' fonts.googleapis.com unpkg.com *.cloudflare.com *.jsdelivr.net 'unsafe-inline';img-src 'self' * data:;font-src 'self' fonts.gstatic.com *.cloudflare.com *.jsdelivr.net data:;connect-src 'self';media-src 'self';object-src 'none';base-uri 'self';report-uri; frame-src 'self' *.google.com",

    'X-Permitted-Cross-Domain-Policies' => 'none',

    // 'Referrer-Policy' => 'no-referrer',

    'Permissions-Policy' => 'accelerometer=(),ambient-light-sensor=(),autoplay=(),battery=(),camera=(),display-capture=(),document-domain=(),encrypted-media=(),fullscreen=(),gamepad=(),geolocation=(),gyroscope=(),layout-animations=(self),legacy-image-formats=(self),magnetometer=(),microphone=(),midi=(),oversized-images=(self),payment=(),picture-in-picture=(),publickey-credentials-get=(),speaker-selection=(),sync-xhr=(self),unoptimized-images=(self),unsized-media=(self),usb=(),screen-wake-lock=(),web-share=(),xr-spatial-tracking=()',

    'Cross-Origin-Embedder-Policy' => 'same-origin',

    'Cross-Origin-Resource-Policy' => 'same-origin',

    'Cross-Origin-Opener-Policy' => 'same-origin',
];
