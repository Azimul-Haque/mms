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
			<th colspan="14" align="center">Transaction Summary</th>
		</tr>
		<tr>
			<th colspan="14" align="left">Date: {{ date('D, d/m/Y') }}</th>
		</tr>
		<tr>
			<th rowspan="3" class="lightgray">Loan Officer</th>
			<th rowspan="3" class="lightgray">Group Name</th>
			<th colspan="4" class="lightgray" align="center">PRIMARY LOAN</th>
			<th colspan="4" class="lightgray" align="center">PRODUCT LOAN</th>
			<th colspan="4" class="lightgray" align="center">Total</th>
		</tr>
		<tr>
			<td colspan="2" class="lightgray" align="center"><b>Dummy</b></td>

			<td class="lightgray" align="center"><b>Realisable</b></td>
			<td colspan="3" class="lightgray" align="center"><b>Realised</b></td>
			<td class="lightgray" align="center"><b>Realisable</b></td>
			<td colspan="3" class="lightgray" align="center"><b>Realised</b></td>
			<td class="lightgray" align="center"><b>Realisable</b></td>
			<td colspan="3" class="lightgray" align="center"><b>Realised</b></td>
		</tr>
		<tr>
			<td colspan="2" class="lightgray"><b></b></td>
			
			<td class="lightgray" align="center"><b></b></td>
			<td class="lightgray" align="center"><b>Cash</b></td>
			<td class="lightgray" align="center"><b>Adjust</b></td>
			<td class="lightgray" align="center"><b>Advance</b></td>

			<td class="lightgray" align="center"><b></b></td>
			<td class="lightgray" align="center"><b>Cash</b></td>
			<td class="lightgray" align="center"><b>Adjust</b></td>
			<td class="lightgray" align="center"><b>Advance</b></td>

			<td class="lightgray" align="center"><b></b></td>
			<td class="lightgray" align="center"><b>Cash</b></td>
			<td class="lightgray" align="center"><b>Adjust</b></td>
			<td class="lightgray" align="center"><b>Advance</b></td>
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

			
			$primaryrealisabletotal = 0;
			$primarycashtotal = 0;
			$productrealisabletotal = 0;
			$productcashtotal = 0;
		@endphp
		@foreach($staffs as $staff)
			@if($staff->groups->count() > 0)
			@php
				$primaryrealisablestaff = 0;
				$primarycashstaff = 0;
				$productrealisablestaff = 0;
				$productcashstaff = 0;
			@endphp
			@foreach($staff->groups as $group)
				<tr>
					<td align="left">{{ $staff->name }}</td>
					<td align="left">{{ $group->name }}</td>
					<td align="right">
						@php
							$primaryrealisablegroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans->where('loanname_id', 1) as $loan) {
									if($loan->status == 1) {
										foreach ($loan->loaninstallments as $loaninstallment) {
											if($loaninstallment->due_date == $datetocalc) {
												$primaryrealisablegroup = $primaryrealisablegroup + $loaninstallment->installment_total;
											}
										}
									}
								}
							}
							$primaryrealisablestaff = $primaryrealisablestaff + $primaryrealisablegroup;
						@endphp
						{{ $primaryrealisablegroup }}
					</td>
					<td align="right">
						@php
							$primarycashgroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans->where('loanname_id', 1) as $loan) {
									if($loan->status == 1) {
										foreach ($loan->loaninstallments as $loaninstallment) {
											if($loaninstallment->due_date == $datetocalc) {
												$primarycashgroup = $primarycashgroup + $loaninstallment->paid_total;
											}
										}
									}
								}
							}
							$primarycashstaff = $primarycashstaff + $primarycashgroup;
						@endphp
						{{ $primarycashgroup }}
					</td>
					<td align="right">0</td>
					<td align="right">0</td>

					<td align="right">
						@php
							$productrealisablegroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans->where('loanname_id', 2) as $loan) {
									if($loan->status == 1) {
										foreach ($loan->loaninstallments as $loaninstallment) {
											if($loaninstallment->due_date == $datetocalc) {
												$productrealisablegroup = $productrealisablegroup + $loaninstallment->installment_total;
											}
										}
									}
								}
							}
							$productrealisablestaff = $productrealisablestaff + $productrealisablegroup;
						@endphp
						{{ $productrealisablegroup }}
					</td>
					<td align="right">
						@php
							$productcashgroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans->where('loanname_id', 2) as $loan) {
									if($loan->status == 1) {
										foreach ($loan->loaninstallments as $loaninstallment) {
											if($loaninstallment->due_date == $datetocalc) {
												$productcashgroup = $productcashgroup + $loaninstallment->paid_total;
											}
										}
									}
								}
							}
							$productcashstaff = $productcashstaff + $productcashgroup;
						@endphp
						{{ $productcashgroup }}
					</td>
					<td align="right">0</td>
					<td align="right">0</td>
					
					<td align="right">{{ $primaryrealisablegroup + $productrealisablegroup }}</td>
					<td align="right">{{ $primarycashgroup + $productcashgroup }}</td>
					<td align="right">0</td>
					<td align="right">0</td>
				</tr>
			@endforeach
			<tr>
				<th align="right"></th>
				<th align="right">Total</th>

				<th align="right">
					{{ $primaryrealisablestaff }}
					@php
						$primaryrealisabletotal = $primaryrealisabletotal + $primaryrealisablestaff;
					@endphp
				</th>
				<th align="right">
					{{ $primarycashstaff }}
					@php
						$primarycashtotal = $primarycashtotal + $primarycashstaff;
					@endphp
				</th>
				<th align="right">0</th>
				<th align="right">0</th>

				<th align="right">
					{{ $productrealisablestaff }}
					@php
						$productrealisabletotal = $productrealisabletotal + $productrealisablestaff;
					@endphp
				</th>
				<th align="right">
					{{ $productcashstaff }}
					@php
						$productcashtotal = $productcashtotal + $productcashstaff;
					@endphp
				</th>
				<th align="right">0</th>
				<th align="right">0</th>
				
				<th align="right">{{ $primaryrealisablestaff + $productrealisablestaff }}</th>
				<th align="right">{{ $primarycashstaff + $productcashstaff }}</th>
				<th align="right">0</th>
				<th align="right">0</th>
			</tr>
			@endif
		@endforeach
		<tr>
			<th></th>
			<th align="center">Grand Total</th>
			<th align="right">{{ $primaryrealisabletotal }}</th>
			<th align="right">{{ $primarycashtotal }}</th>
			<th align="right">0</th>
			<th align="right">0</th>

			<th align="right">{{ $productrealisabletotal }}</th>
			<th align="right">{{ $productcashtotal }}</th>
			<th align="right">0</th>
			<th align="right">0</th>

			<th align="right">{{ $primaryrealisabletotal + $productrealisabletotal }}</th>
			<th align="right">{{ $primarycashtotal + $productcashtotal }}</th>
			<th align="right">0</th>
			<th align="right">0</th>
		</tr>
	</tbody>
</table>