function percentage(name, text, percent, sign) { 
    
    var chart = document.getElementById(name);
    
	$(chart).circliful({
        animationStep: 15,
        foregroundBorderWidth: 5,
        backgroundBorderWidth: 15,
        percent: percent,
        text: text,
        halfCircle: true,
        noPercentageSign: sign
    });
}
