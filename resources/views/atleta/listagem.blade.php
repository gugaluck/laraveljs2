@extends("layout")

@section('titulo')
    Jogadores 
@stop

@section('conteudo')
    <h5>Jogadores</h5>
    <hr>

    <button onclick="formulario()">Cadastrar</button>

    <div class="modal">
    </div>

    <table class="table">

    </table>

    <script>

        function carregarAtletas() {
            oTable = document.querySelector('.table');
            aCabecalho = ['Código', 'Nome', 'Peso', 'Altura','Código Time', 'Time', 'Alterar', 'Remover'];
            const oTr = document.createElement('tr');

            aCabecalho.forEach(element => {
                oColuna = document.createElement('td');
                oColuna.style.fontWeight ='bold';
                oColuna.innerHTML = element;

                oTr.appendChild(oColuna);

                oTable.appendChild(oTr);
            });

            $.ajax({
                url: '/api/atleta',
                type: 'GET',
                success: function(result) {
                    if(result) {
                        result.forEach(element => {
                            const oTr = document.createElement('tr');

                            aHref = document.createElement('a');
                            aHref.setAttribute('href', 'atleta/detalhe/'+element.id);

                            oCodigo = document.createElement('td');
                            oCodigo.appendChild(aHref);
         
                            aHref.innerHTML = element.id;

                            oTr.appendChild(oCodigo);

                            oNome = document.createElement('td');
                            oNome.innerHTML = element.nome;

                            oTr.appendChild(oNome);

                            oPeso = document.createElement('td');
                            oPeso.innerHTML = element.peso;

                            oTr.appendChild(oPeso);

                            oAltura = document.createElement('td');
                            oAltura.innerHTML = element.altura;

                            oTr.appendChild(oAltura);

                            oTimeID = document.createElement('td');
                            oTimeID.innerHTML = element.time_id;

                            oTr.appendChild(oTimeID);

                            oTimeNome = document.createElement('td');
                            oTimeNome.innerHTML = element.time_nome;

                            oTr.appendChild(oTimeNome);

                            oAltera = document.createElement('td');
                            oImgAlt = document.createElement('img');
                            oImgAlt.setAttribute('width', '45px');
                            oImgAlt.setAttribute('height', '40px');
                            oImgAlt.style.cursor = 'pointer';
                            oImgAlt.setAttribute('onclick', 'formAlteraAtleta('+element.id+',"'+element.nome+'","'+element.peso+'","'+element.altura+'","'+element.time_id+'")');

                            oRemove = document.createElement('td');
                            oImgDel = document.createElement('img');
                            oImgDel.setAttribute('width', '45px');
                            oImgDel.setAttribute('height', '40px');
                            oImgDel.style.cursor = 'pointer'
                            oImgDel.setAttribute('onclick', 'deletaAtleta('+element.id+')');
                 

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

        function formAlteraAtleta(id, nome, peso, altura, time) {
            formulario(id, nome, peso, altura, time);
        }

        function alterarAtleta(codigo) {
            debugger;
            $.ajax({
                url: '/api/atleta/update/'+codigo,
                type: 'PUT',
                data: {
                        id: codigo,
                        nome: document.getElementById('nome').value,
                        peso: document.getElementById('peso').value,
                        altura: document.getElementById('altura').value,
                        id_time: document.getElementById('id_time').value
                    },
                success: function(result) {
                    alert('jogaodr removido');
                    carregarAtletas();
                }
                
            });

            return false;
        }

        function deletaAtleta(id) {
            $.ajax({
                url: '/api/atleta/delete/'+id,
                type: 'DELETE',
                success: function(result) {
                    alert('jogador removido');

                    oConsulta = document.querySelector('.table');

                    while (oConsulta.firstChild) {
                        oConsulta.removeChild(oConsulta.lastChild);
                    }

                    carregarAtletas();
                }
            });

            return false;
        }

        function formulario(id, nome, peso, altura, time) {
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
            oForm.setAttribute('onsubmit', bAltera ? 'alterarAtleta('+id+')' : 'cadastrarAtleta()');

            oH1.innerHTML = bAltera ? 'Alteração do jogador: '+ nome : 'Cadastro do jogador';
            oH1.style.textAlign = 'center';

            oLabel = document.createElement('label');
            oLabel.setAttribute('for', 'nome');
            oLabel.innerHTML = 'Nome:';

            oInput = document.createElement('input');
            oInput.setAttribute('type', 'text');
            oInput.setAttribute('name', 'nome');
            oInput.setAttribute('id', 'nome');

            oLabelPeso = document.createElement('label');
            oLabelPeso.setAttribute('for', 'peso');
            oLabelPeso.innerHTML = 'Peso:';

            oPeso = document.createElement('input');
            oPeso.setAttribute('type', 'number');
            oPeso.setAttribute('name', 'peso');
            oPeso.setAttribute('id', 'peso');

            oLabelAltura = document.createElement('label');
            oLabelAltura.setAttribute('for', 'altura');
            oLabelAltura.innerHTML = 'Altura:';

            oAltura = document.createElement('input');
            oAltura.setAttribute('type', 'text');
            oAltura.setAttribute('name', 'altura');
            oAltura.setAttribute('id', 'altura');

            oLabelTime = document.createElement('label');
            oLabelTime.setAttribute('for', 'id_time');
            oLabelTime.innerHTML = 'Time:';

            oTime = document.createElement('input');
            oTime.setAttribute('type', 'text');
            oTime.setAttribute('name', 'id_time');
            oTime.setAttribute('id', 'id_time');

            if (bAltera) {
                oInput.value = nome;
                oPeso.value = peso;
                oAltura.value = altura;
                oTime.value = time;
            }

            oSubmit = document.createElement('input');
            oSubmit.setAttribute('type', 'submit');
            oSubmit.setAttribute('value', bAltera ? 'Alterar': 'Cadastrar');
            oSubmit.style.marginTop = '50px';
            oSubmit.style.marginLeft = '40%';
         
            oForm.appendChild(oH1);
            oForm.appendChild(oLabel);
            oForm.appendChild(oInput);
            oForm.appendChild(document.createElement('br'));
            oForm.appendChild(oLabelPeso);
            oForm.appendChild(oPeso);
            oForm.appendChild(document.createElement('br'));
            oForm.appendChild(oLabelAltura);
            oForm.appendChild(oAltura);
            oForm.appendChild(document.createElement('br'));
            oForm.appendChild(oLabelTime);
            oForm.appendChild(oTime);
            oForm.appendChild(document.createElement('br'));
            oForm.appendChild(oSubmit);

            oModal.appendChild(oForm);
        }

        function fechar() {
            let modal = document.querySelector('.modal');
            modal.style.display = 'none';
        }

        function cadastrarAtleta() {
            $.ajax({
                url: '/api/atleta',
                type: 'POST',
                data: {nome: document.getElementById('nome').value,
                       peso: document.getElementById('peso').value,
                       altura: document.getElementById('altura').value,
                       id_time: document.getElementById('id_time').value},
                success: function(result) {
                    alert('jogador cadastrado');
                }
            });

            return true;
        }

        $(function() {
            carregarAtletas();
        });
        
    </script>

@stop      
