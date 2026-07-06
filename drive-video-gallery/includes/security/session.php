<?php

session_set_cookie_params([     // Configure the session cookie
    'lifetime' => 0,            // The cookie dissapears on browser closed (No permanent login)
    'path' => '/',              // The session cookie works for the whole website (index, videos, logout)
    'secure' => true,           // Cookie is sent only over HTTPS (Prevents traffic sniffing)
    'httponly' => true,         // Javascript cannot read the cookie (Protect against many XSS attacks)
    'samesite' => 'Strict'      // Prevents other websites from sending the session cookie
]);

session_start();                // PHP creates a session ID like e4f9a6a1d8c3... and sores it in a cookie