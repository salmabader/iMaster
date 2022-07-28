// ---------- general variables ----------
const minimize = document.getElementById("minimizeBtn")
const leftSide = document.getElementById("leftSide")
const rightSide = document.getElementById("rightSide")
const cards = document.getElementById("fourCards")
let leftClasses = ""
// ---------- logo variables ----------
const logo = document.getElementById("logo")
// ---------- options variables ----------
const hideAll = document.querySelectorAll(".toHide")
const optionContainer = document.getElementById("optionsDiv")
const icons = document.querySelectorAll(".optionIcons")
// ---------- sign out variables ----------
const signOutBtn = document.getElementById("signoutBtn")
// ---------- handling ----------
minimize.addEventListener('click', function () {
    leftClasses = leftSide.className.split(' ')
    // minimize
    if (leftClasses.includes("lg:w-1/5")) {
        // width
        leftSide.classList.remove("lg:w-1/5")
        leftSide.classList.add("lg:w-fit")
        rightSide.classList.remove("lg:w-4/5")

        // logo
        logo.setAttribute("src", "images/icon.svg")
        logo.classList.add("mx-3")

        optionContainer.classList.add("items-center")
        icons.forEach(function (el) {
            el.classList.remove("mr-4")
            el.classList.remove("h-5")
            el.classList.add("h-7")
        })

        // signout btn
        signOutBtn.classList.add("px-3")
        signOutBtn.classList.remove("px-8")

        // options
        hideAll.forEach(function (el) {
            el.classList.add("hidden")
        })

        cards.classList.remove("mr-3")

    } else { // expand
        // width
        leftSide.classList.remove("lg:w-fit")
        leftSide.classList.add("lg:w-1/5")
        rightSide.classList.add("lg:w-4/5")

        // logo
        logo.setAttribute("src", "images/logo.svg")
        logo.classList.remove("mx-3")

        optionContainer.classList.add("items-center")
        optionContainer.classList.remove("items-center")
        icons.forEach(function (el) {
            el.classList.add("mr-4")
            el.classList.add("h-5")
            el.classList.remove("h-7")
        })

        // signout btn
        signOutBtn.classList.remove("px-3")
        signOutBtn.classList.add("px-8")
        document.getElementById("signOutTtitle").classList.add("inline")

        // options
        hideAll.forEach(function (el) {
            el.classList.remove("hidden")
            el.classList.add("block")
        })

        cards.classList.add("mr-5")
    }
})