## Setup

1. Copy `config.example.php` to `config.php`.
2. Copy `data/videos.example.php` to `data/videos.php` and add your video entries.
3. Generate a password hash:

```sh
php -r "echo password_hash('add_your_password', PASSWORD_DEFAULT);"
```

4. Paste the generated hash into `config.php`, along with your site title and home URL:

```php
<?php
return [
    'password_hash' => 'paste_hash_here',
    'site_title'    => 'My Video Gallery',
    'home_url'      => 'https://example.com/',
];
```

## Run project locally in Kali Linux

Check if PHP is installed:

```sh
php -v
```

Open a terminal and run:

```sh
php -S localhost:8000
```

Open `http://localhost:8000`