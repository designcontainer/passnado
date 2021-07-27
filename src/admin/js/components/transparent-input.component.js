const TransparentInput = (props) => {
	return (
		<input
			className={`transparent-input ${props.white ? 'transparent-input--white' : ''}`}
			type="text"
			value={props.value}
			onChange={props.onChange}
			placeholder={props.placeholder}
		/>
	);
};

export default TransparentInput;
