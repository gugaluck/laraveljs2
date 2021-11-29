@extends("layout")

@section('titulo')
    Time x Campeonato
@stop

@section('conteudo')
    <h5>Time x Jogos</h5>
    <hr>

    <button onclick="formulario()">Cadastrar</button>

    <div class="modal">
    </div>

    <table class="table">

    </table>
 
    <script>

        function carregarTimeCampeonatos() {
            oTable = document.querySelector('.table');
            aCabecalho = ['Código',  'Código jogos','jogos', 'Código Time', 'Time', 'Alterar', 'Remover'];
            const oTr = document.createElement('tr');

            aCabecalho.forEach(element => {
                oColuna = document.createElement('td');
                oColuna.style.fontWeight ='bold';
                oColuna.innerHTML = element;

                oTr.appendChild(oColuna);

                oTable.appendChild(oTr);
            });

            $.ajax({
                url: '/api/timecampeonato',
                type: 'GET',
                success: function(result) {
                    if(result) {
                        result.forEach(element => {
                            const oTr = document.createElement('tr');

                            aHref = document.createElement('a');
                            aHref.setAttribute('href', 'timecampeonato/detalhe/'+element.id);

                            oCodigo = document.createElement('td');
                            oCodigo.appendChild(aHref);
         
                            aHref.innerHTML = element.id;

                            oTr.appendChild(oCodigo);

                          
                            oCodigoCampeonato = document.createElement('td');
                            oCodigoCampeonato.innerHTML = element.campeonato_id;

                            oTr.appendChild(oCodigoCampeonato);

                            oCampeonatoNome = document.createElement('td');
                            oCampeonatoNome.innerHTML = element.campeonato_nome;

                            oTr.appendChild(oCampeonatoNome);

                            oCodigoTime = document.createElement('td');
                            oCodigoTime.innerHTML = element.time_id;

                            oTr.appendChild(oCodigoTime);

                            oTimeNome = document.createElement('td');
                            oTimeNome.innerHTML = element.time_nome;

                            oTr.appendChild(oTimeNome);

        
                            oAltera = document.createElement('td');
                            oImgAlt = document.createElement('img');   oImgAlt.setAttribute('width', '45px');
                            oImgAlt.setAttribute('height', '40px');
                            oImgAlt.style.cursor = 'pointer';
                            oImgAlt.setAttribute('onclick', 'formAlteraTimeCampeonato('+element.id+', '+element.campeonato_id+', '+element.time_id+')');

                            oRemove = document.createElement('td');
                            oImgDel = document.createElement('img'); oImgDel.setAttribute('width', '45px');
                            oImgDel.setAttribute('height', '40px');
                            oImgDel.style.cursor = 'pointer'
                            oImgDel.setAttribute('onclick', 'deletaTimeCampeonato('+element.id+')');
                 

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

        function formAlteraTimeCampeonato(id, id_campeonato, id_time) {
            formulario(id, id_campeonato, id_time);
        }

        function alterarTimeCampeonato(codigo) {
            $.ajax({
                url: '/api/timecampeonato/update/'+codigo,
                type: 'PUT',
                data: {
                        id: codigo,
                        timcodigo: document.getElementById('timcodigo').value,
                        camcodigo: document.getElementById('camcodigo').value
                    },
                success: function(result) {
                    alert('time x jogo alterado');
                    carregarTimeCampeonatos();
                }
                
            });

            return false;
        }

        function deletaTimeCampeonato(id) {
            //mudar para remover a linha apenas.
            $.ajax({
                url: '/api/timecampeonato/delete/'+id,
                type: 'DELETE',
                success: function(result) {
                    alert('Time x jogo');

                    oConsulta = document.querySelector('.table');

                    while (oConsulta.firstChild) {
                        oConsulta.removeChild(oConsulta.lastChild);
                    }

                    carregarTimeCampeonatos();
                }
            });

            return false;
        }

        function formulario(id, id_campeonato, id_time) {
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
            oForm.setAttribute('onsubmit', bAltera ? 'alterarTimeCampeonato('+id+')' : 'cadastrarTimeCampeonato()');

            oH1.innerHTML = bAltera ? 'Alteração do Time x Campeonato': 'Cadastro de time x jogo';
            oH1.style.textAlign = 'center';

            oLabel = document.createElement('label');
            oLabel.setAttribute('for', 'timcodigo');
            oLabel.innerHTML = 'Time:';

            oInput = document.createElement('input');
            oInput.setAttribute('type', 'number');
            oInput.setAttribute('name', 'timcodigo');
            oInput.setAttribute('id', 'timcodigo');

            oLabelCampeonato = document.createElement('label');
            oLabelCampeonato.setAttribute('for', 'camcodigo');
            oLabelCampeonato.innerHTML = 'Campeonato:';

            oCampeonato = document.createElement('input');
            oCampeonato.setAttribute('type', 'number');
            oCampeonato.setAttribute('name', 'camcodigo');
            oCampeonato.setAttribute('id', 'camcodigo');


            if (bAltera) {
                oInput.value = id_campeonato;
                oCampeonato.value = id_time;
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
            oForm.appendChild(oLabelCampeonato);
            oForm.appendChild(oCampeonato);
            oForm.appendChild(document.createElement('br'));
            oForm.appendChild(oSubmit);

            oModal.appendChild(oForm);
        }

        function fechar() {
            let modal = document.querySelector('.modal');
            modal.style.display = 'none';
        }

        function cadastrarTimeCampeonato() {
            $.ajax({
                url: '/api/timecampeonato',
                type: 'POST',
                data: {timcodigo: document.getElementById('timcodigo').value,
                       camcodigo: document.getElementById('camcodigo').value},
                success: function(result) {
                    alert('Time x jogo cadastrado');
                }
            });

            return true;
        }

        $(function() {
            carregarTimeCampeonatos();
        });
        
    </script>

@stop      
