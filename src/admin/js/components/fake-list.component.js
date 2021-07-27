const FakeList = (props) => {
	const Rows = () => {
		var rows = [];
		for (var i = 0; i < props.rows; i++) {
			rows.push(<span key={`fake-row-${i}`} />);
		}
		return rows;
	};

	return (
		<div className="passnado-fake-list">
			<Rows />
		</div>
	);
};

export default FakeList;
