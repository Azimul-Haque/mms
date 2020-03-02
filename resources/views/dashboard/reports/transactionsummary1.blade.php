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
			<th colspan="14" align="center" style="font-size: 30px;"><big>Transaction Summary: Groupwise Loan Collection Information</big></th>
		</tr>
		<tr>
			<th colspan="14" align="left">Date: {{ date('D, d/m/Y', strtotime($datetocalc)) }}</th>
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
			<td class="lightgray" align="center"><b>Overdue</b></td>
			<td class="lightgray" align="center"><b>Advance</b></td>

			<td class="lightgray" align="center"><b></b></td>
			<td class="lightgray" align="center"><b>Cash</b></td>
			<td class="lightgray" align="center"><b>Overdue</b></td>
			<td class="lightgray" align="center"><b>Advance</b></td>

			<td class="lightgray" align="center"><b></b></td>
			<td class="lightgray" align="center"><b>Cash</b></td>
			<td class="lightgray" align="center"><b>Overdue</b></td>
			<td class="lightgray" align="center"><b>Advance</b></td>
		</tr>
	</thead>
	<tbody>
		@php			
			$primaryrealisabletotal = 0;
			$primarycashtotal = 0;
			$primaryoverduetotal = 0;
			$primaryadvancedtotal = 0;

			$productrealisabletotal = 0;
			$productcashtotal = 0;
			$productoverduetotal = 0;
			$productadvancedtotal = 0;
		@endphp
		@foreach($staffs as $staff)
			@if($staff->groups->count() > 0)
			@php
				$primaryrealisablestaff = 0;
				$primarycashstaff = 0;
				$primaryoverduestaff = 0;
				$primaryadvancedstaff = 0;

				$productrealisablestaff = 0;
				$productcashstaff = 0;
				$productoverduestaff = 0;
				$productadvancedstaff = 0;
			@endphp
			@foreach($staff->groups as $group)
				<tr>
					<td align="left">{{ $staff->name }}</td>
					<td align="left">{{ $group->name }}</td>
					<td align="right">
						@php
							$primaryrealisablegroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans as $loan) {
									if($loan->status == 1 && $loan->loanname_id == 1) {
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
								foreach ($member->loans as $loan) {
									if($loan->status == 1 && $loan->loanname_id == 1) {
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
					<td align="right">
						@php
							$primaryoverduegroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans as $loan) {
									if($loan->status == 1 && $loan->loanname_id == 1) {
										foreach ($loan->loaninstallments as $loaninstallment) {
											if(($loaninstallment->due_date == $datetocalc) && ($loaninstallment->installment_total - $loaninstallment->paid_total > 0)) {
												$primaryoverduegroup = $primaryoverduegroup + ($loaninstallment->installment_total - $loaninstallment->paid_total);
											}
										}
									}
								}
							}
							$primaryoverduestaff = $primaryoverduestaff + $primaryoverduegroup;
						@endphp
						{{ $primaryoverduegroup }}
					</td>
					<td align="right">
						@php
							$primaryadvancedgroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans as $loan) {
									if($loan->status == 1 && $loan->loanname_id == 1) {
										foreach ($loan->loaninstallments as $loaninstallment) {
											if(($loaninstallment->due_date == $datetocalc) && ($loaninstallment->paid_total - $loaninstallment->installment_total > 0)) {
												$primaryadvancedgroup = $primaryadvancedgroup + ($loaninstallment->paid_total - $loaninstallment->installment_total);
											}
										}
									}
								}
							}
							$primaryadvancedstaff = $primaryadvancedstaff + $primaryadvancedgroup;
						@endphp
						{{ $primaryadvancedgroup }}
					</td>

					<td align="right">
						@php
							$productrealisablegroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans as $loan) {
									if($loan->status == 1 && $loan->loanname_id == 2) {
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
								foreach ($member->loans as $loan) {
									if($loan->status == 1 && $loan->loanname_id == 2) {
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
					<td align="right">
						@php
							$productoverduegroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans as $loan) {
									if($loan->status == 1 && $loan->loanname_id == 2) {
										foreach ($loan->loaninstallments as $loaninstallment) {
											if(($loaninstallment->due_date == $datetocalc) && ($loaninstallment->installment_total - $loaninstallment->paid_total > 0)) {
												$productoverduegroup = $productoverduegroup + ($loaninstallment->installment_total - $loaninstallment->paid_total);
											}
										}
									}
								}
							}
							$productoverduestaff = $productoverduestaff + $productoverduegroup;
						@endphp
						{{ $productoverduegroup }}
					</td>
					<td align="right">
						@php
							$productadvancedgroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans as $loan) {
									if($loan->status == 1 && $loan->loanname_id == 2) {
										foreach ($loan->loaninstallments as $loaninstallment) {
											if(($loaninstallment->due_date == $datetocalc) && ($loaninstallment->paid_total - $loaninstallment->installment_total > 0)) {
												$productadvancedgroup = $productadvancedgroup + ($loaninstallment->paid_total - $loaninstallment->installment_total);
											}
										}
									}
								}
							}
							$productadvancedstaff = $productadvancedstaff + $productadvancedgroup;
						@endphp
						{{ $productadvancedgroup }}
					</td>
					
					<td align="right">{{ $primaryrealisablegroup + $productrealisablegroup }}</td>
					<td align="right">{{ $primarycashgroup + $productcashgroup }}</td>
					<td align="right">{{ $primaryoverduegroup + $productoverduegroup }}</td>
					<td align="right">{{ $primaryadvancedgroup + $productadvancedgroup }}</td>
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
				<th align="right">
					{{ $primaryoverduestaff }}
					@php
						$primaryoverduetotal = $primaryoverduetotal + $primaryoverduestaff;
					@endphp
				</th>
				<th align="right">
					{{ $primaryadvancedstaff }}
					@php
						$primaryadvancedtotal = $primaryadvancedtotal + $primaryadvancedstaff;
					@endphp
				</th>

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
				<th align="right">
					{{ $productoverduestaff }}
					@php
						$productoverduetotal = $productoverduetotal + $productoverduestaff;
					@endphp
				</th>
				<th align="right">
					{{ $productadvancedstaff }}
					@php
						$productadvancedtotal = $productadvancedtotal + $productadvancedstaff;
					@endphp
				</th>
				
				<th align="right">{{ $primaryrealisablestaff + $productrealisablestaff }}</th>
				<th align="right">{{ $primarycashstaff + $productcashstaff }}</th>
				<th align="right">{{ $primaryoverduestaff + $productoverduestaff }}</th>
				<th align="right">{{ $primaryadvancedstaff + $productadvancedstaff }}</th>
			</tr>
			@endif
		@endforeach
		<tr>
			<th></th>
			<th align="center">Grand Total</th>
			<th align="right">{{ $primaryrealisabletotal }}</th>
			<th align="right">{{ $primarycashtotal }}</th>
			<th align="right">{{ $primaryoverduetotal }}</th>
			<th align="right">{{ $primaryadvancedtotal }}</th>

			<th align="right">{{ $productrealisabletotal }}</th>
			<th align="right">{{ $productcashtotal }}</th>
			<th align="right">{{ $productoverduetotal }}</th>
			<th align="right">{{ $productadvancedtotal }}</th>

			<th align="right">{{ $primaryrealisabletotal + $productrealisabletotal }}</th>
			<th align="right">{{ $primarycashtotal + $productcashtotal }}</th>
			<th align="right">{{ $primaryoverduetotal + $productoverduetotal }}</th>
			<th align="right">{{ $primaryadvancedtotal + $productadvancedtotal }}</th>
		</tr>
	</tbody>
</table>