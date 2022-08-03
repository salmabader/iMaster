let form2_inputs = document.querySelectorAll("#form2 input")
let allFilled = false

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
            <input type="text" name="lessonTitle[]" onkeyup="checkValue()" class="rounded-md border border-gray-300 w-full">
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
    newLesson.innerHTML = `<input type="text" name="lessonTitle[]" onkeyup="checkValue()" class="rounded-md border border-gray-300 w-full">
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
// ---------- after click next2 button ----------
next2.addEventListener('click', function () {
    const allChapters = document.getElementsByName("chapterTitle[]")
    let chaptersTitle = []
    allChapters.forEach(element => {
        chaptersTitle.push(element.value)
    });
    let lessonsTitle = []
    const allChapterCards = document.getElementById("chapterSection").children
    console.log(allChapterCards)
    for (let i = 0; i < allChapterCards.length; i++) {
        let chapterLesson = allChapterCards[i].getElementsByTagNameNS("lessonTitle[]")
        let lessons = []
        for (let j = 0; j < chapterLesson.length; j++) {
            lessons.push(chapterLesson[j].value)
        }
        lessonsTitle.push(lessons)
    }
    console.log(chaptersTitle)
    console.log(lessonsTitle)
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
// ---------- activate done button ----------
const description = document.getElementById("description")
const image = document.getElementById("image")
const collaborator = document.querySelectorAll('input[type="radio"]')
const co = document.getElementById("collaborator")
const coUsername = document.getElementById("coUsername")
const form4_inputs = [description, coUsername]
let checked = ""
let isThereCo = true

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
    } else {
        isThereCo = true
    }
    done.disabled = !(description.value && image.value && isThereCo)
}