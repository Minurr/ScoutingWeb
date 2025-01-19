const buttons = document.querySelectorAll('s-button');

buttons.forEach(button => {
    button.onclick = function () {
        const buttonId = button.id;

        if (buttonId === 'button1') {
            window.location.href = './scout';
        } else if (buttonId === 'button2') {
            window.location.href = './video';
        } else if (buttonId === 'button3') {
            window.location.href = './view';
        } else if (buttonId === 'button4') {
            window.location.href = './user';
        } else if (buttonId === 'button5') {
            window.location.href = './admin';
        } else if (buttonId === 'button6') {
            window.location.href = 'https://github.com/Minurr/ScoutWeb';
        } else if (buttonId === 'button7') {
            window.location.href = 'https://frc5516.com.cn/';
        }
    };
});