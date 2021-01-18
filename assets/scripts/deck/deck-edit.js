import {memoize, times} from "lodash";

const DeckEdit = (props) => {
  const {setAttributes} = props;
  const {perRow, perRowClass} = props.attributes;
  const {InnerBlocks, InspectorControls} = wp.blockEditor;
  const {PanelBody, RangeControl} = wp.components;
  const {Fragment} = wp.element;

  const allowedBlocks = ['dashifen/card'];

  const onChangePerRow = (value) => {
    if (value === 2) {
      setAttributes({perRowClass: 'two-cards'});
    } else if (value === 3) {
      setAttributes({perRowClass: 'three-cards'});
    } else if (value === 4) {
      setAttributes({perRowClass: 'four-cards'});
    }
    setAttributes({perRow: value});
  };

  const getCardsTemplate = memoize((quantity) => {
    return times(quantity, () => allowedBlocks);
  });

  if (perRowClass === '') {
    setAttributes({perRowClass: 'three-cards'});
  }

  return (
    <Fragment>
      <InspectorControls>
        { /* Number of cards to display per row. */}
        <PanelBody title='Cards'>
          <RangeControl
            label='Number of cards in this deck'
            help='This card deck may display between 2 and 4 cards per row on large screens.'
            value={perRow}
            onChange={onChangePerRow}
            min={2}
            max={4}
          />
        </PanelBody>
      </InspectorControls>

      { /* The block itself. */}
      <div className={'dashifen-deck in-editor icon-deck'}>
        <InnerBlocks
          template={getCardsTemplate(3)}
          allowedBlocks={allowedBlocks}
        />
      </div>
    </Fragment>
  );
};

export default DeckEdit;
