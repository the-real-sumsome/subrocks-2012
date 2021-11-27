<style>
    .example-parent {
    color: black;
    display: flex;
    font-family: sans-serif;
    font-weight: bold;
    }

    .example-origin {
    flex-basis: 100%;
    flex-grow: 1;
    padding: 10px;
    }

    .example-draggable {
        background-color: #f2f2f2;
    font-weight: normal;
    margin-bottom: 10px;
    margin-top: 10px;
    padding: 10px;
    }

    #solidcolor {
        vertical-align: middle;
        text-shadow: 0 1px 0 #fff;
        border-color: #ccc #ccc #aaa;
        background-color: #e0e0e0;
        -moz-box-shadow: inset 0 0 1px #fff;
        -ms-box-shadow: inset 0 0 1px #fff;
        -webkit-box-shadow: inset 0 0 1px #fff;
        box-shadow: inset 0 0 1px #fff;
        background-image: -moz-linear-gradient(top, #fafafa 0, #dcdcdc 100%);
        background-image: -ms-linear-gradient(top, #fafafa 0, #dcdcdc 100%);
        background-image: -o-linear-gradient(top, #fafafa 0, #dcdcdc 100%);
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #fafafa), color-stop(100%, #dcdcdc));
        background-image: -webkit-linear-gradient(top, #fafafa 0, #dcdcdc 100%);
        background-image: linear-gradient(to bottom, #fafafa 0, #dcdcdc 100%);
        height: 32px;
        border: 0;
    }

    .example-dropzone {
    background-color: #6DB65B;
    flex-basis: 100%;
    flex-grow: 1;
    padding: 10px;
    }

    .www-header-item {
        margin: 0px !important;
    }

    .channel-customization-options {
        float: right;
    }

    .label-with-info {
        display: inline-block;
        width: 200px;
    }

    .channel-layout-selector {
        display: inline-block;
        height: 300px;
        width: 18%;
        vertical-align: top;
        margin-top: 9px;
        padding: 10px;
    }

    .channel-layout-selector img {
        width: 134px;
    }

    .grey-text-options input {
        vertical-align: top;
    }

    .grey-text-options {
        position: relative;
        top: 3px;
    }

    .user-header-bottom table {
        width: 970px;
        padding: 10px;
        background-color: rgb(239, 239, 239);
        position: relative;
        top: -2px;
    }

    td .thin-line-darker {
        border-bottom: 1px dotted #bbb;
    }

    .right-side-customization {
        vertical-align: top;
        width: 450px;
        border-left: 1px dotted #bbb;
        left: 4px;
        padding: 5px;
    }

    .right-side-customization b, .right-side-customization .grey-text {
        position: relative;
        left:4px;
    }

    .right-side-customization .thin-line-darker {
        width: 100%;
    }

    .www-header-list table {
        background: rgb(232,232,232);
        background: linear-gradient(0deg, rgba(232,232,232,1) 0%, rgba(250,250,250,1) 100%); 
    }

    .left-side-customization {
        width: 450px;
        vertical-align: top;
        padding-left: 25px;
    }

    /*
        .right-side-customization input[type="submit"], .left-side-customization input[type="submit"] {
            color: #039;
            background: #c6d7f3 url(/yt/imgbin/spritesheet_main.png)repeat-x center -1602px;
            border: 1px solid #a0b1dc;
            text-decoration: none;
            border-radius: 3px;
            padding: 3px 0.833em;
            font-weight: bold;
        }
    */

    .customization-module {
        display: inline-block;
        float:right;
    }

    .user-header-bottom table {
        border: 1px solid #999;
        border-top: 0px;
    }

    .www-header-list {
        margin-top: 0px;
        width: 101%;
        background-image: linear-gradient(to bottom,#f0f0f0 0,#e6e6e6 100%);
        height: 43px;
        position: relative;
        left: 1px;
        bottom: 2px;
        width: 968px;
    }

    #biomd {
        position: relative;
        top: 6px;
    }

    .channel-customization-bg {
        background: url(/s/img/chnanel-customization-bg.png);
        max-height: 700px;
        min-height: 400px;
    }

    .channel-customization-base {
        width: 960px;
        margin: auto;
        position: relative;
        right: 5px;
    }

    .channel-custom-top {
        margin: auto;
        width: 970px;
    }

    .www-header-list .yt-uix-button {
        width: 128px;
        height: 100%;
    }

    .www-header-list .yt-uix-button:nth-child(n+1) {
        margin-left: -5px;
    }

    .www-header-list .yt-uix-button {
        background: rgb(239, 239, 239);
        font-weight: lighter;
        font-size: 13px;
        outline: 0;
    }

    .www-header-list .yt-uix-button:focus {
        outline: 0;
        box-shadow: none;
    }
</style>

<div class="channel-customization-bg">
    <br>
    <div class="channel-custom-top">
        <h1 style="color: white;font-weight: bolder;font-weight:normal;display:inline-block;">Edit my channel</h1>
        <button style="float: right;" onclick='$(".channel-customization-bg").fadeOut(300);' class="yt-uix-button yt-uix-button-default">Cancel</button>
    </div>
    <br>
    <div class="channel-customization-base" id="channel-customize">
        <div class="user-header-bottom">
            <div class="www-header-list">
                <script>
                    function selectTable(showDom) {
                        doms = ['#pictures-table', '#misc-table', '#bg-table', '#color-table', '#layout-table']; 
                        doms.forEach(dom => $(dom).hide()); 
                        $(showDom).show();
                    };

                    $("#biom").change(function(){
                        
                    }); 
                </script>
                <a class="www-header-item" href="#" id="pictures-table-button" onclick="selectTable('#pictures-table');">
                    <button class="yt-uix-button yt-uix-button-default" style="margin-left: 0px;">Apperance</button>
                </a>
                <a class="www-header-item" href="#" id="misc-table-button" style='display:none;' onclick="selectTable('#misc-table');">
                    <button class="yt-uix-button yt-uix-button-default">Info and Settings</button>
                </a>
                <a class="www-header-item" href="#" id="bg-table-button" onclick="selectTable('#bg-table');">
                    <button class="yt-uix-button yt-uix-button-default">Info and Settings</button>
                </a>
                <a class="www-header-item" href="#" id="layout-table-button" onclick="selectTable('#layout-table');">
                    <button class="yt-uix-button yt-uix-button-default">Tabs</button>
                </a>
                <div class="channel-customization-options">
                </div>
            </div>

            <table id="pictures-table" style="width: 970px;padding: 10px;">
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <form method="post" id="picturesform" action="/d/channel_update" enctype="multipart/form-data">
                    <td class="left-side-customization">
                        <h2>Avatar</h2>
                        <p style="font-size: 11px;color: grey;">
                            Choose image. Non-square images wil be cropped.<br>
                            Suggested dimensions: 800x800 pixels. Max size: 1MB.
                        </p>
                        <?php if($_user['pfp'] != "default.png") { ?>
                            <a style="font-size: 11px;" href="/get/remove_profile_pic">Remove Profile Picture</a><br>
                        <?php } ?>
                        <br>
                        <a id="browse" href="javascript:;">
                            <button class="yt-uix-button yt-uix-button-default">
                                Browse
                            </button>
                        </a>  
                        <a id="start-upload" href="javascript:;">                                    
                            <button class="yt-uix-button yt-uix-button-default">
                                Upload
                            </button>
                        </a>
                        <div class="customization-module" id="pfp" action="/d/channel_update" enctype="multipart/form-data">
                        </div><br><br>
                        <ul id="filelist"></ul>
                            <pre id="console"></pre>

                            <script type="text/javascript">
                            var alerts = 0;

                            var uploader = new plupload.Uploader({
                                browse_button: 'browse', 
                                url: '/d/channel_update?n=pfp',
                                multi_selection: false,
                                
                                filters: {
                                    ime_types : [
                                        { title : "Image files", extensions : "jpg,gif,png" },
                                    ],
                                    max_file_size: "1024kb"
                                },

                                resize: {
                                    width: 100,
                                    height: 100,
                                    preserve_headers: false
                                }
                            });
                            
                            uploader.init();
                            
                            uploader.bind('FilesAdded', function(up, files) {
                                var html = '';
                                plupload.each(files, function(file) {
                                    console.log("file added");
                                });
                            });
                            
                            uploader.bind('UploadFile', function(up, file) {

                            });

                            uploader.bind('FileUploaded', function(up, file, response) {
                                alerts++;  
                                response = JSON.parse(response.response);
                                $("#photo-update").attr("src", "/dynamic/pfp/" + response.profile_picture);
                            });
                            
                            uploader.bind('Error', function(up, err) {
                                document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
                            });
                            
                            document.getElementById('start-upload').onclick = function() {
                            uploader.start();
                            };
                            
                            </script>
                            <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                            <br>
                            <h2>Background Options</h2>
                            <span style="font-size: 11px;color:grey;">Choose image (Max file size: 1MB)</span><br><br>
                            <div id="backgroundoptions" method="post" action="/d/channel_update" enctype="multipart/form-data">
                                <select class="yt-uix-button yt-uix-button-default" name="bgoption">
                                    <option value="repeaty">Repeat only vertically</option>
                                    <option value="repeatx">Repeat only horrizontaly</option>
                                    <option value="norepeat">Don't Repeat</option>
                                    <option value="repeatxy">Repeat</option>
                                    <option value="stretch">Stretch to fit</option>
                                    <option value="solid">Solid</option>
                                </select>
                                <input style="vertical-align: middle;" type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['primary_color']); ?>">
                            </div><br>
                            <h2>Background</h2>
                            <span style="font-size: 11px;color:grey;" class="grey-text">Choose Image (Max file size: 10MB)</span><br>
                            <div id="backgroundimage" method="post" action="/d/channel_update" enctype="multipart/form-data">
                                <input type="file" name="backgroundbgset" id="background-upload">
                                <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                            </div><br>
                            <?php if($__user_h->if_partner($_user['username'])) { ?>
                                <h2>Watch Page Subscribe Button</h2>
                                <span style="font-size: 11px;color:grey;" class="grey-text">Choose Image (Max file size: 10MB)</span><br>
                                <div id="watchsub" method="post" action="/d/channel_update?n=watchsub" enctype="multipart/form-data">
                                    <input type="file" name="watchsubset" id="watch-upload">
                                    <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                                </div>
                            <?php } ?>
                            
                            <input class="yt-uix-button yt-uix-button-default" style="position: absolute;top: -89px;right: -412px;" type="submit" value="Done Editing"><br><br>
                    </td>
                    <td class="right-side-customization">
                        
                    </td>
                    </form>
                </tr>
            </table>

            <table id="layout-table" style="width: 970px;padding: 10px;display: none;">
                <tr>
                    <th></th>
                </tr>
                <tr>
                    <form method="post" id="layoutform" action="/d/channel_update" enctype="multipart/form-data">
                    <td>
                        <center>
                            <div class="channel-layout-selector">
                                <button onclick=";upload_layout('feed');return false;">
                                    <img src="/s/img/creator.png">
                                    <h2>Feed</h2>
                                    <p>
                                        A list of recent comments<br>
                                        and videos from you
                                    </p>
                                </button>
                            </div>
                            <div class="channel-layout-selector">
                                <button onclick=";upload_layout('featured');return false;">
                                    <img src="/s/img/blogger.png">
                                    <h2>Blogger</h2>
                                    <p>
                                        A reverse chronological list of<br>
                                        your recent uploads or a<br>
                                        featured playlist<br>
                                    </p>
                                </button>
                            </div>
                            <div class="channel-layout-selector">
                                <button onclick=";upload_layout('playlists');return false;">
                                    <img src="/s/img/network.png">
                                    <h2>Network</h2>
                                    <p>
                                        A featured video from a playlist <br>
                                        with a group of featured<br>
                                        channels
                                    </p>
                                </button>
                            </div>
                            <div class="channel-layout-selector">
                                <button onclick=";upload_layout('everything');return false;">
                                    <img src="/s/img/everything.png">
                                    <h2>Everything</h2>
                                    <p>
                                        A featured video from a playlist<br>
                                        with a group of featured playlists<br>
                                        and channels.
                                    </p>
                                </button>
                            </div>
                        </center>
                    </td>
                    </form>
                </tr>
            </table>

            <table id="misc-table" style="width: 970px;padding: 10px;display:none;">
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                <form method="post" id="miscform" action="/d/channel_update" enctype="multipart/form-data">
                    <td class="left-side-customization">
                        <b>Primary Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;">This will change the text color of your channel ribbon.</span>
                        <div class="customization-module" id="primarycolor" style="float: right;position: relative;bottom: 15px;" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['primary_color']); ?>">
                        </div><br><hr class="thin-line-darker" style="width: unset !important;">
                        <b>Channel Box Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;">This will change the background color of the channel info box and the channel ribbon at top.</span><br>
                        <div class="customization-module" id="channelboxcolor" style="float: right;position: relative;bottom: 30px;" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="color" id="channelboxcolorpicker" name="channelboxcolor" value="<?php echo htmlspecialchars($_user['secondary_color']); ?>">
                        </div><br><hr class="thin-line-darker" style="width: unset !important;">
                        <b>Border Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;">This will change the border color of all the elements.</span><br>
                        <div class="customization-module" id="bordercolor" style="float: right;position: relative;bottom: 30px;" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="color" id="bordercolorpicker" name="bordercolor" value="<?php echo htmlspecialchars($_user['border_color']); ?>">
                        </div><br><hr class="thin-line-darker" style="width: unset !important;"><br><br><br>
                        <input class="yt-uix-button yt-uix-button-default" style="position: absolute;left: 6px;bottom: 8px;" type="submit" value="Done Editing">
                    </td>
                    <td class="right-side-customization">
                        <b>Background Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;">This will change the background of all the other boxes including the top featured area.</span><br>
                        <div class="customization-module" id="boxbackgroundcolor" style="float: right;position: relative;bottom: 30px;" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="color" id="solidcolorbackground" name="backgroundcolor" value="<?php echo htmlspecialchars($_user['third_color']); ?>">
                        </div><br><hr class="thin-line-darker">
                        <b>Text Main Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;">This will change the color of the text for boxes.</span><br>
                        <div class="customization-module" id="textmaincolor" style="float: right;position: relative;bottom: 30px;" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="color" id="textmaincolor" name="textmaincolor" value="<?php echo htmlspecialchars($_user['primary_color_text']); ?>">
                        </div><br><hr class="thin-line-darker">
                    </td>
                </form>
                </tr>
            </table>

            <table id="bg-table" style="display:none;width: 970px;padding: 10px;">
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                <form method="post" id="bgform" action="/d/channel_update" enctype="multipart/form-data">
                    <td class="left-side-customization" style="width: 247px;">
                        <h2>Channel information & Settings</h2>
                        <span style="font-size: 10px;color: grey;">Featured Video</span><br>
                        <input class="yt-uix-form-input-text" style="width: 225px;" id="biomd" placeholder="Video ID" value="<?php echo htmlspecialchars($_user['featured']);?>" name="videoid"><br><br>
                        <span style="font-size: 10px;color: grey;">Description</span><br>
                        <div id="bio" action="/d/channel_update" enctype="multipart/form-data">
                            <textarea class="yt-uix-form-input-text" style="resize:none;height: 55px;width: 225px;background-color:white;border: 1px solid #d3d3d3;" id="readthisbio" placeholder="Bio" name="bio"><?php echo htmlspecialchars($_user['bio']); ?></textarea><br>
                        </div>


                        <br><input class="yt-uix-button yt-uix-button-default" type="submit" style="position: absolute;top: -89px;right: 66px;" value="Done Editing"><br><br>
                    </td>
                    <td class="right-side-customization" style="width: 630px;border: 0px;padding:0px;">
                        <h2>Advanced</h2>
                        <span style="font-size: 10px;color: grey;">Website URL</span><br>
                        <div id="featuredvid" action="/d/channel_update" enctype="multipart/form-data">
                        <input class="yt-uix-form-input-text" style="width: 225px;" id="websiteurlinp" placeholder="Website URL" value="<?php echo htmlspecialchars($_user['website']);?>" name="website">
                        </div><br>
                        <div>
                            <span style="font-size: 10px;color: grey;">Featured Channels</span>
                            <div id="featuredvid" action="/d/channel_update" enctype="multipart/form-data">
                            <input class="yt-uix-form-input-text" style="width: 291px;"  id="biomd" placeholder="Seperate by commas!" value="<?php echo htmlspecialchars($_user['featured_channels']);?>" name="featuredchannels">
                            </div>
                        </div><br>

                        <span style="font-size: 10px;color: grey;">Country</span><br>
                        <div id="countryselect" action="/d/channel_update" enctype="multipart/form-data">
                            <select style="width: 246px;" class="yt-uix-button yt-uix-button-default" id="country_input" name="country" value="<?php echo $_user['country']?>">
                            <?php
                            $countries = ["Select country","Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"];

                            $countryLength = sizeof($countries);
                            $i = 0;
                            for($i = 0;$i <= $countryLength; $i++)
                            {
                                $c = $countries[$i];
                                if ($c == $_user['country'])
                                //country is the same as in database
                                {
                                ?>
                                <option value="<?php echo $c; ?>" selected="selected"><?php echo $c; ?></option>
                                <?php
                                }
                                else
                                {
                                ?>
                                <option value="<?php echo $c;?>"><?php echo $c; ?></option>
                                <?php
                                }
                            }
                            ?>
                            </select>
                        </div>

                        <?php $categories = ["None", "Director", "Musician", "Comedian", "Guru", "Nonprofit"]; ?>
                        <div style="position: relative;top: 7px;padding-bottom: 6px;">
                            <span style="font-size: 10px;color: grey;">Channel Genre</span><br>
                            <div id="channellayout" action="/d/channel_update" enctype="multipart/form-data">
                                <select style="width: 246px;" class="yt-uix-button yt-uix-button-default" name="genre">
                                    <?php foreach($categories as $category) { ?>
                                        <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><br><br>
                    </td>
                </form>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
    var alerts = 0; 
    $('#picturesform').submit(
        function( e ) {
            var data = new FormData(this);
            d = 0;
            $.each($("input[type='file']")[0].files, function(i, file) {
                data.append('file', file + "_" + d);
                d++;
            });

            $.ajax( {
                url: '/d/channel_update',
                type: 'POST',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(result){
                    alerts++;
                    addAlert("editsuccess_" + alerts, "Successfully updated your channel!");
                    showAlert("#editsuccess_" + alerts);
                    $("#bio-changeme").text($("#biom").val());
                }
            } );
            e.preventDefault();
        } 
    );

    $('#miscform').submit(
        function( e ) {
            var data = new FormData(this);

            $.ajax( {
                url: '/d/channel_update',
                type: 'POST',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(result){
                    alerts++;
                    addAlert("editsuccess_" + alerts, "Successfully updated your channel!");
                    showAlert("#editsuccess_" + alerts);
                    $("#bio-changeme").text($("#biom").val());
                }
            } );
            e.preventDefault();
        } 
    );

    $('#bgform').submit(
        function( e ) {
            var data = new FormData(this);

            $.ajax( {
                url: '/d/channel_update',
                type: 'POST',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function(result){
                    alerts++;
                    addAlert("alert__" + alerts, "Successfully updated your channel!");
                    showAlert("#editsuccess_" + alerts);
                    $("#bio-changeme").text($("#readthisbio").val());
                    $("#website_url_change").text($("#websiteurlinp").val());
                    $("#country_change").text($("#country_input").val());
                }
            } );
            e.preventDefault();
        } 
    );

    function upload_layout(layout) {
        $.post("/d/channel_update",
        {
            layout_channel: layout
        },
        function(data, status){
            alerts++;
            addAlert("editsuccess_" + alerts, "Successfully updated your channel!");
            showAlert("#editsuccess_" + alerts);
        });
    }
</script>
<script src="/s/js/channelEdit.js"></script>
<script src="/s/js/alert.js"></script>
