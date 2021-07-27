const { __ } = wp.i18n;
const { Button, Modal } = wp.components;
const { useState, useEffect } = wp.element;

import Help from '../components/help.component';
import PartHeader from '../components/part-header.component';

import Confetti from '../utils/confetti';

const passnadoToggle = (props) => {
	const getPassnado = async () => {
		try {
			const settings = new wp.api.models.Settings();
			const response = await settings.fetch();
			setPassnado(response.passnado_protect);
		} catch (err) {
			throw new Error(`Failed loading setting: ${err}`);
		}
	};

	const [passnado, setPassnado] = useState(() => getPassnado());
	const [confirm, setConfirm] = useState(false);

	const handlePassnado = () => {
		console.log(`passnado: ${passnado}`);
		console.log(`confirm: ${confirm}`);

		if (passnado === true && confirm === true) {
			setPassnado(false);
			setConfirm(false);
			Confetti();
		} else if (passnado === true && confirm === false) {
			setConfirm(true);
		} else {
			setPassnado(true);
		}
	};

	const isDisabled = () => {
		if (passnado !== true) return false;
		if (props.canDisable === true) return false;
		return true;
	};

	useEffect(() => {
		props.passnado(passnado);

		new wp.api.models.Settings({
			passnado_protect: passnado,
		}).save();
	}, [passnado]);

	return (
		<>
			<div className="passnado-settings__part">
				<PartHeader>{__('Toggle password protection', 'passnado')}</PartHeader>

				{isDisabled() ? (
					<Help>{__('Complete the checklist before going live', 'passnado')}</Help>
				) : (
					<Help icon={false}>
						{__("Looks like you're ready to go live! 🚀'", 'passnado')}
					</Help>
				)}

				<Button
					isPrimary={true}
					disabled={isDisabled()}
					onClick={handlePassnado}
					text={
						passnado === true
							? __('Go live', 'passnado')
							: __('Enable Passnado', 'passnado')
					}
				/>
			</div>

			{confirm && (
				<Modal
					title={__('Are you sure you want to disable Passnado?', 'passnado')}
					onRequestClose={() => setConfirm(false)}
				>
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
