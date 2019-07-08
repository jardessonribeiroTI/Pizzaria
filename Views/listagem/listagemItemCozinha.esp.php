<?php 

	require_once "../../classes/conexao.class.php";

	$c = new conectar();

    $conexao = $c->conexao();

    $nome = $_POST['busca_nome_item'];
    
    $sql =  "SELECT ite.cod_itenscozinha, fornec.nome_fornecedor, ite.nome_item, ite.quantidade, ite.validade, ite.valor_item, ite.descricao_item, ite.categoria FROM tab_itenscozinha ite JOIN tab_fornecedor fornec ON ite.cod_fornecedor = fornec.cod_fornecedor WHERE ite.nome_item LIKE '%$nome%'";

    $result = mysqli_query($conexao, $sql);


?>
<!DOCTYPE html>
<html>
<head>
	<title>Lista de Pedidos</title>
	<?php require_once "../dependencias.php" ?>
	<link rel="stylesheet" type="text/css" href="../../css/listagem_geral.css">
	<link rel="stylesheet" type="text/css" href="../../lib/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../css/estilo_btn_voltar.css">

	<script src="../../lib/jquery-3.2.1.min.js"></script>
	<script src="../../lib/bootstrap/js/bootstrap.js"></script>	

</head>
<body>
	<div class="principal">
		<div id="voltar_pesquisa">
			<span id="btnVoltar"><a href="../TelaListagemItensCozinha.php">Voltar</a></span>
		</div>
		<h2>Listagem de Produto Especifica</h2>
				<div id="mostrapedidos">
					<table border="1" class="" id="tabeladepedidos">
						<tr id="topo_tabela">
							<td>Código</td>
							<td>Fornecedor</td>
							<td>Nome</td>
							<td>Qnt em Estoque</td>
							<td>Validade</td>
							<td>Valor Pago</td>
							<td>Descricao</td>
							<td>Categoria</td>
							<td>Editar</td>
						</tr>

						<?php while($mostrar = mysqli_fetch_row($result)): ?>

						<tr id="corpo_tabela">
							<td><?php echo $mostrar[0]; ?></td>
							<td><?php echo $mostrar[1]; ?></td>
							<td><?php echo $mostrar[2]; ?></td>
							<td><?php echo $mostrar[3]; ?></td>
							<td><?php echo $mostrar[4]; ?></td>
							<td><?php echo $mostrar[5]; ?></td>
							<td><?php echo $mostrar[6]; ?></td>
							<td><?php echo $mostrar[7]; ?></td>
							<td>
								<span  data-toggle="modal" data-target="#abremodalUpdateItemEsp" class="btn btn-primary btn-xs" onclick="atualizarCliente('<?php echo $mostrar[6] ?>')">
									<span class="glyphicon glyphicon-pencil"></span>
								</span>
							</td>
						</tr>

			<?php endWhile; ?>
					</table>
					
				</div>
			<div class="modal fade" id="abremodalUpdateItemEsp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-xm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Atualizar Produto</h4>
					</div>
					<div class="modal-body">
					<form id="frmAtualizarProdutoVendaModal" enctype="multipart/form-data">
						<input type="text" hidden="" id="cod_produtoU" name="cod_produtoU">
						<label>Nome</label>
						<input type="text" class="form-control input-sm" id="nome_produtoU" name="nome_produtoU">
						<label>Valor do Produto</label>
						<input type="text" class="form-control input-sm" id="valor_produtoU" name="valor_produtoU">
						<label>Qnt Atual Estoque</label>
						<input type="text" class="form-control input-sm" id="quantidade_produtoU" name="quantidade_produtoU">
						<label>Descrição</label>
						<textarea class="form-control input-sm" id="descricao_produtoU" name="descricao_produtoU"></textarea>
					</form>
					</div>
					<div class="modal-footer">
						<button id="btnAtualizarProdutoModal" type="button" class="btn btn-warning" data-dismiss="modal">Atualizar</button>
					</div>
				</div>
			</div>
		</div>
					
				</div>
				
			</fieldset>
		</div>
	</div>

</body>
</html>
<script type="text/javascript">
		function obterDadosProdutoEsp(idproduto){
			$.ajax({
				type:"POST",
				data:"idproduto=" + idproduto,
				url:"../../procedimentos/produtos/obterDadosProdutoVenda.php",
				success:function(r){
					
					dado=jQuery.parseJSON(r);

					$('#cod_produtoU').val('cod_produtovenda');
					$('#nome_produtoU').val(dado['nome_produto']);
					$('#valor_produtoU').val(dado['valor_produto']);
					$('#quantidade_produtoU').val(dado['qnt_produto']);
					$('#descricao_produtoU').val(dado['descricao_produto']);
					
				}
			});
		}
		$(document).ready(function(){
			$('#btnAtualizarProdutoModal').click(function(){
				dados=$('#frmAtualizarProdutoVendaModal').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../../procedimentos/produtos/atualizarProdutoModal.php",
					success:function(r){

						if(r==1){
							alertify.success("Cliente atualizado com sucesso!");
							window.location.reload();
						}else{
							alertify.error("Não foi possível atualizar cliente");
						}
					}
				});
			})
		})
</script>