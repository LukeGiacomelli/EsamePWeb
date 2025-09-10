function goBack() {
    if (document.referrer) {
        window.history.back(); // Torna indietro se c'è una cronologia
    } else {
        window.location.href = "index.html"; // Reindirizza a index
    }
}
