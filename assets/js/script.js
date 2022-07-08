// <textarea>のheightの自動調整
document.querySelectorAll(".auto-adjust").forEach(function(){
  this.addEventListener('input',function(e){
    e.srcElement.style.height = 0;
    e.srcElement.style.height = e.srcElement.scrollHeight+"px";
  })
})
