<?php

// Set secure session cookie parameters
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'domain' => 'example.com',
    'secure' => true,  // Only send cookie over HTTPS
    'httponly' => true  // Prevent JavaScript access to the cookie
]);

session_start();
