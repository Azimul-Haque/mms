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
			<th colspan="4" align="center" {{-- style="font-size: 30px;" --}}>Transaction Summary: Staff wise total Collection and Disbursement</th>
		</tr>
		<tr>
			<th colspan="4" align="left">Date: {{ date('D, d/m/Y') }}</th>
		</tr>
		<tr>
			<th class="lightgray">Loan Officer</th>
			<th class="lightgray" align="center">Total Collection</th>
			<th class="lightgray" align="center">Total Disbursement</th>
			<th class="lightgray" align="center">Rest Amount</th>
		</tr>
	</thead>
	<tbody>
		@php
			$totalloaninstallmentscollection = 0;
			$totalsavinginstallmentscollection = 0;
		@endphp
		@foreach($staffs as $staff)
		<tr>
			<td align="left">{{ $staff->name }}</td>
			<td>
				@php
					$staffloaninstallmentscollection = 0;
					foreach ($loaninstallments as $loaninstallment) {
						if($loaninstallment->user_id == $staff->id) {
							$staffloaninstallmentscollection = $staffloaninstallmentscollection + $loaninstallment->paid_total;
						}
					}
					$totalloaninstallmentscollection = $totalloaninstallmentscollection + $staffloaninstallmentscollection;

					$staffsavinginstallmentscollection = 0;
					foreach ($savinginstallments as $savinginstallment) {
						if($savinginstallment->user_id == $staff->id) {
							$staffsavinginstallmentscollection = $staffsavinginstallmentscollection + $savinginstallment->amount;
						}
					}
					$totalsavinginstallmentscollection = $totalsavinginstallmentscollection + $staffsavinginstallmentscollection;
				@endphp
				{{ $staffloaninstallmentscollection + $staffsavinginstallmentscollection }}
			</td>
			<td>
				
			</td>
			<td>
				
			</td>
		</tr>
		@endforeach
		<tr>
			<td align="left">Total</td>
			<td>{{ $totalloaninstallmentscollection + $totalsavinginstallmentscollection }}</td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>