/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Button, Modal } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

/**
 * Hooks
 */
import useSetting from '../hooks/use-setting.hook';

/**
 * Components
 */
import PartContainer from '../components/part-container.component';
import PartHeader from '../components/part-header.component';
import Help from '../components/help.component';

/**
 * Utilities
 */
import confetti from '../utils/confetti';
import wpeClearCache from '../utils/wpe-clear-cache';

const passnadoToggle = (props) => {
	const [passnado, setPassnado, loading] = useSetting('passnado_protect');
	const [confirm, setConfirm] = useState(false);

	const handlePassnado = () => {
		if (passnado === true && confirm === false) {
			// If the popup is not open and passnado is active
			setConfirm(true);
		} else if (passnado === true && confirm === true) {
			// If the popup is open and pasnado is active
			setPassnado(false);
			setConfirm(false);
			confetti();
			wpeClearCache();
		} else {
			// If passnado is not active
			setPassnado(true);
			wpeClearCache();
		}
	};

	const isToggleDisabled = () => {
		if (passnado !== true) return false;
		if (props.canDisable === true) return false;
		return true;
	};

	useEffect(() => {
		props.passnado(passnado);
	}, [passnado]);

	return (
		<>
			<PartContainer disabled={loading}>
				<PartHeader>{__('Toggle password protection', 'passnado')}</PartHeader>

				{isToggleDisabled() && passnado && (
					<Help>{__('Complete the checklist before going live', 'passnado')}</Help>
				)}
				{!isToggleDisabled() && passnado && (
					<Help icon={false}>
						{__("Looks like you're ready to go live! 🚀", 'passnado')}
					</Help>
				)}
				{!passnado && (
					<Help>{__('Passnado is currently disabled for this site', 'passnado')}</Help>
				)}

				<Button
					isPrimary={true}
					disabled={isToggleDisabled()}
					onClick={handlePassnado}
					text={
						passnado === true
							? __('Go live', 'passnado')
							: __('Enable Passnado', 'passnado')
					}
				/>
			</PartContainer>

			{confirm && (
				<Modal
					title={__('Are you sure you want to disable Passnado?', 'passnado')}
					onRequestClose={() => setConfirm(false)}
				>
					<p>{__('This will make the site public for everyone.', 'passnado')}</p>
					<Button isPrimary={true} onClick={handlePassnado}>
						{__('Yes', 'passnado')}
					</Button>
					<Button onClick={() => setConfirm(false)}>{__('Cancel', 'passnado')}</Button>
				</Modal>
			)}
		</>
	);
};

export default passnadoToggle;
