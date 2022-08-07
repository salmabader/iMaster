let form2_inputs = document.querySelectorAll("#form2 input")
let allFilled = false
let allContent = false
let correctUsername = false

// ---------- next and back buttons ----------
const form1 = document.getElementById("form1")
const form2 = document.getElementById("form2")
const form3 = document.getElementById("form3")
const form4 = document.getElementById("form4")

const next1 = document.getElementById("next1")
const next2 = document.getElementById("next2")
const next3 = document.getElementById("next3")
const done = document.getElementById("done")

const back1 = document.getElementById("back1")
const back2 = document.getElementById("back2")
const back3 = document.getElementById("back3")

const progressBar = document.getElementById("progress")

const step2 = document.getElementById("step2")
const step3 = document.getElementById("step3")
const step4 = document.getElementById("step4")

next1.addEventListener('click', function () {
    form1.classList.add("hidden")
    form2.style.display = "block"
    progressBar.style.width = "50%"
    step2.classList.add("text-white")
})
back1.addEventListener('click', function () {
    form1.classList.remove("hidden")
    form1.classList.add("block")
    form2.style.display = "none"
    progressBar.style.width = "20%"
    step2.classList.remove("text-white")
})

next2.addEventListener('click', function () {
    form2.style.display = "none"
    form3.style.display = "block"
    progressBar.style.width = "75%"
    step3.classList.add("text-white")
})
back2.addEventListener('click', function () {
    form2.style.display = "block"
    form3.style.display = "none"
    progressBar.style.width = "50%"
    step3.classList.remove("text-white")
})

next3.addEventListener('click', function () {
    form3.style.display = "none"
    form4.style.display = "block"
    progressBar.style.width = "100%"
    step4.classList.add("text-white")
})
back3.addEventListener('click', function () {
    form3.style.display = "block"
    form4.style.display = "none"
    progressBar.style.width = "75%"
    step4.classList.remove("text-white")
})

// ---------- form2 buttons: add/remove chapter & lesson ----------
const chapterSection = document.getElementById("chapterSection")
let chapterNum = 1
let lessonNum = 1

function addChapter() {
    chapterNum++
    let newChapter = document.createElement("div")
    newChapter.classList.add("flex", "lg:flex-row", "flex-col", "w-full", "mt-3")
    newChapter.innerHTML = `
<div class="chapterN text-lg font-bold flex items-center justify-center bg-amber-300 text-gray-800 px-2 lg:rounded-l-md lg:rounded-tr-none rounded-t-md">${chapterNum}</div>
<div class="bg-blue-100 p-5 lg:rounded-r-md lg:rounded-bl-none rounded-b-md w-full">
    <div class="flex lg:flex-row flex-col">
    <div class="flex flex-col mr-4 lg:w-1/2 w-full">
    <label class="text-md font-semibold text-gray-800 mb-2">Chapter title</label>
    <input type="text" name="chapterTitle[]" onkeyup="checkValue()" class="rounded-md border border-gray-300">
    <div class="flex justify-end items-center mt-1">
        <button type="button" onclick="deleteChapter(this)" class="delete flex items-center text-xs font-medium px-2 hover:bg-red-500 hover:text-white rounded-md duration-200"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg><span>Delete chapter</span></button>
    </div>
</div>
        <div class="flex flex-col lg:w-1/2 w-full">
        <div id="lessonSection" class="flex flex-col">
            <label class="text-md font-semibold text-gray-800 mb-2">Lesson titles</label>
            <input lesson-input type="text" name="lessonTitle_${chapterNum}[]" onkeyup="checkValue()" class="lessonTitle rounded-md border border-gray-300 w-full">
        </div>
            <div class="flex justify-end mt-1">
                <button type="button" onclick="addLesson(this)" class="hover:bg-blue-300 px-2 rounded-md text-xs font-medium flex items-center duration-150 ease-in-out"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg><span>Add more lesson</span></button>
            </div>
        </div>
    </div>
</div>`
    chapterSection.appendChild(newChapter)
    form2_inputs = document.querySelectorAll("#form2 input")
    checkValue()
}

function addLesson(e) {
    let newLesson = document.createElement("div")
    newLesson.classList.add("flex", "items-center", "w-full", "mt-2")
    newLesson.innerHTML = `<input type="text" lesson-input name="lessonTitle_${chapterNum}[]" onkeyup="checkValue()" class="lessonTitle rounded-md border border-gray-300 w-full">
    <button type="button" onclick="deleteLesson(this)"><svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 inline text-red-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg></button>`
    e.parentElement.parentElement.children[0].appendChild(newLesson)
    form2_inputs = document.querySelectorAll("#form2 input")
    checkValue()
}
function deleteLesson(e) {
    e.parentElement.remove()
    form2_inputs = document.querySelectorAll("#form2 input")
    checkValue()
}

function deleteChapter(el) {
    chapterNum--
    el.parentElement.parentElement.parentElement.parentElement.parentElement.remove()
    form2_inputs = document.querySelectorAll("#form2 input")
    renumberChapter()
    renumberLessons()
    checkValue()
}
function renumberChapter() {
    const chapter = document.querySelectorAll(".chapterN")
    let n = 1
    chapter.forEach(element => {
        if (window.getComputedStyle(element.parentElement).display != "none") {
            element.textContent = n
            n++
        }
    });
}
function renumberLessons() {
    const allLessons = document.querySelectorAll("[lesson-input]")
    let ch = 1
    let temp = ""
    for (let i = 0; i < allLessons.length - 1; i++) {
        let name1 = allLessons[i].getAttribute("name")
        temp = name1
        let name2 = allLessons[i + 1].getAttribute("name")
        if (temp == name2) {
            allLessons[i].setAttribute("name", "lessonTitle_" + ch + "[]")
        } else {
            ch++
        }
        if (ch > chapterNum) break
    }
    allLessons[allLessons.length - 1].setAttribute("name", "lessonTitle_" + ch + "[]")
}
// ---------- after click next2 button ----------
const list = document.getElementById("items")
next2.addEventListener('click', function () {
    const allChapters = document.getElementsByName("chapterTitle[]")
    let chaptersTitle = []
    allChapters.forEach(element => {
        chaptersTitle.push(element.value)
    });
    let lessonsTitle = []
    const allChapterCards = document.getElementById("chapterSection").children
    for (let i = 0; i < allChapterCards.length; i++) {
        let chapterLesson = allChapterCards[i].getElementsByClassName("lessonTitle")
        let lessons = []
        for (let j = 0; j < chapterLesson.length; j++) {
            lessons.push(chapterLesson[j].value)
        }
        lessonsTitle.push(lessons)
    }
    localStorage.setItem("chapters", JSON.stringify(chaptersTitle))
    localStorage.setItem("lessons", JSON.stringify(lessonsTitle))

    let chapters = JSON.parse(localStorage.getItem("chapters"))
    let lessons = JSON.parse(localStorage.getItem("lessons"))
    let rows = ""
    for (let i = 0; i < chapters.length; i++) {
        let les = ""
        let chapterLesson = lessons[i]
        rows += `<details class="w-full cursor-pointer mb-3 bg-blue-50 px-3 py-1 border rounded-md border-gray-300">        
        <summary class="font-medium text-lg text-blue-800">${chapters[i]}</summary>`
        for (let j = 0; j < chapterLesson.length; j++) {
            if (j == chapterLesson.length - 1) {
                les += `<details class="ml-3 w-[97%] flex justify-start items-center my-2 pb-1"><summary>${chapterLesson[j]}</summary>
                <div class="ml-3 flex flex-col">
                <div>
                <label class="text-md font-semibold text-gray-800 mb-2">Lesson video</label>
                <input name="contentVideo[]" class="block mb-5 w-full text-xs text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" onchange="activeNext3()">
                </div>
                <div>
                <label class="text-md font-semibold text-gray-800 mb-2">Description</label>
                <textarea name="contentDescription[]" class="w-full rounded-md border border-gray-300 p-3"></textarea>
                </div>
                </div>
                </details>`
            } else {
                les += `<details class="border-b border-gray-300 ml-3 w-[97%] flex justify-start items-center my-2 pb-1"><summary>${chapterLesson[j]}</summary>
                <div class="ml-3 flex flex-col">
                <div>
                <label for="image" class="text-md font-semibold text-gray-800 mb-2">Lesson video</label>
                <input id="image" name="video" class="block mb-5 w-full text-xs text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" onchange="activeNext3()">
                </div>
                <div>
                <label for="description" class="text-md font-semibold text-gray-800 mb-2">Description</label>
                <textarea name="contentDescription[]" id="description" class="w-full rounded-md border border-gray-300 p-3"></textarea>
                </div>
                </div>
                </details>`
            }
        }
        rows += les + `</details>`
    }
    list.innerHTML = rows
    activeNext3()
})

// ---------- activate next1 button ----------
const title = document.getElementById("courseTitle")
const category = document.getElementById("category")
const objective = document.getElementById("objectives")
const requirement = document.getElementById("requirement")
const level = document.getElementById("level")
const form1_inputs = [title, objective, requirement]
const form1_lists = [category, level]

form1_inputs.forEach(element => {
    element.addEventListener('keyup', function () {
        activeNext1()
    })
});
form1_lists.forEach(element => {
    element.addEventListener('change', function () {
        activeNext1()
    })
});

function activeNext1() {
    next1.disabled = !(title.value && category.selectedIndex != 0 && objective.value && requirement.value && level.selectedIndex != 0)
}

// ---------- activate next2 button ----------
function checkValue() {
    for (let i = 0; i < form2_inputs.length; i++) {
        if (form2_inputs[i].value) {
            allFilled = true
        } else {
            allFilled = false
            break
        }
    }
    next2.disabled = !allFilled
}
// ---------- activate next3 button ----------
function activeNext3() {
    const step3_inputs = document.querySelectorAll("#form3 input[type=file]")
    for (let i = 0; i < step3_inputs.length; i++) {
        if (step3_inputs[i].value) {
            allContent = true
        } else {
            allContent = false
            break
        }
    }
    next3.disabled = !allContent
}
// ---------- activate done button ----------
const description = document.getElementById("description")
const image = document.getElementById("image")
const collaborator = document.querySelectorAll('input[type="radio"]')
const co = document.getElementById("collaborator")
const coUsername = document.getElementById("coUsername")
const form4_inputs = [description, coUsername]
let checked = ""
let isThereCo = false

form4_inputs.forEach(element => {
    element.addEventListener('keyup', function () {
        activeDone()
    })
})

collaborator.forEach(element => {
    element.addEventListener('change', function () {
        if (element.checked) {
            if (element.value == 'yes') {
                co.style.display = "block"
                checked = "yes"
            } else {
                co.style.display = "none"
                checked = "no"
            }
        }
        activeDone()
    })
})
image.addEventListener('change', function () {
    activeDone()
})

function activeDone() {
    if (checked == "yes" && !coUsername.value) {
        isThereCo = false
    } else if (checked == "yes" && coUsername.value) {
        isThereCo = true
    } else if (checked == "no") {
        isThereCo = true
        correctUsername = true
    } else {
        isThereCo = false
    }
    done.disabled = !(description.value && image.value && isThereCo && correctUsername)
}
done.addEventListener('click', function () {
    localStorage.clear()
})

// ---------- to check if the collaborator username exist ----------
let wrongUsername = document.getElementById("wrongUsername")
function checkUsername(arr_username) {
    if (arr_username.includes(coUsername.value.toLowerCase())) {
        correctUsername = true
        wrongUsername.classList.add("hidden")
    } else if (coUsername.value == "") {
        wrongUsername.classList.add("hidden")

    } else {
        correctUsername = false
        wrongUsername.classList.remove("hidden")
    }
    activeDone()
}

// ---------- to show toast msg ----------
const toast = document.getElementById("course-submitted")
const msg = document.getElementById("submittingMsg")
window.addEventListener('load', function () {
    if (msg.innerHTML.length > 0) {
        toast.classList.remove("opacity-0")
        toast.classList.add("opacity-100")
    }
})