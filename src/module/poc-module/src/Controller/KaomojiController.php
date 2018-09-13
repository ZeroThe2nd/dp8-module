<?php namespace Drupal\poc\Controller;

// Access URL data
use Drupal\Core\Url;
use Drupal\Component\Utility\Html;
use Drupal\poc\Service\LoremIpsumService;
use Drupal\poc\Service\RestService;

/**
 * Controller routines for Lorem ipsum pages.
 */
class KaomojiController {

  /** @var LoremIpsumService */
  private $loremIpsumService;

  /** @var \Drupal\poc\Service\RestService */
  private $restService;

  public function __construct() {
    $this->loremIpsumService = new LoremIpsumService;
    $this->restService = new RestService;
  }

  /**
   * Constructs Lorem ipsum text with arguments.
   * This callback is mapped to the path
   * 'poc/generate/{paragraphs}/{phrases}'.
   *
   * @param string $paragraphs
   *   The amount of paragraphs that need to be generated.
   * @param string $phrases
   *   The maximum amount of phrases that can be generated inside a paragraph.
   *
   * @return mixed
   */
  public function generate($paragraphs, $phrases) {
    $config = \Drupal::config('poc.settings');
    $lipsum = $this->loremIpsumService->getLoremIpsum($paragraphs, $phrases);
    $this->restService->setLastData($lipsum);

    return $element = [
      '#source_text' => $lipsum,
      '#title' => Html::escape(
        $config->get('poc.page_title')
      ),
      '#theme' => 'kaomoji',
      '#libraries' => [
          'poc/css',
          'poc/vue',
          'poc/kaomoji-app'
      ]
    ];
  }
}
