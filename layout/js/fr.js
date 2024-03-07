// confirmation message ont button
document.querySelectorAll('.confirm').forEach(function(del){
    del.onclick=()=>{
        return confirm('are you sure?');
    }
})
// show star astriksse in required fild
let inputes=document.querySelectorAll('.form input:not(input[type="submit"])');
inputes.forEach(inp =>{
    let astriksSespan=document.createElement('span');
    let spanContent=document.createTextNode('*');
    astriksSespan.appendChild(spanContent);
    astriksSespan.style.cssText="position: absolute;right:10px;top: 60%;color: #f00;";
    if(inp.hasAttribute('required')){
        inp.parentElement.appendChild(astriksSespan);
    }
})
// script to hide errors box after somme time
// let signupBtn=document.getElementById('Singup');
let box_off_errMsg=document.getElementById('the-err-msg');
let is_empty=box_off_errMsg.children;
if(is_empty.length !== 0){
    setTimeout(() => {
        box_off_errMsg.style.display='none';
    }, 6000);
}

