<?php


namespace Drupal\cwf\Hook;

/**
 * @file
 * Contains \Drupal\cwf\Hook.
 */

/**
 * Hook BlockRegion.
 */
class BlockRegion {

/**
 * Hook.
 */
  public static function hook(array &$suggestions, array &$variables) {
    if (!empty($variables['elements']['#id'])) {
      $block = \Drupal\block\Entity\Block::load($variables['elements']['#id']);
      $suggestions[] = 'block__' . $block->getRegion();
      $suggestions[] = 'block__' . $block->getRegion() . '__' . $variables['elements']['#id'];
    }
    return $suggestions;
  }
}

