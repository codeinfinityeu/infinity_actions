<?php

namespace Drupal\infinity_actions\Plugin\Action;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\node\Entity\Node;
use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;

/**
 * Content moderation action for node publishing.
 *
 * @Action(
 *   id = "infinity_actions_moderate_publish_node_action",
 *   label = @Translation("Publish node (moderation workflow)"),
 *   type = "node",
 *   confirm = TRUE
 * )
 */
class WorkflowPublishNodeAction extends ViewsBulkOperationsActionBase
{

    use StringTranslationTrait;

    /**
     * {@inheritdoc}
     */
    public function execute($entity = NULL)
    {
        if (!$moderation_state = $entity->get('moderation_state')->getString()) {
            return $this->t('Moderation state change for @title, is not allowed',
                [
                    '@title' => $entity->getTitle(),
                ]
            );
        }

        switch ($moderation_state) {
            case 'archive':
            case 'archived':
            case 'draft':
                $entity->set('moderation_state', 'published');
                $entity->save();
                break;
        }

        return $this->t('State for @title, changed to @state',
            [
                '@title' => $entity->getTitle(),
                '@state' => $entity->get('moderation_state')->getString(),
            ]
        );
    }

    /**
     * Action permission check
     * @param $object
     * @param \Drupal\Core\Session\AccountInterface|NULL $account
     * @param $return_as_object
     * @return mixed
     */
    public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {

        return $object->access('update', $account, $return_as_object);
    }
}
