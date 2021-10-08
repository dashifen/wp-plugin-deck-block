<?php
/**
 * Plugin Name:  Dashifen's Deck Block
 * Description: A WordPress Deck block, which contains between two and four Cards.
 * Author URI: mailto:dashifen@dashifen.com
 * Author: David Dashifen Kees
 * Version: 2.0.0
 */

use Dashifen\Blocks\DeckBlock\DeckBlock;
use Dashifen\WPHandler\Handlers\HandlerException;

if (!class_exists('Dashifen\Blocks\DeckBlock\DeckBlock')) {
  require_once 'vendor/autoload.php';
}

try {
  (function () {
    
    // by instantiating our object in this anonymous function we avoid putting
    // it in the global scope.  this prevents access to it from anywhere but
    // within this specific scope.
    
    $deckBlock = new DeckBlock();
    $deckBlock->initialize();
  })();
} catch (HandlerException $e) {
  DeckBlock::catcher($e);
}
