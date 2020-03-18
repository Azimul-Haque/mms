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
			<th colspan="15" align="center" {{-- style="font-size: 30px;" --}}>Transaction Summary: Groupwise Savings, Admission Fee, PassBook Fee, Loan Insurance</th>
		</tr>
		<tr>
			<th colspan="15" align="left">Date: {{ date('D, d/m/Y', strtotime($datetocalc)) }}</th>
		</tr>
		<tr>
			<th rowspan="2" class="lightgray">Loan Officer</th>
			<th rowspan="2" class="lightgray">Group Name</th>
			<th colspan="2" class="lightgray" align="center">GENERAL SAVINGS</th>
			<th colspan="2" class="lightgray" align="center">LONG TERM SAVINGS</th>
			<th colspan="2" class="lightgray" align="center">SHARED DEPOSIT</th>
			<th class="lightgray" align="center">Admission Fee</th>
			<th class="lightgray" align="center">PassBook Fee</th>
			<th class="lightgray" align="center">Loan Insurance</th>
			<th class="lightgray" align="center">Processing Fee</th>
			{{-- <th class="lightgray" align="center">Down Payment</th> --}}
			<th class="lightgray" align="center"></th>
			<th class="lightgray" align="center">Total Loan</th>
			<th class="lightgray" align="center">Total Loan Amount</th>
		</tr>
		<tr>
			<td colspan="2" class="lightgray" align="center"><b>Dummy</b></td>

			<td class="lightgray" align="center"><b>Collection</b></td>
			<td class="lightgray" align="center"><b>Withdrawal</b></td>
			<td class="lightgray" align="center"><b>Collection</b></td>
			<td class="lightgray" align="center"><b>Withdrawal</b></td>
			<td class="lightgray" align="center"><b>Collection</b></td>
			<td class="lightgray" align="center"><b>Withdrawal</b></td>
			<td class="lightgray" align="center"><b>Total</b></td>
			<td class="lightgray" align="center"><b>Total</b></td>
			<td class="lightgray" align="center"><b>Total</b></td>
			<td class="lightgray" align="center"><b>Total</b></td>
			{{-- <td class="lightgray" align="center"><b>Total</b></td> --}}
			<td class="lightgray" align="center"><b>Total</b></td>
			<td class="lightgray" align="center"></td>
			<td class="lightgray" align="center"></td>
		</tr>
	</thead>
	<tbody>
		@php			
			$generalcolltotal = 0;
			$generalwithdrawtotal = 0;

			$longtermcolltotal = 0;
			$longtermwithdrawtotal = 0;

			$shareddepcolltotal = 0;
			$shareddepwithdrawtotal = 0;

			$admissionfeetotal = 0;
			$passbookfeetotal = 0;
			$loaninsurancetotal = 0;
			$processingfeetotal = 0;

			$loanstotal = 0;
			$loansamounttotal = 0;

		@endphp
		@foreach($staffs as $staff)
			@if($staff->groups->count() > 0)
			@php
				$generalcollstaff = 0;
				$generalwithdrawstaff = 0;

				$longtermcollstaff = 0;
				$longtermwithdrawstaff = 0;

				$shareddepcollstaff = 0;
				$shareddepwithdrawstaff = 0;

				$admissionfeestaff = 0;
				$passbookfeestaff = 0;
				$loaninsurancestaff = 0;
				$processingfeestaff = 0;

				$loansofstaff = 0;
				$loansamountofstaff = 0;
			@endphp
			@foreach($staff->groups as $group)
				<tr>
					<td align="left">{{ $staff->name }}</td>
					<td align="left">{{ $group->name }}</td>
					<td align="right">
						@php
							$generalcollgroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->savings as $saving) {
									if($saving->savingname_id == 1) {
										foreach ($saving->savinginstallments as $savinginstallment) {
											if($savinginstallment->due_date == $datetocalc) {
												$generalcollgroup = $generalcollgroup + $savinginstallment->amount;
											}
										}
									}
								}
							}
							$generalcollstaff = $generalcollstaff + $generalcollgroup;
						@endphp
						{{ $generalcollgroup }}
					</td>
					<td align="right">
						@php
							$generalwithdrawgroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->savings as $saving) {
									if($saving->savingname_id == 1) {
										foreach ($saving->savinginstallments as $savinginstallment) {
											if($savinginstallment->due_date == $datetocalc) {
												$generalwithdrawgroup = $generalwithdrawgroup + $savinginstallment->withdraw;
											}
										}
									}
								}
							}
							$generalwithdrawstaff = $generalwithdrawstaff + $generalwithdrawgroup;
						@endphp
						{{ $generalwithdrawgroup }}
					</td>
					<td align="right">
						@php
							$longtermcollgroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->savings as $saving) {
									if($saving->savingname_id == 2) {
										foreach ($saving->savinginstallments as $savinginstallment) {
											if($savinginstallment->due_date == $datetocalc) {
												$longtermcollgroup = $longtermcollgroup + $savinginstallment->amount;
											}
										}
									}
								}
							}
							$longtermcollstaff = $longtermcollstaff + $longtermcollgroup;
						@endphp
						{{ $longtermcollgroup }}
					</td>
					<td align="right">
						@php
							$longtermwithdrawgroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->savings as $saving) {
									if($saving->savingname_id == 2) {
										foreach ($saving->savinginstallments as $savinginstallment) {
											if($savinginstallment->due_date == $datetocalc) {
												$longtermwithdrawgroup = $longtermwithdrawgroup + $savinginstallment->withdraw;
											}
										}
									}
								}
							}
							$longtermwithdrawstaff = $longtermwithdrawstaff + $longtermwithdrawgroup;
						@endphp
						{{ $longtermwithdrawgroup }}
					</td>

					<td align="right">
						@php
							$shareddepcollgroup = 0;
							foreach ($group->members as $member) {
								if($member->admission_date == $datetocalc) {
									$shareddepcollgroup = $shareddepcollgroup + $member->shared_deposit;
								}
							}
							$shareddepcollstaff = $shareddepcollstaff + $shareddepcollgroup;
						@endphp
						{{ $shareddepcollgroup }}
					</td>
					<td align="right">
						@php
							$shareddepwithdrawalgroup = 0;
							foreach ($group->members as $member) {
								if($member->closing_date == $datetocalc) {
									$shareddepwithdrawalgroup = $shareddepwithdrawalgroup + $member->shared_deposit;
								}
							}
							$shareddepwithdrawstaff = $shareddepwithdrawstaff + $shareddepwithdrawalgroup;
						@endphp
						{{ $shareddepwithdrawalgroup }}
					</td>

					<td align="right">
						@php
							$admissionfeegroup = 0;
							foreach ($group->members as $member) {
								if(($member->admission_date == $datetocalc)) {
									$admissionfeegroup = $admissionfeegroup + $member->admission_fee;
								}
							}
							$admissionfeestaff = $admissionfeestaff + $admissionfeegroup;
						@endphp
						{{ $admissionfeegroup }}
					</td>
					<td align="right">
						@php
							$passbookfeegroup = 0;
							foreach ($group->members as $member) {
								if(($member->admission_date == $datetocalc)) {
									$passbookfeegroup = $passbookfeegroup + $member->passbook_fee;
								}
							}
							$passbookfeestaff = $passbookfeestaff + $passbookfeegroup;
						@endphp
						{{ $passbookfeegroup }}
					</td>
					<td align="right">
						@php
							$loaninsurancegroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans as $loan) {
									if(($loan->loanname_id == 1) && ($loan->disburse_date == $datetocalc)) {
										$loaninsurancegroup = $loaninsurancegroup + $loan->insurance;
									}
								}
							}
							$loaninsurancestaff = $loaninsurancestaff + $loaninsurancegroup;
						@endphp
						{{ $loaninsurancegroup }}
					</td>
					<td align="right">
						@php
							$processingfeegroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans as $loan) {
									if(($loan->loanname_id == 1) && ($loan->disburse_date == $datetocalc)) {
										$processingfeegroup = $processingfeegroup + $loan->processing_fee;
									}
								}
							}
							$processingfeestaff = $processingfeestaff + $processingfeegroup;
						@endphp
						{{ $processingfeegroup }}
					</td>
					
					<td align="right">{{ $generalcollgroup + $longtermcollgroup + $shareddepcollgroup - ($generalwithdrawgroup + $longtermwithdrawgroup + $shareddepwithdrawalgroup) + $admissionfeegroup + $passbookfeegroup + $loaninsurancegroup + $processingfeegroup  }}</td>

					<td align="right">
						@php
							$totalloansofgroup = 0;
							$totalloansamountofgroup = 0;
							foreach ($group->members as $member) {
								foreach ($member->loans as $loan) {
									if($loan->disburse_date == $datetocalc) {
										$totalloansofgroup = $totalloansofgroup + 1;
										$totalloansamountofgroup = $totalloansamountofgroup + $loan->total_disbursed;
									}
								}
							}
							$loansofstaff = $loansofstaff + $totalloansofgroup;
							$loansamountofstaff = $loansamountofstaff + $totalloansamountofgroup;
						@endphp
						{{ $totalloansofgroup }}
					</td>
					<td>
						{{ $totalloansamountofgroup }}
					</td>
				</tr>
			@endforeach
			<tr>
				<th align="right"></th>
				<th align="right">Total</th>

				<th align="right">
					{{ $generalcollstaff }}
					@php
						$generalcolltotal = $generalcolltotal + $generalcollstaff;
					@endphp
				</th>
				<th align="right">
					{{ $generalwithdrawstaff }}
					@php
						$generalwithdrawtotal = $generalwithdrawtotal + $generalwithdrawstaff;
					@endphp
				</th>

				<th align="right">
					{{ $longtermcollstaff }}
					@php
						$longtermcolltotal = $longtermcolltotal + $longtermcollstaff;
					@endphp
				</th>
				<th align="right">
					{{ $longtermwithdrawstaff }}
					@php
						$longtermwithdrawtotal = $longtermwithdrawtotal + $longtermwithdrawstaff;
					@endphp
				</th>

				<th align="right">
					{{ $shareddepcollstaff }}
					@php
						$shareddepcolltotal = $shareddepcolltotal + $shareddepcollstaff;
					@endphp
				</th>
				<th align="right">
					{{ $shareddepwithdrawstaff }}
					@php
						$shareddepwithdrawtotal = $shareddepwithdrawtotal + $shareddepwithdrawstaff;
					@endphp
				</th>

				<th align="right">
					{{ $admissionfeestaff }}
					@php
						$admissionfeetotal = $admissionfeetotal + $admissionfeestaff;
					@endphp
				</th>
				<th align="right">
					{{ $passbookfeestaff }}
					@php
						$passbookfeetotal = $passbookfeetotal + $passbookfeestaff;
					@endphp
				</th>
				<th align="right">
					{{ $loaninsurancestaff }}
					@php
						$loaninsurancetotal = $loaninsurancetotal + $loaninsurancestaff;
					@endphp
				</th>
				<th align="right">
					{{ $processingfeestaff }}
					@php
						$processingfeetotal = $processingfeetotal + $processingfeestaff;
					@endphp
				</th>
				
				<th align="right">
					{{ ($generalcollstaff + $longtermcollstaff + $shareddepcollstaff + $admissionfeestaff + $passbookfeestaff + $loaninsurancestaff + $processingfeestaff) - ($generalwithdrawstaff + $longtermwithdrawstaff + $shareddepwithdrawstaff) }}
				</th>

				<th align="right">
					{{ $loansofstaff }}
					@php
						$loanstotal = $loanstotal + $loansofstaff;
					@endphp
				</th>

				<th align="right">
					{{ $loansamountofstaff }}
					@php
						$loansamounttotal = $loansamounttotal + $loansamountofstaff;
					@endphp
				</th>
			</tr>
			@endif
		@endforeach
		<tr>
			<th></th>
			<th align="center">Grand Total</th>
			<th align="right">{{ $generalcolltotal }}</th>
			<th align="right">{{ $generalwithdrawtotal }}</th>
			
			<th align="right">{{ $longtermcolltotal }}</th>
			<th align="right">{{ $longtermwithdrawtotal }}</th>
			
			<th align="right">{{ $shareddepcolltotal }}</th>
			<th align="right">{{ $shareddepwithdrawtotal }}</th>

			<th align="right">{{ $admissionfeetotal }}</th>
			<th align="right">{{ $passbookfeetotal }}</th>
			<th align="right">{{ $loaninsurancetotal }}</th>
			<th align="right">{{ $processingfeetotal }}</th>

			<th align="right">{{ ($generalcolltotal + $longtermcolltotal + $shareddepcolltotal + $admissionfeetotal + $passbookfeetotal + $loaninsurancetotal + $processingfeetotal) - ($generalwithdrawtotal + $longtermwithdrawtotal + $shareddepwithdrawtotal) }}</th>

			<th align="right">{{ $loanstotal }}</th>
			<th align="right">{{ $loansamounttotal }}</th>
		</tr>
	</tbody>
</table>