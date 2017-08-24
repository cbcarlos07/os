/**
 * Created by carlos.bruno on 29/06/2017.
 */

$(document).ready(function () {

    var selector = '.nav li';
    var url = window.location.href;
    var target = url.split('/');

    $(selector).each(function(){
        var urlAtual = target[target.length-1].split('#');
       // console.log(  $(this).find('a').attr('href')+" - "+ urlAtual[0]);
        if($(this).find('a').attr('href')===urlAtual[0]){
       // if($(this).find('a').attr('href')===($(this).find('a').attr('href'))){

            $(selector).removeClass('current');
            $(this).addClass('current');
        }
    });
});

