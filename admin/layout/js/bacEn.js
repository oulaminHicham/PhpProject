// confirmation message ont button
// document.querySelectorAll('.confirm').onclick=function(){
    
// }
//
document.querySelectorAll('.confirm').forEach(function(del){
    del.onclick=()=>{
        return confirm('are you sure?');
    }
})