<?php

namespace Drupal\infinity_actions\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Module settings
 */
class SettingsForm extends ConfigFormBase
{

    /**
     * Config settings.
     *
     * @var string
     */
    const SETTINGS = 'infinity_actions.settings';

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'infinity_actions_admin_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
            static::SETTINGS,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $config = $this->config(static::SETTINGS);

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $this->configFactory->getEditable(static::SETTINGS)->save();

        parent::submitForm($form, $form_state);
    }

}
