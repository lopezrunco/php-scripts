<?php

require 'includes/security/session.php';
require 'includes/security/csrf.php';
require 'includes/security/rate_limit.php';

$config = require __DIR__ . '/config.php';
$passwordHash = $config['password_hash'];
$pageTitle = $config['site_title'];

$attemptsFile = __DIR__ . '/storage/login_attempts.json';   // Load stored login attempts file
$attempts = loadAttempts($attemptsFile);

$ip = $_SERVER['REMOTE_ADDR'];                              // Get the user's IP address
$maxAttempts = 5;
$lockoutSeconds = 900;                                      // 15 minutes

cleanupAttempts($attempts, $lockoutSeconds);
saveAttempts($attemptsFile, $attempts);

if (isLockedOut($attempts, $ip, $maxAttempts, $lockoutSeconds)) { 
    $remaining = ceil(($lockoutSeconds - (time() - $attempts[$ip]['last_attempt'])) / 60);
    password_verify('dummy', $passwordHash);                // Normalize response time to prevent timing-based lockout detection
    $error = "Demasiados intentos fallidos. Intente nuevamente en {$remaining} minutos."; 
    logSecurityEvent('LOCKOUT_BLOCKED', $ip);
}

generateCsrfToken();

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&                // Check if the form was submitted
    empty($error)                                           // Prevent a lockd-out user from attempting password verification
) {
    if (!validateCsrfToken()) { 
        $error = 'Solicitud inválida'; 
    } elseif (
        isset($_POST['password']) &&
        password_verify($_POST['password'], $passwordHash)
    ) {
        session_regenerate_id(true);
        logSecurityEvent('LOGIN_SUCCESS', $ip);

        // CSRF token rotation
        unset($_SESSION['csrf']);
        generateCsrfToken();

        // Reset failed attempts on success
        unset($attempts[$ip]);                              // Clear brute-force counter for this IP
        saveAttempts($attemptsFile, $attempts);

        $_SESSION['logged_in'] = true;
        header('Location: videos.php');
        exit;
    } else {
        registerFailedAttempt($attempts, $ip);
        logSecurityEvent('LOGIN_FAILED', $ip);
        saveAttempts($attemptsFile, $attempts);
        $error = 'Contraseña incorrecta';
    }
}

require 'includes/layout/header.php';
require 'includes/layout/home_link.php';

?>

<div class="login">
    <h3>Ingrese la contraseña que le fué proporcionada para ver los videos</h3>

    <form method="post">
        <!-- When the form is submitted, the request contains the secret token -->
        <input
            type="hidden"
            name="csrf"
            value="<?= htmlspecialchars($_SESSION['csrf']) ?>"
        >

        <label>Contraseña:
            <div class="input-group">
                <input
                    class="password-input"
                    type="password"
                    name="password"
                    autocomplete="off"
                    placeholder="Ingrese contraseña"
                    required
                />
                <i class="fas fa-eye"></i>
            </div>
        </label>
        <button type="submit">Entrar <i class="fas fa-chevron-right"></i></button>
    </form>

    <?php if (!empty($error)): ?>
        <span class="login-error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <?= htmlspecialchars($error) ?>
        </span>
    <?php endif; ?>

</div>

<?php require 'includes/layout/footer.php'; ?>