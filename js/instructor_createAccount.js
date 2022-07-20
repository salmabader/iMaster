// ----------- activate submit button -----------
const radioBtns = document.querySelectorAll('input[type="radio"]')
let selectOne = false
let isLinkFilled = false
const createAccountBtn = document.getElementById("signupBtn")
const inputFeilds = document.querySelectorAll("input");
const bio = document.getElementById("bio");
const inputLink = document.getElementById("courseLink");
const inputDegree = document.getElementById("degree");
const myField = document.getElementById("field");
radioBtns.forEach(function (btn) {
    btn.addEventListener('change', function () {
        if (btn.checked) {
            if (btn.value == 'yes') {
                inputLink.style.display = "block"
                isLinkFilled = false
            }
            if (btn.value == 'no') {
                inputLink.style.display = "none"
                isLinkFilled = true
            }
            localStorage.setItem("isThereLink", btn.value)
        }
    })
})

const checkEnableButton = () => {
    // handle the link input
    if ((radioBtns[0].checked && inputLink.value.length > 0) || radioBtns[1].checked) {
        isLinkFilled = true
    } else {
        isLinkFilled = false
    }
    if (!isLinkFilled) {
        inputLink.classList.add("border-2")
        inputLink.classList.add("border-red-500")
    } else {
        inputLink.classList.remove("border-2")
        inputLink.classList.remove("border-red-500")
    }
    // handle the select tag
    if (inputDegree.selectedIndex != 0) {
        selectOne = true
    } else {
        selectOne = false
    }
    if (myField.selectedIndex != 0) {
        selectOne = true
    } else {
        selectOne = false
    }
    createAccountBtn.disabled = !(
        inputFeilds[0].value && inputFeilds[1].value && isValidUN && isValidPass && isValidEmail && selectOne && inputFeilds[5].value && isLinkFilled && bio.value.length != 0
    )
}
inputFeilds.forEach(function (inp) {
    inp.addEventListener('change', function () {
        checkEnableButton()
    })
});
bio.addEventListener('change', function () {
    checkEnableButton()
})
inputDegree.addEventListener('change', function () {
    localStorage.setItem("degree", inputDegree.selectedIndex)
    checkEnableButton()
})
myField.addEventListener('change', function () {
    localStorage.setItem("field", myField.selectedIndex)
    checkEnableButton()
})
window.addEventListener('load', function () {
    if (!inputFeilds[0].value && !inputFeilds[1].value && !isValidUN && !isValidPass && !isValidEmail && !selectOne && !inputFeilds[5].value && !isLinkFilled && bio.value.length == 0) {
        localStorage.clear()
    }
    isValidUN = true
    isValidPass = true
    isValidEmail = true
    const selectedDegree = localStorage.getItem("degree")
    const selectedField = localStorage.getItem("field")
    const isThereCourse = localStorage.getItem("isThereLink")
    const optionsDegree = inputDegree.options
    const optionsField = myField.options
    for (let i = 0; i < optionsDegree.length; i++) {
        if (i == selectedDegree) {
            optionsDegree[i].selected = true
            break
        }
    }
    for (let i = 0; i < optionsField.length; i++) {
        if (i == selectedField) {
            optionsField[i].selected = true
            break
        }
    }
    radioBtns.forEach(function (rb) {
        if (rb.value == isThereCourse) {
            rb.checked = true
            if (rb.value == 'yes') {
                inputLink.style.display = "block"
            } else {
                inputLink.style.display = "none"
            }
        }
    })
    checkEnableButton()
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