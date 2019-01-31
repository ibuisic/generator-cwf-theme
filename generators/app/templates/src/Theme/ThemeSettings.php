<?php


namespace Drupal\<%= themeName %>\Theme;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Hook ThemeSettings.
 */
class ThemeSettings {

/**
 * Hook.
 */
  public static function hook(&$variables) {
    // Get the theme object.
    static $theme;
    if (!isset($theme)) {
      $theme = \Drupal::theme()->getActiveTheme();
    }

    // Get the theme settings.
    static $theme_settings;
    if (!isset($theme_settings)) {
      $theme_settings = \Drupal::config($theme->getName() . '.settings')->get();
    }

    // Add active theme settings.
    if (!isset($variables['theme_settings'])) {
      $variables['theme_settings'] = $theme_settings;
    }
  }
}

