<?php

namespace Drupal\<%= themeName %>\Hook;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Hook.
 */

/**
 * Hook PreprocessHtml.
 */
class PreprocessHtml {

  /**
   * Hook.
   */
  public static function hook(&$variables) {

    $route = \Drupal::routeMatch()->getRouteName();
    if ($route == 'entity.node.canonical') {
      $variables['attributes']['class'][] = 'page-node-view';
    }
    elseif ($route == 'entity.node.edit_form') {
      $variables['attributes']['class'][] = 'page-node-edit';
    }

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
