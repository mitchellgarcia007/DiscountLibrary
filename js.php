<?php
    $usi_page_URL = $_SERVER['HTTP_REFERER'];

    if($usi_page_URL != "http://discounts.mitchellgarcia.net/add/"){
        die;
    }
?>

$(document).ready(function(){

    //hidden top div
    var div = document.createElement("div");
    div.className = "usi_top_div";
    div.style.width = "100%";
    div.style.height = "5px";
    div.style.background = "transparent";
    div.style.position = "fixed";
    div.style.top = "0";
    document.body.appendChild(div);

    
                






    //red cookies
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function main(){
        //Modal
        $(".usi_top_div").mouseenter(function(){
            if(getCookie("usi_cookie_launched") != 1){

                var modal1 = '<div id="myModal" class="modal fade" role="dialog">';
                var modal2 = '<div class="modal-dialog">';
                    var modal3 = '<div class="modal-content">';
                        var modal4 = '<div class="modal-header">';
                            var modal5 = '<button type="button" class="close" data-dismiss="modal">&times;</button>';
                            var modal6 = '<h4 class="modal-title">Modal Header</h4>';
                        var modal7 = '</div>';
                        var modal8 = '<div class="modal-body">';
                            var modal9 = '<p>Some text in the modal.</p>';
                        var modal10 = '</div>';
                        var modal11 = '<div class="modal-footer">';
                            var modal12 = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                        var modal13 = '</div>';
                    var modal14 = '</div>';
                var modal15 = '</div>';
            var modal16 = '</div>';
        
            $("body").append(modal1, modal2, modal3, modal4, modal5, modal6, modal7, modal8, modal9, modal10, modal11, modal12, modal13, modal14, modal15, modal16);

                $("#myModal").modal({show: "true"}); 
                document.cookie = "usi_cookie_launched=1";
                console.log("lunching modal");
            }
            else{
                console.log("suppressing modal");
            }
        });
    }

    setTimeout(main, 1000);
        
});