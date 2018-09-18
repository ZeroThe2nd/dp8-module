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

  public function generate($length = 64) {
    $config = \Drupal::config('poc.settings');
    $charset = $config->get('poc.TokenAlphabet');
    if (!is_null($charset)) {
      $this->tokenService->setTokenChars((string) $charset);
    }

    return [
      '#token' => $this->tokenService->generateToken($length),
      '#theme' => 'token',
      '#attached' => [
        'library' => [
          'poc/css',
        ],
      ],
    ];
  }
}
