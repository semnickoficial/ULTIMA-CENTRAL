// Proteção contra DevTools
(function() {
    function detectDevTools(allow) {
        if(isNaN(+allow)) allow = 100;
        var start = +new Date();
        debugger;
        var end = +new Date();
        if(isNaN(start) || isNaN(end) || end - start > allow) {
            window.location.href = "https://t.me/authcentergg";
        }
    }
    if(window.attachEvent) {
        if (document.readyState === "complete" || document.readyState === "interactive") {
            detectDevTools();
            window.attachEvent('onresize', detectDevTools);
            window.attachEvent('onmousemove', detectDevTools);
            window.attachEvent('onfocus', detectDevTools);
            window.attachEvent('onblur', detectDevTools);
        } else {
            setTimeout(argument.callee, 0);
        }
    } else {
        window.addEventListener('load', detectDevTools);
        window.addEventListener('resize', detectDevTools);
        window.addEventListener('mousemove', detectDevTools);
        window.addEventListener('focus', detectDevTools);
        window.addEventListener('blur', detectDevTools);
    }
})();

// Desabilitar teclas de atalho, exceto no textarea
document.onkeydown = function(e) {
    // Verifica se o elemento focado é um textarea
    if (e.target.tagName === 'TEXTAREA') {
        return true; // Permite todas as operações no textarea
    }
    
    if (e.ctrlKey && 
        (e.keyCode === 67 || // C
         e.keyCode === 86 || // V
         e.keyCode === 85 || // U
         e.keyCode === 117)) { // F6
        return false;
    } else if (e.keyCode === 123) { // F12
        return false;
    }
};

// Desabilitar clique direito, exceto no textarea
document.addEventListener('contextmenu', function(e) {
    if (e.target.tagName !== 'TEXTAREA') {
        e.preventDefault();
    }
});

// Desabilitar seleção de texto, exceto no textarea
document.addEventListener('selectstart', function(e) {
    if (e.target.tagName !== 'TEXTAREA') {
        e.preventDefault();
    }
});

// Proteção contra print screen
document.addEventListener('keyup', function(e) {
    if (e.key == 'PrintScreen') {
        navigator.clipboard.writeText('');
    }
});

// Proteção contra print screen usando o DevTools
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key == 'p') {
        e.cancelBubble = true;
        e.preventDefault();
        e.stopImmediatePropagation();
    }
}); 