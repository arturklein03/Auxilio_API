<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="sytle.css">
   <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
   <title>Auxílio Brasil</title>
</head>
<body>

   <form action="index.php" method="POST">
      <label for="cidade">Cidade: </label>
      <input type="text" value="linha nova" id="cidade" name="cidade">
      <label for="mes">Mês: </label>
      <select required name="mes" id="mes">
         <!--<option disabled selected value=""></option>-->
         <option value="202111">Novembro 2021</option>
         <option value="202112">Dezembro 2021</option>
         <option value="202201">Janeiro 2022</option>
      </select>
      <input type="submit" value="Buscar" name="botao" id="botao">
   </form>
   <div id="grafico"></div>
 <?php
 
   if (isset($_POST['botao'])){
      require_once "api.php";
      require_once "BD.php";
      
      $banco = new MySQL();

      $sql = "SELECT * FROM cidades WHERE nomeCidade = '".$_POST['cidade']."'";
      $codigo = $banco->consultaCidade($sql);
      if(empty($codigo)){
         echo ("Cidade Inválida");
      }else{
         $dados = auxBrasilPessoa($codigo['codigoCidade'],$_POST['mes']);
         $totalPessoas = count($dados);
         $valorTotal = somarValorSaque($dados);
         $valorMedio = $valorTotal / $totalPessoas;
         $datasSaques = datasSaques($dados);

         
         $dataArray = array_keys($datasSaques);
         $quantArray = [];
         foreach ($datasSaques as $x){
            array_push($quantArray, $x);
         }
         $data = implode("', '", $dataArray);
         $quant = implode(",", $quantArray);

         var_dump($dataArray);
         echo "<br>"         ;
         var_dump($data);
         echo "<br>"   ;
         echo ("'$data'");
         echo "<br>"    ;
         var_dump($quant);
         

         /*var_dump($quantArray);
         echo ("<br>");
         var_dump($dataArray);
         echo ("<br>");
         var_dump($datasSaques);*/

         ?> 
         <script>
            var grafico = document.getElementById("grafico")
            
            var options = {
               chart: {
                  type: 'pie',
                  width: 700,
                  height: 500
               },
               series: [
                  <?php echo($quant); ?>
               ],
               labels: [
                  <?php echo ("'$data'");?>
               ]
            }

            var chart = new ApexCharts(grafico, options);
            chart.render();

         </script>
         <?php

         
         
      }
      
     
   }
   ?>


   
</body>
</html>
    
