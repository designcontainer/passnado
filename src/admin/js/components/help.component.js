/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Dashicon } from '@wordpress/components';

const Help = (props) => {
	return (
		<div className="passnado-help">
			{props.icon !== false && <Dashicon icon="info-outline" />}
			<i>{props.children}</i>
		</div>
	);
};

export default Help;
