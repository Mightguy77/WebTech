let a=10;
console.log(a);
b=a+10;
console.log(b)
console.log(a++)
console.log(typeof a)
console.log("---------------Arithmathic--------------------------")
let val1=20;
let val2="20";
b=val1+val2;
console.log(typeof b)
//Arithmatic ops.
console.log(val1-val2);
console.log(val1+val2);
console.log(val1/val2);
console.log(val1*val2);
console.log(val1%val2);
console.log(val1**val2);

//compare value
console.log(val1==val2);

//compare value and type
console.log(val1===val2);

console.log("<<<<<<<<<<<<<<<<<<<Flow control>>>>>>>>>>>>>>>>")

let country="Aus";
let state="NY";

if(country=="Aus")
{
    if(state=="DC")
    {
        console.log("Are you D. Trump??");
    }
    else if(state=="NY"){
        console.log("Hello world")
    }
    else
    {
        console.log("are you meow?");
    }
}

else if(country=="Aus")
{
    console.log("FakiBaj");
}

else
{
    console.log("meow");
}


a=99;
b=67;
(a>b)? console.log(a):console.log(b)

console.log("<<<<<<<<<<<<<<LOOP>>>>>>>>>>>>>>>>>")

for(let i=1;i<6;i++)
{
    console.log(i);
}

let valNum=100;

do{
    console.log(valNum);
    valNum++;
}while(valNum<10)

while(valNum<100)
{
    console.log(valNum);
    valNum++;
}

console.log("<<<<<<<<<<<<<<Array>>>>>>>>>>>>>>>>>")

let fruits=["Jambura","PineApple","Mango","Kola","Banggi"]
console.log(fruits[3])
fruits[7]="gggg";
console.log(fruits.length)
console.log(fruits)

console.log("------------Main array--------------")
fruits.forEach(x=>
{
    console.log(x)
}
)

console.log("------------After push--------------")
fruits.push("watermilon")
fruits.forEach(x=>
{
    console.log(x)
}
)

console.log("------------After unshisft--------------")
// at the beggining item will add
fruits.unshift("Orange");
fruits.forEach(x=>
{
    console.log(x)
}
)

console.log("------------After pop--------------")
// last item will be removed
fruits.pop();
fruits.pop();
fruits.forEach(x=>
{
    console.log(x)
}
)

console.log("------------After shift--------------")
// first item will be removed
fruits.shift();
fruits.forEach(x=>
{
    console.log(x)
}
)

console.log("------------After push--------------")

fruits.push("Mango");

fruits.forEach(x=>
{
    console.log(x)
}
)


console.log("------------index --------------")

console.log(fruits.indexOf("mango"));
console.log(fruits.indexOf("Mango"));

console.log(fruits.includes("Mango"));
console.log(fruits.includes("mango"));

console.log("------------slice --------------")
let newArray=fruits.slice(0,3)
console.log(newArray)
console.log(newArray.reverse())
console.log(newArray.sort())


console.log("------------operator --------------")
console.log(isNaN(11));
let x="10abc";
let y=20;

console.log(x+y)
console.log(x-y)
console.log(x*y)
console.log(x/y)
console.log(x**y)
console.log()

console.log("------------operator --------------")

let f="10"
let g=20;

console.log(f+g)
console.log(f-g)
console.log(f*g)
console.log(f/g)
console.log(f**g)

console.log("------------String --------------")
let str= "Bangladesh i is a A Bangladesh country";

console.log(str)
console.log(str.length)
console.log(str.toUpperCase())
console.log(str.toLowerCase())
console.log(str)
console.log(str.indexOf("i"))
console.log(str.indexOf("is"))
console.log(str.indexOf("anglades"))
console.log(str.lastIndexOf("i"))
console.log(str.includes("India"))
console.log(str.includes("Bangla"))
console.log(str.replace("Bangladesh"))
console.log(str.replace("Bangladesh","India"))
console.log(str.replace("Bangladesh","India"))
console.log(str.replaceAll("Bangladesh","India"))
console.log(str.startsWith("Ban"))
console.log(str.endsWith("country"))

console.log("------------String delimeter--------------")
let str2="Meow, cat, bird";
console.log(str2.split(","))
console.log(str2.charAt(0))

console.log("------------String strim--------------")
str3=" Meow ";
console.log(str3)
console.log(str3.trim())
console.log(str3.concat("cat"))

console.log(typeof undefined);

function sayMyName(){
    console.log('faysal khan')
}
sayMyName()

function sayMyName(name){
    console.log(name)
    console.log('faysal khan')

}
sayMyName("Hello")

array=[1,2,4,5,6];
console.log(array.length)

function arrayOp(arr){
    for(i=0;i<arr.length;i++){
        array[i]+=5;
    }
    return arr;
}

array2=arrayOp(array)
console.log(array2)
console.log(typeof arrayOp)