	@foreach($content as $value)
	<tr>
		<td width="15" style="text-align:center;">{{$value['0']}}</td>
		<td width="15" style="text-align:center;">{{$value['1']}}</td>
		<td width="15" style="text-align:center;">{{$value['2']}}</td>
		<td width="15" style="text-align:center;">{{$value['3']}}</td>
		<td width="15" style="text-align:center;">{{$value['4']}}</td>
		<td width="15" style="text-align:center;">{{$value['5']}}</td>
		<td width="15" style="text-align:center;">{{$value['6']}}</td>
		<td width="15" style="text-align:center;">{{$value['7']}}</td>
		<td width="15" style="text-align:center;">{{$value['8']}}</td>
		<td width="15" style="text-align:center;">{{$value['9']}}</td>
		<td width="15" style="text-align:center;">{{$value['10']}}</td>
		<td width="15" style="text-align:center;">{{$value['11']}}</td>
	</tr>
	@endforeach
	<tr style="font-weight:bold;">
		<td colspan="5" style="text-align:right; padding-right:1em;">TOTALES</td>
		<td style="text-align:center;">{{number_format($totalAmount, 2)}}</td>
		<td style="text-align:center;">{{number_format($totalRetention, 2)}}</td>
		<td style="text-align:center;">{{number_format($totalCancelar, 2)}}</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>