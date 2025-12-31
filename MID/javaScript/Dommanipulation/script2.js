const body=document.body;

const div1=document.createElement("div");
div1.innerText="Hello World!!";
div1.setAttribute("id","div1");
div1.setAttribute("class", "myClass");
div1.setAttribute("name", "myClass");

div1.style.backgroundColor="gray";
div1.style.color="black";
div1.style.display="inline";
body.appendChild(div1);

const p1=document.createElement("p")

p1.id="p1";
p1.className="para";
p1.innerText="This is paragraph";
div1.append(p1);

const p2=document.createElement("P");
p2.id="p2"
p2.className="para"
p2.innerText="This is second paragraph"
p2.style.color="blue"
div1.append(p2)

const h1=document.createElement("h1");
h1.id="h1t";
h1.innerText="This is h1";
div1.append(h1)

const h2=document.createElement("h2")
h2.id="h2T";
h2.innerText="this is h2";
//h2.style.display="inline";
div1.insertBefore(h2, p2);

const sp1=document.createElement("span")
sp1.innerHTML="this si span";
sp1.id="sp1"
sp1.style.display="block"
div1.replaceChild(sp1,p1)

const sp2=document.createElement("span");
sp2.id="sp2";
sp2.style.display="block";
sp2.innerText="span2";
div1.insertAdjacentElement('BeforeBegin',sp2);

// div1.removeChild(p2);
h2.remove();


sp1.innerText="meow meow meow";

const btn1=document.createElement("button");
btn1.id="btn1"
btn1.innerText="Click Me"
body.append(btn1)

btn1.addEventListener("click",say);

function say(){
    // alert("Meow meow")
    window.location.href="https://google.com"
}

btn1.addEventListener("mouseover", mouseOver)

function mouseOver(){
    btn1.style.backgroundColor="green";
}

btn1.addEventListener('mouseout',mouseOut)
function mouseOut(){
    btn1.style.backgroundColor="white"
}

div1.addEventListener('mouseover', mouseOverDiv);

function mouseOverDiv()
{
    div1.style.backgroundColor="green";
}

div1.addEventListener('mouseout', mouseoutDiv);

function mouseoutDiv()
{
    div1.style.backgroundColor="white";
}

