<!DOCTYPE html>
{{-- <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
        <title>Aperçu PDF</title>
        <style>
            #pdf-canvas {
                border: 1px solid #f2f2f2;
                width: 40%;
                height: 400px;
            }
        </style>
    </head>
    <body>
        <h1>Aperçu du PDF</h1>
        <canvas id="pdf-canvas"></canvas>

        <script>
            var url = '{{ url('/view-pdf/'.$filename) }}';

            // Utilisation de PDF.js pour afficher le PDF
            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                console.log('PDF loaded');
                pdf.getPage(1).then(function(page) {
                    var scale = 1.5;
                    var viewport = page.getViewport({ scale: scale });

                    // Préparer le canvas pour l'affichage
                    var canvas = document.getElementById('pdf-canvas');
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Rendre la page sur le canvas
                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });
                });
            });
        </script>
    </body>
</html> --}}

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aperçu PDF</title>
        <style>

            .pdf-preview-container {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                margin: 20px;
            }
            .pdf-thumbnails {
                display: flex;
                gap: 10px;
            }
            .pdf-thumbnails canvas {
                border: 1px solid #ddd;
                width: 200px;
                height: 280px;
            }
            .buttons {
                margin-top: 20px;
            }
            .buttons button {
                padding: 10px 15px;
                font-size: 16px;
                cursor: pointer;
                margin: 0 5px;
            }
        </style>
    </head>
    <body>
        <div class="pdf-preview-container">
            <div class="pdf-thumbnails">
                <canvas id="page1-canvas"></canvas>
                <canvas id="page2-canvas"></canvas>
            </div>
            <p>Exemples des pages de cours</p>
            <div class="buttons">
                <button onclick="openPreviewPage()">👁️ Aperçu le PDF</button>
                <button onclick="downloadPDF()">📥 Télécharger</button>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
        <script>
            var url = '{{ url("/view-pdf/".$filename) }}'; // Lien vers le PDF
            console.log(url);
            // Fonction pour charger les miniatures des pages
            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                loadPage(pdf, 1, 'page1-canvas');
                loadPage(pdf, 2, 'page2-canvas');
            });

            function loadPage(pdf, pageNumber, canvasId) {
                pdf.getPage(pageNumber).then(function(page) {
                    var scale = 0.5;
                    var viewport = page.getViewport({ scale: scale });

                    var canvas = document.getElementById(canvasId);
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });
                }).catch(function() {
                    console.log(`Page ${pageNumber} non disponible.`);
                });
            }
            const filename = @json($filename); // Transmettez correctement la variable PHP à JavaScript
            var url = `/view-pdf/${filename}`; // Utilisation dynamique de la variable dans l'URL

            function openPreviewPage() {
                if (!filename) {
                    alert('Nom du fichier PDF non défini.');
                    return;
                }
                window.location.href = `/pdf-preview/${filename}`; // URL vers la route définie
            }

            function downloadPDF() {
                if (!filename) {
                    alert('Nom du fichier PDF non défini.');
                    return;
                }
                window.location.href = `/view-pdf/${filename}`; // Téléchargement du fichier
            }
        </script>
    </body>
</html>
