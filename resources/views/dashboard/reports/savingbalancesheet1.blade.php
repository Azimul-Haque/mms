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
			<th colspan="8" align="center" {{-- style="font-size: 30px;" --}}>Program Balance Sheet: SAVINGS</th>
		</tr>
		<tr>
			<th colspan="2" align="left">{{ date('D, d/m/Y') }}</th>
			<th colspan="4" align="center">Loan Officer: {{ $staff->name }}</th>
			<th colspan="2" align="right">GENERAL SAVING</th>
		</tr>
		<tr>
			<th class="lightgray">S #</th>
			<th class="lightgray">Group Name</th>
			<th class="lightgray">Member Name</th>
			<th class="lightgray">Phone</th>
			<th class="lightgray">Program</th>
			<th class="lightgray">Deposit</th>
			<th class="lightgray">Withdraw</th>
			<th class="lightgray">Balance</th>
		</tr>
	</thead>
	<tbody>
		@php			
			$counter = 1;
			$totalamount = 0;
			$totalwithdraw = 0;
			$totalbalance = 0;
		@endphp
		@foreach($group->members as $member)
			@foreach($member->savings->where('savingname_id', 1) as $saving)
				{{-- @if($saving->status == 1)
					
				@endif --}}
				<tr>
					<td>{{ $counter++ }}</td>
					<td>{{ $group->name }}</td>
					<td>{{ $member->name }}-{{ $member->fhusband }}</td>
					<td>{{ $member->present_phone }}</td>
					<td>GENERAL SAVING</td>
					<td align="right">{{ $saving->total_amount }}</td>
					<td align="right">{{ $saving->withdraw }}</td>
					<td align="right">{{ $saving->total_amount - $saving->withdraw }}</td>
				</tr>
				@php			
					$totalamount = $totalamount + $saving->total_amount;
					$totalwithdraw = $totalwithdraw + $saving->withdraw;
					$totalbalance = $totalbalance + $saving->total_amount - $saving->withdraw;
				@endphp
			@endforeach
		@endforeach
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th>Total</th>
			<th align="right">{{ $totalamount }}</th>
			<th align="right">{{ $totalwithdraw }}</th>
			<th align="right">{{ $totalbalance }}</th>
		</tr>
	</tbody>
</table>