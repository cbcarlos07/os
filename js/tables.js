$(document).ready(function() {
        $('#example').dataTable();
} );

$('#setor').on('change', function () {
   var cdsetor = $(this).val();

   var form = $('<form action="bem.php" method="post">' +
                '<input type="hidden" value="'+cdsetor+'" name="setor">'+
                '</form>');
   $('body').append( form );
   form.submit();
});

