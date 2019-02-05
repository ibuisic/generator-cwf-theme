<?php


namespace Drupal\<%= themeName %>\Theme;

use Drupal\Core\Form\FormStateInterface;

/**
 * @file
 * Contains \Drupal\<%= themeName %>\Theme.
 */

/**
 * Hook Form.
 */
class Form {

/**
 * Form element.
 */
  public static function element(&$variables) {
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

  /**
   * Submit template.
   */
  public static function submit_template(array &$suggestions, array $variables) {
    if ($variables['element']['#type'] == 'submit' && theme_get_setting('submit_button')) {
      $suggestions[] = 'input__submit_button';
    }
  }

  /**
   * Search block alter.
   */
  public static function search_block_alter(&$form, FormStateInterface $form_state, $form_id) {
    $form['keys']['#prefix'] = '<div class="form-inline">';
    $form['actions']['#suffix'] = '</div>';
    $form['keys']['#attributes']['class'][] = 'mr-sm-2';
    $form['actions']['#attributes']['class'][] = 'my-2 my-sm-0';
  }

}

