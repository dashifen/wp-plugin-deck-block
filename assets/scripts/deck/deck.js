import Icons from '../icons.js';
import DeckEdit from './deck-edit.js';

const Deck = (() => {
  const { registerBlockType } = wp.registerBlockType;
  const { InnerBlocks } = wp.blockEditor;

  registerBlockType('dashifen/deck', {
    title: 'Deck',
    category: 'layout',
    description: 'A block providing a container for a set of cards.',
    icon: Icons.deck,
    supports: {
      customClassName: false
    },
    attributes: {
      perRow: {
        default: 3
      },
      perRowClass: {
        type: 'text',
        default: 'three'
      }
    },

    edit: () => {
      return DeckEdit();
    },

    save: () => {
      return <InnerBlocks.Content />;
    }
  });
});

export default Deck;
