<?php


namespace Drupal\dd_cookiebar\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Class CookieSettingsForm
 * @package Drupal\dd_cookiebar\Form
 */
class CookieSettingsForm extends ConfigFormBase
{

    /**
     * Gets the configuration names that will be editable.
     *
     * @return array
     *   An array of configuration object names that are editable if called in
     *   conjunction with the trait's config() method.
     */
    protected function getEditableConfigNames()
    {
        return [
            'dd_cookiebar.settings'
        ];
    }

    /**
     * Returns a unique string identifying the form.
     *
     * @return string
     *   The unique string identifying the form.
     */
    public function getFormId()
    {
        return 'dd_cookiebar_settings';
    }

    /**
     * @param array $form
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     * @return mixed
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $configCookieSettings = \Drupal::config('dd_cookiebar.settings');

        $form['version'] = [
            '#type'          => 'textfield',
            '#title'         => 'Cookie version',
            '#default_value' => $configCookieSettings->get('version') ? $configCookieSettings->get('version') : '1.0',
            '#size'          => 10,
            '#required'      => true,
        ];

        $fid = $configCookieSettings->get('document');

        $form['document'] = array(
            '#title'             => $this->t('Cookie consent'),
            '#description'       => $this->t('Please upload the current cookie pdf document'),
            '#type'              => 'managed_file',
            '#upload_location'   => 'public://pdf',
            '#default_value'     => $fid ? [$fid] : '',
            '#upload_validators' => array(
                'file_validate_extensions' => array('pdf'),
                'file_validate_size'       => array(
                    file_upload_max_size(),
                ),
            ),
            '#required'          => true,
        );

        return parent::buildForm($form, $form_state);
    }

    /**
     * @param array $form
     * @param \Drupal\Core\Form\FormStateInterface $form_state
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = $this->configFactory->getEditable('dd_cookiebar.settings');
        $documentFid = $form_state->getValue('document')[0];
        $file = $this->saveImage($documentFid);

        if ($config->get('document') !== $documentFid || $config->get('version') !== $form_state->getValue('version')) {
            $config
                ->set('document', $documentFid)
                ->set('documentLink', $file->url())
                ->set('version', $form_state->getValue('version'))
                ->save();
        }

        parent::submitForm($form, $form_state);
    }

    /**
     * @param $fid
     * @return \Drupal\Core\Entity\EntityInterface|\Drupal\file\Entity\File|null
     * @throws \Drupal\Core\Entity\EntityStorageException
     */
    public function saveImage($fid)
    {
        $file = File::load($fid);
        if ($file) {
            $file->setPermanent();
            $file->save();

            return $file;
        }
    }
}
