<?php

function generateCsrfToken(): void {
    if (empty($_SESSION['csrf'])) {                         // Asks if there is a CSRF token in the session
        $_SESSION['csrf'] = bin2hex(random_bytes(32));      // Creates a random token like and stores it in the session
    }
}

function validateCsrfToken(): bool {
    return (
        isset($_POST['csrf']) &&                            // Ask if a CSRF token was sentin the form submit
        hash_equals($_SESSION['csrf'], $_POST['csrf'])      // Compares the token from the session whith the token submitted. If ok, login continues.
    );
}