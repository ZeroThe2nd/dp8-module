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
class KaomojiBlock extends BlockBase {

  private $kaomojiService;

  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->kaomojiService = new KaomojiService;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::config('poc.settings');
    $useApp = (bool) $config->get('poc.UseKaomojiApp');
    $render = [
      '#cache' => [
        'max-age' => 0,
      ],
      '#libraries' => [
        'poc/style',
      ],
    ];

    if ($useApp) {
      return array_merge($render, [
        '#theme' => 'kaomoji-app',
        '#attached' => [
          'library' => [
            'poc/kaomoji-app',
          ],
        ],
      ]);
    }

    // Use the static version
    return array_merge($render, [
      '#kaomoji' => $this->kaomojiService->getKaomoji(),
      '#theme' => 'kaomoji',
    ]);
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'view kaomoji');
  }
}
