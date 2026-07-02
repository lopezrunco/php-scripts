<?php

function render_wapp_fixed_btn()
{

  $phone_number = '59892251334';
  // Regex validation on phone number. Uruguay country code 598 + 8 subscriber digits = 11 digits total.
  if (!preg_match('/^598\d{8}$/', $phone_number)) {
    return;
  }
  $encoded_message = rawurlencode('Hola, deseo hacer una consulta…');
  $wapp_url        = "https://wa.me/{$phone_number}?text={$encoded_message}";

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

      small {
        display: block;
        color: var(--white);
      }

      .icon-wrapper {
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

        .active-circle {
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

        .aditional {
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

          &::after {
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

          span {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            padding: 1rem;

            .text-wrapper {
              display: block;
            }
          }

          .text-wrapper {
            color: var(--white);
            display: none;
          }
        }
      }
    }

    @media screen and (min-width: 992px) {
      .wapp-link {
        border-radius: var(--border-radius);

        &:hover,
        &:active {
          .icon-wrapper {
            background-color: var(--light-whatsapp);
          }
        }

        .icon-wrapper {
          transition: var(--main-transition);

          &:hover,
          &:active {
            background-color: var(--dark-whatsapp);

            .aditional {
              transform: scale(1);
            }
          }
        }
      }
    }
  </style>

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
