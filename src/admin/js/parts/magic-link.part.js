const { __ } = wp.i18n;
const { Button, Modal } = wp.components;
const { useState, useEffect } = wp.element;

import password from 'secure-random-password';

import PartHeader from '../components/part-header.component';
import Help from '../components/help.component';
import CopyToClipboard from '../components/copy-to-clipboard.component';

const MagicLink = (props) => {
	const getKey = async () => {
		try {
			const settings = new wp.api.models.Settings();
			const response = await settings.fetch();
			setKey(response.passnado_key);
		} catch (err) {
			throw new Error(`Failed loading tasks: ${err}`);
		}
	};

	const [key, setKey] = useState(() => getKey());
	const [confirmKey, setConfirmKey] = useState(false);
	const [confirmDisable, setConfirmDisable] = useState(false);

	const handleNewKey = () => {
		const newKey = password.randomPassword({
			length: 30,
			characters: [password.lower, password.upper, password.digits],
		});

		if (key !== '' && confirmKey === false) {
			setConfirmKey(true);
		} else {
			setKey(newKey);
		}
	};

	const urlWithKey = () => {
		const prot = location.protocol;
		const host = location.hostname;
		return `${prot}//${host}/?key=${key}`;
	};

	useEffect(() => {
		setConfirmKey(false);
		setConfirmDisable(false);
		new wp.api.models.Settings({
			passnado_key: key,
		}).save();
	}, [key]);

	return (
		<>
			<div
				className={`passnado-settings__part ${
					!props.passnado && 'passnado-settings__part--disabled'
				}`}
			>
				<PartHeader>{__('Magic link', 'passnado')}</PartHeader>
				<p>
					{__(
						"Magic links are special URL's that can be given to clients for previewing a site without them having to login. Be careful who you give this to!",
						'passnado'
					)}
				</p>

				{typeof key !== 'object' && key !== '' ? (
					<>
						<div className="passnado-form">
							<input type="text" value={urlWithKey()} disabled />
							<CopyToClipboard text={urlWithKey()} />
						</div>
					</>
				) : (
					<Help>Magic link is not enabled yet. Generate one to get started.</Help>
				)}

				<div className="passnado-button-group">
					<Button
						icon="admin-network"
						isPrimary={true}
						text={__('Generate link', 'passnado')}
						onClick={handleNewKey}
					></Button>
					{typeof key !== 'object' && key !== '' && (
						<Button
							isDestructive={true}
							text={__('Disable', 'passnado')}
							onClick={() => setConfirmDisable(true)}
						></Button>
					)}
				</div>
			</div>

			{confirmKey && (
				<Modal
					title={__('Are you sure you want to generate a new link?', 'passnado')}
					onRequestClose={() => setConfirmKey(false)}
				>
					<p>This will render the previous link useless.</p>
					<Button isPrimary={true} onClick={handleNewKey}>
						{__('Yes', 'passnado')}
					</Button>
					<Button onClick={() => setConfirmKey(false)}>
						{__('Cancel', 'passnado')}
					</Button>
				</Modal>
			)}

			{confirmDisable && (
				<Modal
					title={__('Are you sure you want to disable magic link?', 'passnado')}
					onRequestClose={() => setConfirmDisable(false)}
				>
					<p>This will render the previous link useless.</p>
					<Button isPrimary={true} onClick={() => setKey('')}>
						{__('Yes', 'passnado')}
					</Button>
					<Button onClick={() => setConfirmDisable(false)}>
						{__('Cancel', 'passnado')}
					</Button>
				</Modal>
			)}
		</>
	);
};

export default MagicLink;
