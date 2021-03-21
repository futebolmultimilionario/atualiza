<?php

$dados = $_POST;

  ob_start();
	var_dump($dados);
	$input = ob_get_contents();
	ob_end_clean();
	file_put_contents("input.log",$input.PHP_EOL,FILE_APPEND);

 function cadastraProduto($produto){
  $codigoProduto = $produto['codigo'];
  $nomeProduto = $produto['nome'];
  $chaveProduto = $produto['chave']; // Exibe a categoria do produto

  $db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");
  $selecionarproduto = "SELECT * FROM produto WHERE codigo='$codigoProduto'";
  $buscaproduto = pg_query($db_handle, $selecionarproduto);

if(is_array(pg_fetch_assoc($buscaproduto)) == false){
    $query = "INSERT INTO produto (codigo, chave, nome) VALUES ('$codigoProduto', '$chaveProduto', '$nomeProduto')";
    $result = pg_query($db_handle, $query);				
} else {
    $query = "UPDATE produto SET codigo='$codigoProduto', chave='$chaveProduto', nome='$nomeProduto' WHERE codigo='$codigoProduto'";
    $result = pg_query($db_handle, $query);	
}
}

function cadastraAssinatura($assinatura){
  $codAssinatura    = $assinatura['codigo']; // código da assinatura na Monetizze
  $statusAssinatura = $assinatura['status'];
  $dataAssinatura   = $assinatura['data_assinatura']; // Data da Assinatura. Formato: yyyy-mm-dd H:i:s
  $parcelaAssinatura   = $assinatura['parcela']; // Parcela da cobrança

  $db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");
  $selecionarassinatura = "SELECT * FROM assinatura WHERE codigo='$codAssinatura'";
  $buscaassinatura = pg_query($db_handle, $selecionarassinatura);

if(is_array(pg_fetch_assoc($buscaassinatura)) == false){
    $query = "INSERT INTO assinatura (codigo, status, data, parcela) VALUES ('$codAssinatura', '$statusAssinatura', '$dataAssinatura', '$parcelaAssinatura')";
    $result = pg_query($db_handle, $query);				
} else {
    $query = "UPDATE assinatura SET codigo='$codAssinatura', status='$statusAssinatura', data='$dataAssinatura', parcela='$parcelaAssinatura' WHERE codigo='$codAssinatura'";
    $result = pg_query($db_handle, $query);	
}
}

function cadastraComprador($comprador){
  $nome             = $comprador['nome'];
  $email            = $comprador['email'];
  $cnpj_cpf         = $comprador['cnpj_cpf']; //Numero inteiro (sem pontos)
  $telefone         = $comprador['telefone'];
  $pais             = $comprador['pais'];
  $db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");
  $selecionarcomprador = "SELECT * FROM comprador WHERE documento='$cnpj_cpf'";
  $buscacomprador = pg_query($db_handle, $selecionarcomprador);
  print_r($buscacomprador);
if(is_array(pg_fetch_assoc($buscacomprador)) == false){
    $query = "INSERT INTO comprador (nome, email, documento, telefone, pais) VALUES ('$nome', '$email', '$cnpj_cpf', '$telefone', '$pais')";
    $result = pg_query($db_handle, $query);		
} else {
    $query = "UPDATE comprador SET nome='$nome', email='$email', documento='$cnpj_cpf', telefone='$telefone', pais='$pais' WHERE documento='$cnpj_cpf'";
    $result = pg_query($db_handle, $query);
}
}

function cadastraAfiliado($comissao){
  $refAfiliado      = $comissao['refAfiliado']; // Referencia do afiliado ao produto, se for uma comissao de afiliado, se nao for envia NULL (vazio)
  $nomeComissionado = $comissao['nome']; // do afiliado ou produto que recebeu essa comissão
  $tipoComissao     = $comissao['tipo_comissao']; // tipo da comissão (Sistema, Produtor, Co-Produtor, Primeiro Clique, Clique intermediário, Último Clique, Lead, Premium, Gerente)
  $valorComissao    = $comissao['valor']; // Valor que esse comissionado recebeu
  $porcComissao     = $comissao['porcentagem']; // Porcentagem do valor todal da venda que ele recebeu
  $EmailComissao    = $comissao['email']; // E-mail do afiliado/coprodutor/gerente

  $db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");
  $selecionarafiliado = "SELECT * FROM afiliado WHERE referencia='$refAfiliado'";
  $buscaafiliado = pg_query($db_handle, $selecionarafiliado);

if(is_array(pg_fetch_assoc($buscaafiliado)) == false){
    $query = "INSERT INTO afiliado (referencia, nome, tipocomissao, valorcomissao, porccomissao, email) VALUES ('$refAfiliado', '$nomeComissionado', '$tipoComissao', '$valorComissao', '$porcComissao', '$EmailComissao')";
    $result = pg_query($db_handle, $query);				
} else {
    $query = "UPDATE afiliado SET referencia='$refAfiliado', nome='$nomeComissionado', tipocomissao='$tipoComissao', valorcomissao='$valorComissao', porccomissao='$porcComissao', email='$EmailComissao' WHERE referencia='$refAfiliado'";
    $result = pg_query($db_handle, $query);	
}
}

function cadastraPlano($plano){
  $plano_codigo        = $plano['codigo']; // codigo do plano
  $plano_referencia    = $plano['referencia']; // referencia do plano
  $plano_nome          = $plano['nome']; // nome do plano
  $plano_quantidade    = $plano['quantidade']; // quantidade de produtos que sao entregues com esse plano, normalmente usado em produtos físicos
  $plano_periodicidade = $plano['periodicidade']; // Semanal, Mensal, Bimestral, Trimestral, Semestral, Anual- OBS:

  $db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");
  $selecionarplano = "SELECT * FROM plano WHERE codigo='$plano_codigo'";
  $buscaplano = pg_query($db_handle, $selecionarplano);

if(is_array(pg_fetch_assoc($buscaplano)) == false){
    $query = "INSERT INTO plano (codigo, referencia, nome, quantidade, periodicidade) VALUES ('$plano_codigo', '$plano_referencia', '$plano_nome', '$plano_quantidade', '$plano_periodicidade')";
    $result = pg_query($db_handle, $query);				
} else {
    $query = "UPDATE plano SET codigo='$plano_codigo', referencia='$plano_referencia', nome='$plano_nome', quantidade='$plano_quantidade', periodicidade='$plano_periodicidade' WHERE codigo='$plano_codigo'";
    $result = pg_query($db_handle, $query);	
}
}

  $chaveUnica = $dados['chave_unica'];
  if($chaveUnica  != '93010a79ca331778fd62c7f6dc4b81c4') {
    exit;
  }

  $chave = $dados['produto']['chave'];
  if($chave  != 'ca56a7386016ce8a9a68d6313d08b190') {
    exit;
  }

  $codigoProduto = $dados['produto']['codigo'];
  
  cadastraProduto($dados['produto']);
  
  
    // Tipo Postback
  $codTipoPostback = $dados['tipoPostback']['codigo']; // 1=Sistema, 2=Produtor, 3=Co-Produtor, 4=Afiliado, 5=Afiliado Premium, 6=Gerente de Afiliado, 7=Co-Afiliado 
  $descTipoPostback = $dados['tipoPostback']['descricao']; //Sistema,Produtor, Co-Produtor, Afiliado, Afiliado Premium, Gerente de Afiliado, Co-Afiliado

  //$codigoTipoEvento = $dados['tipoEvento']['codigo']; // 1=AGUARDANDO_PAGAMENTO, 2=FINALIZADA_APROVADA, 3=CANCELADA, 4=DEVOLVIDA, 5=BLOQUEADA, 6=COMPLETA, 7=ABANDONO_DE_CHECKOUT, 8=OCULTO, 98=CARTAO, 99=BOLETO, 101=ASSINATURA_ATIVA, 102=ASSINATURA_INADIMPLENTE, 103=ASSINATURA_CANCELADA, 104=ASSINATURA_AGUARDANDO_PAGAMENTO
  //$descricaoTipoEvento = $dados['tipoEvento']['descricao']; // 1='Aguardando pagamento', 2='Finalizada / Aprovada', 3='Cancelada', 4='Devolvida (Reembolso)', 5='Bloqueada', 6='Completa', 7='Abandono de Checkout', 8='Oculto', 98='Cartão', 99='Boleto', 101='Assinatura - Ativa', 102='Assinatura - Inadimplente', 103='Assinatura - Cancelada', 104='Assinatura - Aguardando pagamento'

$codVenda         = $dados['venda']['codigo']; // Código da transação

$codPlano         = $dados['venda']['plano']; // código do plano do produto (da edição do produto aba planos)

$codCupom         = $dados['venda']['cupom']; // código do cupom usado na venda

$dataInicio       = strtotime($dados['venda']['dataInicio']); // Data que iniciou a compra. Formato: yyyy-mm-dd H:i:s
$dataFinalizada   = strtotime($dados['venda']['dataFinalizada']); // Data em que foi confirmado o pagamento. Formato: yyyy-mm-dd H:i:s
if($dataFinalizada<1){
  $dataFinalizada = 0;
}
print_r(strtotime($dataFinalizada));
$meioPagamento    = $dados['venda']['meioPagamento']; // Meio de pagamento utilizado - (PagSeguro, MoIP, Monetize)
$formaPagamento   = $dados['venda']['formaPagamento']; // Forma de pagamento utilizado - (Cartão de crédito,  Débito online, Boleto, Gratis, Outra)
$garantiaRestante = $dados['venda']['garantiaRestante']; //Tempo de garantia em inteito ex: 0 - Padrão: 0
$fimGarantia      = date('Y-m-d H:i:s', strtotime($dataFinalizada . ' +7 days'));
$quantidadeParcelas= $dados['venda']['parcelas']; // Quantidade de parcelas da venda - Padrão 1
$statusVenda      = $dados['venda']['status']; // Status da venda (Aguardando pagamento, Finalizada, Cancelada, Devolvida, Bloqueada, Completa)

$valorVenda       = $dados['venda']['valor']; //valor total pago ex: 1457.00

$quantidade       = $dados['venda']['quantidade']; //quantidade de produtos comprados nessa venda
$valorRecebido    = $dados['venda']['valorRecebido'] ; //valor total que você recebeu por essa venda ex: 1367.00
$tipo_frete       = $dados['venda']['tipo_frete'] ; //Tipo do frete ( 4014 = SEDEX, 4510 = PAC, 999999 = Valor Fixo) Qualquer valor q for enviado diferente desses, refere-se ao código da Intelipost.
$descr_tipo_frete = $dados['venda']['descr_tipo_frete'] ; //Descricao do frete (Ex: Correios SEDEX, Corretios PAC, Total Express)
$frete            = $dados['venda']['frete'] ; // Valor pago pelo frete

$onebuyclick      = $dados['venda']['onebuyclick'] ; // se a essa venda foi feita com 1 click (Upsell)
$venda_upsell     = $dados['venda']['venda_upsell'] ; // Caso essa venda tenha se originado de um upsell, nesse campo vai o cód da venda principal, que originou essa venda.

$src              = $dados['venda']['src']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação
$utm_source       = $dados['venda']['utm_source']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação
$utm_medium       = $dados['venda']['utm_medium']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação
$utm_content      = $dados['venda']['utm_content']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação
$utm_campaign     = $dados['venda']['utm_campaign']; //Valor do SRC que foi enviado via parâmetro da URL de divulgação

$url_recuperacao = $dados['url_recuperacao']; // URL de recuperacao de venda, link direto para o checkout que o cliente acessou ja preenchendo os dados cadastrais do comprador.

if(array_key_exists('plano', $dados)){
cadastraPlano($dados['plano']);
$plano_codigo        = $dados['plano']['codigo'];
}

$linkBoleto       = $dados['venda']['linkBoleto'];
$linhaDigitavel   = $dados['venda']['linha_digitavel'];
  
if(array_key_exists('assinatura', $dados)){
    cadastraAssinatura($dados['assinatura']);
    $codAssinatura    = $dados['assinatura']['codigo'];
} else {
    $codAssinatura    = '';
}


$refAfiliado      = '';
foreach ($dados['comissoes'] as $comissao) {
    if($comissao['refAfiliado'] != null){
        cadastraAfiliado($comissao);
        $refAfiliado      = $comissao['refAfiliado'];
        break;
    }
}


$cnpj_cpf         = $dados['comprador']['cnpj_cpf'];
cadastraComprador($dados['comprador']);



  $cnpj_cpf_produtor = $dados['produtor']['cnpj_cpf']; //Numero inteiro (sem pontos)
  $nome_produtor     = $dados['produtor']['nome'];
  $email_produtor     = $dados['produtor']['email'];

  //$json = $dados['json']; // Contem todo o conteúdo do postback em formato json

  $db_handle = pg_connect("host=ec2-54-164-241-193.compute-1.amazonaws.com dbname=detfg6vttnaua8 port=5432 user=kgsgrroozfzpnv password=a2ec0dd00478fd02c6395df74d3e82adc94632e51ea2c1cca2ba94f988e591f5");
  $selecionarvenda = "SELECT * FROM vendas WHERE codigo='$codVenda'";
  $buscavenda = pg_query($db_handle, $selecionarvenda);
if(is_array(pg_fetch_assoc($buscavenda)) == false){
    $query = "INSERT INTO vendas (codigo, plano, datainicio, datafinalizada, meiopagamento, formapagamento, fimdagarantia, status, valor, quantidade, valorecebido, doccomprador, refafiliado, codigoassinatura, linkboleto, linhaboleto, urlrecuperacao, codigoproduto) VALUES ('$codVenda', '$codPlano', '$dataInicio', '$dataFinalizada', '$meioPagamento', '$formaPagamento', '$fimGarantia', '$statusVenda', '$valorVenda', '$quantidade', '$valorRecebido', '$cnpj_cpf', '$refAfiliado', '$codAssinatura', '$linkBoleto', '$linhaDigitavel', '$url_recuperacao', '$codigoProduto')";
	$result = pg_query($db_handle, $query);				
} else {
    $query = "UPDATE vendas SET codigo='$codVenda', plano='$codPlano', datainicio='$dataInicio', datafinalizada='$dataFinalizada', meiopagamento='$meioPagamento', formapagamento='$formaPagamento', fimdagarantia='$fimGarantia', status='$statusVenda', valor='$valorVenda', quantidade='$quantidade', valorecebido='$valorRecebido', doccomprador='$cnpj_cpf', refafiliado='$refAfiliado', codigoassinatura='$codAssinatura', linkboleto='$linkBoleto', linhaboleto='$linhaDigitavel', urlrecuperacao='$url_recuperacao' , codigoproduto='$codigoProduto' WHERE codigo='$codVenda'";
	$result = pg_query($db_handle, $query);	
}

?>
