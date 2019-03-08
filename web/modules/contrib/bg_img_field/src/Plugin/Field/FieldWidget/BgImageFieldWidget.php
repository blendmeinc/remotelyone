<?php

namespace Drupal\bg_img_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\image\Plugin\Field\FieldWidget\ImageWidget;

/**
 * Plugin implementation of the 'image_image' widget.
 *
 * @FieldWidget(
 *   id = "bg_img_field_widget",
 *   label = @Translation("Background Image Field Widget"),
 *   field_types = {
 *     "bg_img_field"
 *   }
 * )
 */
class BgImageFieldWidget extends ImageWidget {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $settings = parent::defaultSettings();
    // Add the specific css settings.
    $settings['css_settings']['css_selector'] = '';
    $settings['css_settings']['css_repeat'] = 'inherit';
    $settings['css_settings']['css_background_size'] = 'inherit';
    $settings['css_settings']['css_background_position'] = 'inherit';

    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $elements = parent::formElement($items, $delta, $element, $form, $form_state);

    $elements['#upload_validators']['file_validate_extensions'][0] =
      $this->getFieldSetting('file_extensions');

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $new_values = parent::massageFormValues($values, $form, $form_state);

    foreach ($new_values as $key => $value) {
      $new_values[$key]['css_selector'] = $value['css_settings']['css_selector'];
      $new_values[$key]['css_repeat'] = $value['css_settings']['css_repeat'];
      $new_values[$key]['css_background_size'] = $value['css_settings']['css_background_size'];
      $new_values[$key]['css_background_position'] = $value['css_settings']['css_background_position'];
      unset($new_values[$key]['css_settings']);
    }

    return $new_values;
  }

  /**
   * {@inheritdoc}
   */
  public static function process($element, FormStateInterface $form_state, $form) {
    $elements = parent::process($element, $form_state, $form);

    $entity = $form_state->getformObject()->getEntity();

    // Check to see if the entity field definition exist.
    // If not apply default values.
    if (isset($element['#field_name']) && $entity->getFieldDefinition($element['#field_name']) !== NULL) {
      $field_settings = $entity->getFieldDefinition($element['#field_name'])
        ->getSettings();
    }
    else {
      $field_settings = self::defaultSettings();
    }

    $css_option_settings = $field_settings['css_settings'];

    if ($element['#files']) {

      $elements['css_settings'] = [
        '#type' => 'details',
        '#title' => t('CSS Settings'),
        '#description' => t('Set default CSS properties for the background image.'),
        '#open' => FALSE,
      ];

      $token_types = [$entity->getEntityType()->id()];

      // Background selector value.
      $selector = !empty($element['#value']['css_selector']) ?
      $element['#value']['css_selector'] : $css_option_settings['css_selector'];

      // The css selector input field needed to.
      $elements['css_settings']['css_selector'] = [
        '#type' => 'textfield',
        '#title' => t('Selector'),
        '#description' => t('CSS Selector for background image.'),
        '#default_value' => $selector,
        '#token_types' => $token_types,
        '#required' => FALSE,
      ];

      // The tokens that are scoped for the selector input.
      $elements['css_settings']['tokens'] = [
        '#theme' => 'token_tree_link',
        '#token_types' => $token_types,
        '#global_types' => TRUE,
        '#show_nested' => FALSE,
      ];

      // Background repeat value.
      $repeat = !empty($element['#value']['css_selector']) ?
        $element['#value']['css_repeat']
        : $css_option_settings['css_repeat'];
      // User ability to select a background repeat option.
      $elements['css_settings']['css_repeat'] = [
        '#type' => 'radios',
        '#title' => t('Repeat Options'),
        '#description' => t('Add the css no repeat value to the background image.'),
        '#default_value' => $repeat,
        '#options' => [
          "inherit" => t("inherit"),
          "no-repeat" => t("no-repeat"),
          "repeat" => t('repeat'),
        ],
      ];

      // Background size value.
      $background_size = !empty($element['#value']['css_selector']) ?
        $element['#value']['css_background_size']
        : $css_option_settings['css_background_size'];
      // User the ability to choose background size.
      $elements['css_settings']['css_background_size'] = [
        '#type' => 'radios',
        '#title' => t('Background Size'),
        '#description' => t("Add the background size setting you would like for the image, use inherit for default."),
        '#default_value' => $background_size,
        '#options' => [
          'inherit' => t('inherit'),
          'auto' => t('auto'),
          'cover' => t('cover'),
          'contain' => t('contain'),
          'initial' => t('initial'),
        ],
      ];

      // Background position values.
      $background_pos = !empty($element['#value']['css_selector']) ?
        $element['#value']['css_background_position']
        : $css_option_settings['css_background_position'];
      // User the ability to set the background position.
      $elements['css_settings']['css_background_position'] = [
        '#type' => 'radios',
        '#title' => t('Background Position'),
        '#description' => t('Set a background position, leave unchecked to have your own in your theme css.'),
        '#default_value' => $background_pos,
        '#options' => [
          "inherit" => t("inherit"),
          "left top" => t("left top"),
          "left center" => t("left center"),
          "left bottom" => t("left bottom"),
          "right top" => t("right bottom"),
          "right center" => t("right center"),
          "right bottom" => t("right bottom"),
          "center top" => t("center top"),
          "center center" => t("center center"),
          "center bottom" => t("center bottom"),
        ],
        '#tree' => TRUE,
      ];
    }
    return $elements;
  }

}
