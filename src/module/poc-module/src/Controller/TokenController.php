<?php namespace Drupal\poc\Controller;

use Drupal\poc\Service\RestService;

/**
 * Class TokenController
 *
 * @package Drupal\poc\Controller
 */
class TokenController {

  private $restApi;

  public function __construct() {
    $this->restApi = new RestService();
  }

  public function getYesNo() {
    return [
      '#yesNo' => $this->restApi->getYesNo(),
      '#theme' => 'yesno',
      '#attached' => [
        'library' => [
          'poc/poc',
        ],
      ],
    ];
  }
}
