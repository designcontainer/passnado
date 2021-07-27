/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

const PartHeader = (props) => {
	return (
		<header className="passnado-part-header">
			<h2>{props.children}</h2>
		</header>
	);
};

export default PartHeader;
