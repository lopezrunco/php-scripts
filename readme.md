# PHP Scripts

A collection of PHP scripts developed for real-world client projects and now being refactored with a strong focus on secure coding practices, maintainability, and modern development standards.

## About

This repository serves as a personal portfolio and learning project. Each script represents a practical solution to a real business requirement that has been revisited to improve its overall quality and security.

Rather than simply publishing old code, the goal is to analyze it from an Application Security perspective, identify potential weaknesses, and implement modern, secure alternatives.

## Scripts

1. `woocommerce-wapp-ask-price-snippet`

Adds a "Ask price" link on individual product pages and catalog listings. Phone number is configurable from the Wordpress admin. Run it with the Code Snippets WordPress plugin.

2. `wordpress-wapp-contact-btn-snippet`

Adds a fixed Whatsapp contact button in the bottom-right corner of every page. Phone number and message are configurable from the Wordpress admin. Run it with the Code Snippets WordPress plugin.

3. `woocommerce-change-dollar-symbol`

Replaces the default Woocommerce USD symbol with `U$`, used in Uruguayan e-commerces.

4. `drive-video-gallery`

A password-protected video gallery built with pure PHP, designed to privately share a curated list of video links (e.g. embedded/external URLs) with a group via a single shared password. Includes secure session handling, CSRF-protected login, brute-force rate limiting with IP-based lockout, timing-attack mitigation, and security event logging. See the project's own README for setup instructions.

5. `woocommerce-config-catalog-mode`

Converts WooCommerce from transactional to showcase-only mode removing prices, Add to Cart, cart/checkout access, stock display, order emails and redirecting my-account page.

6. `woocommerce-restrict-shop-manager-capabilities`

WooCommerce grants Shop Manager role unintended access to theme settings by default. This snippet removes that access.
Removes: edit_theme_options and switch_themes.

## Goals

* Refactor legacy PHP code.
* Apply secure coding best practices.
* Improve code readability and maintainability.
* Add documentation and comments where appropriate.
* Follow modern PHP standards and conventions.
* Demonstrate practical Application Security knowledge.

## Security Improvements

Depending on the project, refactoring may include:

* Input validation and sanitization
* Context-aware output escaping
* Protection against Cross-Site Scripting (XSS)
* Protection against Cross-Site Request Forgery (CSRF)
* Secure database interactions (prepared statements)
* Proper authentication and authorization checks
* Secure file upload handling
* Improved error handling
* Removal of deprecated or insecure code
* Static analysis and code quality improvements

## Disclaimer

These scripts were originally created for real-world client projects. Any client-specific information, credentials, proprietary code, branding, or confidential data has been removed before publication.

## Technologies

* PHP
* WordPress
* WooCommerce
* MySQL

## License

This repository is licensed under the MIT License unless otherwise specified.

