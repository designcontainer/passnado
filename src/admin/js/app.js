/**
 * WordPress dependencies
 */
const { render, Component, Fragment } = wp.element;

import SettingsHeader from './components/header.component';

import Checklist from './components/checklist.component';
import PassnadoToggle from './components/passnado-toggle.component';

class DcFormsSettings extends Component {
	render() {
		return (
			<div className="passnado-settings">
				<SettingsHeader />
				<Checklist />
				<PassnadoToggle />
			</div>
		);
	}
}

render(<DcFormsSettings />, document.getElementById('passnado-settings-container'));
