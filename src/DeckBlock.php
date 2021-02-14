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
    $format = '<div class="%s" data-card-count="%d">%s</div>';
    $cardCount = $attributes['cardCount'] ?? $this->countCards($content);
    
    // we start with a reasonable default with respect to our deck classes and
    // then we add a filter that folks could use to alter them.  this lets a
    // theme using this block add classes it needs to make its display work
    // without being forced to repeat CSS rules in multiple places, hopefully.
    
    $classes = ['wp-block-dashifen-deck', 'cards-' . $cardCount];
    $classes = apply_filters('dashifen-deck-classes', $classes);
    return sprintf($format, join(' ', $classes), $cardCount, $content);
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
      <div class="%s">
        <h2 class="%s">%s</h2>
        <p class="%s">%s</p>
      </div>
CARD;
    
    // we offer a lot of filters here.  we'll do all that work first, and then,
    // we can cram the results of those filters into the $format we just
    // defined.  like for the deck above, we filter our default classes so
    // that themes can alter our defaults here.
    
    $heading = apply_filters('dashifen-card-heading', $attributes['heading'] ?? 'Please enter a heading for this card.');
    $body = apply_filters('dashifen-card-body', $attributes['body'] ?? 'Please enter a body for this card.');
    $cardClasses = join(' ', apply_filters('dashifen-card-classes', ['wp-block-dashifen-card']));
    $headingClasses = join(' ', apply_filters('dashifen-card-heading-classes', ['heading']));
    $bodyClasses = join(' ', apply_filters('dashifen-card-body-classes', ['body']));
    
    return sprintf($format, $cardClasses, $headingClasses, $heading, $bodyClasses, $body);
  }
}
