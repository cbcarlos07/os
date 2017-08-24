/**
 * Created by carlos.bruno on 14/06/2017.
 */


var URL_SEND  = 'funcao/usuario.php';
var TYPE_SEND = 'post';
var DATA_TYPE = 'json';

$('#u').on('focusout', function () {
    var usuario = $(this).val();
    $.ajax({
        url  : URL_SEND,
        type : TYPE_SEND,
        dataType: DATA_TYPE,
        data : {
            usuario : usuario,
            acao    : 'E'
        },
        success : function (data) {
            $('#e').val(data.empresa);
        }

    });
});

$('.signup').on('click',function () {
  // alert('Click');
   submitForm();
});

function OnEnter(evt)
{
    var key_code = evt.keyCode  ? evt.keyCode  :
        evt.charCode ? evt.charCode :
            evt.which    ? evt.which    : void 0;


    if (key_code == 13)
    {
        return true;
    }
}


function EnviaFormulario(e)
{
    if(OnEnter(e))
    {
       /* alert('O formulário pode ser enviado');
        return false;*/
       //submitForm();
        $('.signup').click();
    }
    else
    {
        return true;
    }
}

function submitForm() {
    var usuario = $('#u').val();
    var senha   = $('#p').val();

    $.ajax({
        url : URL_SEND,
        type: TYPE_SEND,
        dataType : DATA_TYPE,
        data : {
            usuario : usuario,
            senha  : senha,
            acao   : 'L'
        },
        success : function (data) {
          //  alert("Retorno: "+data.sucesso);

            if(data.sucesso == 1)
                if( data.sistema == 1 )
                 window.location.href = './bem.php';
                else
                    window.location.href = './solicitar.php';
        }

    });
    return false;
}


$('.btn-sim').on('click',function () {
  $.ajax({
      type : TYPE_SEND,
      dataType: DATA_TYPE,
      url : URL_SEND,
      data :{
          acao : 'S'
      },
      success : function (data) {
          //alert('Sucesso!'+data.sucesso);
          //window.location.href = data.host+"/os";
          window.location.href = "./";
      }
  });
});
