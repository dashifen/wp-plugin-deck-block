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
        'attributes'      => [
          'perRow'      => ['type' => 'number', 'default' => 3],
          'perRowClass' => ['type' => 'string', 'default' => 'three'],
        ],
      ]
    );
    
    register_block_type(
      'dashifen/card',
      [
        'render_callback' => [$this, 'renderCard'],
        'attributes'      => [],
      ]
    );
  }
  
  /**
   * renderDeck
   *
   * Renders a deck block.
   *
   * @param array $attributes
   *
   * @return string
   */
  public function renderDeck(array $attributes): string
  {
    
    return '';
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
    
    return '';
  }
}
