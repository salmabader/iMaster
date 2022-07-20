// ----------- to check if there is one checkbox selected -----------
const signupBtn = document.getElementById("signupBtn")
const hint = document.getElementById("hint")
const checkboxes = document.querySelectorAll('input[type="checkbox"]')
let checkedOne = false
let allChecked = []
let interestValue = ""
// Use Array.forEach to add an event listener to each checkbox.
checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        interestValue = checkbox.value
        checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked)
        if (!checkedOne) {
            hint.textContent = "please choose at least one"
        } else {
            hint.innerHTML = ""
        }
        // in case already check but the page is reload due to php
        if (checkbox.checked) {
            allChecked.push(interestValue)
        } else {
            let i = allChecked.indexOf(interestValue)
            if (i == 0) {
                allChecked.shift()
            } else {
                allChecked.splice(i, i)
            }
        }
        localStorage.setItem("interests", JSON.stringify(allChecked))
    })
});

// ----------- activate submit button -----------
const createAccountBtn = document.getElementById("signupBtn")
const inputFeilds = document.querySelectorAll("input");
const checkEnableButton = () => {
    createAccountBtn.disabled = !(
        inputFeilds[0].value && inputFeilds[1].value && isValidUN && isValidPass && isValidEmail && checkedOne
    )
}
inputFeilds.forEach(function (inp) {
    inp.addEventListener('change', function () {
        checkEnableButton()
    })
});
window.addEventListener('load', function () {
    if (inputFeilds[0].value.length == 0 && inputFeilds[1].value.length == 0 && !isValidUN && !isValidPass && !isValidEmail && !checkedOne) {
        localStorage.clear()
    }
    isValidUN = true
    isValidPass = true
    isValidEmail = true
    const checkedInterests = JSON.parse(localStorage.getItem("interests"))
    if (checkedInterests) {
        if (checkedInterests.length > 0) {
            hint.innerHTML = ""
            checkedInterests.forEach(el => {
                allChecked.push(el)
            });
            checkboxes.forEach(box => {
                if (allChecked.includes(box.value)) {
                    box.checked = true
                }
            });
            localStorage.setItem("interests", JSON.stringify(allChecked))
            checkedOne = true
            checkEnableButton()
        }
    }
})