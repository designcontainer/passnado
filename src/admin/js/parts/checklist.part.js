const { __ } = wp.i18n;
const { Spinner, CheckboxControl, BaseControl, Button } = wp.components;
const { useState, useEffect } = wp.element;

import PartHeader from '../components/part-header.component';
import FakeList from '../components/fake-list.component';

const Checklist = (props) => {
	const getTasks = async () => {
		try {
			const settings = new wp.api.models.Settings();
			const response = await settings.fetch();
			setTasks(response.passnado_checklist);
			setLoading(false);
		} catch (err) {
			throw new Error(`Failed loading tasks: ${err}`);
		}
	};

	const [loading, setLoading] = useState(true);
	const [tasks, setTasks] = useState(() => getTasks());
	const [customTask, setCustomTask] = useState('');

	useEffect(() => {
		if (!tasks.length) return;

		const allDone = !tasks.some((e) => e.done === false);
		props.done(allDone);

		new wp.api.models.Settings({
			passnado_checklist: tasks,
		}).save();
	}, [tasks]);

	const handleTasks = (taskIndex, value) => {
		let newTasks = [...tasks];
		newTasks[taskIndex].done = value;
		setTasks(newTasks);
	};

	const addTask = (label) => {
		if (label === '') return;

		const task = {
			task: label,
			done: false,
			custom: true,
		};
		let newTasks = [...tasks];
		newTasks.push(task);
		setTasks(newTasks);
		setCustomTask('');
	};

	const deleteTask = (taskIndex) => {
		let newTasks = [...tasks];
		newTasks.splice(taskIndex, 1);
		setTasks(newTasks);
	};

	return (
		<div className="passnado-settings__part">
			<PartHeader>{__('Go live checklist', 'passnado')}</PartHeader>

			{loading ? (
				<FakeList rows={10} />
			) : (
				<ul className="passnado-checklist">
					{tasks.map((task, index) => {
						return (
							<li key={`task-item-${index}`}>
								<CheckboxControl
									label={task.task}
									checked={task.done}
									onChange={(value) => handleTasks(index, value)}
								/>
								{task.custom ? (
									<Button
										icon="trash"
										label={__('Delete task', 'passnado')}
										onClick={() => deleteTask(index)}
									/>
								) : (
									''
								)}
							</li>
						);
					})}
				</ul>
			)}

			<div className="passnado-form">
				<input
					type="text"
					placeholder={__('Add task ...', 'passnado')}
					value={customTask}
					onChange={(e) => setCustomTask(e.target.value)}
				/>
				<Button
					icon={() => (
						<svg
							width="24"
							height="24"
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
							role="img"
							aria-hidden="true"
							focusable="false"
						>
							<path d="M18 11.2h-5.2V6h-1.6v5.2H6v1.6h5.2V18h1.6v-5.2H18z"></path>
						</svg>
					)}
					label={__('Add task', 'passnado')}
					onClick={() => addTask(customTask)}
				/>
			</div>
		</div>
	);
};

export default Checklist;
