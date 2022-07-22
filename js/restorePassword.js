// -------------- to activate send button -------------
const inputFeilds = document.querySelectorAll("input")
const sendCode = document.getElementById("sendCode")
const errorMsg = document.getElementById("errorMsg")
const toast = document.getElementById("toast-danger")
const step2 = document.getElementById("secondStep")
const bar = document.getElementById("bar")
inputFeilds.forEach(function (inp) {
    inp.addEventListener('change', function () {
        checkEnableButton()
    })
});
const checkEnableButton = () => {
    sendCode.disabled = !(
        inputFeilds[0].value && inputFeilds[1].value
    )
}
window.addEventListener('load', function () {
    if (errorMsg.innerHTML.length > 0) {
        toast.classList.remove("opacity-0")
        toast.classList.add("opacity-100")
    }
    console.log("here")
    step2.classList.remove("bg-gray-200")
    step2.classList.add("bg-blue-500")
    bar.classList.remove("bg-gray-200")
    bar.classList.add("bg-blue-500")
})

// ----------- to check if the email is valid -----------
const email = document.getElementById("email")
const emailError = document.getElementById("emailError")
let isValidEmail = false
email.addEventListener("keyup", function () {
    if (email.value.length > 0 && !validateEmail(email.value)) {
        emailError.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>  Email is invalid`
        isValidEmail = false
    }
    else {
        emailError.innerHTML = ""
        isValidEmail = true
    }
})
const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};