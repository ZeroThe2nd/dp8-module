<?php namespace Drupal\poc\Controller;

use pepijnzegveld\Dp8TestServices\TokenService;

/**
 * Class TokenController
 *
 * @package Drupal\poc\Controller
 */
class TokenController {

  private $tokenService;

  public function __construct() {
    $this->tokenService = new TokenService;
  }

  /**
   * Ask service to generate a token with the given length for us.
   * Defaults to the config if no value is passed.
   * Updates the token charset if set in the config
   *
   * @param int|null $length
   *
   * @return array
   */
  public function generate($length = NULL) {
    $config = \Drupal::config('poc.settings');
    $tokenCharset = (string) $config->get('poc.TokenCharset');
    $tokenLength = (int) $config->get('poc.TokenLength');

    if (is_null($length) && empty($tokenLength)) {
      $tokenCharset = 64;
    }

    if (!is_null($tokenCharset)) {
      $this->tokenService->setTokenChars($tokenCharset);
    }

    return [
      '#token' => $this->tokenService->generateToken($tokenLength),
      '#theme' => 'token',
      '#attached' => [
        'library' => [
          'poc/style',
        ],
      ],
    ];
  }
}
