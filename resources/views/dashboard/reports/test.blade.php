<table>
	<thead>
		<tr>
			<th colspan="3" align="center">Users</th>
		</tr>
		<tr>
			<th>Id</th>
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