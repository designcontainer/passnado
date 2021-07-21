const { __ } = wp.i18n;

const {} = wp.components;

const { Component } = wp.element;

export default class SettingsHeader extends Component {
	render() {
		return (
			<header className="passnado-header">
				<h1>{__('Yet another project eh?', 'passnado')}</h1>
				<p>
					{__(
						`Before going live, I'm gonna gave you to fill out the launch-checklist.`,
						'passnado'
					)}
				</p>
			</header>
		);
	}
}
