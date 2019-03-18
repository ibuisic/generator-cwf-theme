<?php

namespace Drupal\<%= themeName %>\Theme;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Controller routines for page example routes.
 */
class ThemeSuggestions {

  /**
   * Page.
   */

  public static function page(array &$suggestions, array $variables) {
    if (is_object($node = \Drupal::request()->attributes->get('node'))) {
      array_splice($suggestions, 1, 0, 'page__node__' . $node->getType());
      array_splice($suggestions, 1, 0, 'page__node__' . $node->getType() . '__' . $node->id());
    }
  }

  /**
   * Blocks.
   */
  public static function block(array &$suggestions, array &$variables) {
    if (!empty($variables['elements']['#id'])) {
      $block = \Drupal\block\Entity\Block::load($variables['elements']['#id']);
      $suggestions[] = 'block__' . $block->getRegion();
      $suggestions[] = 'block__' . $block->getRegion() . '__' . $variables['elements']['#id'];
    }
    return $suggestions;
  }

  /**
   * Menu.
   */
  public static function menu(array &$suggestions, array &$variables) {
    if (isset($variables['attributes']['region'])) {
      $suggestions[] = 'menu__' . $variables['menu_name'] . '__' . $variables['attributes']['region'];
    }
  }

  /**
   * Link.
   */
  public static function link(array &$suggestions, array $variables) {
    if ($variables['theme_hook_original'] == 'links__language_block') {
      if (theme_get_setting('language_block_type') == 'inline') {
        $suggestions[] = 'links__inline';
      }
      if (theme_get_setting('language_block_type') == 'dropdown') {
        $suggestions[] = 'links__dropdown_language_block';
      }
    }
    if ($variables['theme_hook_original'] == 'links__node') {
      if (theme_get_setting('node_links_btn_group')) {
        $suggestions[] = 'links__btn_group';
      }
    }
  }
}
