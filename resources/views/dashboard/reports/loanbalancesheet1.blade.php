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
			<th colspan="8" align="center" {{-- style="font-size: 30px;" --}}>Program Balance Sheet: LOAN</th>
		</tr>
		<tr>
			<th colspan="2" align="left">Date: {{ date('D, d/m/Y') }}</th>
			<th colspan="4" align="center">Loan Officer: {{ $staff->name }}</th>
			<th colspan="2" align="right">PRIMARY LOAN</th>
		</tr>
		<tr>
			<th class="lightgray">S #</th>
			<th class="lightgray">Group Name</th>
			<th class="lightgray">Member Name</th>
			<th class="lightgray">Phone</th>
			<th class="lightgray">Disbursed</th>
			<th class="lightgray">Paid</th>
			<th class="lightgray">Outstanding</th>
			<th class="lightgray">Overdue</th>
		</tr>
	</thead>
	<tbody>
		@php			
			$counter = 1;
			$totaldisbursed = 0;
			$totalpaid = 0;
			$totaloutstanding = 0;
			$totaloverdue = 0;
		@endphp
		@foreach($group->members as $member)
			@foreach($member->loans->where('loanname_id', 1) as $loan)
				@if($loan->status == 1)
					<tr>
						<td>{{ $counter++ }}</td>
						<td>{{ $group->name }}</td>
						<td>{{ $member->name }}-{{ $member->fhusband }}</td>
						<td>{{ $member->present_phone }}</td>
						<td align="right">{{ $loan->total_disbursed }}</td>
						<td align="right">{{ $loan->total_paid }}</td>
						<td align="right">{{ $loan->total_outstanding }}</td>
						<td align="right">
							@php
								$memberoverdue = 0;
								foreach ($loan->loaninstallments as $installment) {
									if((strtotime($installment->due_date) <= strtotime(date('Y-m-d'))) && ($installment->installment_total - $installment->paid_total > 0) && ($loan->total_outstanding > 0)) {
										$memberoverdue = $memberoverdue + ($installment->installment_total - $installment->paid_total);
									}
								}
								$totaloverdue = $totaloverdue + $memberoverdue;
							@endphp
							{{ $memberoverdue }}
						</td>
					</tr>
					@php			
						$totaldisbursed = $totaldisbursed + $loan->total_disbursed;
						$totalpaid = $totalpaid + $loan->total_paid;
						$totaloutstanding = $totaloutstanding + $loan->total_outstanding;
					@endphp
				@endif
			@endforeach
		@endforeach
		<tr>
			<th></th>
			<th></th>
			<th></th>
			<th>Total</th>
			<th align="right">{{ $totaldisbursed }}</th>
			<th align="right">{{ $totalpaid }}</th>
			<th align="right">{{ $totaloutstanding }}</th>
			<th align="right">{{ $totaloverdue }}</th>
		</tr>
	</tbody>
</table>