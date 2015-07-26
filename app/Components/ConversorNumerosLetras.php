<?php
namespace Mep\Components;

// FUNCIONES DE CONVERSION DE NUMEROS A LETRAS
// Se llama a la funci�n principal: convertir_a_letras($numero)

if(isset($_POST['id']))
 {
$numero = $_POST['id'];
$result = convertir_a_letras($numero);
return $result;
 }
?>