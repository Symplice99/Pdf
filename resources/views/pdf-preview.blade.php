<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Visualisation PDF</title>
        <style>
            #pdf-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin: 20px;
            }
            canvas {
                margin: 10px 0;
                border: 1px solid #ddd;
            }
            button {
                padding: 10px 15px;
                font-size: 16px;
                cursor: pointer;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div id="pdf-container"></div>
        <button onclick="downloadPDF()">📥 Télécharger</button>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
        <script>
            const filename = @json($filename); // Transmettez la variable PHP
            var url = `/view-pdf/${filename}`; // URL dynamique

            pdfjsLib.getDocument(url).promise.then(function(pdf) {
                var numPages = Math.min(pdf.numPages, 5); // Limitez à 5 pages ou moins
                for (let i = 1; i <= numPages; i++) {
                    loadPage(pdf, i);
                }
            });

            function loadPage(pdf, pageNumber) {
                pdf.getPage(pageNumber).then(function(page) {
                    var scale = 1.5;
                    var viewport = page.getViewport({ scale: scale });

                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });

                    document.getElementById('pdf-container').appendChild(canvas);
                });
            }

            function downloadPDF() {
                window.location.href = url; // Télécharger le fichier
            }
        </script>
    </body>
</html>
