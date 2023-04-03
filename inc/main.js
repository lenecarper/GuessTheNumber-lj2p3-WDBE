let timeLeft = "<?php echo $time; ?>";

console.log(timeLeft);

function countdown()
{
    for (let i = 0; i > timeLeft; i++)
    {
        timeLeft--;
        document.getElementById('time-left').innerHTML = timeLeft;
        console.log('test');
    }

}

window.onload = countdown();