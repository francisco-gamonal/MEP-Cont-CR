<div class="row">
	<img src="{{asset('img/mep-logo.png')}}" width="80" style="position:absolute;">
	<div style="font-size:12px; font-weight:bold; text-align:center;">
		<p style="margin:0;">MINISTERIO DE EDUCACIÓN PÚBLICA</p>
		<p style="margin:0;">DIRECCION REGIONAL DE EDUCACIÓN DE XXXX</p>
	</div>
	<div style="font-size:13px; text-align:center;">
		<p style="margin:0;">{{$budget->schools->name}} CÉDULA JURÍDICA {{$budget->schools->charter}}</p>
		<p>
			<span>CIRCUITO {{$budget->schools->circuit}}</span>
			<span>CÓDIGO {{$budget->schools->code}}</span>
		</p>
	</div>
</div>