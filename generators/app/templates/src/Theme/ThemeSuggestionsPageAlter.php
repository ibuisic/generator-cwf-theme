<?php

namespace Drupal\<%= themeName %>\Theme;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Controller routines for page example routes.
 */
class ThemeSuggestionsPageAlter {

  /**
   * Hook.
   */
  public static function hook(array &$suggestions, array $variables) {
    if (is_object($node = \Drupal::request()->attributes->get('node'))) {
      array_splice($suggestions, 1, 0, 'page__node__' . $node->getType());
      array_splice($suggestions, 1, 0, 'page__node__' . $node->getType() . '__' . $node->id());
    }
  }

}
