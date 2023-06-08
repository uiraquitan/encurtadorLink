// Selecting all required elements

const form = document.querySelector(".wrapper form"),
    fullURL = form.querySelector("input"),
    shortenBtn = form.querySelector("button"),
 blueEfect = document.querySelector(".blur-effect"),
 popupBox = document.querySelector(".popup-box"),
    form2 = popupBox.querySelector("form"),
    shortenURL = popupBox.querySelector("input"),
    saveBtn = popupBox.querySelector("button"),
    copyBtn = popupBox.querySelector(".copy-icon"),
    infoBox = popupBox.querySelector(".info-box");

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

                // let work on save btn click
                saveBtn.onclick = () => {
                    form2.onsubmit = (e) => {
                        e.preventDefault();
                    }
                    let xhr2 = new XMLHttpRequest();// Creating xhr object
                    xhr2.open("POST", "php/save-url.php", true);
                    xhr2.onload = () => {
                        if (xhr2.readyState == 4 && xhr2.status == 200) {
                            let data = xhr2.response;
                            if (data == "success") {
                                location.reload();
                            } else {
                                infoBox.classList.add("error");
                                infoBox.innerText = data;
                            }
                        }
                    }

                    //let'a send two  data/value from ajax to php
                    let short_url = shortenURL.value;
                    let hidden_url = data;
                    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr2.send("shorten_ul=" + short_url + "&hidden_url=" + hidden_url);
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