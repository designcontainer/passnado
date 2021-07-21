const { __ } = wp.i18n;

const { CheckboxControl, BaseControl, Button } = wp.components;

const { Component } = wp.element;

export default class Checklist extends Component {
	constructor() {
		super(...arguments);

		this.state = {
			is_settings_loaded: false,
			can_disable_passnado: false,
			passnado_checklist: [],
			custom_checklist_item: '',
		};
	}

	componentDidMount() {
		wp.api.loadPromise.then(() => {
			this.settings = new wp.api.models.Settings();

			if (false === this.state.is_settings_loaded) {
				this.settings.fetch().then((response) => {
					this.canDisablePassnado(response.passnado_checklist);
					this.setState({
						passnado_checklist: response.passnado_checklist,
						is_settings_loaded: true,
					});
				});
			}
		});
	}

	canDisablePassnado(checklist) {
		if (checklist.some((e) => e.done === false)) {
			this.setState({ can_disable_passnado: false });
		} else {
			this.setState({ can_disable_passnado: true });
		}
	}

	saveChecklist(newList) {
		// Update state
		this.setState({ passnado_checklist: newList });
		// Update the database
		new wp.api.models.Settings({
			passnado_checklist: newList,
		}).save();
	}

	modifyChecklist(index, value) {
		let newList = [...this.state.passnado_checklist];
		newList[index].done = value;

		this.saveChecklist(newList);
		this.canDisablePassnado(newList);
	}

	appendChecklist(task) {
		const taskObj = {
			task,
			done: false,
			custom: true,
		};
		let newList = [...this.state.passnado_checklist];
		newList.push(taskObj);
		this.saveChecklist(newList);
		this.setState({ custom_checklist_item: '' });
	}

	render() {
		return (
			<div class="passnado-settings__row">
				<ul>
					{this.state.passnado_checklist.map((obj, i) => {
						return (
							<li>
								<CheckboxControl
									label={obj.task}
									checked={obj.done}
									onChange={(v) => this.modifyChecklist(i, v)}
								/>
								{obj.custom ? 'deletable' : ''}
							</li>
						);
					})}
				</ul>

				<div class="custom-task-wrapper">
					<input
						type="text"
						placeholder={__('Add custom task ...', 'passnado')}
						value={this.state.custom_checklist_item}
						onChange={(e) => this.setState({ custom_checklist_item: e.target.value })}
					/>
					<Button
						variant="secondary"
						onClick={() => this.appendChecklist(this.state.custom_checklist_item)}
					>
						+
					</Button>
				</div>
			</div>
		);
	}
}
