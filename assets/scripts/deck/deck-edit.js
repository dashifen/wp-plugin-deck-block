import {memoize, times} from "lodash";

const DeckEdit = (props) => {

  // we're not currently using properties within the Deck editor.  but, we
  // pass them here so that we don't have to remember to add them when we get
  // to that point.  first, we import various WP objects from core, then we
  // set up a few things related to this block specifically.  finally, we
  // return the JSX fragment that the block editor uses to show a deck.

  const {Fragment} = wp.element;
  const {InnerBlocks} = wp.blockEditor;
  const allowedBlocks = ['dashifen/card'];
  const getCardsTemplate = memoize((quantity) => {
    return times(quantity, () => allowedBlocks);
  });

  return (
    <Fragment>
      <div className={'dashifen-deck in-editor icon-deck'}>
        <span className={'dashifen-deck-title'}>Deck</span>
        <InnerBlocks template={getCardsTemplate(1)} allowedBlocks={allowedBlocks}/>
      </div>
    </Fragment>
  );
};

export default DeckEdit;
