var addEvent = (function(window, document) {
    if (document.addEventListener) {
        return function(elem, type, cb) {
            if ((elem && !elem.length) || elem === window) {
                elem.addEventListener(type, cb, false);
            } else if (elem && elem.length) {
                var len = elem.length;
                for (var i = 0; i < len; i++) {
                    addEvent(elem[i], type, cb);
                }
            }
        };
    } else if (document.attachEvent) {
        return function(elem, type, cb) {
            if ((elem && !elem.length) || elem === window) {
                elem.attachEvent('on' + type, function() {
                    return cb.call(elem, window.event)
                });
            } else if (elem.length) {
                var len = elem.length;
                for (var i = 0; i < len; i++) {
                    addEvent(elem[i], type, cb);
                }
            }
        };
    }
})(this, document);

// Derived from: http://stackoverflow.com/a/10924150/402706
function getpreviousSibling(element) {
    var p = element;
    do p = p.previousSibling;
    while (p && p.nodeType != 1);
    return p;
}
(function() {
    // Function to highlight the row
    function highlightRow() {
        var trows = this.parentNode.rows;
        for (var t = 1; t < trows.length; ++t) {
            trow = trows[t];
            if (trow != this) {
                trow.className = "normal";
            }
        }
        this.className = (this.className == "highlighted") ? "normal" : "highlighted";
    }

    // Event handler for table row click
    function addRowClickHandler(className) {
        var tables = document.getElementsByClassName(className);
        for (var i = 0; i < tables.length; i++) {
            var trows = tables[i].rows;
            for (var t = 1; t < trows.length; ++t) {
                trow = trows[t];
                trow.className = "normal";
                trow.onclick = highlightRow;
            }
        }
    }

    // Event handler for keydown event
    addEvent(document, 'keydown', function(e) {
        var key = e.keyCode || e.which;
        if ((key === 38 || key === 40) && !e.shiftKey && !e.metaKey && !e.ctrlKey && !e.altKey) {
            var highlightedRows = document.querySelectorAll('.highlighted');
            if (highlightedRows.length > 0) {
                var highlightedRow = highlightedRows[0];
                var prev = getpreviousSibling(highlightedRow);
                var next = getnextSibling(highlightedRow);
                if (key === 38 && prev && prev.nodeName === highlightedRow.nodeName) {
                    // Up arrow key
                    highlightedRow.className = 'normal';
                    prev.className = 'highlighted';
                } else if (key === 40 && next && next.nodeName === highlightedRow.nodeName) {
                    highlightedRow.className = 'normal';
                    next.className = 'highlighted';
                }
            }
        }
    });

    // Call addRowClickHandler to set up the event handlers
    addRowClickHandler('.inventoryCard table');

})();
