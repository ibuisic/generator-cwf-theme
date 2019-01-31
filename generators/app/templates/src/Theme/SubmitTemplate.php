<?php


namespace Drupal\<%= themeName %>\Theme;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Hook SubmitTemplate.
 */
class SubmitTemplate {

/**
 * Hook.
 */
  public static function hook(array &$suggestions, array $variables) {
    if ($variables['element']['#type'] == 'submit' && theme_get_setting('submit_button')) {
      $suggestions[] = 'input__submit_button';
    }
  }
}

