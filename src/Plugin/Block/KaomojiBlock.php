<?php

namespace Drupal\poc\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use pepijnzegveld\Dp8TestServices\KaomojiService;

/**
 * Provides a Kaomoji block for a random Kaomoji everywhere.
 *
 * @Block(
 *   id = "kaomoji_block",
 *   admin_label = @Translation("Kaomoji Block"),
 * )
 */
class KaomojiBlock extends BlockBase
{
    private $kaomojiService;

    public function __construct(array $configuration, $plugin_id, $plugin_definition)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);

        $this->kaomojiService = new KaomojiService;
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        return [
            '#markup' => $this->t('Hello, World!'),
            '#theme' => 'kaomoji'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function blockAccess(AccountInterface $account)
    {
        return AccessResult::allowedIfHasPermission($account, 'view kaomoji');
    }
}