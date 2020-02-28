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
			<th colspan="11" align="center" {{-- style="font-size: 30px;" --}}>Transaction Summary: Groupwise Savings, Admission Fee, PassBook Fee, Loan Insurance</th>
		</tr>
		<tr>
			<th colspan="11" align="left">Date: {{ date('D, d/m/Y') }}</th>
		</tr>
		<tr>
			<th rowspan="2" class="lightgray">Loan Officer</th>
			<th rowspan="2" class="lightgray">Group Name</th>
			<th colspan="2" class="lightgray" align="center">GENERAL SAVINGS</th>
			<th colspan="2" class="lightgray" align="center">LONG TERM SAVINGS</th>
			<th class="lightgray" align="center">Admission Fee</th>
			<th class="lightgray" align="center">PassBook Fee</th>
			<th class="lightgray" align="center">Loan Insurance</th>
			<th class="lightgray" align="center">Processing Fee</th>
			<th class="lightgray" align="center"></th>
		</tr>
		<tr>
			<td colspan="2" class="lightgray" align="center"><b>Dummy</b></td>

			<td class="lightgray" align="center"><b>Collection</b></td>
			<td class="lightgray" align="center"><b>Withdrawal</b></td>
			<td class="lightgray" align="center"><b>Collection</b></td>
			<td class="lightgray" align="center"><b>Withdrawal</b></td>
			<td class="lightgray" align="center"><b>Total</b></td>
			<td class="lightgray" align="center"><b>Total</b></td>
			<td class="lightgray" align="center"><b>Total</b></td>
			<td class="lightgray" align="center"><b>Total</b></td>
			<td class="lightgray" align="center"><b>Total</b></td>
		</tr>
	</thead>
	<tbody>
		@php			
			$generalcolltotal = 0;
			$generalwithdrawtotal = 0;

			$longtermcolltotal = 0;
			$longtermwithdrawtotal = 0;

			$admissionfeetotal = 0;
			$passbookfeetotal = 0;
			$loaninsurancetotal = 0;
			$processingfeetotal = 0;

		@endphp
		@foreach($staffs as $staff)
			@if($staff->groups->count() > 0)
			@php
				$generalcollstaff = 0;
				$generalwithdrawstaff = 0;

				$longtermcollstaff = 0;
				$longtermwithdrawstaff = 0;

				$admissionfeestaff = 0;
				$passbookfeestaff = 0;
				$loaninsurancestaff = 0;
				$processingfeestaff = 0;
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
									if($saving->status == 1 && $saving->savingname_id == 1) {
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
									if($saving->status == 1 && $saving->savingname_id == 1) {
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
									if($saving->status == 1 && $saving->savingname_id == 2) {
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
									if($saving->status == 1 && $saving->savingname_id == 2) {
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
							$admissionfeegroup = 0;
							foreach ($group->members as $member) {
								if(($member->status == 1) && ($member->admission_date == $datetocalc)) {
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
								if(($member->status == 1) && ($member->admission_date == $datetocalc)) {
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
									if(($loan->status == 1) && ($loan->loanname_id == 1) && ($loan->disburse_date == $datetocalc)) {
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
									if(($loan->status == 1) && ($loan->loanname_id == 1) && ($loan->disburse_date == $datetocalc)) {
										$processingfeegroup = $processingfeegroup + $loan->processing_fee;
									}
								}
							}
							$processingfeestaff = $processingfeestaff + $processingfeegroup;
						@endphp
						{{ $processingfeegroup }}
					</td>
					
					<td align="right">{{ $generalcollgroup + $longtermcollgroup - ($generalwithdrawgroup + $longtermwithdrawgroup) }}</td>
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
					{{ ($generalcollstaff + $longtermcollstaff + $admissionfeestaff + $passbookfeestaff + $loaninsurancestaff) - ($generalwithdrawstaff + $longtermwithdrawstaff) }}
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

			<th align="right">{{ $admissionfeetotal }}</th>
			<th align="right">{{ $passbookfeetotal }}</th>
			<th align="right">{{ $loaninsurancetotal }}</th>
			<th align="right">{{ $processingfeetotal }}</th>

			<th align="right">{{ ($generalcolltotal + $longtermcolltotal + $admissionfeetotal + $passbookfeetotal + $loaninsurancetotal + $processingfeetotal) - ($generalwithdrawtotal + $longtermwithdrawtotal) }}</th>
			
		</tr>
	</tbody>
</table>