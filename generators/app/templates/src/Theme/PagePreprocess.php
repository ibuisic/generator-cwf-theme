<?php


namespace Drupal\<%= themeName %>\Theme;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Hook PagePreprocess.
 */
class PagePreprocess {

/**
 * Hook.
 */
  
  public static function hook(&$variables) {
    $icons = theme_get_setting('icon_set');
    $offcanvas = theme_get_setting('navbar_offcanvas');

    if ($icons) {
      $variables['#attached']['library'][] = '<%= themeName %>/' . $icons;
    }

    if ($offcanvas) {
      $variables['#attached']['library'][] = '<%= themeName %>/offcanvas';
    }
  }

}

