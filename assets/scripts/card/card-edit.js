const CardEdit = (props) => {
  const {setAttributes} = props;
  const {heading, body} = props.attributes;
  const {TextControl} = wp.components;
  const {RichText} = wp.blockEditor;
  const {Fragment} = wp.element;

  const onChangeHeading = (value) => {
    setAttributes({heading: value});
  };

  const onChangeBody = (value) => {
    setAttributes({body: value});
  };

  return (
    <Fragment>
      <div className='dashifen-card in-editor icon-card'>
        <div className='card-heading-container'>
          <p className='card-heading'>Card Heading</p>
          <TextControl
            id='card-heading'
            className='card-heading-input'
            label='Card Heading'
            value={heading}
            onChange={onChangeHeading}
          />
        </div>
        <div className='card-body-container'>
          <p className='card-body'>Card Body</p>
          <RichText
            placeholder='Entre card body'
            className='card-body'
            allowedFormats={['core/bold', 'core/italic']}
            value={body}
            onChange={onChangeBody}
          />
        </div>
      </div>
    </Fragment>
  );
};

export default CardEdit;
