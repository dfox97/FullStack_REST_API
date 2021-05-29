
//When button is presset display the get request data
function displayData() {
    /* This is your input, but you shoud use another Id for your fields. */
    var textValue = document.getElementById('input').value;
    //trying to fix weird error with button on click for blank input, if input is blank it would duplicate my html.
    if (!textValue.includes(".ac.uk")){
        var textValue = 0;
    }
    /* Change the inner HTML of your div. */
    var requestVal = document.getElementById('requestval').value;
    var xhttp = new XMLHttpRequest(); 
  
    xhttp.open(requestVal, textValue, true);
    xhttp.onload=function(){
        if(this.status==200 && requestVal=="GET" || requestVal=="POST"){
            try {
                var str = JSON.stringify(this.responseText)
                var data=JSON.parse(str)
                console.log(data);//this works in console terminal 
                document.getElementById('Response').innerHTML=data;
            //This part doesnt work because i have an array inside an array or soemthign
            } catch (error) {
                document.getElementById('Response').innerHTML="Error";
            }
            
        }
        
        else{
            //this probs not correct
            alert("URL not supported: Try https://student.csc.liv.ac.uk/~sgdfox/v1/read");
        }
        
    }
    xhttp.send();  
}
//When reset button pressed clear the response field.
function setData(){
    document.getElementById('Response').innerHTML="Response Here";
} 

