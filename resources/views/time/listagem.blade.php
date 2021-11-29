@extends("layout")

@section('titulo')
    Times 
@stop

@section('conteudo')
    <h5>Times</h5>
    <hr>

    <button onclick="formulario()">Cadastrar</button>

    <div class="modal">
    </div>

    <table class="table">

    </table>

    <script>

        function carregarTimes() {
            oTable = document.querySelector('.table');
            aCabecalho = ['Código', 'Nome', 'Alterar', 'Remover'];
            const oTr = document.createElement('tr');

            aCabecalho.forEach(element => {
                oColuna = document.createElement('td');
                oColuna.style.fontWeight ='bold';
                oColuna.innerHTML = element;

                oTr.appendChild(oColuna);

                oTable.appendChild(oTr);
            });

            $.ajax({
                url: '/api/time',
                type: 'GET',
                success: function(result) {
                    if(result) {
                        result.forEach(element => {
                            const oTr = document.createElement('tr');

                            aHref = document.createElement('a');
                        
                            aHref.setAttribute('onclick', 'visualizarTime('+element.id+',"'+element.nome+'")');

                            oCodigo = document.createElement('td');
                            oCodigo.appendChild(aHref);
         
                            aHref.innerHTML = element.id;

                            oTr.appendChild(oCodigo);

                            oNome = document.createElement('td');
                            oNome.innerHTML = element.nome;

                            oTr.appendChild(oNome);

                            oAltera = document.createElement('td');
                            oImgAlt = document.createElement('img');oImgAlt.setAttribute('width', '45px');
                            oImgAlt.setAttribute('height', '40px');
                            oImgAlt.style.cursor = 'pointer';
                            oImgAlt.setAttribute('onclick', 'formAlteraTime('+element.id+',"'+element.nome+'")');

                            oRemove = document.createElement('td');
                            oImgDel = document.createElement('img'); oImgDel.setAttribute('width', '45px');
                            oImgDel.setAttribute('height', '40px');
                            oImgDel.style.cursor = 'pointer'
                            oImgDel.setAttribute('onclick', 'deletaTime('+element.id+')');
                 

                            oAltera.appendChild(oImgAlt);
                            oRemove.appendChild(oImgDel);

                            oTr.appendChild(oAltera);
                            oTr.appendChild(oRemove);
                
                            oTable.appendChild(oTr); 
                        });
                      
                    };
                }
            });
        }

        function formAlteraTime(id, nome) {
            formulario(id, nome);
        }

        function visualizarTime(id, nome) {
            formulario(id, nome, true);
        }

        function alterarTime(codigo) {
            debugger;
            $.ajax({
                url: '/api/time/update/'+codigo,
                type: 'PUT',
                data: {id: codigo, nome: document.getElementById('nome').value},
                success: function(result) {
                    alert('time removido');
                    carregarTimes();
                }
                
            });

            return false;
        }

        function deletaTime(id) {
            //mudar para remover a linha apenas.
            $.ajax({
                url: '/api/time/delete/'+id,
                type: 'DELETE',
                success: function(result) {
                    alert('time removido');
                    oConsulta = document.querySelector('.table');

                    while (oConsulta.firstChild) {
                        oConsulta.removeChild(oConsulta.lastChild);
                    }

                    carregarTimes();
                }
            });

            return false;
        }

        function formulario(id, nome, bVisualizacao = false) {
            let bAltera = id ? true : false;

            oModal = document.querySelector('.modal');

            while (oModal.firstChild) {
                oModal.removeChild(oModal.lastChild);
            }

            oModal.style.display = 'block';

            oDivFechar = document.createElement('div');
            oDivFechar.setAttribute('class', 'fechar');
            oDivFechar.setAttribute('onclick', 'fechar()');
            oDivFechar.innerHTML = 'X';
            oModal.appendChild(oDivFechar);
            
            oForm = document.createElement('form');

            oForm.setAttribute('onsubmit', bAltera ? 'alterarTime('+id+')' : 'cadastrarTime()');

            oH1 = document.createElement('h1');

            if(!bVisualizacao) {
                oH1.innerHTML = bAltera ? 'alteração do time: '+ nome : 'cadastro de Times';
            } else {
                oH1.innerHTML = 'Detalhamento do Time'
            }

            oH1.style.textAlign = 'center';
            
            if(bVisualizacao) {
                oLabelCodigo = document.createElement('label');
                oLabelCodigo.setAttribute('for', 'codigo');
                oLabelCodigo.innerHTML = 'Código:';

                oInputCod = document.createElement('input');
                oInputCod.setAttribute('type', 'text');
                oInputCod.setAttribute('name', 'codigo');
                oInputCod.setAttribute('id', 'codigo');
                oInputCod.setAttribute('disabled', true);
            }


            oLabel = document.createElement('label');
            oLabel.setAttribute('for', 'nome');
            oLabel.innerHTML = 'Nome:';

            oInput = document.createElement('input');
            oInput.setAttribute('type', 'text');
            oInput.setAttribute('name', 'nome');
            oInput.setAttribute('id', 'nome');

            if (bAltera) {
                oInput.value = nome;
                oInputCod.value = id;
            } 
            
            if (bVisualizacao) {
                oInput.setAttribute('disabled', true);
            }

            if (!bVisualizacao) {
                oSubmit = document.createElement('input');
                oSubmit.setAttribute('type', 'submit');
                oSubmit.setAttribute('value', bAltera ? 'Alterar': 'Cadastrar');
                oSubmit.style.marginTop = '50px';
                oSubmit.style.marginLeft = '40%';
            }

            oForm.appendChild(oH1);

            if(bVisualizacao) {
                oForm.appendChild(oLabelCodigo);
                oForm.appendChild(oInputCod);
                oForm.appendChild(document.createElement('br'));
            }

            oForm.appendChild(oLabel);
            oForm.appendChild(oInput);
            oForm.appendChild(document.createElement('br'));

            if (!bVisualizacao) {
                oForm.appendChild(oSubmit);
            }

            oModal.appendChild(oForm);
        }

        function fechar() {
            let modal = document.querySelector('.modal');
            modal.style.display = 'none';
        }

        function cadastrarTime() {
            $.ajax({
                url: '/api/time',
                type: 'POST',
                data: {nome: document.getElementById('nome').value},
                success: function(result) {
                    alert('time cadastrado');
                }
            });

            return true;
        }

        $(function() {
            carregarTimes();
        });
        
    </script>

@stop      
