<?php

namespace Drupal\<%= themeName %>\Theme;

use Drupal\Core\Language\LanguageInterface;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Hook PreprocessLinks.
 */
class PreprocessLinks {

  /**
   * Hook.
   */
  public static function hook(&$variables) {
    // Custom block language links.
    if ($variables['theme_hook_original'] == 'links__language_block') {
      if (theme_get_setting('language_block_type') == 'dropdown') {
        // Add needed CSS style classes.
        // @todo - can we do this in template?
        foreach ($variables['links'] as &$link) {
          $link['link']['#options']['attributes']['class'][] = 'dropdown-item';
        }

        // Set the active language native label and class.
        $current_language = \Drupal::languageManager()->getCurrentLanguage(LanguageInterface::TYPE_CONTENT);
        // Current language can be missing in language links if language is
        // hidden/disabled in any (custom) way.
        if (isset($variables['links'][$current_language->getId()])) {
          if (theme_get_setting('language_block_code')) {
            $variables['active_language_name'] = $current_language->getId();
          } else {
            $variables['active_language_name'] = $variables['links'][$current_language->getId()]['text'];
          }
          $variables['links'][$current_language->getId()]['link']['#options']['attributes']['class'][] = 'active';
        }
      }

      // Language code title.
      if (theme_get_setting('language_block_code')) {
        foreach ($variables['links'] as &$link) {
          $link['link']['#options']['attributes']['title'] = $link['link']['#title'];
          $link['link']['#options']['attributes']['class'][] = 'language-link--langcode';
          $link['link']['#title'] = $link['link']['#options']['language']->getId();
        }
      }
    }
  }
}
