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

  // General settings
$form['settings'] = array(
  '#type' => 'details',
  '#title' => t('General'),
  '#group' => '<%= themeName %>',
);

$form['settings']['general'] = array(
  '#type' => 'details',
  '#title' => 'General theme Settings',
  '#collapsible' => true,
  '#open' => true,
);

$form['settings']['general']['inline_logo'] = array(
  '#type' => 'checkbox',
  '#title' => t('Inline SVG logo'),
  '#default_value' => theme_get_setting('inline_logo')
);

$form['settings']['general']['responsive_images'] = array(
  '#type' => 'checkbox',
  '#title' => t('Responsive images'),
  '#default_value' => theme_get_setting('responsive_images')
);

$form['settings']['general']['menu_icons'] = array(
  '#type' => 'checkbox',
  '#title' => t('Menu icons'),
  '#description' => t('When this is checked you can use a seperator <b> | </b> and write down classes and it will generate an &#60;i&#62; tag with those classes.'),
  '#default_value' => theme_get_setting('menu_icons')
);


  // forms

$form['forms'] = array(
  '#type' => 'details',
  '#title' => t('Forms'),
  '#group' => '<%= themeName %>',
);

$form['forms']['general'] = array(
  '#type' => 'details',
  '#title' => 'General Form Settings',
  '#collapsible' => true,
  '#open' => true,
);

$form['forms']['general']['submit_classes'] = array(
  '#type' => 'textfield',
  '#title' => t('Submit Button classes'),
  '#default_value' => theme_get_setting('submit_classes')
);

$form['forms']['general']['submit_button'] = array(
  '#type' => 'checkbox',
  '#title' => t('Change all input submit elements to button elements. Note: use at your own risk!'),
  '#default_value' => theme_get_setting('submit_button')
);

$form['forms']['custom_forms'] = array(
  '#type' => 'details',
  '#title' => 'Custom forms',
  '#collapsible' => true,
  '#open' => true,
);

$form['forms']['custom_forms']['custom_form_select'] = array(
  '#type' => 'checkbox',
  '#title' => t('Select'),
  '#default_value' => theme_get_setting('custom_form_select')
);

$form['forms']['custom_forms']['custom_form_checkbox'] = array(
  '#type' => 'checkbox',
  '#title' => t('Checkbox'),
  '#default_value' => theme_get_setting('custom_form_checkbox')
);

$form['forms']['custom_forms']['custom_form_radio'] = array(
  '#type' => 'checkbox',
  '#title' => t('Radio'),
  '#default_value' => theme_get_setting('custom_form_radio')
);

$form['forms']['custom_forms']['custom_form_file'] = array(
  '#type' => 'checkbox',
  '#title' => t('File'),
  '#default_value' => theme_get_setting('custom_form_file')
);

// Images

  // images

$form['images'] = array(
  '#type' => 'details',
  '#title' => t('Images'),
  '#group' => '<%= themeName %>',
);

$form['images']['general'] = array(
  '#type' => 'details',
  '#title' => 'General Images Settings',
  '#collapsible' => true,
  '#open' => true,
);

$form['images']['general']['img_thumbnail'] = array(
  '#type' => 'checkbox',
  '#title' => t('Image thumbnail (Adding padding, border and border-radius to all images)'),
  '#default_value' => theme_get_setting('img_thumbnail')
);

$form['images']['general']['img_border'] = array(
  '#type' => 'checkbox',
  '#title' => t('Image border (Adding 1px solid border on all images). Note: No need to check this if you already checked "Image thumbnail"'),
  '#default_value' => theme_get_setting('img_border')
);

$form['images']['general']['img_border_color'] = array(
  '#type' => 'select',
  '#title' => t('Image border color (Choose what color your border would be)'),
  '#default_value' => theme_get_setting('img_border_color'),
  '#empty_option' => t('None'),
  '#options' => [
    'border-primary' => 'Primary',
    'border-secondary' => 'Secondary',
    'border-success' => 'Success',
    'border-danger' => 'Danger',
    'border-warning' => 'Warning',
    'border-info' => 'Info',
    'border-light' => 'Light',
    'border-dark' => 'Dark',
    'border-white' => 'White'
  ]
);

$form['images']['general']['img_border_radius'] = array(
  '#type' => 'select',
  '#title' => t('Image border radius (Add class to an image to round its corners)'),
  '#default_value' => theme_get_setting('img_border_radius'),
  '#empty_option' => t('None'),
  '#options' => [
    'rounded' => 'Rounded',
    'rounded-top' => 'Rounded-top',
    'rounded-right' => 'Rounded-right',
    'rounded-bottom' => 'Rounded-bottom',
    'rounded-left' => 'Rounded-left',
    'rounded-circle' => 'Rounded-circle',
    'rounded-pill' => 'Rounded-pill',
    'rounded-0' => 'Rounded-0'
  ]
);

// Tables

$form['tables'] = array(
  '#type' => 'details',
  '#title' => t('Tables'),
  '#group' => '<%= themeName %>',
);

$form['tables']['general'] = array(
  '#type' => 'details',
  '#title' => 'General Tables Settings',
  '#collapsible' => true,
  '#open' => true,
);

$form['tables']['general']['tables_background'] = array(
  '#type' => 'select',
  '#title' => t('Tables background'),
  '#default_value' => theme_get_setting('tables_background'),
  '#empty_option' => t('None'),
  '#options' => [
    'table-light' => 'Light',
    'table-dark' => 'Dark'
  ],
);

$form['tables']['general']['thead_background'] = array(
  '#type' => 'select',
  '#title' => t('Table thead background'),
  '#default_value' => theme_get_setting('thead_background'),
  '#options' => [
    'none' => 'None',
    'thead-light' => 'Light',
    'thead-dark' => 'Dark'
  ],
);

$form['tables']['general']['tables_borders'] = array(
  '#type' => 'select',
  '#title' => t('Choose between bordered or borderless tables'),
  '#default_value' => theme_get_setting('tables_borders'),
  '#empty_option' => t('None'),
  '#options' => [
    'table-bordered' => 'Bordered',
    'table-borderless' => 'Borderless'
  ],
);

$form['tables']['general']['tables_striped_rows'] = array(
  '#type' => 'checkbox',
  '#title' => t('Use .table-striped to add zebra-striping to any table row within the tbody'),
  '#default_value' => theme_get_setting('tables_striped_rows')
);

$form['tables']['general']['tables_hover'] = array(
  '#type' => 'checkbox',
  '#title' => t('Add .table-hover to enable a hover state on table rows within a tbody'),
  '#default_value' => theme_get_setting('tables_hover')
);

$form['tables']['general']['tables_sm'] = array(
  '#type' => 'checkbox',
  '#title' => t('Add .table-sm to make tables more compact by cutting cell padding in half'),
  '#default_value' => theme_get_setting('tables_sm')
);

$form['tables']['general']['tables_responsive'] = array(
  '#type' => 'select',
  '#title' => t('Use .table-responsive{-sm|-md|-lg|-xl} as needed to create responsive tables up to a particular breakpoint'),
  '#default_value' => theme_get_setting('tables_responsive'),
  '#options' => [
    'none' => 'None',
    'table-responsive' => 'All',
    'table-responsive-sm' => 'Sm',
    'table-responsive-md' => 'Md',
    'table-responsive-lg' => 'Lg',
    'table-responsive-xl' => 'Xl'
  ],
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
  '#collapsible' => true,
  '#open' => true,
  '#description' => t('All additional classes and settings for each region')
);


// All regions
$theme = \Drupal::theme()->getActiveTheme()->getName();
$exclude_regions = array('navbar', 'navbar_collapsed', 'hidden');
$region_list = system_region_list($theme, $show = REGIONS_ALL);

foreach ($region_list as $name => $description) {
  if (!in_array($name, $exclude_regions)){
    if (theme_get_setting('region_classes_' . $name) !== null) {
      $region_class = theme_get_setting('region_classes_' . $name);
    } else {
      $region_class = '';
    }

    $form['layout']['regions'][$name] = array(
      '#type' => 'details',
      '#title' => $description,
      '#collapsible' => true,
      '#open' => false,
    );
    $form['layout']['regions'][$name]['region_classes_' . $name] = array(
      '#type' => 'textfield',
      '#title' => t('@description classes', array('@description' => $description)),
      '#default_value' => $region_class
    );
    $form['layout']['regions'][$name]['region_container_' . $name] = [
      '#type' => 'select',
      '#title' => t('Container type'),
      '#options' => [
        'no' => t('No container'),
        'container' => t('Fixed'),
        'container-fluid' => t('Fluid'),
      ],
      '#default_value' => theme_get_setting('region_container_' . $name),
      '#group' => 'container',
    ];
  }
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
  '#collapsible' => true,
  '#open' => true,
);

$form['fonts']['icons']['icon_set'] = array(
  '#type' => 'select',
  '#title' => t('Icon set'),
  '#default_value' => theme_get_setting('icon_set'),
  '#empty_option' => t('None'),
  '#description' => t('On how to use each Icon Set visit their website : @fa_link, @socicon, @material_icon, @stroke7', array(
    '@fa_link' => Drupal::l('Font Awesome', Url::fromUri('http://fontawesome.com/', ['absolute' => true])),
    '@socicon' => Drupal::l('Socicon', Url::fromUri('http://www.socicon.com/', ['absolute' => true])),
    '@material_icon' => Drupal::l('Material Design Icons', Url::fromUri('https://material.io/tools/icons/', ['absolute' => true])),
    '@stroke7' => Drupal::l('Stroke 7', Url::fromUri('https://themes-pixeden.com/font-demos/7-stroke/', ['absolute' => true])),
  )),
  '#options' => array(
    'fontawesome' => 'Font Awesome',
    'socicon' => 'Socicon',
    'material_design_icons' => 'Material Design Icons',
    'stroke_7' => 'Stroke 7 Icon Set'
  ),
);

  //Change collapsible fieldsets (now details) to default #open => FALSE.
$form['theme_settings']['#open'] = false;
$form['logo']['#open'] = false;
$form['favicon']['#open'] = false;
