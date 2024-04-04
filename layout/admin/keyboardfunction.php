<script>
$(document).ready(function() {
    var positionX = 0;
    var positionY = 0;
    
    $(document).on('keydown', function(event) {
        var keyCode = event.keyCode || event.which; 
        
        switch (keyCode) {
            case 37: 
                positionX -= 10;
                $('#box').css('left', positionX + 'px');
                break;
            case 38: 
                positionY -= 10;
                $('#box').css('top', positionY + 'px');
                break;
            case 39: 
                positionX += 10;
                $('#box').css('left', positionX + 'px');
                break;
            case 40: 
                positionY += 10;
                $('#box').css('top', positionY + 'px');
                break;
        }
    });
});
</script>