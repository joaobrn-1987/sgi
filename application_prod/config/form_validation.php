<?php
$config = array('clientes' => array(array(
                                	'field'=>'nomeCliente',
                                	'label'=>'Nome',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'documento',
                                	'label'=>'CPF/CNPJ',
                                	'rules'=>'required|trim|xss_clean'
                                )
								/*array(
                                	'field'=>'telefone',
                                	'label'=>'Telefone',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'email',
                                	'label'=>'Email',
                                	'rules'=>'required|trim|valid_email|xss_clean'
                                ),
								array(
                                	'field'=>'rua',
                                	'label'=>'Rua',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'numero',
                                	'label'=>'Número',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'bairro',
                                	'label'=>'Bairro',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'cidade',
                                	'label'=>'Cidade',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'estado',
                                	'label'=>'Estado',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'cep',
                                	'label'=>'CEP',
                                	'rules'=>'required|trim|xss_clean'
                                )*/)
                ,
                'fornecedores' => array(array(
                    'field'=>'nomeFornecedor',
                    'label'=>'Nome',
                    'rules'=>'required|trim|xss_clean'
                ),
                array(
                    'field'=>'documento',
                    'label'=>'CPF/CNPJ',
                    'rules'=>'required|trim|xss_clean'
                )
               /* array(
                    'field'=>'telefone',
                    'label'=>'Telefone',
                    'rules'=>'required|trim|xss_clean'
                ),
                array(
                    'field'=>'email',
                    'label'=>'Email',
                    'rules'=>'required|trim|valid_email|xss_clean'
                ),
                array(
                    'field'=>'rua',
                    'label'=>'Rua',
                    'rules'=>'required|trim|xss_clean'
                ),
                array(
                    'field'=>'numero',
                    'label'=>'Número',
                    'rules'=>'required|trim|xss_clean'
                ),
                array(
                    'field'=>'bairro',
                    'label'=>'Bairro',
                    'rules'=>'required|trim|xss_clean'
                ),
                array(
                    'field'=>'cidade',
                    'label'=>'Cidade',
                    'rules'=>'required|trim|xss_clean'
                ),
                array(
                    'field'=>'estado',
                    'label'=>'Estado',
                    'rules'=>'required|trim|xss_clean'
                ),
                array(
                    'field'=>'cep',
                    'label'=>'CEP',
                    'rules'=>'required|trim|xss_clean'
                )*/)
,
                'maquinas' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'descricao',
                                    'label'=>'',
                                    'rules'=>'trim|xss_clean'
                                )
                               )
                            ,
							'maquinasusuarios' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'descricao',
                                    'label'=>'',
                                    'rules'=>'trim|xss_clean'
                                )
                               )
                            ,
					'clientes_solicitantes' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                    'field'=>'email_solici',
                                    'label'=>'email',
                                    'rules'=>'trim|xss_clean'
                                ),
                                
                                array(
                                    'field'=>'idClientes',
                                    'label'=>'Cliente',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                            ,		
                            
                'produtos' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                
                                
                                array(
                                    'field'=>'pn',
                                    'label'=>'PN',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'insumos' => array(array(
                                    'field'=>'descricaoInsumo',
                                    'label'=>'Descrição',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                            
                                array(
                                    'field'=>'idSubcategoria',
                                    'label'=>'Subcategoria',
                                    'rules'=>'required|trim|xss_clean'
                                ))
,
                'categoriaInsumos' => array(array(
                                        'field'=>'descricaoCategoria',
                                        'label'=>'Descrição',
                                        'rules'=>'required|trim|xss_clean'
                                    ))
                                        ,
                                        'subcategoriaInsumo' => array(array(
                                            'field'=>'descricaoSubcategoria	',
                                            'label'=>'Descrição',
                                            'rules'=>'required|trim|xss_clean'
                                        ),
                                        
                    
                                        array(
                                            'field'=>'idCategoria',
                                            'label'=>'Categoria',
                                            'rules'=>'required|trim|xss_clean'
                                        ))
    ,
                                             
                                            'subcategoriaInsumo' => array(array(
                                                'field'=>'descricaoSubcategoria	',
                                                'label'=>'Descrição',
                                                'rules'=>'required|trim|xss_clean'
                                            ),
                                            

                                            array(
                                                'field'=>'idCategoria',
                                                'label'=>'Categoria',
                                                'rules'=>'required|trim|xss_clean'
                                            ))
,
'orcamento' => array(array(
                                    'field'=>'idSolicitante',
                                    'label'=>'Solicitante',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'idstatusOrcamento',
                                    'label'=>'Status Orçamento',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'idVendedor',
                                    'label'=>'Vendedor',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
										
                'usuarios' => array(array(
                                    'field'=>'nome',
                                    'label'=>'Nome',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                               
                               
                                array(
                                    'field'=>'senha',
                                    'label'=>'Senha',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'user',
                                    'label'=>'Usuario',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,      
                'os' => array(array(
                                    'field'=>'data_abertura_editada',
                                    'label'=>'data_abertura_editada',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'idStatusOs',
                                    'label'=>'Status OS',
                                    'rules'=>'trim|xss_clean'
                                ),
                                array(
                                    'field'=>'qtd_os',
                                    'label'=>'qtd_os',
                                    'rules'=>'trim|xss_clean'
                                ),
                                array(
                                    'field'=>'unid_execucao',
                                    'label'=>'Unidade Execução',
                                    'rules'=>'trim|xss_clean'
                                ),
                                array(
                                    'field'=>'unid_faturamento',
                                    'label'=>'Unid. Faturamento',
                                    'rules'=>'trim|xss_clean'
                                ),
								array(
                                    'field'=>'data_entrega',
                                    'label'=>'data_entrega',
                                    'rules'=>'trim|xss_clean'
                                ),
								array(
                                    'field'=>'descricao_os',
                                    'label'=>'descricao_os',
                                    'rules'=>'trim|xss_clean'
                                ),
								
                                array(
                                    'field'=>'contrato',
                                    'label'=>'Contrato',
                                    'rules'=>'required|trim|xss_clean'
                                ))

                  ,
				'tiposUsuario' => array(array(
                                	'field'=>'nomeTipo',
                                	'label'=>'NomeTipo',
                                	'rules'=>'required|trim|xss_clean'
                                ),
								array(
                                	'field'=>'situacao',
                                	'label'=>'Situacao',
                                	'rules'=>'required|trim|xss_clean'
                                ))

                ,
                'receita' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'Descrição',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'valor',
                                    'label'=>'Valor',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'vencimento',
                                    'label'=>'Data Vencimento',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                        
                                array(
                                    'field'=>'cliente',
                                    'label'=>'Cliente',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'tipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'despesa' => array(array(
                                    'field'=>'descricao',
                                    'label'=>'Descrição',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'valor',
                                    'label'=>'Valor',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'vencimento',
                                    'label'=>'Data Vencimento',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'fornecedor',
                                    'label'=>'Fornecedor',
                                    'rules'=>'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'tipo',
                                    'label'=>'Tipo',
                                    'rules'=>'required|trim|xss_clean'
                                ))
                ,
                'vendas' => array(array(

                                    'field' => 'dataVenda',
                                    'label' => 'Data da Venda',
                                    'rules' => 'required|trim|xss_clean'
                                ),
                                array(
                                    'field'=>'clientes_id',
                                    'label'=>'clientes',
                                    'rules'=>'trim|xss_clean|required'
                                ),
                                array(
                                    'field'=>'usuarios_id',
                                    'label'=>'usuarios_id',
                                    'rules'=>'trim|xss_clean|required'
                                ))
		);
			   