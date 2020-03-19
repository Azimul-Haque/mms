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
			<th colspan="6" align="center">Program Top Sheet</th>
		</tr>
		<tr>
			<th colspan="6">Year: {{ date('Y') }}</th>
		</tr>
		<tr>
			<th rowspan="3" class="lightgray">S# </th>
			<th rowspan="3" class="lightgray">Loan Officer</th>
			<th colspan="4" class="lightgray" align="center">Savings Account</th>
		</tr>
		<tr>
			<td colspan="2" class="lightgray">Disbursed Amount Dummy</td>
			<td colspan="2" class="lightgray" align="center"><b>General Savings</b></td>
			<td colspan="2" class="lightgray" align="center"><b>Long Term Savings</b></td>
		</tr>
		<tr>
			<td class="lightgray"><b>Member Dummy</b></td>
			<td class="lightgray"><b>Amount Dummy</b></td>
			<td class="lightgray"><b>Member</b></td>
			<td class="lightgray"><b>Balance</b></td>
			<td class="lightgray"><b>Member</b></td>
			<td class="lightgray"><b>Balance</b></td>
		</tr>
	</thead>
	<tbody>
		@php
			$membercounter = 1;
			$grosstotalmembersgeneral = 0;
			$grosstotalgeneral = 0;
			$grosstotalmemberslongterm = 0;
			$grosstotallongterm = 0;
			$grosstotalmembersoverdue = 0;
			$grosstotaloverdue = 0;
		@endphp
		@foreach($staffs as $staff)
			<tr>
				<td>{{ $membercounter++ }}</td>
				<td align="left">{{ $staff->name }}</td>
				<td align="right">
					@php
						$totalgeneralmembers = 0;
						foreach ($staff->groups as $group) {
							foreach ($group->members as $member) {
								if($member->status == 1) {
									foreach ($member->savings as $saving) {
										if($saving->savingname_id == 1) {
											$totalgeneralmembers++;
										}
									}
								}
							}
						}
						$grosstotalmembersgeneral = $grosstotalmembersgeneral + $totalgeneralmembers;
					@endphp
					{{ $totalgeneralmembers }}
				</td>
				<td align="right">
					@php
						$totalgeneralbalance = 0;
						foreach ($staff->groups as $group) {
							foreach ($group->members as $member) {
								if($member->status == 1) {
									foreach ($member->savings as $saving) {
										if($saving->savingname_id == 1) {
											$totalgeneralbalance = $totalgeneralbalance + $saving->total_amount - $saving->withdraw;
										}
									}
								}
							}
						}
						$grosstotalgeneral = $grosstotalgeneral + $totalgeneralbalance;
					@endphp
					{{ $totalgeneralbalance }}
				</td>
				<td align="right">
					@php
						$totallongtermmembers = 0;
						$totallongtermbalance = 0;
						foreach ($staff->groups as $group) {
							foreach ($group->members as $member) {
								if($member->status == 1) {
									$memberbalance = 0;
									foreach ($member->savings as $saving) {
										if($saving->savingname_id == 2) {
											$totallongtermbalance = $totallongtermbalance + $saving->total_amount - $saving->withdraw;
											$memberbalance = $memberbalance + $saving->total_amount - $saving->withdraw;
										}
									}
									if($memberbalance > 0) {
										$totallongtermmembers++;
									}
								}
							}
						}
						$grosstotalmemberslongterm = $grosstotalmemberslongterm + $totallongtermmembers;
						$grosstotallongterm = $grosstotallongterm + $totallongtermbalance;
					@endphp
					{{ $totallongtermmembers }}
				</td>
				<td align="right">{{ $totallongtermbalance }}</td>
			</tr>
		@endforeach
		<tr>
			<th></th>
			<th align="center">Total</th>
			<th align="right">{{ $grosstotalmembersgeneral }}</th>
			<th align="right">{{ $grosstotalgeneral }}</th>
			<th align="right">{{ $grosstotalmemberslongterm }}</th>
			<th align="right">{{ $grosstotallongterm }}</th>
		</tr>
	</tbody>
</table>