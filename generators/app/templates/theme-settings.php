<?php

/**
 * @file
 * theme-settings.php
 *
 * Provides theme settings
 *
 * @see ./includes/settings.inc
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Implementation of hook_form_system_theme_settings_alter()
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 *
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function <%= themeName %>_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {

  // Theme info
  $theme = \Drupal::theme()->getActiveTheme()->getName();
  $theme_path =  \Drupal::theme()->getActiveTheme()->getPath();

  // Regions
  $region_list = system_region_list($theme, $show = REGIONS_ALL);
  $exclude_regions = array('navbar', 'navbar_collapsed', 'hidden');

  // For the custom form handler
  $theme_file = drupal_get_path('theme', $theme) . '/theme-settings.php';
  $build_info = $form_state->getBuildInfo();
  if (!in_array($theme_file, $build_info['files'])) {
    $build_info['files'][] = $theme_file;
  }
  $form_state->setBuildInfo($build_info);
  $form['#submit'][] = $theme . '_form_system_theme_settings_submit';


    // Vertical tabs
  $form['<%= themeName %>'] = array(
    '#type' => 'vertical_tabs',
    '#prefix' => '<h2><small>' . t('govance Settings') . '</small></h2>',
    '#weight' => -10,
    '#description' => t('Note: Some of these settings require you to <a href="@cache-link">flush caches.</a></br>
      Different Note: There is a collection of relevant Bootstrap components and your custom Icon set <a href="@test-page-link" target="_blank">here</a>',
      array(
        '@cache-link' => Url::fromRoute('system.performance_settings')->toString(),
        '@test-page-link' => Url::fromUri('internal:/' . $theme_path . '/' . $theme . '-test-page.html')->toString()
      )
    )
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
    '#description' => t('Place logo code inside HTML.'),
    '#default_value' => theme_get_setting('inline_logo')
  );

    $form['settings']['general']['btt'] = array(
    '#type' => 'checkbox',
    '#title' => t('Back to top'),
    '#description' => t('Add a little back to top arrow to your site.'),
    '#default_value' => theme_get_setting('btt')
  );

  $form['settings']['general']['menu_icons'] = array(
    '#type' => 'checkbox',
    '#title' => t('Menu icons'),
    '#description' => t('When this is checked you can use a seperator <b> | </b> and write down classes and it will generate an <code>&#60;i&#62;</code> tag with those classes.'),
    '#default_value' => theme_get_setting('menu_icons')
  );

  $form['settings']['general']['fadein_page_onload'] = array(
    '#type' => 'checkbox',
    '#title' => t('Fade in pages'),
    '#description' => t('All pages will have "fade-in" effect on document load.'),
    '#default_value' => theme_get_setting('fadein_page_onload')
  );

  $form['settings']['general']['dropdown_hover'] = [
    '#type' => 'checkbox',
    '#title' => t('On hover dropdowns'),
    '#default_value' => theme_get_setting('dropdown_hover'),
    '#description' => t('Open Bootstrap @dropdowns on hover instead on click, and make the parents clickable.', array(
      '@dropdowns' => Drupal::l('dropdowns', Url::fromUri('https://getbootstrap.com/docs/4.2/components/dropdowns/',  ['absolute' => true, 'attributes' => array('target' => '_blank')])),
    ))
  ];

  $form['settings']['general']['node_links_btn_group'] = [
    '#type' => 'checkbox',
    '#title' => t('Btn group - node links'),
    '#default_value' => theme_get_setting('node_links_btn_group'),
    '#description' => t('Display node links as @btn-groups.', array(
      '@btn-groups' => Drupal::l('buttons', Url::fromUri('https://getbootstrap.com/docs/4.2/components/button-group/',  ['absolute' => true, 'attributes' => array('target' => '_blank')])),
    )),
  ];

  // Content
  $form['settings']['content'] = array(
    '#type' => 'details',
    '#collapsible' => true,
    '#title' => t('Content')
  );

  $form['settings']['content']['main_container'] = [
    '#type' => 'select',
    '#title' => t('Main container type'),
    '#empty_option' => t('None'),
    '#options' => [
      'container' => t('Fixed'),
      'container-fluid' => t('Fluid'),
    ],
    '#default_value' => theme_get_setting('main_container'),
    '#group' => 'container',
  ];

  $form['settings']['content']['main_container_classes'] = array(
    '#type' => 'textfield',
    '#title' => t('Main content classes'),
    '#default_value' => theme_get_setting('main_container_classes')
  );

  // navbar

  $form['header'] = array(
    '#type' => 'details',
    '#title' => t('Navbar and Navbar Collapsed'),
    '#group' => '<%= themeName %>',
  );

  $form['header']['navbar'] = array(
    '#type' => 'details',
    '#title' => "Navbar Settings",
    '#collapsible' => true,
    '#description' => t('Additional classes and container settings for navbar region'),
    '#open' => true
  );

  $form['header']['navbar']['navbar_position'] = array(
    '#type' => 'select',
    '#title' => t('Navbar position'),
    '#default_value' => theme_get_setting('navbar_position'),
    '#empty_option' => t('None'),
    '#options' => [
      'fixed-top' => 'Fixed top',
      'fixed-bottom' => 'Fixed bottom',
      'sticky-top' => 'Sticky top'
    ]
  );

  $form['header']['navbar']['navbar_container'] = [
    '#type' => 'select',
    '#title' => t('Navbar container type'),
    '#empty_option' => t('None'),
    '#options' => [
      'container' => t('Fixed'),
      'container-fluid' => t('Fluid'),
    ],
    '#default_value' => theme_get_setting('navbar_container'),
    '#group' => 'container',
  ];

  $form['header']['navbar']['navbar_color'] = array(
    '#type' => 'select',
    '#title' => t('Navbar color'),
    '#default_value' => theme_get_setting('navbar_color'),
    '#empty_option' => t('None'),
    '#options' => [
      'navbar-dark' => 'Navbar dark',
      'navbar-light' => 'Navbar light'
    ]
  );

  $form['header']['navbar']['navbar_classes'] = array(
    '#type' => 'textfield',
    '#title' => t('Navbar classes'),
    '#default_value' => theme_get_setting('navbar_classes')
  );

  $form['header']['navbar']['navbar_expand'] = array(
    '#type' => 'select',
    '#title' => t('Responsive'),
    '#default_value' => theme_get_setting('navbar_expand'),
    '#empty_option' => t('None'),
    '#options' => [
      'navbar-expand-sm' => 'Navbar expand on sm',
      'navbar-expand-md' => 'Navbar expand on md',
      'navbar-expand-lg' => 'Navbar expand on lg',
      'navbar-expand-xl' => 'Navbar expand on xl'
    ]
  );

  $form['header']['navbar']['navbar_offcanvas'] = array(
    '#type' => 'checkbox',
    '#title' => t('Navbar offcanvas'),
    '#description' => t('Change from default @bootstrap-navbar to navbar offcanvas.', array(
      '@bootstrap-navbar' => Drupal::l('Bootstrap navbar', Url::fromUri('https://getbootstrap.com/docs/4.2/components/navbar/',  ['absolute' => true, 'attributes' => array('target' => '_blank')])),
    )),
    '#default_value' => theme_get_setting('navbar_offcanvas')
  );

  $form['header']['navbar_collapsed'] = array(
    '#type' => 'details',
    '#title' => "Navbar Collapsed Settings",
    '#collapsible' => true,
    '#description' => t('Additional classes and settings for navbar collapsed region, region used for Main navigation, Language block...'),
    '#open' => false
  );

  $form['header']['navbar_collapsed']['navbar_collapsed_classes'] = array(
    '#type' => 'textfield',
    '#title' => t('Navbar collapsed classes'),
    '#default_value' => theme_get_setting('navbar_collapsed_classes')
  );

  $form['header']['navbar_collapsed']['navbar_collapsed_container'] = [
    '#type' => 'select',
    '#title' => t('Navbar collapsed container type'),
    '#empty_option' => t('None'),
    '#options' => [
      'container' => t('Fixed'),
      'container-fluid' => t('Fluid'),
    ],
    '#default_value' => theme_get_setting('navbar_collapsed_container'),
    '#group' => 'container',
  ];

  // Blocks
  $form['blocks'] = array(
    '#type' => 'details',
    '#title' => t('Blocks'),
    '#group' => '<%= themeName %>',
  );

  // Language block.
  $form['blocks']['language_block'] = array(
    '#type' => 'details',
    '#title' => "Language Block Settings",
    '#collapsible' => true,
    '#open' => true
  );

  $form['blocks']['language_block']['language_block_code'] = [
    '#type' => 'checkbox',
    '#title' => t('Language codes'),
    '#default_value' => theme_get_setting('language_block_code'),
    '#description' => t('Display language codes instead of titles.'),
  ];

  $form['blocks']['language_block']['language_block_type'] = [
    '#type' => 'select',
    '#title' => t('Language block type'),
    '#options' => [
      'links' => t('Default'),
      'inline' => t('Links Inline'),
      'dropdown' => t('Dropdown')],
    '#default_value' => theme_get_setting('language_block_type'),
    '#description' => t('Render the language block as is, inline or as a dropdown menu'),
  ];

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
    '#title' => t('Submit buttons'),
    '#description' => t('Convert all input submit elements to buttons. Note: use at your own risk, some bugs may occur!'),
    '#default_value' => theme_get_setting('submit_button')
  );

  $form['forms']['custom_forms'] = array(
    '#type' => 'details',
    '#title' => 'Custom forms',
    '#description' => t('Check which form element type should use Bootstrap @custom-forms.', array(
      '@custom-forms' => Drupal::l('custom forms', Url::fromUri('https://getbootstrap.com/docs/4.2/components/forms/#custom-forms/',  ['absolute' => true, 'attributes' => array('target' => '_blank')]))
    )),
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

  $form['images_and_tables'] = array(
    '#type' => 'details',
    '#title' => t('Images and Tables'),
    '#group' => '<%= themeName %>',
  );

  $form['images_and_tables']['images'] = array(
    '#type' => 'details',
    '#title' => 'Image Settings',
    '#collapsible' => true,
    '#open' => true,
  );


  $form['images_and_tables']['images']['responsive_images'] = array(
    '#type' => 'checkbox',
    '#title' => t('Responsive images'),
    '#description' => t('Images in Bootstrap are made responsive with <code>.img-fluid</code> class so that they scale with the parent element.<br> For more informations go to @img-responsive.', array(
      '@img-responsive' => Drupal::l('Responsive images', Url::fromUri('https://getbootstrap.com/docs/4.2/content/images/#responsive-images/', ['absolute' => true, 'attributes' => array('target' => '_blank')])),
    )),
    '#default_value' => theme_get_setting('responsive_images')
  );

  $form['images_and_tables']['images']['img_thumbnail'] = array(
    '#type' => 'checkbox',
    '#title' => t('Image thumbnail'),
    '#description' => t('You can use bootstrap <code>.img-thumbnail</code> class to give an image some padding and a rounded 1px border appearance. <br> For more informations check on their official website @img-thumbnail.', array(
      '@img-thumbnail' => Drupal::l('Thumbnail images', Url::fromUri('https://getbootstrap.com/docs/4.2/content/images/#image-thumbnails/',  ['absolute' => true, 'attributes' => array('target' => '_blank')])),
    )),
    '#default_value' => theme_get_setting('img_thumbnail'),
    '#states' => [
      'invisible' => [
        'input[name="img_border"]' => ['checked' => TRUE],
      ],
    ],
  );

  $form['images_and_tables']['images']['img_border'] = array(
    '#type' => 'checkbox',
    '#title' => t('Image border'),
    '#description' => t('Adding 1px solid border on all images. <br> Note: No need to check this if you already checked "Image thumbnail".'),
    '#default_value' => theme_get_setting('img_border'),
    '#states' => [
      'invisible' => [
        'input[name="img_thumbnail"]' => ['checked' => TRUE],
      ],
    ],
  );

  $form['images_and_tables']['images']['img_border_color'] = array(
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
    ],
    '#states' => [
      'invisible',
      'visible' => [
        'input[name="img_border"]' => ['checked' => TRUE],
      ],
    ],
  );

  $form['images_and_tables']['images']['img_border_radius'] = array(
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
    ],
    '#states' => [
      'invisible',
      'visible' => [
        'input[name="img_border"]' => ['checked' => TRUE],
      ],
    ],
  );

  // Tables

  $form['images_and_tables']['tables'] = array(
    '#type' => 'details',
    '#title' => 'Table Settings',
    '#collapsible' => true,
  );

  $form['images_and_tables']['tables']['tables_background'] = array(
    '#type' => 'select',
    '#title' => t('Tables background'),
    '#default_value' => theme_get_setting('tables_background'),
    '#empty_option' => t('None'),
    '#options' => [
      'table-light' => 'Light',
      'table-dark' => 'Dark'
    ],
  );

  $form['images_and_tables']['tables']['thead_background'] = array(
    '#type' => 'select',
    '#title' => t('Table thead background'),
    '#default_value' => theme_get_setting('thead_background'),
    '#empty_option' => t('None'),
    '#options' => [
      'thead-light' => 'Light',
      'thead-dark' => 'Dark'
    ],
  );

  $form['images_and_tables']['tables']['tables_borders'] = array(
    '#type' => 'select',
    '#title' => t('Choose between bordered or borderless tables'),
    '#default_value' => theme_get_setting('tables_borders'),
    '#empty_option' => t('None'),
    '#options' => [
      'table-bordered' => 'Bordered',
      'table-borderless' => 'Borderless'
    ],
  );

  $form['images_and_tables']['tables']['tables_striped_rows'] = array(
    '#type' => 'checkbox',
    '#title' => 'Table striped',
    '#description' => t('Zebra-striping to any table row within the <code>tbody</code>. For more informations go to @table-striped.', array(
      '@table-striped' => Drupal::l('Table striped', Url::fromUri('https://getbootstrap.com/docs/4.2/content/tables/#striped-rows/',  ['absolute' => true, 'attributes' => array('target' => '_blank')]))
    )),
    '#default_value' => theme_get_setting('tables_striped_rows')
  );

  $form['images_and_tables']['tables']['tables_hover'] = array(
    '#type' => 'checkbox',
    '#title' => 'Table hover',
    '#description' => t('Enable hover state on table rows within a <code>tbody</code>. For more informations go to @table-hover', array(
      '@table-hover' => Drupal::l('Table hover', Url::fromUri('https://getbootstrap.com/docs/4.2/content/tables/#hoverable-rows/',  ['absolute' => true, 'attributes' => array('target' => '_blank')]))
    )),
    '#default_value' => theme_get_setting('tables_hover')
  );

  $form['images_and_tables']['tables']['tables_sm'] = array(
    '#type' => 'checkbox',
    '#title' => 'Table small',
    '#description' => t('Make tables more compact by cutting cell padding in half. For more informations go to @table-small', array(
      '@table-small' => Drupal::l('Table small', Url::fromUri('https://getbootstrap.com/docs/4.2/content/tables/#small-table/',  ['absolute' => true, 'attributes' => array('target' => '_blank')]))
    )),
    '#default_value' => theme_get_setting('tables_sm')
  );

  $form['images_and_tables']['tables']['tables_responsive'] = array(
    '#type' => 'select',
    '#title' => t('Use .table-responsive{-sm|-md|-lg|-xl} as needed to create responsive tables up to a particular breakpoint'),
    '#default_value' => theme_get_setting('tables_responsive'),
    '#empty_option' => t('None'),
    '#options' => [
      'table-responsive' => 'All',
      'table-responsive-sm' => 'Sm',
      'table-responsive-md' => 'Md',
      'table-responsive-lg' => 'Lg',
      'table-responsive-xl' => 'Xl'
    ],
  );

  // Layout
  $form['regions'] = array(
    '#type' => 'details',
    '#title' => t('Regions'),
    '#group' => '<%= themeName %>',
    '#description' => t('Additional classes and container settings for each region')
  );

  // Regions
  foreach ($region_list as $name => $description) {
    if (!in_array($name, $exclude_regions)){
      if (theme_get_setting('region_classes_' . $name) !== null) {
        $region_class = theme_get_setting('region_classes_' . $name);
      } else {
        $region_class = '';
      }

      $form['regions'][$name] = array(
        '#type' => 'details',
        '#title' => $description,
        '#collapsible' => true,
        '#open' => false,
      );
      $form['regions'][$name]['region_classes_' . $name] = array(
        '#type' => 'textfield',
        '#title' => t('@description classes', array('@description' => $description)),
        '#default_value' => $region_class
      );
      $form['regions'][$name]['region_container_' . $name] = [
        '#type' => 'select',
        '#title' => t('Container type'),
        '#empty_option' => t('None'),
        '#options' => [
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

  $form['fonts']['google_fonts'] = array(
    '#type' => 'details',
    '#title' => t('Google Fonts'),
    '#collapsible' => true,
    '#open' => true,
    '#description' => t('A few predefined font libraries deliverd from Google.')
  );


  $form['fonts']['google_fonts']['font_set'] = array(
    '#type' => 'select',
    '#title' => t('Font libraries'),
    '#default_value' => theme_get_setting('font_set'),
    '#empty_option' => t('None'),
    '#description' => t('All fonts are loaded with Regular, Italic and Bold variants.'),
    '#options' => array(
      'roboto' => 'Roboto',
      'raleway' => 'Raleway',
      'montserrat' => 'Montserrat',
      'open_sans' => 'Open Sans',
      'lato' => 'Lato'
    ),
  );

  $form['fonts']['icons'] = array(
    '#type' => 'details',
    '#title' => t('Icons'),
    '#collapsible' => true,
    '#open' => true,
    '#description' => t('Chose which Icon Font should be loaded'),
  );

  $form['fonts']['icons']['icon_set'] = array(
    '#type' => 'select',
    '#title' => t('Icon set'),
    '#default_value' => theme_get_setting('icon_set'),
    '#empty_option' => t('None'),
    '#description' => t('On how to use each Icon Set visit their website : @fa_link, @socicon, @material_icon, @stroke7', array(
      '@fa_link' => Drupal::l('Font Awesome', Url::fromUri('http://fontawesome.com/', ['absolute' => true, 'target' => '_blank'])),
      '@socicon' => Drupal::l('Socicon', Url::fromUri('http://www.socicon.com/',  ['absolute' => true, 'attributes' => array('target' => '_blank')])),
      '@material_icon' => Drupal::l('Material Design Icons', Url::fromUri('https://material.io/tools/icons/',  ['absolute' => true, 'attributes' => array('target' => '_blank')])),
      '@stroke7' => Drupal::l('Stroke 7', Url::fromUri('https://themes-pixeden.com/font-demos/7-stroke/',  ['absolute' => true, 'attributes' => array('target' => '_blank')])),
    )),
    '#options' => array(
      'fontawesome' => 'Font Awesome',
      'socicon' => 'Socicon',
      'material_design_icons' => 'Material Design Icons',
      'stroke_7' => 'Stroke 7 Icon Set'
    ),
  );

  // Custom  CSS
  $form['custom_css'] = array(
    '#type' => 'details',
    '#title' => t('Custom CSS'),
    '#group' => '<%= themeName %>',
  );

  $form['custom_css']['<%= themeName %>_custom_css_on'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable custom CSS'),
    '#default_value' => theme_get_setting('<%= themeName %>_custom_css_on'),
  );
  if (file_exists('public://<%= themeName %>-custom.css'))
    $custom_file = file_get_contents('public://<%= themeName %>-custom.css');
  else
    $custom_file = '';

  $form['custom_css']['<%= themeName %>_custom_css'] = array(
    '#type' => 'textarea',
    '#title' => t('Custom CSS'),
    '#rows' => 14,
    '#resizable' => TRUE,
    '#default_value' => $custom_file,
    '#states' => [
      'invisible',
      'visible' => [
        'input[name="<%= themeName %>_custom_css_on"]' => ['checked' => TRUE],
      ],
    ],
  );

  // Change collapsible fieldsets (now details) to default #open => FALSE.
  $form['theme_settings']['#open'] = false;
  $form['logo']['#open'] = false;
  $form['favicon']['#open'] = false;
}


/**
 * Save custom CSS to file on theme setting form submit.
 */
function <%= themeName %>_form_system_theme_settings_submit(&$form, FormStateInterface $form_state) {
  file_unmanaged_save_data($form_state->getValue('<%= themeName %>_custom_css'), 'public://<%= themeName %>-custom.css', FILE_EXISTS_REPLACE);
}
