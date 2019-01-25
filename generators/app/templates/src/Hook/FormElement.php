<?php


namespace Drupal\<%= themeName %>\Hook;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Hook.
 */

/**
 * Hook FormElement.
 */
class FormElement {

/**
 * Hook.
 */
  public static function hook(&$variables) {
    // Add special class to form element.
    $variables['attributes']['class'][] = 'form-group';

    if (!empty($variables['element']['#errors'])) {
      $variables['has_errors'] = TRUE;
    }

    $element_type = $variables['type'];
    $variables['label']['#element_type'] = $variables['type'];


    // Add classes to description item of the form element.
    if (isset($variables['description']['attributes'])) {
      $variables['description']['attributes']->addClass('form-text text-muted');
    }
  }
}

