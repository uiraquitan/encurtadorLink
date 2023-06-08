// Selecting all required elements

const form = document.querySelector(".wrapper form"),
    fullURL = form.querySelector("input"),
    shortenBtn = form.querySelector("button");
const blueEfect = document.querySelector(".blur-effect");
const popupBox = document.querySelector(".popup-box");
const form2 = popupBox.querySelector("form");
shortenURL = popupBox.querySelector("input"),
    saveBtn = popupBox.querySelector("button");
copyBtn = popupBox.querySelector(".copy-icon");

// preventing form from submiting
form.onsubmit = (e) => {
    e.preventDefault();
}

shortenBtn.onclick = (e) => {
    //Let's start ajax
    let xhr = new XMLHttpRequest(); // creating xhr object
    xhr.open("POST", "php/url-controll.php", true);
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) { //if ajax request status is ok/success
            let data = xhr.response;
            if (data.length <= 5) {
                blueEfect.style.display = "block";
                popupBox.classList.add("show");

                let domain = "localhost/url/";
                shortenURL.value = domain + data;

                
                copyBtn.onclick = () => {
                    shortenURL.select();
                    document.execCommand('copy');
                }
                form2.onsubmit = (e) => {
                    e.preventDefault();
                }
                saveBtn.onclick = () => {
                    location.reload(); // reload the current page
                }
            } else {
                alert(data);
            }
        }

    }

    //let's send from data to php file
    let formData = new FormData(form); //creating new formData object
    xhr.send(formData); // sendinf form value to php
};