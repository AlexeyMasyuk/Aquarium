
function checkTextArea( textArea, max ) {
    var shortText, message, val = textArea.value;
    // trim function removes whitespace from both sides of a string
    if ( val.trim().length === 0 ) {
        message = "Please note that you typed 0 characters in the textarea";
        window.alert( message );
    } else if ( val.length > max ) {
        message = "You typed more than " + max + " characters.\n";
        shortText = val.substr( 0, max );
        message += " your message will be trancated to " + shortText;
        // set truncated value to the field
        textArea.value = shortText;
        // write a message in the popup window
        window.alert( message );
    }
}