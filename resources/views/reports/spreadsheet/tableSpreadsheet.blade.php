<p style="font-size:12px; margin:0; text-align:center;">FORMULARIO F-4 LISTA DE PAGOS A REALIZAR</p>
<table border="1" style="font-size:12px;" width="100%;">
	<tr>
		<th style="text-align:center;" colspan="8">
			PLANILLA DE PAGO N° {{$spreadsheet->number}}-{{$spreadsheet->year}} FECHA {{$spreadsheet->date}}
			<br>
			Cédula Jurídica {{$spreadsheet->budgets->schools->charter}}
		</th>
		<th style="text-align:center;" colspan="4">
			PROGRAMA:
			<br>
			{{$spreadsheet->budgets->name}}
		</th>
	</tr>
</table>