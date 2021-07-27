/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Icons
 */
import Locked from '../icons/locked.icon';
import Unlocked from '../icons/unlocked.icon';

const SettingsHeader = (props) => {
	return (
		<header className="passnado-header">
			<span
				className={`icon-wrap ${
					props.passnado ? 'icon-wrap--locked' : 'icon-wrap--unlocked'
				}`}
			>
				{props.passnado ? <Locked /> : <Unlocked />}
			</span>
			<h1>
				{__('Passnado is currently', 'passnado')}&nbsp;
				{props.passnado ? __('enabled', 'passnado') : __('disabled', 'passnado')}&nbsp;
				{__('for this site', 'passnado')}
			</h1>
		</header>
	);
};

export default SettingsHeader;
