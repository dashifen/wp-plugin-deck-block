const CardEdit = (props) => {
  const {setAttributes} = props;
  const {heading, body} = props.attributes;
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
        <span className='dashifen-card-title'>Card</span>
        <div className='card-heading-container'>
          <RichText
            placeholder='Enter heading here'
            className='card-heading'
            allowedFormats={[]}
            value={heading}
            onChange={onChangeHeading}
          />
        </div>
        <div className='card-body-container'>
          <RichText
            placeholder='Enter body here'
            className='card-body'
            allowedFormats={['core/bold', 'core/italic', 'editorskit/abbreviation']}
            value={body}
            onChange={onChangeBody}
          />
        </div>
      </div>
    </Fragment>
  );
};

export default CardEdit;
