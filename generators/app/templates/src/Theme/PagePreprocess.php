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
    if ($icons) {
      $variables['#attached']['library'][] = 'cwf/' . $icons;
    }
  }
}

