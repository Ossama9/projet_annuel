const inputs = document.querySelectorAll(".input");
const form = document.querySelectorAll(".form-control");

console.log(form)
function addcl(){
    let parent = this.parentNode.parentNode;
    parent.classList.add("focus");
}

function remcl(){
    let parent = this.parentNode.parentNode;
    if(this.value == ""){
        parent.classList.remove("focus");
    }
}


inputs.forEach(input => {
    input.addEventListener("focus", addcl);
    input.addEventListener("blur", remcl);
});

form.forEach(input => {
    input.addEventListener("focus", addclform);
    input.addEventListener("blur", remclform);
});
function addclform(){
    let parent = this.parentNode.parentNode.parentNode;;
    parent.classList.add("focus");
}

function remclform(){
    let parent = this.parentNode.parentNode.parentNode;
    if(this.value == ""){
        parent.classList.remove("focus");
    }
}