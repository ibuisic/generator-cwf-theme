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
      $variables['#attached']['library'][] = '<%= themeName %>/' . $icons;
    }

    if (theme_get_setting('navbar_offcanvas')) {
      $variables['#attached']['library'][] = '<%= themeName %>/offcanvas';
    }

    if (theme_get_setting('fadein_page_onload')) {
      $variables['#attached']['library'][] = '<%= themeName %>/fade';
    }

    if (theme_get_setting('dropdown_hover')) {
      $variables['#attached']['library'][] = '<%= themeName %>/dropdown_hover';
    }
  }

}

