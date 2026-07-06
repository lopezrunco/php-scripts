<?php

function loadAttempts(string $file): array {
    return file_exists($file)                                       // Read the JSON file into a PHP array
        ? json_decode(file_get_contents($file), true)
        : [];
}

function saveAttempts(string $file, array $attempts): void {
    file_put_contents($file, json_encode($attempts, JSON_PRETTY_PRINT));
}

function cleanupAttempts(array &$attempts, int $lockoutSeconds): void {
    foreach ($attempts as $ip => $data) {                           // Loop through all stored IPs
        if (time() - $data['last_attempt'] > $lockoutSeconds) {     // Ask if has it been more that 15 minutes since last attempt
            unset($attempts[$ip]);                                  // Remove that IP from tracking
        }
    }
}

function registerFailedAttempt(array &$attempts, string $ip): void {
    if (!isset($attempts[$ip])) {                                   // If it's the first time this IP falls, initialize record
        $attempts[$ip] = [
            'count' => 0,
            'last_attempt' => time()
        ];
    }

    $attempts[$ip]['count']++;
    $attempts[$ip]['last_attempt'] = time();
}

function isLockedOut(array $attempts, string $ip, int $maxAttempts, int $lockoutSeconds): bool {
    return (
        isset($attempts[$ip]) &&                                    // Check if the current IP is locked
        $attempts[$ip]['count'] >= $maxAttempts &&                  // Ask if the IP has failed 5+ times
        time() - $attempts[$ip]['last_attempt'] < $lockoutSeconds   // Ask if the IP is still within the 15-minute window
    );
}

function logSecurityEvent(string $type, string $ip): void {
    $entry = date('Y-m-d H:i:s') . " [{$type}] ip={$ip}" . PHP_EOL;
    file_put_contents(
        __DIR__ . '/../../storage/security.log',
        $entry,
        FILE_APPEND | LOCK_EX
    );
}