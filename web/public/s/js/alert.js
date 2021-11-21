function showAlert(id) {
    $(id).fadeIn();
}

function addAlert(id, text) {
    $(".alerts-2012").append(
        `
        <div id="alerts" class="content-alignment" style="margin-top:3px;">
            <div class="yt-alert yt-alert-default yt-alert-info hid" id="alert__` + id + `" style="display: block;">
                <div class="yt-alert-icon">
                    <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="icon master-sprite" alt="Alert icon">
                </div>
                <div class="yt-alert-buttons"><button type="button" class="close yt-uix-close yt-uix-button yt-uix-button-close yt-uix-button-size-default" onclick="this.parent.style.display = 'none';" data-close-parent-class="yt-alert" role="button"><span class="yt-uix-button-content">Close </span></button></div>
                <div class="yt-alert-content" role="alert">
                    <span class="yt-alert-vertical-trick"></span>
                    <div class="yt-alert-message">
                        ` + text + `
                    </div>
                </div>
            </div>
        </div>
        `
    );

    return "Alert created " + id + text;
}