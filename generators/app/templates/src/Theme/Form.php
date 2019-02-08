<?php


namespace Drupal\<%= themeName %>\Theme;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

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
  public static function form_alter(&$form, FormStateInterface $form_state, $form_id) {
    if ($form_id == 'search_form'){
      $form['#attributes']['class'][] = 'bg-light';
      $form['#attributes']['class'][] = 'p-3';
      $form['basic']['keys']['#attributes']['class'][] = 'mx-3';
    }
    if ($form_id == 'search_block_form'){
      $form['keys']['#prefix'] = '<div class="form-inline">';
      $form['actions']['#suffix'] = '</div>';
      $form['keys']['#attributes']['class'][] = 'mr-sm-2';
      $form['actions']['#attributes']['class'][] = 'my-2 my-sm-0';
    }
  }

    /**
   * User form alter.
   */


  public static function user_form_alter(&$form, FormStateInterface $form_state, $form_id) {
    // Display the "Forgot your password?" link under the password input.
    $pass_link = \Drupal::l(t('Forgot your password?'), Url::fromUri('route:user.pass', ['attributes' => ['class' => ['pass-link']]]));
    $form['pass']['#suffix'] = '<div class="pb-2">' . $pass_link  . '</div>';
  }

    /**
   * User form suggestions alter.
   */

  public static function user_form_suggestions_alter(&$suggestions, $variables) {
    $form_id = $variables['element']['#form_id'];
    if (in_array($form_id, ['user_login_form','user_register_form','user_pass']))  {
      $suggestions[] = 'form__' . $form_id;
    }
  }

}

