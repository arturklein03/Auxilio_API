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
<header>
   <div class = 'titulo'>
      <h2>Dados Auxílio Brasil</h1>
   </div>
   <div class = 'barraPesquisa'>
   <a href="info.php">Informações</a>
      <form action="index.php" method="POST">
         <label for="cidade">Cidade: </label>
         <!--<input type="text" value="linha nova" id="cidade" name="cidade">-->
         <select required  name="cidade" id="cidade">
            <option disabled selected value=""></option>
            <option value="4300570">Alto Feliz</option>
            <option value="4301651">Barão</option>
            <option value="4302352">Bom Princípio</option>
            <option value="4302659">Brochier</option>
            <option value="4304689">Capela de Santana</option>
            <option value="4308102">Feliz</option>
            <option value="4309555">Harmonia</option>
            <option value="4311643">Linha Nova</option>
            <option value="4311791">Maratá</option>
            <option value="4312401">Montenegro</option>
            <option value="4314035">Pareci Novo</option>
            <option value="4314803">Portão</option>
            <option value="4316501">Salvador do Sul</option>
            <option value="4318481">São José do Hortêncio</option>
            <option value="4318614">São José do Sul</option>
            <option value="4319356">São Pedro da Serra</option>
            <option value="4319505">São Sebastião do Caí</option>
            <option value="4319752">São Vendelino</option>
            <option value="4322251">Tupandi</option>
            <option value="4322541">Vale Real</option>
         </select>
         <label for="mes">Mês: </label>
         <select required name="mes" id="mes">
            <option disabled selected value=""></option>
            <option value="202111">Novembro 2021</option>
            <option value="202112">Dezembro 2021</option>
            <option value="202201">Janeiro 2022</option>
            <option value="202202">Fevereiro 2022</option>
            <option value="202203">Março 2022</option>
            <option value="202204">Abril 2022</option>
            <option value="202205">Maio 2022</option>
            <option value="202206">Junho 2022</option>
            <option value="202207">Julho 2022</option>
         </select>
         <input type="submit" value="Buscar" name="botao" id="botao">
      </form>
      <a href="https://api.portaldatransparencia.gov.br/swagger-ui.html#/Aux%C3%ADlio_Brasil">API Usada</a>
   </div>
</header>
<body>
<div class = 'resultados'>
      <div class = "dados" id = "dados"></div>
      <div class = "grafico" id = "grafico"></div>
   
      <?php
      
         if (isset($_POST['botao'])){
            require_once "api.php";
            /*require_once "BD.php";
            
            $banco = new MySQL();

            $sql = "SELECT * FROM cidades WHERE nomeCidade = '".$_POST['cidade']."'";
            $codigo = $banco->consultaCidade($sql);*/
            if(isset($_POST['cidade']) && isset($_POST['mes'])){
               $dados = auxBrasilPessoa($_POST['cidade'],$_POST['mes']);
               $totalPessoas = count($dados);
               $valorTotal = number_format((somarValorSaque($dados)), 2,',','.');
               $valorMedio = number_format((somarValorSaque($dados) / $totalPessoas), 2, ",",".");

               $datasSaques = datasSaques($dados);

               /*$datasSaques['outros'] = 0;
               foreach ($datasSaques as $quantPorData) {
                  if ($quantPorData < ($totalPessoas*0.000002)){
                     $datasSaques['outros'] += 1;
                     
                  }
               }*/

               //array_filter($datasSaques);

               $dataArray = array_keys($datasSaques);

               $quantArray = [];
               foreach ($datasSaques as $x){
                  array_push($quantArray, $x);
               }
               $data = implode("', '", $dataArray);
               $quant = implode(",", $quantArray);

            //var_dump($datasSaques);

               /*var_dump($quantArray);
               echo ("<br>");
               var_dump($dataArray);
               echo ("<br>");
               var_dump($datasSaques);*/

               ?> 
               <script>
                  var cidade = document.getElementById("cidade")
                  var mes = document.getElementById("mes")
                  cidade.value = <?php echo($_POST['cidade']); ?>;
                  mes.value = <?php echo($_POST['mes']); ?>

                  var dados = document.getElementById("dados")
                  dados.innerHTML = `<h3>Valor Total: R$ <?php echo($valorTotal);?></h3>
                                    <h3>Total de Pessoas: <?php echo($totalPessoas);?></h3>
                                    <h3>Valor Médio: R$ <?php echo($valorMedio);?></h3>`

                  var grafico = document.getElementById("grafico")
                  grafico.innerHTML = "<h4>DATAS DOS SAQUES NA CIDADE DE <?php echo($dados[0]['municipio']['nomeIBGE']);?></h4>"                                      
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
</div>

   
</body>
</html>
    
