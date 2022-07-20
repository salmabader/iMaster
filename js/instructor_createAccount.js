// ----------- check if one radio is selected -----------
const radioBtns = document.querySelectorAll('input[type="radio"]')
let checkedOne = false

// ----------- activate submit button -----------
const createAccountBtn = document.getElementById("signupBtn")
const inputFeilds = document.querySelectorAll("input");
const inputLink = document.getElementById("courseLink");
radioBtns.forEach(function (btn) {
    btn.addEventListener('change', function () {
        if (btn.checked && btn.value == 'yes') {
            inputLink.style.display = "block"
        }
        else {
            inputLink.style.display = "none"
        }
        checkedOne = Array.prototype.slice.call(radioBtns).some(x => x.checked)
    })
})
const checkEnableButton = () => {
    console.log(inputFeilds[0].value)
    console.log(inputFeilds[1].value)
    console.log(isValidPass)
    console.log(isValidUN)
    console.log(isValidEmail)
    console.log(checkedOne)
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