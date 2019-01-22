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

  // All regions
  $theme = \Drupal::theme()->getActiveTheme()->getName();
  $region_list = system_region_list($theme, $show = REGIONS_ALL);

  // Vertical tabs
  $form['<%= themeName %>'] = array(
    '#type' => 'vertical_tabs',
    '#prefix' => '<h2><small>' . t('<%= themeName %> Settings') . '</small></h2>',
    '#weight' => -10,
  );

  // General settings
  $form['settings'] = array(
    '#type' => 'details',
    '#title' => t('Settings'),
    '#group' => '<%= themeName %>',
  );

  $form['settings']['<%= themeName %>_inline_logo'] = array(
    '#type' => 'checkbox',
    '#title' => t('Inline SVG logo'),
    '#default_value' => theme_get_setting('<%= themeName %>_inline_logo')
  );

  // Layout
  $form['layout'] = array(
    '#type' => 'details',
    '#title' => t('Layout'),
    '#group' => '<%= themeName %>',
  );
  $form['layout']['regions'] = array(
    '#type' => 'details',
    '#title' => t('Regions'),
    '#collapsible' => TRUE,
    '#open' => TRUE,
    '#description' => t('All additional classes and settings for each region')
  );


  foreach ($region_list as $name => $description) {
    if ( theme_get_setting('<%= themeName %>_region_classes_' . $name) !== NULL) {
      $region_class = theme_get_setting('<%= themeName %>_region_classes_' . $name);
    }
    $form['layout']['regions'][$name] = array(
      '#type' => 'details',
      '#title' => $description,
      '#collapsible' => TRUE,
      '#open' => FALSE,
    );
    $form['layout']['regions'][$name]['region_classes_' . $name] = array(
      '#type' => 'textfield',
      '#title' => t('@description classes', array('@description' => $description)),
      '#default_value' => $region_class
    );
  }

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
    '#open' => TRUE,
  );

  $form['fonts']['icons']['<%= themeName %>_icons'] = array(
    '#type' => 'select',
    '#title' => t('Icon set'),
    '#default_value' => theme_get_setting('<%= themeName %>_icons'),
    '#empty_option' => t('None'),
    '#description' => t('On how to use each Icon Set visit their website : @fa_link, @socicon, @material_icon, @stroke7', array(
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
