<?php

add_action('customize_register', 'wapp_fixed_btn_customizer');
function wapp_fixed_btn_customizer($wp_customize)
{
  // Section
  $wp_customize->add_section('wapp_fixed_btn_section', [
    'title'             => 'Botón de contacto de WhatsApp',
    'priority'          => 200,
  ]);

  // Phone number setting + control.
  $wp_customize->add_setting('wapp_phone_number', [
    'default'           => '59800000000',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'refresh'                // Forces full page refresh instead of JS live preview injection.
  ]);
  $wp_customize->add_control('wapp_phone_number', [
    'label'             => 'Número de WhatsApp',
    'section'           => 'wapp_fixed_btn_section',
    'type'              => 'text',
  ]);

  // Message setting + control.
  $wp_customize->add_setting('wapp_message', [
    'default'           => 'Hola, deseo hacer una consulta...',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'refresh'                // Forces full page refresh instead of JS live preview injection.
  ]);
  $wp_customize->add_control('wapp_message', [
    'label'             => 'Mensaje predeterminado',
    'section'           => 'wapp_fixed_btn_section',
    'type'              => 'text',
  ]);
}

function render_wapp_fixed_btn()
{
  $phone_number = sanitize_text_field(get_theme_mod('wapp_phone_number', '59800000000'));
  // Regex validation on phone number. Uruguay country code 598 + 8 subscriber digits = 11 digits total.
  if (!preg_match('/^598\d{8}$/', $phone_number)) {
    return;
  }
  $encoded_message = rawurlencode(sanitize_text_field(get_theme_mod('wapp_message', 'Hola, deseo hacer una consulta...')));
  $wapp_url        = "https://wa.me/{$phone_number}?text={$encoded_message}";

  static $styles_printed = false;
  if (!$styles_printed) {
    $styles_printed = true;

?>
    <style>
      :root {
        --main-transition: all ease-in-out .25s;
        --light-whatsapp: #25d366;
        --danger: #dc3545;
        --dark-whatsapp: #008069;
        --border-radius: 0px;
        --white: #ffffff;
      }

      .wapp-link {
        position: fixed;
        bottom: 4rem;
        right: .5rem;
        z-index: 99;
        color: var(--white);
        text-decoration: none;
        transition: var(--main-transition);
      }

      .wapp-link small {
        display: block;
        color: var(--white);
      }

      .wapp-link .icon-wrapper {
        position: relative;
        height: 4rem;
        width: 4rem;
        font-size: 2rem;
        background-color: var(--light-whatsapp);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
      }

      .wapp-link .icon-wrapper .active-circle {
        width: 10px;
        height: 10px;
        background-color: var(--danger);
        position: absolute;
        z-index: 1;
        border-radius: 50%;
        right: 4px;
        top: 4px;
        display: block;
      }

      .wapp-link .icon-wrapper .aditional {
        position: absolute;
        right: 5rem;
        bottom: 0;
        font-size: 1rem;
        width: 250px;
        background: var(--dark-whatsapp);
        border-radius: var(--border-radius);
        transform: scale(0);
        transform-origin: center right;
        transition: var(--main-transition);
      }

      .wapp-link .icon-wrapper .aditional::after {
        content: " ";
        width: 0;
        height: 0;
        border-top: 0.5rem solid transparent;
        border-bottom: 0.5rem solid transparent;
        border-left: 0.5rem solid var(--dark-whatsapp);
        position: absolute;
        right: -0.5rem;
        top: 50%;
      }

      .wapp-link .icon-wrapper .aditional span {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
      }

      .wapp-link .icon-wrapper .aditional .text-wrapper {
        color: var(--white);
        display: none;
      }

      @media screen and (min-width: 992px) {
        .wapp-link {
          border-radius: var(--border-radius);
        }

        .wapp-link:hover .icon-wrapper,
        .wapp-link:active .icon-wrapper {
          background-color: var(--light-whatsapp);
        }

        .wapp-link .icon-wrapper:hover,
        .wapp-link .icon-wrapper:active {
          background-color: var(--dark-whatsapp);
        }

        .wapp-link .icon-wrapper:hover .aditional,
        .wapp-link .icon-wrapper:active .aditional {
          transform: scale(1);
        }

        .wapp-link .icon-wrapper:hover .aditional .text-wrapper,
        .wapp-link .icon-wrapper:active .aditional .text-wrapper {
          display: block;
        }
      }
    </style>

  <?php
  }
  ?>

  <a
    href="<?php echo esc_url($wapp_url); ?>"
    target="_blank"
    rel="nofollow noopener noreferrer"
    aria-label="<?php esc_attr_e('Contactar por WhatsApp', 'the7mk2'); ?>"
    class="wapp-link fade-in delay-level2">
    <div class="icon-wrapper">
      <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
      <span class="active-circle" aria-hidden="true"></span>
      <div class="aditional" aria-hidden="true">
        <span>
          <div class="text-wrapper">
            <small><?php esc_html_e('Ante cualquier duda o consulta', 'the7mk2'); ?></small>
            <small><?php esc_html_e('no dude en contactarnos.', 'the7mk2'); ?></small>
          </div>
        </span>
      </div>
    </div>
  </a>

<?php
}

add_action('wp_footer', 'render_wapp_fixed_btn');
