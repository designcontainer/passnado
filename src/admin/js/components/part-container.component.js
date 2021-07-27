const PartContainer = (props) => {
	return (
		<div
			className={`passnado-settings__part ${
				props.disabled && 'passnado-settings__part--disabled'
			}`}
		>
			{props.children}
		</div>
	);
};

export default PartContainer;
