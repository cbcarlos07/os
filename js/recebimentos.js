/**
 * Created by carlos.bruno on 17/07/2017.
 */

$(document).ready(function () {
   preencherTabela();
});


function preencherTabela() {
    $.ajax({
        url      : 'funcao/os.php',
        dataType : 'json',
        type     : 'post',
        data : {
            acao : 'A'
        },
        success : function (data) {

            $.each(data.chamados, function (i, j) {
                 var tbody = "<tr>" +
                                 "<td>" + j.codigo + "</td>"+
                                 "<td>" + j.data + "</td>"+
                                 "<td>" + j.descricao + "</td>"+
                                 "<td>" + j.setor + "</td>"+
                                 "<td>" + j.solicitante + "</td>"+
                                 "<td> <a href='#rec' class='btn btn-primary btn-rec btn-xs' onclick='receber("+ j.codigo +")'>Receber</a>  </td>"+
                             "</tr>";
                 $('.tbody').append( tbody );

            });

        }
    });
}

 function receber( codigo ) {

    var form = $('<form action="chamados.php" method="post">'
               +'<input type="hidden" name="cdos" value="'+ codigo +'" />'
               + '</form>');
    $('body').append( form );
    form.submit();

 }

