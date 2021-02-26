$(document).ready(function() {

        //prevent resubmits on back button and refresh
        if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
        }

        //code for color change
        var colorPopup = document.getElementById("colorChooser");
        var colorOpener = document.getElementById("colorOpener");
        var colorCloser = document.getElementsByClassName("close-popup")[0];
        colorOpener.onclick = function() {
                colorPopup.style.display = "block";
        };
        colorCloser.onclick = function() {
                colorPopup.style.display = "none";
        };
        window.onclick = function(event) {
                if(event.target == colorPopup) {
                        colorPopup.style.display = "none";
                }
        };



        var content_field = document.getElementById('content_input_field');
        var content_field_holder = document.getElementById('content_field_holder');
        content_field.addEventListener("focus",textAreaFocus);
        content_field.addEventListener("blur",textAreaBlur);

        var delete_button;
        var recent_piece;
        var recent_piece_id;

        var frame = document.getElementById("story-window");
                function setDeleteButton() {
                        //Get all Pieces
                        var pieces = frame.querySelectorAll("p");
                        var forms  = frame.querySelectorAll("form");

                        //Get last Piece
                        recent_piece = pieces[pieces.length-1];
                        recent_piece_form = forms[forms.length-1];
                        if (recent_piece_form) {
                        
                                delete_button = recent_piece_form.lastChild;
                                delete_button.setAttribute("style","visibility:visible");
                                delete_button.style.visibility = "visible";

                                delete_button.onclick = function() {
                                        recent_piece.remove();
                                        setDeleteButton();
                                }
                        }
                }    

        //Set first button
        setDeleteButton();

        //Delete Piece
        

        document.getElementById("menuButton").addEventListener("click", function(){
                document.getElementById("menu").classList.toggle("show");
        });

        document.getElementById("add_writer").addEventListener("click", function(){
                document.getElementById("writer_search").classList.toggle("writer_search_show");
        });

        window.onclick = function(event) {
                if (!event.target.matches('.dropbtn') && !event.target.matches('.dropbtnicon')) {
                        document.getElementById("menu").classList.remove('show');
                }
                if (!event.target.matches('.add_writer') && !event.target.matches('.add_writer_icon') && !event.target.matches('.add_writer_input')) {
                        document.getElementById("writer_search").classList.remove('writer_search_show');
                }
        }

     
        window.setInterval(function(){
                getLivePieces(projectID, chapterID, username, projectName);
        }, 5000);
        
        //MAY NEED THESE COMMENTED OUT METHODS IF .STYLE DOESN'T WORK IN OTHER BROWSERS
    function textAreaFocus() {
            //content_field_holder.setAttribute("style","height:24vh;box-shadow: 0px 3px 3px rgba(0, 0, 0, 0.25)");
            content_field_holder.style.height = "24vh";
            content_field_holder.style.boxShadow = "0px 3px 3px rgba(0, 0, 0, 0.25)";
            //content_field.setAttribute("style","height:94%;top:3%;bottom:3%");
            content_field.style.height = "94%";
            content_field.style.top = "3%";
            content_field.style.bottom = "3%";
    }
    function textAreaBlur() {
            //content_field_holder.setAttribute("style","height:4vh;box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.25)");
            content_field_holder.style.height = "4vh";
            content_field_holder.style.boxShadow = "0px 1px 1px rgba(0, 0, 0, 0.25)";
            //content_field.setAttribute("style","height:80%;top:10%;bottom:10%");
            content_field.style.height = "60%";
            content_field.style.top = "20%";
            content_field.style.bottom = "20%";
    }


    



});


function getLivePieces(project, chapter, user, projectName) {
        $.post("Includes/handlers/ajax_load_pieces.php", {projectID: project, chapterID:chapter, username:user, project:projectName}, function(data) {
            $('#story-window').append(data);
        });
}