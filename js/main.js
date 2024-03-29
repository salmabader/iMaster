// ----------- check password -----------
const inputPassword = document.getElementById("password")
const passlength = document.getElementById("passLength")
const capitalL = document.getElementById("passCL")
const smallL = document.getElementById("passSL")
const specialChar = document.getElementById("passSC")
const passError = document.getElementById("passwordError")
let isCorrectLen = false
let isCapital = false
let isSmall = false
let isSpecial = false
let isValidPass = false
inputPassword.addEventListener("keyup", function () {
    // check password length
    if (inputPassword.value.length < 8) {
        passlength.innerHTML = `<svg class="text-red-500 inline h-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
      </svg>`
        isCorrectLen = false
    }
    else {
        passlength.innerHTML = `<svg class="text-green-500 inline h-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
      </svg>`
        isCorrectLen = true
    }

    // check if there is a capital letter
    if (isUpper(inputPassword.value)) {
        capitalL.innerHTML = `<svg class="text-green-500 inline h-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
      </svg>`
        isCapital = true
    }
    else {
        capitalL.innerHTML = `<svg class="text-red-500 inline h-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>`
        isCapital = false
    }

    // check if there is a small letter
    if (isLower(inputPassword.value)) {
        smallL.innerHTML = `<svg class="text-green-500 inline h-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
      </svg>`
        isSmall = true
    }
    else {
        smallL.innerHTML = `<svg class="text-red-500 inline h-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>`
        isSmall = false
    }

    // check if there is a special character
    if (isSpecialChar(inputPassword.value)) {
        specialChar.innerHTML = `<svg class="text-green-500 inline h-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
      </svg>`
        isSpecial = true
    }
    else {
        specialChar.innerHTML = `<svg class="text-red-500 inline h-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>`
        isSpecial = false
    }

    // clear the icon when the password empty
    if (inputPassword.value.length == 0) {
        passlength.innerHTML = ""
        capitalL.innerHTML = ""
        smallL.innerHTML = ""
        specialChar.innerHTML = ""
    }

    if ((!isCorrectLen || !isCapital || !isSmall || !isSpecial) && inputPassword.value.length > 0) {
        passError.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>  Password does not satisfy the conditions`
        isValidPass = false
    }
    else {
        passError.innerHTML = ""
        isValidPass = true
    }
})
function isUpper(str) {
    return /[A-Z]/.test(str)
}
function isLower(str) {
    return /[a-z]/.test(str)
}
function isSpecialChar(str) {
    return /[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?~]/.test(str)
}

// ----------- to check if the email is valid -----------
const inputEmail = document.getElementById("email")
const emailError = document.getElementById("emailError")
let isValidEmail = false
inputEmail.addEventListener("keyup", function () {
    if (inputEmail.value.length > 0 && !validateEmail(inputEmail.value)) {
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

// ----------- to check if the username is valid -----------
const inputUsername = document.getElementById("signup_usename")
const usernameError = document.getElementById("usernameError")
let isValidUN = false
if (inputUsername) {
    inputUsername.addEventListener("keyup", function () {
        if (inputUsername.value.length > 0 && !isValidUsername(inputUsername.value)) {
            usernameError.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>  Invalid username`
            isValidUN = false
        }
        else {
            usernameError.innerHTML = ""
            isValidUN = true
        }
    })
}
function isValidUsername(str) {
    return /[a-zA-Z0-9_]{5,10}$/.test(str) && isNaN(str)
}
