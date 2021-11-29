@extends("layout")

@section('titulo')
    Campeonatos 
@stop

@section('conteudo')
    <h5>Jogos</h5>
    <hr>

    <button onclick="formulario()">Cadastrar</button>

    <div class="modal">
    </div>

    <table class="table">

    </table>

    <script>

        function carregarCampeonatos() {
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
                url: '/api/campeonato',
                type: 'GET',
                success: function(result) {
                    if(result) {
                        result.forEach(element => {
                            const oTr = document.createElement('tr');

                            aHref = document.createElement('a');
                            aHref.setAttribute('href', 'campeonato/detalhe/'+element.id);

                            oCodigo = document.createElement('td');
                            oCodigo.appendChild(aHref);
         
                            aHref.innerHTML = element.id;

                            oTr.appendChild(oCodigo);

                            oNome = document.createElement('td');
                            oNome.innerHTML = element.nome;

                            oTr.appendChild(oNome);

                            oAltera = document.createElement('td');
                            oImgAlt = document.createElement('img'); oImgAlt.setAttribute('width', '45px');
                            oImgAlt.setAttribute('height', '40px');
                            oImgAlt.style.cursor = 'pointer';
                            oImgAlt.setAttribute('onclick', 'formAlteraCampeonato('+element.id+',"'+element.nome+'")');

                            oRemove = document.createElement('td');
                            oImgDel = document.createElement('img');   oImgDel.setAttribute('width', '45px');
                            oImgDel.setAttribute('height', '40px');
                            oImgDel.style.cursor = 'pointer'
                            oImgDel.setAttribute('onclick', 'deletaCampeonato('+element.id+')');
                 

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

        function formAlteraCampeonato(id, nome) {
            formulario(id, nome);
        }

        function alterarCampeonato(codigo) {
            debugger;
            $.ajax({
                url: '/api/campeonato/update/'+codigo,
                type: 'PUT',
                data: {id: codigo, nome: document.getElementById('nome').value},
                success: function(result) {
                    alert('jogo removido');
                    carregarCampeonatos();
                }
                
            });

            return false;
        }

        function deletaCampeonato(id) {
            //mudar para remover a linha apenas.
            $.ajax({
                url: '/api/campeonato/delete/'+id,
                type: 'DELETE',
                success: function(result) {
                    alert('jogo removido');

                    oConsulta = document.querySelector('.table');

                    while (oConsulta.firstChild) {
                        oConsulta.removeChild(oConsulta.lastChild);
                    }

                    carregarCampeonatos();
                }
            });

            return false;
        }

        function formulario(id, nome) {
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
            
            oH1 = document.createElement('h1');
            oForm = document.createElement('form');
            oForm.setAttribute('onsubmit', bAltera ? 'alterarCampeonato('+id+')' : 'cadastrarCampeonato()');

            oH1.innerHTML = bAltera ? 'alteração do jogo: '+ nome : 'cadastro de jogos';
            oH1.style.textAlign = 'center';

            oLabel = document.createElement('label');
            oLabel.setAttribute('for', 'nome');
            oLabel.innerHTML = 'Nome:';

            oInput = document.createElement('input');
            oInput.setAttribute('type', 'text');
            oInput.setAttribute('name', 'nome');
            oInput.setAttribute('id', 'nome');

            if (bAltera) {
                oInput.value = nome;
            }

            oQuebra = document.createElement('br');

            oSubmit = document.createElement('input');
            oSubmit.setAttribute('type', 'submit');
            oSubmit.setAttribute('value', bAltera ? 'Alterar': 'Cadastrar');
            oSubmit.style.marginTop = '50px';
            oSubmit.style.marginLeft = '40%';

            oForm.appendChild(oH1);
            oForm.appendChild(oLabel);
            oForm.appendChild(oInput);
            oForm.appendChild(oQuebra);
            oForm.appendChild(oSubmit);

            oModal.appendChild(oForm);
        }

        function fechar() {
            let modal = document.querySelector('.modal');
            modal.style.display = 'none';
        }

        function cadastrarCampeonato() {
            $.ajax({
                url: '/api/campeonato',
                type: 'POST',
                data: {nome: document.getElementById('nome').value},
                success: function(result) {
                    alert('jogo cadastrado');
                }
            });

            return true;
        }

        $(function() {
            carregarCampeonatos();
        });
        
    </script>

@stop      
