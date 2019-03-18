<?php

namespace Drupal\<%= themeName %>\Theme;

use Drupal\Core\Link;
use Drupal\block\Entity\Block;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Hook PreprocessHtml.
 */
class Preprocess {


  /**
   * Global.
   */
  public static function global(&$variables) {
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

  /**
   * HTML.
   */
  public static function html(&$variables) {
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

  /**
   * Page.
   */

  public static function page(&$variables) {
    $font = theme_get_setting('font_set');
    $icons = theme_get_setting('icon_set');


    if ($font) {
      $variables['#attached']['library'][] = '<%= themeName %>/font-' . $font;
    }
    if ($icons) {
      $variables['#attached']['library'][] = '<%= themeName %>/' . $icons;
    }

    if (theme_get_setting('btt')) {
      $variables['#attached']['library'][] = '<%= themeName %>/back_to_top';
    }

    if (theme_get_setting('navbar_offcanvas')) {
      $variables['#attached']['library'][] = '<%= themeName %>/navbar-offcanvas';
    }

    if (theme_get_setting('fadein_page_onload')) {
      $variables['#attached']['library'][] = '<%= themeName %>/fade';
    }

    if (theme_get_setting('dropdown_hover')) {
      $variables['#attached']['library'][] = '<%= themeName %>/dropdown_hover';
    }

    if (theme_get_setting('navbar_position') == 'fixed-top') {
      $variables['#attached']['library'][] = '<%= themeName %>/fixed-top-navbar';
    }

    if (theme_get_setting('<%= themeName %>_custom_css_on')) {
      $variables['#attached']['library'][] = '<%= themeName %>/<%= themeName %>-custom';
    }
  }

  /**
   * Region.
   */
  public static function region(&$variables) {
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

  /**
   * Block.
   */
  public static function block(&$variables) {
    $block_id = $variables['elements']['#id'];
    $block = Block::load($block_id);

    if (strpos($block->getPluginId(), 'system_menu_block') !== FALSE) {
      $region = Block::load($variables['elements']['#id'])->getRegion();
      $variables['content']['#attributes']['region'] = $region;
    }
  }

  /**
   * Links.
   */

  public static function links(&$variables) {
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

  /**
   * Local task.
   */

  public static function local_task(&$variables) {
    $link = $variables['element']['#link'];
    $url = $link['url'];
    $options = $url->getOptions();
    $url->setOptions($options + $link['localized_options']);
    $variables['item'] = Link::fromTextAndUrl($link['title'], $url);
  }

  /**
   * Local action.
   */

  public static function local_action(&$variables) {
    $link = $variables['element']['#link'];
    $link += array(
      'localized_options' => array(),
    );
    $link['localized_options']['attributes']['class'][] = 'btn';
    $link['localized_options']['attributes']['class'][] = 'btn-secondary';
    $link['localized_options']['set_active_class'] = TRUE;
    $variables['link'] = array(
      '#type' => 'link',
      '#title' => $link['title'],
      '#options' => $link['localized_options'],
      '#url' => $link['url'],
    );
  }
}
