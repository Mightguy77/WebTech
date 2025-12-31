const div1=document.getElementById("div1");
div1.style.backgroundColor="red"

const d=Array.from(document.getElementsByClassName("d"))

// for(let x of d){
//     x.style.backgroundColor="green"
// }
d.forEach(x=>
{
    x.style.backgroundColor="orange"
}
)

// const elems = document.getElementsByClassName("d");
// elems[0].style.backgroundColor = "green";
// elems[1].style.backgroundColor = "green";
// for (let x of elems) {
    
// }


let d3=document.getElementsByName("d3")
console.log("Name")
console.log(d3)
console.log("heelo")

d3.forEach(x=>
{
    x.style.display="inline"
    x.style.backgroundColor="rgba(105, 199, 231, 1)"
}
)
// let element3=document.querySelector("#div1");
// element3.style.display="inline";

// let elementArray3=document.querySelectorAll(".d");
// elementArray3.forEach(x=>
// {
//     x.style.display="inline"
//     x.style.backgroundColor="red"
// }
// )





