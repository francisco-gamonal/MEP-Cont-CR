<br>
<table border="1" style="font-size:12px;" width="100%;">
	<tr>
		<th colspan="4">PLAN OPERATIVO</th>
		<th colspan="3"></th>
	</tr>
	<tr>
		<td style="text-align:center;">POLÍTICAS</td>
		<td style="text-align:center;">OBJETIVO ESTRATÉGICO</td>
		<td style="text-align:center;">OBJETIVO OPERACIONAL</td>
		<td style="text-align:center;">METAS</td>
		<td style="text-align:center;">CÓDIGOS Presupuestario</td>
		<td style="text-align:center;">RECURSOS PROVINIENTES</td>
		<td style="text-align:center;">MONTO DEL PROYECTO</td>
	</tr>
	@foreach($balanceBudgets as $balanceBudget)
	<tr>
		<td style="text-align:center;">{{$balanceBudget->policies}}</td>
		<td style="text-align:center;">{{$balanceBudget->strategic}}</td>
		<td style="text-align:center;">{{$balanceBudget->operational}}</td>
		<td style="text-align:center;">{{$balanceBudget->goals}}</td>
		<td style="text-align:center;">{{$balanceBudget->catalogs->codeCuenta()}}</td>
		<td style="text-align:center;">{{$balanceBudget->budgets->name}}</td>
		<td style="text-align:center;">{{number_format($balanceBudget->amount)}}</td>
	</tr>
	@endforeach
	<tr>
		<th colspan="6" style="text-align:right; padding-right:1em;">TOTAL PRESUPUESTO {{$balanceBudgets[0]->budgets->name}}</th>
		<th style="text-align:center;">{{number_format($totalBalanceBudgets)}}</th>
	</tr>
</table>