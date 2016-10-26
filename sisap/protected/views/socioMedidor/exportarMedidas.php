<?php
/* 
 * ANALIZAMOS, DISE�AMOS Y PROGRAMAMOS TUS IDEAS  
 *    EN SISTEMAS INFORM�TICOS PARA LA WEB
 *            Ing. Juan Tierra
 *            PRESENCE SYSTEM

 */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" /> 
<title></title>
</head>
<body> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <table border="2px">
        <tr BGCOLOR="#81DAF5"  align="center"> 
            <td>
              <b> N° </b>
            </td>
            <td>
                <b> ID </b>
            </td>
            <td>
                <b> RECORRIDO </b>
            </td>
            <td>
                <b> APELLIDOS Y NOMBRES </b>
            </td>
            <td>
                <b> CI </b>
            </td>            
            <td>
                <b> MEDIDOR N° </b>
            </td>
            
            <td>
                <b> C. ANTERIOR </b>
            </td>
            <td>
                <b> C. ACTUAL </b>
            </td>
        </tr>
        <?php 
        $contador = 1;
        foreach ($socio_medidor as $soc_med)
        {
            echo "<tr>";
                echo "<td>".$contador++."</td>";
                echo "<td>".$soc_med->ID."</td>";
                echo "<td>".$soc_med->FECHA_ACTUALIZACION."</td>"; //Orden de Recorrido
                echo "<td>".$soc_med->cODIGOSOCIO->APELLIDO."</td>";
                echo "<td>".$soc_med->cODIGOSOCIO->CI."</td>";                
                echo "<td>".$soc_med->iDMEDIDOR->NUMERO."</td>";                
                $consumo_anterior = $soc_med->COD_USUARIO; //
                if ($consumo_anterior == '')
                    $consumo_anterior=0;
                echo "<td>".$consumo_anterior."</td>";
                echo "<td>";
                echo "</td>";
            echo "</tr>";
        }; // Termina de exportar todos los medidores
        ?>
    </table>
</body>
</html>

