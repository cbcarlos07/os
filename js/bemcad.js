
$( document ).ready( function () {
    var acao    = $('#acao').val();


     getSetor(  );
     getProprietario();

    comboBoxUsuarios( '%' );
    if( acao == 'A' ){
        codigo();
        comboBoxTipoEquipamento( 0 );
        comboBoxFabricante( 0 );

    }else{
        getDados();
    }
    loadTotal();

} );

$('#proprietario').on('change', function () {
    getSigla();
});



function getSigla() {
    var fornecedor = $('#proprietario').val();
    $.ajax({
        url  : 'funcao/fornecedor.php',
        type : 'post',
        dataType: 'json',
        data : {
            acao       : 'E',
            fornecedor : fornecedor
        },
        success : function (data) {
            var patrimonio = $('#patrimonio');
            var cdPatrimonio = patrimonio.val().replace(/[^0-9]/g,'');;
            var sigla = data[0].ds_sigla;
            var codigo = sigla + cdPatrimonio;
            patrimonio.val( codigo );
        }
    });
}


function getDados() {

    var codigo  = $('#codigo').val();

        $.ajax({
            url : 'funcao/bem.php',
            type : 'post',
            dataType: 'json',
            data : {
                acao : 'E',
                codigo : codigo
            },
            success : function (data) {
                console.log(  data );
                $('#item').val( data.bens[0].ds_item );
                $('#setor').val( data.bens[0].cd_setor ).trigger( "chosen:updated" );
                getLocalidade( data.bens[0].cd_localidade  );

               // console.log( "Proprietario: "+data[0].proprietario );
                $('#proprietario').val( data.bens[0].proprietario ).trigger( "chosen:updated" );
                $('#serie').val( data.bens[0].nr_serie ).trigger( "chosen:updated" );
                //getUsuario( data[0].proprietario );
                $('#patrimonio').val( data.bens[0].nr_patrimonio );
                comboBoxTipoEquipamento( data.bens[0].cd_tipo_equipamento );
                comboBoxFabricante( data.bens[0].cd_fabricante );
                var linha = "";
                $.each( data.historico, function ( i, j ) {
                    //console.log("Setor: "+j.nm_setor);
                     linha += "" +
                        "<tr>" +
                            "<td>"+j.nm_setor+"<input type='hidden' name='cdsetor[]' id='cdsetor'  value='"+j.cd_setor+"'> </td>"+
                            "<td>"+j.ds_localidade+"<input type='hidden' name='cdlocalidade[]' value='"+j.cd_localidade+"'> </td>"+
                            "<td>"+j.dt_entrada+"<input type='hidden' name='datain[]' value='"+j.dt_entrada+"'> </td>"+
                            "<td>"+j.usuario+"<input type='hidden' name='usuario[]' value='"+j.usuario+"'> </td>"+
                            "<td><a href='#div' class='btn btn-danger btn-remove btn-xs'>remover</a></td>"+
                        "</tr>";
                } );

                var tbody = $('.tbody');
                tbody.find('tr').remove();
                tbody.append( linha );

                comboBoxUsuarios( '' );


            }
        });

}

function getSetor() {
    $.ajax({
        url : 'funcao/setor.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'S'
        },
        success : function (data) {
            var option = "<option value=''></option>";
          //   console.log( data );
            $.each( data.setor, function ( i, j ) {
                //console.log( j.nmsetor );
                option += "<option value='"+j.codsetor+"'>"+j.nmsetor+"</option>";
            } );
            var combo = $('#setor');
            combo.find('option').remove();
            combo.append( option );
            combo.trigger( 'chosen:updated' );

        }
    });
}

$('#setor').on('change', function () {
    getLocalidade(  );
   // console.log( 'Setor' );
});

function getLocalidade( local ) {
    var setor = $('#setor').val();
    $.ajax({
        url : 'funcao/localidade.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'A',
            setor : setor
        },
        success : function (data) {
            var option = "<option value='%'></option>";
          //  console.log( data );
            $.each( data, function ( i, j ) {
              //  console.log( j.cd_localidade );
               // console.log( j.ds_localidade );
                option += "<option value='"+j.cd_localidade+"'>"+j.ds_localidade+"</option>";
            } );

            if( $('#acao').val() == 'C' ){
                if( typeof data[0].nm_responsavel == 'undefined'){
                    location.reload();
                }
            }
            $('#responsavel').val( data[0].nm_responsavel );
            var combo = $('#localidade');
            combo.find('option').remove();
            combo.append( option );
            combo.val( local ).trigger( 'chosen:updated' );
        }
    });
}


function sucessoChamado() {
    $('.loading').fadeOut();
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-success">Opera&ccedil;&atilde;o realizada com sucesso</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
        location.href = "bem.php";
    },2000);
}

function msgErro( msg ) {
    var mensagem = $('.alerta');
    mensagem.empty().html('<p class="alert alert-danger">'+msg+'</p>').fadeIn("fast");
    setTimeout(function (){
        mensagem.fadeOut();
    },2000);
}


function getProprietario( usuario ) {

    $.ajax({
        url : 'funcao/fornecedor.php',
        dataType: 'json',
        type: 'post',
        data : {
            acao : 'H'
        },
        success : function (data) {
            var option = "<option value=''></option>";
            // console.log( data );
            $.each( data, function ( i, j ) {
                //console.log( j.usuario );
                option += "<option value='"+j.cd_fornecedor+"'>"+j.nm_fantasia+"</option>";
            } );
            var combo = $('#proprietario');
            combo.find('option').remove();
            combo.append( option );
            combo.val( usuario ).trigger( 'chosen:updated' );
        }
    });
}

$('.btn-salvar').on('click', function () {
   // verificarCampos()
        if( verificarCampos() ){
            salvar();
        }


});

function verificarCampos() {

    var item          = $('#item');
    var serie         = $('#serie');
    var tipo          = $('#tipo');
    var fabricante    = $('#fabricante');
    var proprietario  = $('#proprietario');
    var patrimonio    = $('#patrimonio');

    var retorno = false;
    console.log( "Tabela: "+ $(".tbody tr").length ) ;
    if( ( item.val() === "" || serie.val() === "" ) || ( tipo.val() === null || fabricante.val() == null ) ||
        ( ( proprietario.val() === null || proprietario.val() === "" ) ||  patrimonio.val() === '' )
        || ( $(".tbody tr").length  === 0 ) ){

        if( item.val() === "" ){
            $('.item').addClass( 'has-error' );
        }

        if( serie.val() === "" ){
            $('.serie').addClass( 'has-error' );
        }

        if( tipo.val() === null ){
            removerClass( '#tipo_chosen', 1 );
        }

        if( fabricante.val() === null ){
            removerClass( '#fabricante_chosen', 1 );
        }

        if( proprietario.val() === null || proprietario.val() === "" ){
            removerClass( '#proprietario_chosen', 1 );
        }
        if( patrimonio.val() === "" ){
            $('.patrimonio').addClass( 'has-error' );
        }
        if( $(".tbody tr").length == 0 ){
            $('span.table_error').text('Tabela não possui dados');
        }

    }else{
        $('.item').removeClass( 'has-error' );
        $('.serie').removeClass( 'has-error' );
        removerClass( '#tipo_chosen', 0 );
        removerClass( '#fabricante_chosen', 0 );
        removerClass( '#proprietario_chosen', 0 );
        $('.patrimonio').removeClass( 'has-error' );
        $('span.table_error').text('');
        retorno = true;
    }

    return retorno;
}

function salvar() {
    var codigo        = $('#codigo').val();
    var item          = $('#item').val();
    var serie         = $('#serie').val();
    var tipo          = $('#tipo').val();
    var fabricante    = $('#fabricante').val();
    var proprietario  = $('#proprietario').val();
    var patrimonio    = $('#patrimonio').val();
    var acao          = $('#acao').val();

    var setor = $('input[name="cdsetor[]"]').map(function(){
        return this.value;
    }).get();
    var localidade = $('input[name="cdlocalidade[]"]').map(function(){
        return this.value;
    }).get();
    var data = $('input[name="datain[]"]').map(function(){
        return this.value;
    }).get();
    var usuario = $('input[name="usuario[]"]').map(function(){
        return this.value;
    }).get();
    //console.log( "Localidade: "+localidade );
   /* console.log( "Codigo: "+codigo );
    console.log( "Item: "+item );
    console.log( "serie: "+serie );
    console.log( "Tipo de Equipamento: "+tipo+" "+$('#tipo option:selected').text() );
    console.log( "Fabricante: "+fabricante+" "+$('#fabricante option:selected').text() );
    console.log( "Proprietario: "+proprietario+" "+$('#proprietario option:selected').text() );
    console.log( "Patrimonio: "+patrimonio+" "+$('#patrimonio option:selected').text() );
    console.log( "Codigo: "+codigo );

    console.log( "Setor: "+setor );*/


    if( item == "" ){
        $('.item').addClass( 'has-error' );
    }else{
        $('.item').removeClass( 'has-error' );
        $.ajax({
            url      : 'funcao/bem.php',
            type     : 'post',
            dataType : 'json',
            beforeSend: aguardando,
            data :  {
                acao         : acao,
                codigo       : codigo,
                item         : item,
                serie        : serie,
                tipo         : tipo,
                fabricante   : fabricante,
                proprietario : proprietario,
                patrimonio   : patrimonio,
                'setor[]'      : setor,
                'localidade[]' : localidade,
                'data[]'       : data,
                'usuario[]'    : usuario
            },
            success : function ( data ) {
                console.log( data.retorno );
                if( data.retorno == true ){
                    sucessoChamado();
                    $('#acao').val( 'C' )
                }
            }
        });
    }

}
function aguardando() {
    $('.loading').fadeIn();
}

function codigo() {

    $.ajax({
        url : 'funcao/bem.php',
        type : 'post',
        dataType : 'json',
        data : {
            acao : 'B'
        },
        success : function ( data ) {
            console.log( data.CODIGO );
            $('#codigo').val( data.CODIGO );
            $('#patrimonio').val( data.PATRIMONIO );

        }

    });

}

$('.btn-cancelar').on('click', function () {
    $('.modal-cancel').modal('show');
});

$('.btn-sim').on('click', function () {
    window.location.href = "bem.php";
});


function loadTotal(  ) {
    console.log( "Usuario: "+$('#usuario').val() );
    console.log( "Funcionario: "+$('#funcionario').val() );
    var usuario = $('#usuario').val();
    var funcion = $('#funcionario').val();
    loadTotalMenu( usuario, funcion );

    setTimeout( function(){
        loadTotal();
    },30000 );
}


function comboBoxTipoEquipamento( codigo ) {
    
    $.ajax({
        url   : 'funcao/tipo.php',
        type  : 'post',
        dataType : 'json',
        data : {
            acao : 'F'
            
        },
        success : function (data) {

            //  var option = "<option value='%'></option>";
              var option = "<option value=''></option>";
              $.each( data, function (i, j) {
                  option += "<option value='"+j.cd_tipo_equipamento+"'>"+j.ds_tipo_equipamento+"</option>";
              } );

              var combo = $('#tipo');
              combo.find('option').remove();
              combo.append( option );
              combo.val( codigo ).trigger( "chosen:updated" )


        }
    });
    
    
}



function comboBoxFabricante( codigo ) {

    $.ajax({
        url   : 'funcao/fabricante.php',
        type  : 'post',
        dataType : 'json',
        data : {
            acao : 'F'

        },
        success : function (data) {

              var option = "<option value=''></option>";
            //var option = "";
            $.each( data, function (i, j) {
                option += "<option value='"+j.cd_fabricante+"'>"+j.nm_fabricante+"</option>";
            } );

            var combo = $('#fabricante');
            combo.find('option').remove();
            combo.append( option );
            combo.val( codigo ).trigger( "chosen:updated" )


        }
    });


}


function comboBoxUsuarios( codigo ) {

    $.ajax({
        url   : 'funcao/usuario.php',
        type  : 'post',
        dataType : 'json',
        data : {
            acao : 'U'

        },
        success : function (data) {

              var option = "<option value=''></option>";
            //var option = "";
            $.each( data.usuarios, function (i, j) {
                option += "<option value='"+j.usuario+"'>"+j.nome+"</option>";
            } );

            var combo = $('#responsavel');
            combo.find('option').remove();
            combo.append( option );
            if( codigo != "%" ) {
                combo.val(codigo).trigger("chosen:updated");
                console.log('Seleciona');
            }
            else {
                combo.trigger("chosen:updated")
                console.log('Nao Seleciona');
            }


        }
    });


}

$('.btn-adicionar').on('click', function () {

    if( verifyFieldsTable() ){
        adicionarItemTable();
    }

});


function adicionarItemTable() {

    var cdsetor   = $('#setor option:selected').val();
    var nmsetor   = $('#setor option:selected').text();
    var cdlocal   = $('#localidade option:selected').val();
    var nmlocal   = $('#localidade option:selected').text();
   // var cdprop    = $('#proprietario option:selected').val();
   // var nmprop    = $('#proprietario option:selected').text();
    var usuari    = $('#responsavel option:selected').val();
    var datain    = $('#datain').val();
    var dataou    = $('#dataout').val();

    var linha = "" +
        "<tr>" +
        "<td>"+nmsetor+"<input type='hidden' name='cdsetor[]' id='cdsetor'  value='"+cdsetor+"'> </td>"+
        "<td>"+nmlocal+"<input type='hidden' name='cdlocalidade[]' value='"+cdlocal+"'> </td>"+
        "<td>"+datain+"<input type='hidden' name='datain[]' value='"+datain+"'> </td>"+
        "<td>"+usuari+"<input type='hidden' name='usuario[]' value='"+usuari+"'> </td>"+
        "<td><a href='#div' class='btn btn-danger btn-remove btn-xs'>remover</a></td>"+
        "</tr>";
    //$('.tbody').append( linha );
    $( linha ).prependTo( '.tbody' );
    $("#setor option:first").attr('selected','selected');
    $('#localidade').val($("#localidade option:first").val());
    $('#datain').val('');
    $('#responsavel').val($("#responsavel option:first").val());
    $('span.table_error').text('');
    $(".tbody").on("click", ".btn-remove", function(e){
        $(this).closest('tr').remove();

    });



}

$("#datain").datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    mask: true,
    locale: 'pt-br'
});
$("#dataout").datetimepicker({
    timepicker: false,
    format: 'd/m/Y',
    mask: true,
    locale: 'pt-br'
});

$('.refr-tipo').on('click', function () {
    comboBoxTipoEquipamento(0);
});
$('.refr-fabr').on('click', function () {
    comboBoxFabricante(0);
});
$('.refr-fornecedor').on('click', function () {
    getProprietario(    0);
});

function verifyFieldsTable() {

    var tudoOk = false;
    var setor  = $( '#setor' );
    var local  = $( '#localidade' );
    var data   = $( '#datain' );
    var resp   = $( '#responsavel' );

    if( (setor.val() === '' || local.val() === "") ||
        ( data.val( ) === '__/__/___'  || data.val( ) === '' ) ||
        ( resp.val() === null || resp.val() === ""  ) ){

        if( setor.val() === '' ){
            $('#setor_chosen').addClass( 'required' );
            setor.trigger( "chosen:activate" );
            setor.attr('title','Por favor escolha uma opção');

        }

        if( local.val() === '' ){
            $('#localidade_chosen').addClass( 'required' );
            local.trigger( "chosen:activate" );
            local.attr('title','Por favor escolha uma opção');

        }

        if( data.val( ) === '__/__/___'  || data.val( ) === '' ){
            $('.data').addClass( 'has-error' );
            data.focus();

        }

        if( resp.val() === null || resp.val() === "%"  ){
            $('#responsavel_chosen').addClass( 'required' );
            resp.trigger( "chosen:activate" );
            resp.attr('title','Por favor escolha uma opção');

        }

    }else{
        tudoOk = true;
        removerClass( '#setor_chosen',0 );
        removerClass( '#localidade_chosen',0 );
        removerClass( '#responsavel_chosen',0 );

    }
    return tudoOk;

}

function removerClass( id, op ) {
    if( op === 1  ){
        $(id).addClass( 'required' );
    }else{
        $(id).removeClass( 'required' );
    }

}


