/* Client-side search inside the current CMS document, no API requests. */
(() => {
 "use strict";
 if (!document.body.classList.contains("arah-cms")) return;
 const content=document.getElementById("arah-document-content"),
 input=document.querySelector("[data-legal-search]"),
 clear=document.querySelector("[data-legal-clear]"),
 nav=document.querySelector("[data-legal-navigation]"),
 count=document.querySelector("[data-legal-count]"),
 prev=document.querySelector("[data-legal-prev]"),
 next=document.querySelector("[data-legal-next]");
 if (![content,input,clear,nav,count,prev,next].every(Boolean)) return;
 let marks=[],index=-1;
 function reset() {
  const parents=new Set();
  content.querySelectorAll("mark.arah-legal-mark").forEach(mark=>{
   const parent=mark.parentNode;
   if (!parent) return;
   mark.replaceWith(document.createTextNode(mark.textContent||""));
   parents.add(parent);
  });
  parents.forEach(parent=>parent.normalize());
  marks=[];index=-1;
 }
 function refresh(scroll) {
  marks.forEach((mark,i)=>mark.classList.toggle("is-active",i===index));
  count.textContent=index>=0?String(index+1)+" / "+String(marks.length):
    input.value.trim()?(count.dataset.noMatch||"No matches"):"";
  prev.disabled=!marks.length;next.disabled=!marks.length;
  if (scroll && index>=0) marks[index].scrollIntoView({
   behavior:window.matchMedia("(prefers-reduced-motion: reduce)").matches?"auto":"smooth",
   block:"center"
  });
 }
 function search() {
  reset();
  const query=input.value.trim();
  clear.hidden=!query;nav.hidden=!query;
  if (!query){refresh(false);return;}
  const walker=document.createTreeWalker(content,NodeFilter.SHOW_TEXT),nodes=[];
  while (walker.nextNode()) {
   const node=walker.currentNode;
   if (node.nodeValue?.trim() && !node.parentElement?.closest(
     "script,style,noscript,textarea,svg,button,[contenteditable],[aria-hidden='true']"
   )) nodes.push(node);
  }
  const needle=query.toLowerCase();
  for (const node of nodes) {
   if (marks.length>=400) break;
   const source=node.nodeValue,lower=source.toLowerCase();
   const fragment=document.createDocumentFragment();
   let at,offset=0,matched=false;
   while ((at=lower.indexOf(needle,offset))>=0 && marks.length<400) {
    matched=true;
    if (at>offset) fragment.appendChild(document.createTextNode(source.slice(offset,at)));
    const mark=document.createElement("mark");
    mark.className="arah-legal-mark";
    mark.textContent=source.slice(at,at+query.length);
    fragment.appendChild(mark);marks.push(mark);offset=at+query.length;
   }
   if (matched) {
    if (offset<source.length) fragment.appendChild(document.createTextNode(source.slice(offset)));
    node.replaceWith(fragment);
   }
  }
  index=marks.length?0:-1;refresh(false);
 }
 function jump(direction) {
  if (!marks.length)return;
  index=(index+direction+marks.length)%marks.length;refresh(true);
 }
 input.addEventListener("input",search);
 clear.addEventListener("click",()=>{input.value="";search();input.focus();});
 prev.addEventListener("click",()=>jump(-1));
 next.addEventListener("click",()=>jump(1));
 input.addEventListener("keydown",event=>{
  if (event.key==="Escape" && input.value){event.preventDefault();clear.click();}
  else if (event.key==="Enter"){event.preventDefault();jump(event.shiftKey?-1:1);}
 });
})();