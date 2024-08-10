
var tooltipDisplayCount = 0;
var maxDisplayCount = 3;
var tooltipText = 'Click this to open option'; 

$("#btn_openOption").tooltip({
    content: tooltipText,
    open: function(event, ui) {
        $('body').css('background-color', '#262626');
    },
    close: function(event, ui) {
        $('body').css('background-color', '#fff');
        tooltipDisplayCount++;
        if (tooltipDisplayCount < maxDisplayCount) {
            $(this).tooltip("open");
        }
    }
});
$("#btn_openOption").tooltip("open");