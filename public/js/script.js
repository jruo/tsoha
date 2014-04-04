function reply(id) {
    if (id < 0) {
        $("#replyMessage").html("");
        $("#replyMessageInput").val("-1");
    } else {
        $("#replyMessage").html("Viesti lähetetään vastauksena viestiin #" + id + ' <a href="javascript:reply(-1)">(peruuta)</a>');
        $("#replyMessageInput").val(id);
    }
    scrollToBottom();
    $("#forum-post-reply-form").focus();
}

function scrollToBottom() {
    $("html, body").animate({ scrollTop: $(document).height() });
}