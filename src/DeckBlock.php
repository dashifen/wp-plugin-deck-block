<?php

namespace Dashifen\Blocks\DeckBlock;

use Dashifen\WPHandler\Handlers\HandlerException;
use Dashifen\WPHandler\Handlers\Plugins\AbstractPluginHandler;

class DeckBlock extends AbstractPluginHandler
{
  /**
   * initialize
   *
   * Uses addAction and/or addFilter to attach protected methods of this object
   * into the WordPress hook ecosystem.
   *
   * @return void
   * @throws HandlerException
   */
  public function initialize(): void
  {
    if (!$this->isInitialized()) {
      $this->addAction('enqueue_block_editor_assets', 'addEditorAssets');
      $this->addAction('init', 'registerBlocks');
    }
  }
  
  /**
   * addAssets
   *
   * Enqueues the editor JS and CSS assets for these blocks.
   */
  protected function addEditorAssets(): void
  {
    $this->enqueue('assets/deck-block.min.js');
    $this->enqueue('assets/deck-block.css');
  }
  
  /**
   * registerBlocks
   *
   * Registers the Deck and Card blocks.
   *
   * @return void
   */
  protected function registerBlocks(): void
  {
    register_block_type(
      'dashifen/deck',
      [
        'render_callback' => [$this, 'renderDeck'],
        'attributes'      => [],
      ]
    );
    
    register_block_type(
      'dashifen/card',
      [
        'render_callback' => [$this, 'renderCard'],
        'attributes'      => [
          'heading' => ['type' => 'string'],
          'body'    => ['type' => 'string'],
        ],
      ]
    );
  }
  
  /**
   * renderDeck
   *
   * Renders a deck block.
   *
   * @param array  $attributes
   * @param string $content
   *
   * @return string
   */
  public function renderDeck(array $attributes, string $content): string
  {
    $cardCount = $attributes['cardCount'] ?? $this->countCards($content);
    $format = '<div class="wp-block-dashifen-deck %s" data-card-count="%d">%s</div>';
    return sprintf($format, 'cards-' . $cardCount, $cardCount, $content);
  }
  
  /**
   * countCards
   *
   * Until we identify a way for the block editor to count the number of cards
   * in a deck for us, we'll rely on counting the number of times that we find
   * the card class within the deck's content and return a class based on that
   * discovery.
   *
   * @param string $deckContent
   *
   * @return int
   */
  private function countCards(string $deckContent): int
  {
    return substr_count($deckContent, 'wp-block-dashifen-card');
  }
  
  /**
   * renderCard
   *
   * Renders a card block.
   *
   * @param array $attributes
   *
   * @return string
   */
  public function renderCard(array $attributes): string
  {
    $format = <<< CARD
      <div class="wp-block-dashifen-card">
        <h2 class="heading">%s</h2>
        <p class="body">%s</p>
      </div>
CARD;
    
    return sprintf(
      $format,
      $attributes['heading'] ?? 'Please enter a heading for this card.',
      $attributes['body'] ?? 'Please enter a body for this card.'
    );
  }
}
