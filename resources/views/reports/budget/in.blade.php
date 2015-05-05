<div style="font-size:14px; text-align:center; background:#D0CDCD; color:black; font-weight:bold; border:2px solid black;">
	<span>INGRESOS</span>
</div>
<table border="1" style="font-size:12px;" width="100%;">
	<thead>
		<th style="text-align:center;" colspan="9">Códigos</th>
		<th style="text-align:center;" width="350">Descripción</th>
		<?php foreach($budget->typeBudgets as $typeBudget){  ?>
			<th style="text-align:center;"><?= $typeBudget->name?></th>
		<?php } ?>
		<th style="text-align:center;">SUB TOTAL</th>
		<th style="text-align:center;">TOTAL</th>
	</thead>
	<tbody>
		<tr style="font-weight:bold; text-align:center;">
			<td width="20">C</td>
			<td width="20">SC</td>
			<td width="20">G</td>
			<td width="20">SG</td>
			<td width="20">P</td>
			<td width="20">SP</td>
			<td width="20">R</td>
			<td width="20">SR</td>
			<td width="20">F</td>
			<td></td>
			foreach($budget->typeBudgets as $typeBudget){
				<td></td>
			}
			<td></td>
			<td></td>
		</tr>
		foreach($budget->groups as $group){
			if($group->type == 'ingresos'){
				<tr>
					<td colspan="10" style="font-weight:bold;font-size:13px;">{{$group->code}}.- {{$group->name}}</td>
					foreach($budget->typeBudgets as $typeBudget){
						<td></td>
					}
					<td></td>
					<td style="text-align:center; padding:0 .5em;">{{$group->balanceForGroup($budget, $group, $group->type)}}</td>
				</tr>
				foreach($catalogsBudget as $catalog){
					if($group->id == $catalog['groups_id']){
						if($catalog['type'] == 'ingresos'){
							<tr>
								<td style="text-align:center;">{{$catalog['c']}}</td>
								<td style="text-align:center;">{{$catalog['sc']}}</td>
								<td style="text-align:center;">{{$catalog['g']}}</td>
								<td style="text-align:center;">{{$catalog['sg']}}</td>
								<td style="text-align:center;">{{$catalog['p']}}</td>
								<td style="text-align:center;">{{$catalog['sp']}}</td>
								<td style="text-align:center;">{{$catalog['r']}}</td>
								<td style="text-align:center;">{{$catalog['sr']}}</td>
								<td style="text-align:center;">{{$catalog['f']}}</td>
								<td style="padding-left:0.5em;">{{$catalog['name']}}</td>
								foreach($catalog['typeBudget'] as $amount){
									if($amount>0){
										<td style="text-align:center;">{{$amount}}</td>
									}else{
										<td></td>
									}
								}
								<td></td>
							</tr>
						}
					}
				}
				<tr>
					<td colspan="10">&nbsp;</td>
					foreach($budget->typeBudgets as $typeBudget){
						<td></td>
					}
					<td></td>
					<td></td>
				</tr>
			}
		}
		<tr style="background:rgb(250, 192, 192);">
			<td colspan="10" style="font-weight:bold;font-size:13px; text-align:right; padding-right:.5em;">TOTAL INGRESOS</td>
			<?php $tot = 0; ?>
			foreach($budget->typeBudgets as $typeBudget){
				<?php $tot += $typeBudget->balanceForTypeBudget($budget, $typeBudget->id, 'ingresos'); ?>
				if($typeBudget->balanceForTypeBudget($budget, $typeBudget->id, 'ingresos') > 0){
					<td style="text-align:center;">{{number_format($typeBudget->balanceForTypeBudget($budget, $typeBudget->id, 'ingresos'))}}</td>
				}else{
					<td></td>
				}
			}
			<td></td>
			<td style="text-align:center;">{{number_format($tot)}}</td>
		</tr>
	</tbody>
</table>