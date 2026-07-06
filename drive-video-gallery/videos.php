<?php

require 'includes/security/session.php';

if (empty($_SESSION['logged_in'])) {    // If not logged in, redirect back to login page
    header('Location: index.php');
    exit;
}

require 'data/videos.php';

$config = require __DIR__ . '/config.php';
$pageTitle = $config['site_title'];

require 'includes/layout/header.php';
require 'includes/layout/home_link.php';

?>

<h2 class="title">Ginkgo Congreso 2026</h2>

<div class="video-grid">
    <?php foreach($videos as $video): ?>
        <div class="item">
            <a class="video-link-element" href="<?=htmlspecialchars($video['url'])?>" target="_blank">
                <i class="far fa-play-circle"></i>
                <p><?=htmlspecialchars($video['title'])?></p>
            </a>
            <img src="./assets/play.svg" class="play-icon" alt="<?=htmlspecialchars($video['title'])?>" />
        </div>
    <?php endforeach; ?>
</div>

<?php
require 'includes/layout/logout_link.php';
require 'includes/layout/footer.php';
?>