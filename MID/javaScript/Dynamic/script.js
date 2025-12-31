

const dataTF=document.getElementById("data");
const dataTR=document.getElementById("value")
const btn=document.getElementById("btn");
const table=document.getElementById("tbl");

btn.addEventListener('click', addNewRow);

function addNewRow()
{
    let dataValue=dataTF.value.trim();
    let dtvalue=dataTR.value.trim();
    const row1=document.createElement("tr");
    const td1=document.createElement("td");
    const td2=document.createElement("td");
    
    td1.innerText=dataValue
    td2.innerText=dtvalue
    row1.append(td1,td2)
    table.append(row1);
  
    dataTF.value=""
    dataTR.value=""    
}