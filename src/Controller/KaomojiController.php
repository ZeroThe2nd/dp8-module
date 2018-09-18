<?php namespace Drupal\poc\Controller;

// Access URL data
use pepijnzegveld\Dp8TestServices\KaomojiService;

class KaomojiController {

  /** @var KaomojiService */
  private $kaomojiService;

  /**
   * KaomojiController constructor.
   */
  public function __construct() {
    $this->kaomojiService = new KaomojiService;
  }

  /**
   * API entry for the Vue KaomojiApp
   *
   * @return string
   * @throws \Exception
   */
  public function getKaomoji() {
    header("Content-type: Application/json", TRUE, 200);
    return json_encode([
      'kaomoji' => $this->kaomojiService->getKaomoji(),
    ]);
  }
}
