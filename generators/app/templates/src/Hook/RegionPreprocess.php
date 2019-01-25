<?php


namespace Drupal\<%= themeName %>\Hook;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Hook.
 */

/**
 * Hook RegionPreprocess.
 */
class RegionPreprocess {

/**
 * Hook.
 */
  public static function hook(&$variables) {
    if (theme_get_setting('region_classes_' . $variables['elements']['#region']) !== NULL) {
      $variables['attributes']['class'][] = theme_get_setting('region_classes_' . $variables['elements']['#region']);
    }
    if (theme_get_setting('region_container_' . $variables['elements']['#region']) !== NULL) {
      $variables['region_container'] = theme_get_setting('region_container_' . $variables['elements']['#region']);
    }
  }
}

