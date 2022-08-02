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

const chapterSection = document.getElementById("chapterSection")
const lessonSection = document.getElementById("lessonSection")
let chapterNum = 1
let lessonNum = 1

function addChapter() {
    chapterNum++
    chapterSection.innerHTML += `<div class="flex lg:flex-row flex-col w-full mt-3">
    <div class="text-lg font-bold flex items-center justify-center bg-amber-300 text-gray-800 px-2 lg:rounded-l-md lg:rounded-tr-none rounded-t-md">${chapterNum}</div>
    <div class="bg-blue-100 p-5 rounded-r-md w-full">
        <div class="flex lg:flex-row flex-col">
            <div class="flex flex-col mr-4 lg:w-1/2 w-full">
                <label for="chapterTitle${chapterNum}" class="text-md font-semibold text-gray-800 mb-2">Chapter title</label>
                <input type="text" name="chapterTitle[]" id="chapterTitle${chapterNum}" class="rounded-md border border-gray-300">
            </div>
            <div class="flex flex-col lg:w-1/2 w-full">
                <label for="lessonTitle1" class="text-md font-semibold text-gray-800 mb-2">Lesson<span id="lessonNum">#1</span> title</label>
                <input type="text" name="lessonTitle[]" id="lessonTitle1" class="rounded-md border border-gray-300">
                <div class="flex justify-end mt-1">
                    <button type="button" onclick="addLesson()" class="hover:bg-blue-300 px-2 rounded-md text-xs font-medium flex items-center duration-150 ease-in-out"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg><span>Add more lesson</span></button>
                </div>
            </div>
        </div>
    </div>
</div>`
}

function addLesson() {

}


// to active buttons
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