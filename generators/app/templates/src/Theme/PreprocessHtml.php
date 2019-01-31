<?php

namespace Drupal\<%= themeName %>\Theme;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Hook PreprocessHtml.
 */
class PreprocessHtml {

  /**
   * Hook.
   */
  public static function hook(&$variables) {
    $variables['attributes']['class'][] = !$variables['root_path'] ? 'front' : 'not-front';
    if (is_object($node = \Drupal::request()->attributes->get('node'))) {
      $variables['attributes']['class'][] = 'page-node-' . $node->nid->value;
    }
    if (!empty($variables['page']['sidebar_first']) && empty($variables['page']['sidebar_second']))  {
      $variables['attributes']['class'][] = 'sidebar-first';
    }
    if (!empty($variables['page']['sidebar_second']) && empty($variables['page']['sidebar_first'])) {
      $variables['attributes']['class'][] = 'sidebar-second';
    }
    if (!empty($variables['page']['sidebar_second']) && !empty($variables['page']['sidebar_first'])) {
      $variables['attributes']['class'][] = 'both-sidebars';
    }
  }
}
