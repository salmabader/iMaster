// ----------- activate submit button -----------
const radioBtns = document.querySelectorAll('input[type="radio"]')
let checkedOne = false
let selectOne = false
let isLinkFilled = false
const createAccountBtn = document.getElementById("signupBtn")
const inputFeilds = document.querySelectorAll("input");
const bio = document.getElementById("bio");
const inputLink = document.getElementById("courseLink");
const inputDegree = document.getElementById("degree");
radioBtns.forEach(function (btn) {
    btn.addEventListener('change', function () {
        checkedOne = Array.prototype.slice.call(radioBtns).some(x => x.checked)
        if (btn.checked && btn.value == 'yes') {
            inputLink.style.display = "block"
            isLinkFilled = false
        }
        if (btn.checked && btn.value == 'no') {
            inputLink.style.display = "none"
            isLinkFilled = true
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
    createAccountBtn.disabled = !(
        inputFeilds[0].value && inputFeilds[1].value && isValidUN && isValidPass && isValidEmail && checkedOne && selectOne && isLinkFilled && bio.value.length != 0
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
    checkEnableButton()
})
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