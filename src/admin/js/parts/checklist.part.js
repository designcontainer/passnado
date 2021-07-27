const { __ } = wp.i18n;
const { Spinner, CheckboxControl, BaseControl, Button } = wp.components;
const { useState, useEffect } = wp.element;

import useSetting from '../hooks/use-setting.hook';

import PartContainer from '../components/part-container.component';
import PartHeader from '../components/part-header.component';
import FakeList from '../components/fake-list.component';

const Checklist = (props) => {
	const [tasks, setTasks, loading] = useSetting('passnado_checklist');
	const [customTask, setCustomTask] = useState('');

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

	useEffect(() => {
		if (!tasks.length) return;
		const allDone = !tasks.some((e) => e.done === false);
		props.done(allDone);
	}, [tasks]);

	return (
		<PartContainer>
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
					icon="plus"
					label={__('Add task', 'passnado')}
					onClick={() => addTask(customTask)}
				/>
			</div>
		</PartContainer>
	);
};

export default Checklist;
