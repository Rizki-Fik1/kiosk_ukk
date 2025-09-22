<?php
// Simple script to generate Laravel APP_KEY
// Run with: php generate-key.php

function generateAppKey() {
    $key = base64_encode(random_bytes(32));
    return 'base64:' . $key;
}

echo "Generated APP_KEY for Laravel:\n";
echo generateAppKey() . "\n\n";
echo "Copy this key and use it in your Vercel environment variables.\n";
?>