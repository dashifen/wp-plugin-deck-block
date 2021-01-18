import Icons from '../icons.js';
import CardEdit from './card-edit.js';

const Card = (() => {
  const {registerBlockType} = wp.registerBlockType;
  const {InnerBlocks} = wp.blockEditor;

  registerBlockType('dashifen/card', {
    title: 'Card',
    category: 'layout',
    description: 'A block that displays as a card within a deck.',
    icon: Icons.card,
    supports: {
      customClassName: false
    },
    attributes: {
      heading: {type: 'text'},
      body: {type: 'text'}
    },

    edit: () => {
      return CardEdit();
    },

    save: () => {
      return null;
    }
  });
});

export default Card;

