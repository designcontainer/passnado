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
import CopyToClipboard from '../components/copy-to-clipboard.component';

import password from 'secure-random-password';

const MagicLink = (props) => {
	const [key, setKey, loading] = useSetting('passnado_key');
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
	}, [key]);

	return (
		<>
			<PartContainer disabled={!props.passnado || loading}>
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
			</PartContainer>

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
