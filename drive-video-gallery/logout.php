<?php

require 'includes/security/session.php';            // PHP needs to load the current user's session before delete it

$_SESSION = [];                                     // Wipe the session data on the server
session_destroy();                                  // Deletes the session file on the server
setcookie(session_name(), '', time() - 3600, '/');  // Wipe the session data on the browser

header('Location: index.php');
exit;