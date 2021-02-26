$(document).ready(function() {

    document.getElementById("menuButton").addEventListener("click", function(){
        document.getElementById("menu").classList.toggle("show");
    });

    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn') && !event.target.matches('.dropbtnicon')) {
                document.getElementById("menu").classList.remove('show');
        }
    }

    document.getElementById("add-project-button").addEventListener("click", function() {
        var projectContainer = document.getElementById("project-selection");
        projectContainer.classList.add("project-selection-hide");
        setTimeout(function() {
            projectContainer.classList.add("project-selection-remove");
        }, 300);

        var addProjectContainer = document.getElementById("new-project-window");
        addProjectContainer.classList.add("new-project-window-add");
        setTimeout(function() {
            addProjectContainer.classList.add("new-project-window-show");
        }, 300);
    });

    document.getElementById("cancel-button").addEventListener("click", function() {
        
        var addProjectContainer = document.getElementById("new-project-window");
        addProjectContainer.classList.remove("new-project-window-show");
        setTimeout(function() {
            addProjectContainer.classList.remove("new-project-window-add");
        }, 300);
        
        var projectContainer = document.getElementById("project-selection");
        projectContainer.classList.remove("project-selection-remove");
        setTimeout(function() {
            projectContainer.classList.remove("project-selection-hide");
        }, 300);
        
    });

    document.getElementById("add-friend").addEventListener("click", function() {
        var buttonBorder = document.getElementById("add-friend-border");
        buttonBorder.classList.toggle("friend-search");
        var addFriendIcon = document.getElementById("add-friend-icon");
        addFriendIcon.classList.toggle("rotate-icon");

    });



});