const nameTF = document.getElementById("nameTF");
const ageTF = document.getElementById("ageTF");
const emailTF = document.getElementById("emailTF");
const maleRB = document.getElementById("maleRB");
const femaleRB = document.getElementById("femaleRB");
const cricketCMB = document.getElementById("cricketCMB");
const footballCMB = document.getElementById("footballCMB");
const country = document.getElementById("country");
const fileUpload = document.getElementById("fileUpload");

const nameERR = document.getElementById("nameERR");
const ageERR = document.getElementById("ageERR");
const emailERR = document.getElementById("emailERR");
const genderERR = document.getElementById("genderERR");
const sportsERR = document.getElementById("sportsERR");
const countryERR = document.getElementById("countryERR");
const fileERR = document.getElementById("fileERR");

const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

function formValidate() {

    const nameRegex = /^[a-zA-Z]+$/;
    let hasERR = false;

    // Clear old errors
    nameERR.innerHTML = ageERR.innerHTML = emailERR.innerHTML =
    genderERR.innerHTML = sportsERR.innerHTML = 
    countryERR.innerHTML = fileERR.innerHTML = "";

    // NAME
    if (nameTF.value.trim() === "") {
        hasERR = true;
        nameERR.innerHTML = "Name cannot be empty";
        nameERR.style.color = "red";
    } else if (!nameRegex.test(nameTF.value.trim())) {
        hasERR = true;
        nameERR.innerHTML = "Name can only contain letters (A-Z)";
        nameERR.style.color = "red";
    }

    // AGE
    const age = Number(ageTF.value);
    if (age < 1 || age > 100) {
        hasERR = true;
        ageERR.innerHTML = "Age must be between 1 and 100";
        ageERR.style.color = "red";
    }

    // EMAIL
    if (emailTF.value.trim() === "") {
        hasERR = true;
        emailERR.innerHTML = "Email cannot be empty";
        emailERR.style.color = "red";
    } else if (!emailRegex.test(emailTF.value.trim())) {
        hasERR = true;
        emailERR.innerHTML = "Invalid email format";
        emailERR.style.color = "red";
    }

    // GENDER
    if (!maleRB.checked && !femaleRB.checked) {
        hasERR = true;
        genderERR.innerHTML = "Please select your gender";
        genderERR.style.color = "red";
    }

    // SPORTS
    if (!cricketCMB.checked && !footballCMB.checked) {
        hasERR = true;
        sportsERR.innerHTML = "Please select at least one sport";
        sportsERR.style.color = "red";
    }

    // COUNTRY
    if (country.value.trim() === "") {
        hasERR = true;
        countryERR.innerHTML = "Please select a country";
        countryERR.style.color = "red";
    }

    // FILE
    if (fileUpload.value.trim() === "") {
        hasERR = true;
        fileERR.innerHTML = "Please upload a file";
        fileERR.style.color = "red";
    }

    return !hasERR;
}
