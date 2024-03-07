// confirmation message ont button
// document.querySelectorAll('.confirm').onclick=function(){
    
// }
//
document.querySelectorAll('.confirm').forEach(function(del){
    del.onclick=()=>{
        return confirm('are you sure?');
    }
})
// categorie view option
let title=document.querySelectorAll('.cat h4');
let divs=document.querySelectorAll('.full-view');
title.forEach((ele)=>{
    ele.style.cursor='pointer';
    ele.addEventListener('click',()=>{
        ele.nextElementSibling.style.display='none';
    })
    ele.addEventListener('dblclick',()=>{
        ele.nextElementSibling.style.display='block';
    })
})


