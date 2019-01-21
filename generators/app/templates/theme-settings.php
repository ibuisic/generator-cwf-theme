<?php

/**
 * @file
 * theme-settings.php
 *
 * Provides theme settings for Bootstrap Barrio based themes when admin theme is not.
 *
 * @see ./includes/settings.inc
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

  // Vertical tabs
  $form['<%= themeName %>'] = array(
    '#type' => 'vertical_tabs',
    '#prefix' => '<h2><small>' . t('<%= themeName %> Settings') . '</small></h2>',
    '#weight' => -10,
  );


  // Fonts.
  $form['fonts'] = array(
    '#type' => 'details',
    '#title' => t('Fonts and Icons'),
    '#group' => '<%= themeName %>',
  );
  $form['fonts']['icons'] = array(
    '#type' => 'details',
    '#title' => t('Icons'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['fonts']['icons']['<%= themeName %>_icons'] = array(
    '#type' => 'select',
    '#title' => t('Icon set'),
    '#default_value' => theme_get_setting('<%= themeName %>_icons'),
    '#empty_option' => t('None'),
    '#description' => t('On how to use each Icon Set visit the set website : @fa_link, @socicon, @material_icon, @stroke7', array(
      '@fa_link' => Drupal::l('Font Awesome' , Url::fromUri('http://fontawesome.com/' , ['absolute' => TRUE])),
      '@socicon' => Drupal::l('Socicon' , Url::fromUri('http://www.socicon.com/' , ['absolute' => TRUE])),
      '@material_icon' => Drupal::l('Material Design Icons' , Url::fromUri('https://material.io/tools/icons/' , ['absolute' => TRUE])),
      '@stroke7' => Drupal::l('Stroke 7' , Url::fromUri('https://themes-pixeden.com/font-demos/7-stroke/' , ['absolute' => TRUE])),
    )),
    '#options' => array(
      'fontawesome' => 'Font Awesome',
      'socicon' => 'Socicon',
      'material_design_icons' => 'Material Design Icons',
      'stroke_7' => 'Stroke 7 Icon Set'
    ),
  );

  //Change collapsible fieldsets (now details) to default #open => FALSE.
  $form['theme_settings']['#open'] = FALSE;
  $form['logo']['#open'] = FALSE;
  $form['favicon']['#open'] = FALSE;
