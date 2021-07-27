const { __ } = wp.i18n;
const { Button } = wp.components;
const { useState, useEffect } = wp.element;

import password from 'secure-random-password';

import PartHeader from '../components/part-header.component';
import Help from '../components/help.component';

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

	const handleKey = () => {
		const newKey = password.randomPassword({
			length: 30,
			characters: [password.lower, password.upper, password.digits],
		});
		setKey(newKey);
	};

	const urlWithKey = () => {
		const prot = location.protocol;
		const host = location.hostname;
		return `${prot}//${host}/?key=${key}`;
	};

	return (
		<div className="passnado-settings__part">
			<PartHeader>{__('Magic link', 'passnado')}</PartHeader>
			<p>
				{__(
					"Magic links are special URL's that can be given to clients for previewing a site without them having to login. Be careful who you give this to!",
					'passnado'
				)}
			</p>

			{typeof key !== 'object' && key !== '' ? (
				<div className="passnado-form">
					<input type="text" value={urlWithKey()} disabled />
				</div>
			) : (
				<Help>Magic link is not enabled yet. Generate a key to get started.</Help>
			)}

			<Button
				icon="admin-network"
				isPrimary={true}
				text={__('Generate key', 'passnado')}
				onClick={handleKey}
			></Button>
		</div>
	);
};

export default MagicLink;
