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
    $("html, body").animate({scrollTop: $(document).height()});
}

function showRenameGroup(id) {
    $(".memberGroupEditName").hide();
    $(".memberGroupRealName").show();
    if (id < 0) {
        return;
    }
    $("#memberGroupRealName-" + id).hide();
    $("#memberGroupEditName-" + id).show();
    $("#memberGroupEditName-" + id).children(".form-control").focus();
}