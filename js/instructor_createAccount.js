// ----------- activate submit button -----------
const radioBtns = document.querySelectorAll('input[type="radio"]')
let checkedOne = false
let isLinkFilled = false
const createAccountBtn = document.getElementById("signupBtn")
const inputFeilds = document.querySelectorAll("input");
const bio = document.getElementById("bio");
const inputLink = document.getElementById("courseLink");
radioBtns.forEach(function (btn) {
    btn.addEventListener('change', function () {
        checkedOne = Array.prototype.slice.call(radioBtns).some(x => x.checked)
        if (btn.checked && btn.value == 'yes') {
            inputLink.style.display = "block"
            isLinkFilled = false
        }
        if (btn.checked && btn.value == 'no') {
            console.log('Im here')
            inputLink.style.display = "none"
            isLinkFilled = true
        }
    })
})
// فيه مشكلة انو لازم اضيف لسنر على التكت ايريا
const checkEnableButton = () => {
    createAccountBtn.disabled = !(
        inputFeilds[0].value && inputFeilds[1].value && isValidUN && isValidPass && isValidEmail && checkedOne && bio.value.length != 0 && isLinkFilled
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