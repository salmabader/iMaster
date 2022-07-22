// -------------- to activate send button -------------
const inputFeilds = document.querySelectorAll("input")
const sendCode = document.getElementById("sendCode")
const errorMsg = document.getElementById("errorMsg")
const feedback = document.getElementById("feedback")
const wrongCode = document.getElementById("wrongCode")
const toast1 = document.getElementById("toast-danger1")
const toast2 = document.getElementById("toast-danger2")
const toast3 = document.getElementById("toast-success")
const step2 = document.getElementById("secondStep")
const bar = document.getElementById("bar")
const verifySection = document.getElementById("verifyCode")
const infoSection = document.getElementById("enterInfo")
inputFeilds.forEach(function (inp) {
    inp.addEventListener('keyup', function () {
        checkEnableButton()
    })
});
const checkEnableButton = () => {
    sendCode.disabled = !(
        inputFeilds[0].value && inputFeilds[1].value && isValidPass && isValidEmail
    )
    verifyBtn.disabled = !(
        codeInput.value
    )
}
window.addEventListener('load', function () {
    isValidPass = true
    if (errorMsg.innerHTML.length > 0) {
        toast1.classList.remove("opacity-0")
        toast1.classList.add("opacity-100")
    }
    // in case the email sent successfully
    if (feedback.innerHTML.length > 0) {
        toast3.classList.remove("opacity-0")
        toast3.classList.add("opacity-100")
        step2.classList.remove("bg-gray-200")
        step2.classList.add("bg-blue-500")
        bar.classList.remove("bg-gray-200")
        bar.classList.add("bg-blue-500")
        verifySection.classList.remove("hidden")
        verifySection.classList.add("block")
        infoSection.classList.remove("block")
        infoSection.classList.add("hidden")
    }
    // in case the user enter wrong code
    if (wrongCode.innerHTML.length > 0) {
        toast2.classList.remove("opacity-0")
        toast2.classList.add("opacity-100")
    }
})

//loadin btn
sendCode.addEventListener('click', function () {
    sendCode.innerHTML = `<svg role="status" class="inline mr-2 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
    </svg>
    Loading...`
})

// -------------- to activate verify button -------------
const verifyBtn = document.getElementById("verify")
const codeInput = document.getElementById("code")
codeInput.addEventListener('keyup', function () {
    if (codeInput.value.length == 6) {
        checkEnableButton()
    }
})

// ----------- to show and hide the password -----------
const eye = document.getElementById("eyeIcon")
eye.addEventListener("click", function () {
    if (eye.children[0].id === "opened") {
        eye.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hover:text-blue-500 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
  <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
  </svg>`
        inputPassword.setAttribute("type", "text")
    }
    else {
        eye.innerHTML = `<svg id="opened" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hover:text-blue-500 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
    </svg>`
        inputPassword.setAttribute("type", "password")
    }
})