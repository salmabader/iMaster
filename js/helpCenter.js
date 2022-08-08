
const option = document.getElementById("option")
const titleList = document.getElementById("title")
const DeleteCourse = document.getElementById("Deletecourses")
const others = document.getElementById("Other")
const toast = document.getElementById("toast")
let titlSelectOne = false
let selectOneOption = false
DeleteCourse.style.display = "none"
others.style.display = "none"

function Validate() {
    if (option.selectedIndex == 1) {

        DeleteCourse.style.display = "block"
        others.style.display = "none"
        selectOneOption = true

        if (titleList.selectedIndex != 0) {
            titlSelectOne = true
        }
    }

    if (option.selectedIndex == 2) {
        others.style.display = "block"
        DeleteCourse.style.display = "none"
        selectOneOption = true

    }
    if (option.selectedIndex == 0) {
        DeleteCourse.style.display = "none"
        others.style.display = "none"

    }

}
// ----------- activate submit button -----------
const createAccountBtn = document.getElementById("signupBtn")
const Reason = document.getElementById("Reason");
const description = document.getElementById("description");

const checkEnableButton = () => {

    if (option.selectedIndex == 1) {

        createAccountBtn.disabled = !(
            titlSelectOne && Reason.value.length != 0
        )
    }
    if (option.selectedIndex == 2) {
        createAccountBtn.disabled = !(
            description.value.length != 0
        )
    }
}

description.addEventListener('change', function () {
    checkEnableButton()
})

Reason.addEventListener('change', function () {
    checkEnableButton()
})

titleList.addEventListener('change', function () {
    localStorage.setItem("title", titleList.selectedIndex)
    checkEnableButton()
})
option.addEventListener('change', function () {

    localStorage.setItem("option ", option.selectedIndex)
    checkEnableButton()
})

window.addEventListener('load', function () {
    if (feedback.innerHTML.length > 0) {
        toast.classList.remove("opacity-0")
        toast.classList.add("opacity-100")
    }
    if (!selectOneOption[0].value && !titlSelectOne[0].value && Reason.value.length == 0 && description.value.length == 0) {
        localStorage.clear()
    }

    const selectedtitleList = localStorage.getItem("title")
    const selectedoption = localStorage.getItem("option")
    const optionsTitleList = titleList.options
    const optionsOption = option.options
    for (let i = 0; i < optionsTitleList.length; i++) {
        if (i == selectedtitleList) {
            optionsTitleList[i].selected = true
            break
        }
    }
    for (let i = 0; i < optionsOption.length; i++) {
        if (i == selectedoption) {
            optionsOption[i].selected = true
            break
        }
    }

    checkEnableButton()
})
