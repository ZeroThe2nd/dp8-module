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
  public function kaomojiString() {
    return json_encode([

    ]);
  }
}
