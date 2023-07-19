<?php

	namespace crud\clientes;
	
	require ('../../lib/ado.class.php');

	class clientes extends \ db2_dao{
		
		public function clientes($params){	
        $cgc = $params['cgc'];		
		$sql = "
		select
		cf.cnpjcpf as cgc
	   , cf.nome as nome
	   , case when LENGTH(cf.email) > 40 then left( cf.email,instr(cf.email,';')) when LENGTH(cf.emailfinanceiro) > 40 then left( cf.email,instr(cf.emailfinanceiro,';'))
	     else (case when cf.email = '' then cf.emailfinanceiro when cf.emailfinanceiro  = '' then cf.email when cf.email != '' then cf.email when cf.emailfinanceiro != ''
		 then cf.emailfinanceiro  end) end email
	   , coalesce(cf.nomecontato1, cf.fone1) telefone
	   , cf.idcep cep
	   , cf.endereco
	   , cf.bairro
	   , ci.descrcidade cidade
	   , ci.uf
	   , cf.idclifor
	   from dba.CLIENTE_FORNECEDOR cf
	   inner join dba.cidades_ibge ci
	   on cf.idcidade = ci.idcidade
	   where cf.cnpjcpf  = '".$cgc."' or cf.idclifor = '".$cgc."' 
	   and flaginativo = 'F'
	   group by cf.cnpjcpf, cf.idclifor, cf.nome,cf.email,cf.nomecontato1,cf.idcep,cf.endereco,cf.bairro,ci.descrcidade,ci.uf,cf.fone1,cf.emailfinanceiro
        ";
		
			$clientes = $this->execSelect($sql);
			
			if( $clientes === false){
				throw new \Exception($this->getErroMsg());
			}
			return $clientes;
		}
	}

?>



