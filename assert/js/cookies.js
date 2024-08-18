const cookieBox = document.querySelector(".wrapper"),
 buttons = document.querySelectorAll(".button");

 const executeCodes = () => {
    cookieBox.classList.add("show");

    buttons.forEach((button) => {
        button.addEventListener("click", () => {
            cookieBox.classList.remove("show");

            // if button has acceptbtn id 
            if(button.id == "acceptbtn"){
                //set cookies for 1 month
                document.cookie = "cookieBy= codewithtec; max-age=" + 60 * 60 * 1 * 1;
            }
        });
    });

 }
// executecode function be called on webpage load
window.addEventListener("load", executeCodes);


 