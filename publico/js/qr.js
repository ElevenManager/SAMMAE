function onScanSuccess(decodedText, decodedResult) {
    // Envía el texto decodificado al servidor PHP
    console.log(`Code scanned = ${decodedText}`, decodedResult);
    fetch('procesarQR.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({codigo: decodedText})
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Muestra la respuesta del script PHP
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

var html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);

