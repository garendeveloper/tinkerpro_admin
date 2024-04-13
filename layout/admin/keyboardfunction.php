<script>
$(document).ready(function() {
    // Add tabindex attribute to buttons and links to make them focusable
    $('.button, .link').attr('tabindex', '0');
    
    // Focus on the first button or link when the page loads
    $('.button, .link').first().focus();

    $(document).on('keydown', function(event) {
        var focusedElement = $(':focus');
        var isButton = focusedElement.hasClass('button');
        var isLink = focusedElement.hasClass('link');
        
        if (event.which === 37 || event.which === 38 || event.which === 39 || event.which === 40) {
            event.preventDefault(); // Prevent default arrow key behavior

            if (isButton || isLink) {
                var siblings = isButton ? '.button' : '.link';
                var focusedIndex = $(siblings).index(focusedElement);
                var newIndex = -1;

                if (event.which === 37 || event.which === 38) { // Left or Up arrow
                    newIndex = focusedIndex === 0 ? $(siblings).length - 1 : focusedIndex - 1;
                } else if (event.which === 39 || event.which === 40) { // Right or Down arrow
                    newIndex = focusedIndex === $(siblings).length - 1 ? 0 : focusedIndex + 1;
                }

                $(siblings).eq(newIndex).focus();
            }
        }
    });
});
</script>
