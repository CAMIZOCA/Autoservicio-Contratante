/* 
 * funcion para capturar la imagen del chart que viene del grafico de google
 */


 function getImgData(chartContainer) {
        var chartArea = chartContainer.getElementsByTagName('iframe')[0].contentDocument.getElementById('chartArea');
        var svg = chartArea.innerHTML;
        var doc = chartContainer.ownerDocument;
        var canvas = doc.createElement('canvas');
        canvas.setAttribute('width', chartArea.offsetWidth);
        canvas.setAttribute('height', chartArea.offsetHeight);        
        
        canvas.setAttribute(
        'style',
        'position: absolute; ' +
            'top: ' + (-chartArea.offsetHeight * 2) + 'px;' +
            'left: ' + (-chartArea.offsetWidth * 2) + 'px;');
        doc.body.appendChild(canvas);
        canvg(canvas, svg);
        var imgData = canvas.toDataURL("image/gif");
        canvas.parentNode.removeChild(canvas);
        //alert(imgData);
        return imgData;
    }
          
    function toImg(chartContainer, imgContainer) { 
        var doc = chartContainer.ownerDocument;
        var img = doc.createElement('img');
        img.src = getImgData(chartContainer);        
        $('[id=img_grafico]').val(img.src);
    }