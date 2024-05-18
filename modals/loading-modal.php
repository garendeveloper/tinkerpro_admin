<style>
/* Ensure the full screen modal */
#modalCashPrint .modal {
    display: block; 
    position: fixed;
    z-index: 3000;
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
}

#modalCashPrint .modal-content {
    position: absolute; 
    top: 50%; 
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: Century Gothic;
    min-width: 200px; 
    max-width: 350px; 
    background-color: #262625; 
    border-radius: 0;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border: 1px solid #262625;
}

#modalCashPrint .modal-body {
    color: white;
    padding: 20px;
    display: flex; 
    justify-content: center; 
    align-items: center; 
    text-align: center; 
    height: 100%; 
    position: relative;
}

.spinner {
    position: absolute;
    top: 10px; 
    left: 50%; 
    transform: translateX(-50%);
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top: 4px solid #FF6900;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

#modalCashPrint .modal-footer {
    position: absolute;
    bottom: 0;
    right: 0;
    padding: 10px;
    width: 100%;
    border-top: none;
}

#done-button {
    border: none;
    border-top: none;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    background-color: #4CAF50;
    border-radius: 0;
    outline: none;
    margin-right: 20px;
    width: 180px;
}

#done-button:hover {
    background-color: #218838; 
}

@keyframes colorChange {
    0%, 100% {
        color: white; 
    }
    50% {
        color: #FF6900; 
    }
}

#animated-text span {
    animation: colorChange 1s infinite; 
}

#animated-text span:nth-child(1) { animation-delay: 0.1s; }
#animated-text span:nth-child(2) { animation-delay: 0.2s; }
#animated-text span:nth-child(3) { animation-delay: 0.3s; }
#animated-text span:nth-child(4) { animation-delay: 0.4s; }
#animated-text span:nth-child(5) { animation-delay: 0.5s; }
#animated-text span:nth-child(6) { animation-delay: 0.6s; }
#animated-text span:nth-child(7) { animation-delay: 0.7s; }
#animated-text span:nth-child(8) { animation-delay: 0.8s; }
#animated-text span:nth-child(9) { animation-delay: 0.9s; }
#animated-text span:nth-child(10) { animation-delay: 1.0s;}
#animated-text span:nth-child(11) { animation-delay: 1.1s;}
#animated-text span:nth-child(12) { animation-delay: 1.2s;}
</style>

<div class="modal" id="modalCashPrint" tabindex="0" style="background-color: rgba(0, 0, 0, 0.9);">
    <div class="modal-content">
        <div class="modal-body">
            <div class="spinner"></div>
            <p id="animated-text" style="margin-top: 20px">
                <span>L</span><span>o</span><span>a</span><span>d</span><span>i</span><span>n</span><span>g</span> <span>P</span><span>l</span><span>e</span><span>a</span><span>s</span><span>e</span> <span>W</span><span>a</span><span>i</span><span>t</span><span>...</span>
            </p>
        </div>
    </div>
</div>