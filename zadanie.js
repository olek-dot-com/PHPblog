//-----------------------------------------------------------------------------
// zadanie7.js
//-----------------------------------------------------------------------------
//
var modal_width = 450;
// funkcje pomocnicze
function modal_center(item){
   $(item).css({"position":"fixed",
                "width":modal_width.toString()+"px",
                "left":((window.innerWidth-modal_width)/2).toString()+"px",
                "top":((window.innerHeight-$(item).height())/2).toString()+"px"
                });
}
function modal_slideToggle(item){
   modal_center(item);
   $(item).slideToggle();
};
// kod wykonywany po załadowaniu całej strony
$(document).ready(function(){
   $(".modal").hide();
   $(".modal").find("form").prepend("<a href='' class='close_modal'>X</a>");
   if( $("#loginerror").text()!="" ) {
     modal_center("#login");
     $("#login").show();
   };
   if( $("#registererror").text()!="" ) {
     modal_center("#register");
     $("#register").show();
   };
   $("a.close_modal").click( function(event){
        $(this).parents(".modal").hide();
        event.preventDefault();
   });
   $("nav a[href='#login']").click( function(event){
        modal_center("#login");
        $("nav a[href='#register']").show();
        $("nav a[href='#login']").hide();
        $("#register").hide();
        $("#login").slideDown();
        event.preventDefault();
   });
   $("nav a[href='#register']").click( function(event){
        modal_center("#register");
        $("nav a[href='#register']").hide();
        $("nav a[href='#login']").show();
        $("#login").hide();
        $("#register").slideDown();
        event.preventDefault();
   }).hide();
   $("#addtopic").click( function(event){
        modal_slideToggle("#modal_topic");
        event.preventDefault();
   });
   // zastosowanie pobierania danych z pomocą AJAX
   $("nav a.topicedit").click( function(event){
        // wstawia napis oraz numer tematu do nagłówka form.
        $("#modal_topic h2").html("Edycja tematu ID: <span topicid=\""+$(this).attr("topicid")+"\">"+$(this).attr("topicid")+"</sapn>");
        // pobiera dane z serwera metodą GET
        $.get("?cmd=gettopic&topicid="+$(this).attr("topicid"),
              // pobrane dane są przekazywane w data fo funkcji,
              // funkcja odpowiada za wykorzystanie pobranych danych
              // oczekiwane są dane w formacie JSON 
              function( data, status){
               // tworzy obiekt topic z napisu o formacie JSON
               var topic=JSON.parse(data);
               // dane są umieszczane w polach form.
               $("#modal_topic [name='topic']").val(topic.topic).focus(); 
               $("#modal_topic [name='topic_body']").val(topic.topic_body);
               $("#modal_topic [name='topicid']").val(topic.topicid);
        });
        modal_slideToggle("#modal_topic");
        event.preventDefault();
   });
// ------------------- do uzupełnienia ----------------------------------------
// kod obsługi dla: dodawania postów, edycji postów, dodawania obrazków,
// edycji podpisu pod obrazkiem, oraz obsługa odpowiednich 'przycisków'
//
// ------------------- do uzupełnienia ----------------------------------------
   $("#addpost").click( function(event){
        modal_slideToggle("#modal_post");
        event.preventDefault();
   });
    $("nav a.postedit").click( function(event){
        $("#modal_post h2").html("Edycja postu ID: <span postid=\""+$(this).attr("postid")+"\">"+$(this).attr("postid")+"</sapn>");
        $.get("?cmd=getpost&postid="+$(this).attr("postid"),
              function( data, status){
               var post=JSON.parse(data);
               $("#modal_post [name='post']").val(post.post).focus();
               $("#modal_post [name='post_body']").val(post.post_body);
               $("#modal_post [name='postid']").val(post.postid);
        });
        modal_slideToggle("#modal_post");
        event.preventDefault();
});
    $("nav a.uploadfile").click(function(event) {
        var postid = $(this).attr("postid");
        $("#modal_file h2").html("Dodawanie obrazka do postu ID: <span postid=\"" + postid + "\">" + postid + "</span>");
        $("#modal_file [name='postid']").val(postid);
        modal_slideToggle("#modal_file");
        event.preventDefault();
    })
    $("a.imgedit").click(function(event) {

        $("#modal_fileedit h2").html("Edycja obrazka ID: <span imgid=\"" + $(this).attr("imgid") + "\">" + $(this).attr("imgid") + "</span>");
        event.preventDefault();
        $.get("?cmd=getf&imgid=" + $(this).attr("imgid"), function(data, status) {
            console.log("AJAX response:", data);
            try {
                var img = JSON.parse(data);
                if (img.status && img.status === 'error') {
                     alert(img.message);
                } else {
                    $("#modal_fileedit [name='imagetitle']").val(img.title).focus();
                    $("#modal_fileedit [name='imgid']").val(img.id);

                }
            } catch (e) {
                console.error("Parsing error:", e, data);
                alert("Błąd podczas parsowania danych obrazka.");
            }
        }).fail(function(xhr, status, error) {
            console.error("AJAX error:", status, error);
            alert("Błąd podczas pobierania danych obrazka.");
        });

        modal_slideToggle("#modal_fileedit");

    });
//
// ------------------- do uzupełnienia ----------------------------------------
   
   $("article.topic").mouseenter(function(){
     $(this).find("footer").css("background-color", "#ccc");
   });
   $("article.topic").mouseleave(function(){
     $(this).find("footer").css("background-color", "#ddd");
   });
}); 