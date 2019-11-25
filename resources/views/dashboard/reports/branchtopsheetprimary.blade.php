<style type="text/css">
	table tr > th, table tr > td {
		border: 1px solid #000000;
	}
	.lightgray {
		background-color: #C0C0C0;
	}
</style>
<table>
	<thead>
		<tr>
			<th colspan="8" align="center">Branch Top Sheet</th>
		</tr>
		<tr>
			<th colspan="8">Year: {{ date('Y') }}</th>
		</tr>
		<tr>
			<th rowspan="3" class="lightgray">S#</th>
			<th rowspan="3" class="lightgray">Loan Officer</th>
			<th colspan="6" class="lightgray">Primary Loan</th>
		</tr>
		<tr>
			<th colspan="2" class="lightgray">Disbursed Amount Dummy</th>
			<th colspan="2" class="lightgray">Disbursed Amount</th>
			<th colspan="2" class="lightgray">Outstanding</th>
			<th colspan="2" class="lightgray">Overdue</th>
		</tr>
		<tr>
			<th class="lightgray">Member Dummy</th>
			<th class="lightgray">Amount Dummy</th>
			<th class="lightgray">Member</th>
			<th class="lightgray">Amount</th>
			<th class="lightgray">Member</th>
			<th class="lightgray">Amount</th>
			<th class="lightgray">Member</th>
			<th class="lightgray">Amount</th>
		</tr>
	</thead>
	<tbody>
		@foreach($staffs as $staff)
			<tr>
				<td width="50px">{{ $staff->id }}</td>
				<td>{{ $staff->name }}</td>
				<td>{{ $staff->phone }}</td>
				<td>{{ $staff->phone }}</td>
				<td>{{ $staff->phone }}</td>
				<td>{{ $staff->phone }}</td>
				<td>{{ $staff->phone }}</td>
				<td>{{ $staff->phone }}</td>
			</tr>
		@endforeach
	</tbody>
</table>