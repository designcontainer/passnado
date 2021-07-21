const { __ } = wp.i18n;

const { Button } = wp.components;

const { Component } = wp.element;

export default class PassnadoToggle extends Component {
	constructor() {
		super(...arguments);

		this.state = {
			is_settings_loaded: false,
			passnado_protect: false,
		};
	}

	componentDidMount() {
		wp.api.loadPromise.then(() => {
			this.settings = new wp.api.models.Settings();

			if (false === this.state.is_settings_loaded) {
				this.settings.fetch().then((response) => {
					this.setState({
						passnado_protect: response.passnado_protect,
						is_settings_loaded: true,
					});
				});
			}
		});
	}

	saveState(stateObj) {
		// Update state
		this.setState(stateObj);
		// Update the database
		new wp.api.models.Settings(stateObj).save();
	}

	render() {
		return (
			<div class="passnado-settings__row">
				<Button
					onClick={this.saveState({ passnado_protect: !this.state.passnado_protect })}
				>
					{__('Go live!', 'passnado')}
				</Button>
			</div>
		);
	}
}
