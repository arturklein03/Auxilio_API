<?php
    
      function auxBrasilPessoa($cidade, $data){
          //$cidade = 4313201;
          //$data = 202202;
          $pagina = 1;
          $dadosTotal = array();

          $url = "https://api.portaldatransparencia.gov.br/api-de-dados/auxilio-brasil-sacado-beneficiario-por-municipio?codigoIbge=".$cidade."&mesAno=".$data."&pagina=".$pagina."";

          $client = curl_init($url);
  
  
          $headers = ['chave-api-dados: fe4a6726ada17f84786df9f75437f1ae'];
      
      
          curl_setopt($client, CURLOPT_HTTPHEADER, $headers);
      
          curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
      
          $response = curl_exec($client);

          if (stristr($response, 'erro') == TRUE){
            return 'Limite da API atingido, espere um minuto';
          }
    
          $dadosUmaPagina = json_decode($response, true);

          curl_close($client);
          
          if (empty($dadosUmaPagina)){
              return false;
          }else {
            $dadosTotal = array_merge($dadosTotal, $dadosUmaPagina);
            $pagina = $pagina + 1;
            
            while (!empty($dadosUmaPagina)){
              $url = "https://api.portaldatransparencia.gov.br/api-de-dados/auxilio-brasil-sacado-beneficiario-por-municipio?codigoIbge=".$cidade."&mesAno=".$data."&pagina=".$pagina."";
              $client = curl_init($url);
              $headers = ['chave-api-dados: fe4a6726ada17f84786df9f75437f1ae'];
              curl_setopt($client, CURLOPT_HTTPHEADER, $headers);
              curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
              $response = curl_exec($client);
              $dadosUmaPagina = json_decode($response, true);

              $dadosTotal = array_merge($dadosTotal, $dadosUmaPagina);
              $pagina = $pagina + 1;
              
             
            }
            
            return $dadosTotal;
          }

      }


      function somarValorSaque($dados){
        $total = 0;
        foreach ($dados as $dado) {
          $total += $dado['valorSaque'];
        }
        return $total;
      }

      function datasSaques($dados){
        $datas = array();
        foreach ($dados as $dado) {
          if (in_array($dado['dataSaque'], array_keys($datas))){
            $datas[$dado['dataSaque']] += 1;
          }else {
            $datas[$dado['dataSaque']] = 1;
          }
        }
        return $datas;
        
      } 

?>