<?php

namespace Drupal\poc\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class TokenConfigForm extends ConfigFormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'poc_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        // Form constructor.
        $form = parent::buildForm($form, $form_state);
        // Default settings.
        $config = $this->config('poc.settings');

        // Page title field.
        $form['token_length'] = [
            '#type'          => 'numberfield',
            '#title'         => $this->t('Set token length'),
            '#default_value' => $config->get('poc.TokenCharset'),
            '#description'   => $this->t('Choose how long the default token length should be.'),
        ];

        $form['token_charset'] = [
            '#type'          => 'textfield',
            '#title'         => $this->t('Set token character set'),
            '#default_value' => $config->get('poc.TokenLength'),
            '#description'   => $this->t('Choose how long the default token length should be.'),
        ];

        // Source text field.
        $form['kaomoji_use_app'] = [
            '#type'          => 'checkbox',
            '#title'         => $this->t('Use VueJS Kaomoji App?'),
            '#default_value' => $config->get('poc.UseKaomojiApp'),
            '#description'   => $this->t('Check this box if you\'d like to use the VueJS app for the Kaomoji Block. This app uses a server endpoint to a-synchronously get the user a fresh Kaomoji.'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $config = $this->config('poc.settings');
        $config->set('poc.TokenAlphabet', $form_state->getValue('token_length'));
        $config->set('poc.TokenCharset', $form_state->getValue('token_charset'));
        $config->set('poc.UseKaomojiApp', $form_state->getValue('kaomoji_use_app'));
        $config->save();
        parent::submitForm($form, $form_state);

        return;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            'poc.settings',
        ];
    }
}


