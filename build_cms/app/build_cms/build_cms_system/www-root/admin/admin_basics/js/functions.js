/* ============================== Pick a random number ============================== */
    function randomNumber(num1, num2) {
        var randomNum = Math.floor( Math.random() * (num2 - num1) ) + num1;

        if (randomNum === num1) {
            randomNum = randomNum + 1;
        }
        
        return randomNum;
    }
/* ============================== /Pick a random number ============================== */


/* ============================== warning message ============================== */
    function warning_message(sum_message, confirm_message) {
        var number1 = randomNumber(0, 6);
        var number2 = randomNumber(0, 6);

        var sumAnswers = number1 + number2;
        var deleteSum = parseInt( prompt(sum_message + " " + number1 + " + " + number2 + " =") );

        // sum message
        if (deleteSum !== sumAnswers) {
            return true;
        }

        // confirm message
        if (!confirm(confirm_message)) {
            return true;
        }
    }
/* ============================== /warning message ============================== */