<?php

namespace Drupal\<%= themeName %>\Theme;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Controller routines for page example routes.
 */
class ThemeSuggestionsLinks {

  /**
   * Hook.
   */
  public static function hook(array &$suggestions, array $variables) {
    if ($variables['theme_hook_original'] == 'links__language_block') {
      if (theme_get_setting('language_block_type') == 'inline') {
        $suggestions[] = 'links__inline';
      }
      if (theme_get_setting('language_block_type') == 'dropdown') {
        $suggestions[] = 'links__dropdown_language_block';
      }
    }
  }
}
