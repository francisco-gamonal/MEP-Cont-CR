	@foreach($content as $value)
	<tr>
		<td style="text-align:center;">{{$value['0']}}</td>
		<td style="text-align:center;">{{$value['1']}}</td>
		<td style="text-align:center;">{{$value['2']}}</td>
		<td style="text-align:center;">{{$value['3']}}</td>
		<td style="text-align:center;">{{$value['4']}}</td>
		<td style="text-align:center;">{{$value['5']}}</td>
	</tr>
	@endforeach
	<tr style="font-weight:bold;">
		<td colspan="3" style="text-align:right; padding-right:1em;">TOTAL</td>
		<td style="text-align:center;">{{$rebajo}}</td>
		<td style="text-align:center;">{{$aumento}}</td>
		<td style="text-align:center;"></td>
	</tr>
</table>