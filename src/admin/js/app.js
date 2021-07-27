/**
 * WordPress dependencies
 */
const { render, useState } = wp.element;

import SettingsHeader from './parts/header.part';
import Checklist from './parts/checklist.part';
import PassnadoToggle from './parts/passnado-toggle.part';
import MagicLink from './parts/magic-link.part';

const PassnadoSettings = () => {
	const [passnado, setPassnado] = useState(false);
	const [canDisable, setCanDisable] = useState(false);

	return (
		<>
			<SettingsHeader passnado={passnado} />
			<div className="passnado-settings">
				<Checklist done={setCanDisable} />
				<PassnadoToggle passnado={setPassnado} canDisable={canDisable} />
				<MagicLink />
			</div>
		</>
	);
};

render(<PassnadoSettings />, document.getElementById('passnado-settings-container'));
