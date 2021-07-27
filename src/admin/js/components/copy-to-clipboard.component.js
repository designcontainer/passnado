/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import { useCopyToClipboard } from '@wordpress/compose';

const CopyToClipboard = (props) => {
	const ref = useCopyToClipboard(props.text);
	return <Button icon="clipboard" label={__('Copy', 'passnado')} ref={ref} />;
};

export default CopyToClipboard;
