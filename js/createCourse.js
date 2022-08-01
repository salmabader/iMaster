const form1 = document.getElementById("form1")
const form2 = document.getElementById("form2")
const form3 = document.getElementById("form3")
const form4 = document.getElementById("form4")

const next1 = document.getElementById("next1")
const next2 = document.getElementById("next2")
const next3 = document.getElementById("next3")

const back1 = document.getElementById("back1")
const back2 = document.getElementById("back2")
const back3 = document.getElementById("back3")

const progressBar = document.getElementById("progress")

const step2 = document.getElementById("step2")
const step3 = document.getElementById("step3")
const step4 = document.getElementById("step4")

next1.addEventListener('click', function () {
    form1.style.left = "-1500px"
    form2.style.left = "149px"
    progressBar.style.width = "600px"
    step2.classList.add("text-white")
})
back1.addEventListener('click', function () {
    form1.style.left = "149px"
    form2.style.left = "1500px"
    progressBar.style.width = "250px"
    step2.classList.remove("text-white")
})

next2.addEventListener('click', function () {
    form2.style.left = "-1500px"
    form3.style.left = "149px"
    progressBar.style.width = "1000px"
    step3.classList.add("text-white")
})
back2.addEventListener('click', function () {
    form2.style.left = "149px"
    form3.style.left = "1500px"
    progressBar.style.width = "600px"
    step3.classList.remove("text-white")
})

next3.addEventListener('click', function () {
    form3.style.left = "-1500px"
    form4.style.left = "149px"
    progressBar.style.width = "1500px"
    step4.classList.add("text-white")
})
back3.addEventListener('click', function () {
    form3.style.left = "149px"
    form4.style.left = "1500px"
    progressBar.style.width = "1000px"
    step4.classList.remove("text-white")
})