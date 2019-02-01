<?php


namespace Drupal\<%= themeName %>\Theme;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Hook RegionPreprocess.
 */
class RegionPreprocess {

/**
 * Hook.
 */
  public static function hook(&$variables) {
    // Load the site name out of configuration.
    $config = \Drupal::config('system.site');
    $variables['site_name'] = $config->get('name');
    $variables['site_slogan'] = $config->get('slogan');

    if (theme_get_setting('region_classes_' . $variables['elements']['#region']) !== NULL) {
      $variables['attributes']['class'][] = theme_get_setting('region_classes_' . $variables['elements']['#region']);
    }
    if (theme_get_setting('region_container_' . $variables['elements']['#region']) !== NULL) {
      $variables['region_container'] = theme_get_setting('region_container_' . $variables['elements']['#region']);
    }
  }
}

