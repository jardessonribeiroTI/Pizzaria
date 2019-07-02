<?php 

	require_once "../classes/conexao.class.php";

	$c = new conectar();

    $conexao = $c->conexao();

    $atual = date('d/m/Y');
    
    $sql =  "SELECT nome_cliente, cpf_cliente, bairro_cliente, rua_cliente, numero, telefone, cod_cliente FROM tab_cliente";

    $result = mysqli_query($conexao, $sql);


?>
<!DOCTYPE html>
<html>
<head>
	<title>Lista de Clientes</title>
	<?php require_once "TelaMenu.php" ?>
	<link rel="stylesheet" type="text/css" href="../css/listagem_geral.css">
	<link rel="stylesheet" type="text/css" href="../css/estiloModal.css">
	<link rel="stylesheet" type="text/css" href="../../lib/bootstrap/css/bootstrap.css">
</head>
<body>
	<div class="principal">
		<div id="cabecalho_pesquisa">
		<h2>Listagem de Clientes</h2>
				<div id="pesquisa">
					<form id="frmpesquisa" action="listagem/listagemCliente.esp.php" method="POST">
						<span id="de">Nome</span>
						<input type="text" class="form-control" id="busca_nome_cliente" name="busca_nome_cliente" placeholder="Digite nome" required></input>
						<button type="submit" class="btn btn-primary" id="btnPesquisaData">buscar</button>
						<!--<span class="btn btn-danger" id="btnPesquisaData">Testar</span>-->
					</form>
				</div>
		</div>
				<div id="mostrapedidos">
					<table border="1" class="" id="tabeladepedidos">
						<tr id="topo_tabela">
							<td>Nome Cliente</td>
							<td>CPF Cliente</td>
							<td>Bairro</td>
							<td>Rua</td>
							<td>N° Casa</td>
							<td>Telefone</td>
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
							<td>
								<span  data-toggle="modal" data-target="#abremodalUpdateProduto" class="btn btn-primary btn-xs" onclick="atualizarCliente('<?php echo $mostrar[6] ?>')">
									<span class="glyphicon glyphicon-pencil"></span>
								</span>
							</td>
						</tr>

			<?php endWhile; ?>
					</table>
					
				</div>
		</div>
	</div>
	<div class="modal fade" id="abremodalUpdateProduto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-xm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Atualizar Cliente</h4>
					</div>
					<div class="modal-body">
						<form id="frmAtualizarClienteU" enctype="multipart/form-data">
						<input type="text" hidden="" id="cod_clienteU" name="cod_clienteU">
						<label>Nome</label>
						<input type="text" class="form-control input-sm" id="nome_clienteU" name="nome_clienteU">
						<label>CPF</label>
						<input type="text" class="form-control input-sm" id="cpf_clienteU" name="cpf_clienteU">
						<label>Telefone</label>
						<input type="text" class="form-control input-sm" id="telefone_clienteU" name="telefone_clienteU">
						<label>Nascimento</label>
						<input type="date" class="form-control input-sm" id="nascimento_clienteU" name="nascimento_clienteU" required="true">
						<label>Endereco-Rua</label>
						<input type="text" class="form-control input-sm" id="rua_clienteU" name="rua_clienteU">
						<label>Endereco-Bairro</label>
						<input type="text" class="form-control input-sm" id="bairro_clienteU" name="bairro_clienteU">
						<label>Endereco-N° Casa</label>
						<input type="number" class="form-control input-sm" id="numero_clienteU" name="numero_clienteU">
							
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAtualizarCliente" type="button" class="btn btn-warning" data-dismiss="modal">Atualizar</button>

					</div>
				</div>
			</div>
		</div>

</body>
</html>
<script type="text/javascript">
		function atualizarCliente(idcliente){
			$.ajax({
				type:"POST",
				data:"idcliente=" + idcliente,
				url:"../procedimentos/clientes/atualizarCliente.php",
				success:function(r){
					
					dado=jQuery.parseJSON(r);

					$('#nome_clienteU').val(dado['nome']);
					$('#cpf_clienteU').val(dado['cpf']);
					$('#telefone_clienteU').val(dado['telefone']);
					$('#nascimento_clienteU').val(dado['nascimento']);
					$('#rua_clienteU').val(dado['rua']);
					$('#bairro_clienteU').val(dado['bairro']);
					$('#numero_clienteU').val(dado['numero']);					
					$('#nascimento_clienteU').val(dado['nascimento']);
					$('#cod_clienteU').val(dado['cod_cliente']);
					
				}
			});
		}
		$(document).ready(function(){
			$('#btnAtualizarCliente').click(function(){
				dados=$('#frmAtualizarClienteU').serialize();

				$.ajax({
					type:"POST",
					data:dados,
					url:"../procedimentos/clientes/atualizarClienteModal.php",
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