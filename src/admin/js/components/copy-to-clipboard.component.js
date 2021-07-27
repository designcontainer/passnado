const { __ } = wp.i18n;
const { useCopyToClipboard } = wp.compose;
const { Button } = wp.components;

const CopyToClipboard = (props) => {
	const ref = useCopyToClipboard(props.text);
	return <Button icon="clipboard" label={__('Copy', 'passnado')} ref={ref} />;
};

export default CopyToClipboard;
