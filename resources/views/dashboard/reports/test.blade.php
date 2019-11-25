<style type="text/css">
	table tr > th, table tr > td {
		border: 1px solid #000000;
	}
	table tr > th {
		background-color: #C0C0C0;
	}
</style>
<table>
	<thead>
		<tr>
			<th colspan="3" align="center">Users</th>
		</tr>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Contact</th>
		</tr>
	</thead>
	<tbody>
		@foreach($staffs as $staff)
			<tr>
				<td>{{ $staff->id }}</td>
				<td>{{ $staff->name }}</td>
				<td>{{ $staff->phone }}</td>
			</tr>
		@endforeach
	</tbody>
</table>