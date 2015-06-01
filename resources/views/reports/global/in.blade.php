<div style="font-size:14px; text-align:center; background:#D0CDCD; color:black; font-weight:bold; border:2px solid black;">
	<span>INGRESOS</span>
</div>
<table border="1" style="font-size:12px;" width="100%;">
	<tr>
		<th style="text-align:center;" colspan="9">Códigos</th>
		<th style="text-align:center;" width="250">Descripción</th>
		<th style="text-align:center;">Monto</th>
		<th style="text-align:center;">Total</th>
	</tr>
	<tr style="font-weight:bold; text-align:center;">
		<td width="10">C</td>
		<td width="10">SC</td>
		<td width="10">G</td>
		<td width="10">SG</td>
		<td width="10">P</td>
		<td width="10">SP</td>
		<td width="10">R</td>
		<td width="10">SR</td>
		<td width="10">F</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<?php $totIn = 0; ?>
	@foreach($groups as $group)
		@if($group->type == 'ingresos')
			<tr>
				<td colspan="10" style="font-weight:bold;font-size:13px;">{{$group->code}}.- {{$group->name}}</td>
				<td></td>
				<td style="font-weight:bold; text-align:center; padding:0 .5em;">{{number_format($group->total, 2)}}</td>
			</tr>
			@foreach($catalogsBudget as $catalog)
				@if($group->id == $catalog->group_id)
					@if($catalog->type == 'ingresos')
						<tr>
							<td style="text-align:center;">{{$catalog->c}}</td>
							<td style="text-align:center;">{{$catalog->sc}}</td>
							<td style="text-align:center;">{{$catalog->g}}</td>
							<td style="text-align:center;">{{$catalog->sg}}</td>
							<td style="text-align:center;">{{$catalog->p}}</td>
							<td style="text-align:center;">{{$catalog->sp}}</td>
							<td style="text-align:center;">{{$catalog->r}}</td>
							<td style="text-align:center;">{{$catalog->sr}}</td>
							<td style="text-align:center;">{{$catalog->f}}</td>
							<td style="padding-left:0.5em;">{{$catalog->name}}</td>
							<td style="text-align:center;">{{number_format($catalog->amount, 2)}}</td>
							<?php $totIn += $catalog->amount; ?>
							<td></td>
						</tr>
					@endif
				@endif
			@endforeach
			<tr>
				<td colspan="10">&nbsp;</td>
				<td></td>
				<td></td>
			</tr>
		@endif
	@endforeach
	<tr style="background:rgb(250, 192, 192);">
		<td colspan="10" style="font-weight:bold; font-size:13px; text-align:right; padding-right:.5em;">TOTAL INGRESOS</td>
		<td style="text-align:center;">{{number_format($totIn, 2)}}</td>
		<td style="font-weight:bold; text-align:center;">{{number_format($totIn, 2)}}</td>
	</tr>
</table>