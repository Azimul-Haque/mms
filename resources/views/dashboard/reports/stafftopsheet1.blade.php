@php
	header("Content-type: application/xlsx",true,200);
@endphp
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
			<th colspan="8" align="center">Staff Top Sheet</th>
		</tr>
		<tr>
			<th colspan="4" align="left">Date: {{ date('D, d/m/Y') }}</th>
			<th colspan="4" align="right">Loan Officer: {{ $staff->name }}</th>
		</tr>
		<tr>
			<th rowspan="3" class="lightgray">S# </th>
			<th rowspan="3" class="lightgray">Group</th>
			<th colspan="6" class="lightgray" align="center">Primary Loan</th>
		</tr>
		<tr>
			<td colspan="2" class="lightgray">Disbursed Amount Dummy</td>
			<td colspan="2" class="lightgray" align="center"><b>Disbursed Amount</b></td>
			<td colspan="2" class="lightgray" align="center"><b>Outstanding</b></td>
			<td colspan="2" class="lightgray" align="center"><b>Overdue</b></td>
		</tr>
		<tr>
			<td class="lightgray"><b>Member Dummy</b></td>
			<td class="lightgray"><b>Amount Dummy</b></td>
			<td class="lightgray"><b>Member</b></td>
			<td class="lightgray"><b>Amount</b></td>
			<td class="lightgray"><b>Member</b></td>
			<td class="lightgray"><b>Amount</b></td>
			<td class="lightgray"><b>Member</b></td>
			<td class="lightgray"><b>Amount</b></td>
		</tr>
	</thead>
	<tbody>
		@php
			$groupcounter = 1;
			$grosstotalmembersdisbursed = 0;
			$grosstotaldisbursed = 0;
			$grosstotalmembersoutstanding = 0;
			$grosstotaloutstanding = 0;
			$grosstotalmembersoverdue = 0;
			$grosstotaloverdue = 0;
		@endphp
		@foreach($staff->groups as $group)
			<tr>
				<td>{{ $groupcounter++ }}</td>
				<td align="left">{{ $group->name }}</td>
				<td align="right">
					@php
						$totalmembers = 0;
						foreach ($group->members as $member) {
							foreach ($member->loans as $loan) {
								if(($loan->loanname_id == 1)) {
									$totalmembers = $totalmembers + 1;
								}
							}
						}
						$grosstotalmembersdisbursed = $grosstotalmembersdisbursed + $totalmembers;
					@endphp
					{{ $totalmembers }}
				</td>
				<td align="right">
					@php
						$totaldisbursed = 0;
						foreach ($group->members as $member) {
							foreach ($member->loans as $loan) {
								if(($loan->loanname_id == 1)) {
									$totaldisbursed = $totaldisbursed + $loan->total_disbursed;
								}
							}
						}
						$grosstotaldisbursed = $grosstotaldisbursed + $totaldisbursed;
					@endphp
					{{ $totaldisbursed }}
				</td>
				<td align="right">
					@php
						$totaloutstandingmembers = 0;
						$totaloutstanding = 0;
						foreach ($group->members as $member) {
							$memberoutstanding = 0;
							foreach ($member->loans as $loan) {
								if(($loan->loanname_id == 1)) {
									$totaloutstanding = $totaloutstanding + $loan->total_outstanding;
									$memberoutstanding = $memberoutstanding + $loan->total_outstanding;
								}
							}
							if($memberoutstanding > 0) {
								$totaloutstandingmembers++;
							}
						}
						$grosstotalmembersoutstanding = $grosstotalmembersoutstanding + $totaloutstandingmembers;
						$grosstotaloutstanding = $grosstotaloutstanding + $totaloutstanding;
					@endphp
					{{ $totaloutstandingmembers }}
				</td>
				<td align="right">{{ $totaloutstanding }}</td>
				<td align="right">
					@php
						$totaloverduemembers = 0;
						$totaloverdue = 0;
						foreach ($group->members as $member) {
							$memberoverdue = 0;
							foreach ($member->loans as $loan) {
								if(($loan->loanname_id == 1)) {
									foreach ($loan->loaninstallments as $installment) {
										if((strtotime($installment->due_date) <= strtotime(date('Y-m-d'))) && ($installment->installment_total - $installment->paid_total > 0) && ($loan->total_outstanding > 0)) {
											$totaloverdue = $totaloverdue + ($installment->installment_total - $installment->paid_total);
											$memberoverdue = $memberoverdue + ($installment->installment_total - $installment->paid_total);
										}
									}
								}
							}
							if($memberoverdue > 0) {
								$totaloverduemembers++;
							}
						}
						$grosstotalmembersoverdue = $grosstotalmembersoverdue + $totaloverduemembers;
						$grosstotaloverdue = $grosstotaloverdue + $totaloverdue;
					@endphp
					{{ $totaloverduemembers }}
				</td>
				<td align="right">{{ $totaloverdue }}</td>
			</tr>
		@endforeach
		<tr>
			<th></th>
			<th align="center">Total</th>
			<th align="right">{{ $grosstotalmembersdisbursed }}</th>
			<th align="right">{{ $grosstotaldisbursed }}</th>
			<th align="right">{{ $grosstotalmembersoutstanding }}</th>
			<th align="right">{{ $grosstotaloutstanding }}</th>
			<th align="right">{{ $grosstotalmembersoverdue }}</th>
			<th align="right">{{ $grosstotaloverdue }}</th>
		</tr>
	</tbody>
</table>