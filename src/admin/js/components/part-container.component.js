const PartContainer = (props) => {
	return (
		<div
			className={`passnado-settings__part ${props.className} ${
				props.disabled && 'passnado-settings__part--disabled'
			} ${props.noPadding && 'passnado-settings__part--no-padding'}`}
		>
			{props.children}
		</div>
	);
};

export default PartContainer;
