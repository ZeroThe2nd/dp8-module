<?php

namespace Drupal\poc\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
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

  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), ['kaomoji_block']);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::config('poc.settings');
    $useApp = (bool) $config->get('poc.UseKaomojiApp');

    if ($useApp) {
      // Use the app
      return [
        '#theme' => 'kaomoji-app',
        '#cache' => [
          'max-age' => 0,
        ],
        '#libraries' => [
          'poc/style',
        ],
        '#attached' => [
          'library' => [
            'poc/kaomoji-app',
          ],
        ],
      ];
    }

    // Use the static version
    return [
      '#theme' => 'kaomoji',
      '#kaomoji' => $this->kaomojiService->getKaomoji(),
      '#cache' => [
        'max-age' => 0,
      ],
      '#libraries' => [
        'poc/style',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'view kaomoji');
  }
}
