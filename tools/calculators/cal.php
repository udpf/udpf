<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Example title</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Keywords" content=" content key word">
<meta name="Description" content="page description">
<style>
* {
	box-sizing: border-box;
	font-family: 'Quicksand', Helvetica, Arial, sans-serif;
	font-size: 40px;
	font-weight: 300;
	margin: 0;
	padding: 0;
}
html {
	height: 100%;
}
body {
		background: url('http://agathecocco.com/js-calculator/background.jpg') no-repeat center center fixed;
	background-size: cover;
	
}
#calculator-container {
	width: 400px;
	position: relative;
	margin: 5% auto;
	box-shadow: 0px 10px 50px rgba(0, 0, 0, 0.3);
	overflow: hidden;
	height:600px;
}
#calculator {
	width: 400px;
	position: relative;
	margin: 5% auto;
	overflow: hidden;
	top:-620px;
}
#blur {
	background: url('http://agathecocco.com/js-calculator/background.jpg') no-repeat center center fixed;
	background-size: cover;
	width: 400px;
	height: 600px;
	position: relative;
	border-radius: 5px;
	-webkit-filter: blur(5px);
	-moz-filter: blur(5px);
	filter: blur(5px);
}
#color {
    background: rgba(255, 255, 255, .60);
    width: 430px;
    height: 330px;
}
.row {
	height:100px;
	line-height: 100px;
	border-bottom: 1px solid rgba(255, 255, 255, 0.3);
}
.row:last-child {
	border-bottom:none;
}
.top .input {
	width: 400px;
	padding: 0 1em;
	color: #FFF;
	text-align: right;
	letter-spacing: 1px;
}
.keys, .top {
	overflow: hidden;
	/*background: rgba(42,45,62,0.8);*/
	background: rgba(255, 255, 255, 0.1);
}
.keys span {
	float: left;
	cursor: pointer;
	width: 100px;
	height: 100px;
	line-height: 100px;
	color: #fff;
	text-align: center;
	user-select: none;
	transition: background-color 0.2s ease;
	border-right: 1px solid rgba(255, 255, 255, 0.3);
}

.keys span.operator-right {
	background: rgba(83,204,191, 0.7);
	border-right: 0;
	color: #fff;
}
.keys span.operator-right:hover {
	background: rgba(152,238,229, 0.7);
}
.keys span.operator-top {
	background: rgba(42,45,62, 0.7);
	color: #fff;
}
.keys span.operator-top:hover {
	background: rgba(76,81,112, 0.7);
}
.keys span.zero {
	width:200px;
}
.keys span:hover {
	background: rgba(255, 255, 255, 0.4);
	color: #FFF;
}
</style>
</head>
<body class="mycss-bg">

<!-- content start-->
<div id="calculator-container">
  <div id="blur"></div>
  <div id="calculator"> 
    <div class="row top">
      <div class="input"></div>
      <div class="result"></div>
    </div>
    <div class="keys">
      <div class="row">
		  <span class="operator-top" data-value="C">C</span> 
		  <span class="operator-top" data-value="+/-">+/-</span> 
		  <span class="operator-top" data-value="%">%</span> 
		  <span class="operator-right" data-value="/">&divide;</span> 
      </div>
      <div class="row">
		  <span data-value="7">7</span> 
		  <span data-value="8">8</span> 
		  <span data-value="9">9</span> 
		  <span class="operator-right" data-value="*">x</span>
      </div>
      <div class="row">
		  <span data-value="4">4</span> 
		  <span data-value="5">5</span> 
		  <span data-value="6">6</span> 
		  <span class="operator-right" data-value="-">-</span> 
      </div>
      <div class="row">
		  <span data-value="1">1</span> 
		  <span data-value="2">2</span> 
		  <span data-value="3">3</span> 
		  <span class="operator-right" data-value="+">+</span> 
      </div>
      <div class="row"> 
		  <span data-value="0" class="zero">0</span> 
		  <span data-value=".">.</span> 
		  <span class="operator-right" data-value="=">=</span> 
      </div>
    </div>
  </div>
</div>
<!-- content start End-->
</body>
</html>
<script>

var keys = document.querySelectorAll('#calculator span'); //returns a nodeList // Get all the keys from document
var operators = ['+', '-', '/', '*'];
var input = document.querySelector('.input');
var resultDisplayed, decimalAdded;
; // storing current input's last character - used later
var init = function() {
	input.innerHTML = '0';
	decimalAdded = false;
	resultDisplayed = false;
}
init();

// adding click handlers to all keys
for(var i = 0; i < keys.length; i++) {
	keys[i].onclick = function(e) {
		
		var inputVal = input.innerHTML;
		var lastChar = inputVal[inputVal.length - 1]
		var btnVal = this.getAttribute("data-value"); // Getting the input and button values 
				
		// If clear key is pressed, erase everything
		if (btnVal == 'C') {
			init();
		}
		
		// If eval key is pressed, calculate and display the result
		else if(btnVal == '=') {
							
			// Replacing all instances of x and ÷ with * and / using regex and the 'g' tag which will replace all instances of the matched character/substring
			// inputVal = inputVal.replace(/x/g, '*').replace(/÷/g, '/');
			
			// checking if the last character is an operator or decimal, and if so, remove it.
			if(operators.indexOf(lastChar) > -1 || lastChar == '.') {
				inputVal = inputVal.replace(/.$/, ''); ///.$/ targets the last character: '.' matches any character while $ denotes the end of string.
			}
		
			if(inputVal) { // avoid "undefined" if input field is empty
				input.innerHTML = eval(inputVal);
			}
			decimalAdded = false;
			resultDisplayed = true;
		}
		
		// fixing small oprator bugs
		else if(operators.indexOf(btnVal) > -1) { // Checking if an operator has been clicked (or that the value of bntVal is in the operator array)
			
			if (resultDisplayed) {
				resultDisplayed = false;
			}		
			// Only add operator if input is not empty and there is no operator at the last
			if(inputVal !== '0' && operators.indexOf(lastChar) == -1)  {
				input.innerHTML += btnVal;
			}
			// Allow minus if the string is empty
			else if(inputVal === '0' && btnVal == '-') {
				input.innerHTML = btnVal;
			}
			// Replace the last operator (if exists) with the newly pressed operator
			else if(operators.indexOf(lastChar) > -1 && inputVal.length > 1) { //checking if the last character is an operator AND if there's more than one character in the input field (avoid unintentionally replacing the minus character)
				input.innerHTML = inputVal.replace(/.$/, btnVal);//targets the last character of the strong and replaces it with the new operator 
			}
		
			decimalAdded = false;
		}
		
		// Now only the decimal problem is left. We can solve it easily using a flag 'decimalAdded' which we'll set once the decimal is added and prevent more decimals to be added once it's set. It will be reset when an operator, eval or clear key is pressed.
		else if (btnVal == '.') {
			if (resultDisplayed) {
				resultDisplayed = false;
			}	
			if (!decimalAdded) {
				input.innerHTML += btnVal;
				decimalAdded = true;
			}
		}
		else if (btnVal == '%') {
				input.innerHTML = parseFloat(inputVal * 0.01);
				decimalAdded = true;
		}
		else if (btnVal == '+/-') {
			if (input.innerHTML >0) {
				input.innerHTML = -input.innerHTML;
			}
			else {
				input.innerHTML = input.innerHTML.replace(/-/g, '');
			}
		}
		// if any other key is pressed, append the key values (btnValue) to the input string 
		else {
			
			if (input.innerHTML === '0' || resultDisplayed) {
				input.innerHTML='';
				input.innerHTML += btnVal;
				resultDisplayed = false;
			}
			else {
				input.innerHTML += btnVal;
			}
		}
		// prevent page jumps
		e.preventDefault();
	} 
}
</script>