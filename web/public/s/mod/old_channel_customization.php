<?Php /* DO NOT USE THIS IN PRODUCTION. ONLY USE AS A ROLLBACK IF SOMETHING FUCKS UP */ ?>
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
        padding: 5px;
    }

    .right-side-customization input[type="submit"], .left-side-customization input[type="submit"] {
        color: #039;
        background: #c6d7f3 url(/yt/imgbin/spritesheet_main.png)repeat-x center -1602px;
        border: 1px solid #a0b1dc;
        text-decoration: none;
        border-radius: 3px;
        padding: 3px 0.833em;
        font-weight: bold;
    }

    .customization-module {
        display: inline-block;
        float:right;
    }

    .user-header-bottom table {
        border: 1px solid #999;
        border-top: 0px;
    }

    #backgroundimage, #backgroundoptions {
        position: relative;
        bottom: 26px;
    }

    .www-header-list {
        margin-top: 0px;
        width: 101%;
        background-image: linear-gradient(to bottom,#f0f0f0 0,#e6e6e6 100%);
        height: 43px;
        position: relative;
        left: 1px;
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
        width: 100px;
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
    }
</style>

<div class="channel-customization-bg">
    <br>
    <div class="channel-custom-top">
        <h1 style="color: white;font-weight: bolder;">Edit my channel</h1>
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
                    <button class="yt-uix-button yt-uix-button-default" style="margin-left: 0px;">Main</button>
                </a>
                <a class="www-header-item" href="#" id="misc-table-button" style='display:none;' onclick="selectTable('#misc-table');">
                    <button class="yt-uix-button yt-uix-button-default">Colors</button>
                </a>
                <a class="www-header-item" href="#" id="bg-table-button" onclick="selectTable('#bg-table');">
                    <button class="yt-uix-button yt-uix-button-default">Background</button>
                </a>
                <a class="www-header-item" href="#" id="layout-table-button" onclick="selectTable('#layout-table');">
                    <button class="yt-uix-button yt-uix-button-default">Layout</button>
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
                        <b style="position: relative;top: 11px;">Avatar</b>
                        <div id="container" style="float: right;margin-top: 4px;">
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
                        </div>
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
                                    ]
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
                                // document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                                addAlert("editsuccess_" + alerts, "Starting upload.");
								showAlert("#editsuccess_" + alerts);
                                alerts++;
                            });

                            uploader.bind('FileUploaded', function(up, file) {
                                addAlert("editsuccess_" + alerts, "Succesfully finished uploading " + file.name);
								showAlert("#editsuccess_" + alerts);
                                alerts++;  
                            });
                            
                            uploader.bind('Error', function(up, err) {
                                document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
                            });
                            
                            document.getElementById('start-upload').onclick = function() {
                            uploader.start();
                            };
                            
                            </script>
                            <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                        <img src="/dynamic/pfp/<?php echo $_user['pfp']; ?>" style="width:100px;height:100px;"><br>
                        <?php if($_user['pfp'] != "default.png") { ?>
                            <a href="/get/remove_profile_pic">Remove Profile Picture</a><br>
                        <?php } ?>
                        <br><hr class="thin-line-darker" style="width:unset;">
                        <!--
                        <b style="position: relative;top: 11px;">Video Page Banner</b>
                        <div class="customization-module" id="watchbanner" action="/d/channel_update" enctype="multipart/form-data" style="display: inline-block;float:right;">
                            <input style="width: 169px;position: relative;top: 10px;" type="file" name="videopagebanner" id="avatar-upload">
                            <button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>
                        </div><br>                   
                        <?php if(!empty($_user['subbutton'])) { ?>
                            <a href="/get/remove_watch_banner">Remove Watch Page Banner</a><br>
                        <?php } ?><br><hr class="thin-line-darker" style="width:unset;">
                        
                        <b>Custom CSS</b><br>
                        
                        <div class="customization-module" id="bio" action="/d/channel_update" enctype="multipart/form-data" style="resize:none;float: right;position: relative;top: -15px;">
                            <span style="font-size: 11px;" class="grey-text">Prefix every image url() with //images.weserv.nl/?url=</span><br>    
                            <textarea class="yt-uix-form-input-text"  style="width: 288px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biomd" placeholder="Custom CSS" name="css"><?php echo htmlspecialchars($_user['css']); ?></textarea><br><br>
                        </div><br><br>
                        -->
                        <div style="position: relative;top: 7px;">
                            <b>Bio</b><br>
                            <div class="customization-module" id="bio" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -15px;">
                                <textarea class="yt-uix-form-input-text" style="resize:none;height: 55px;width: 344px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biom" placeholder="Bio" name="bio"><?php echo htmlspecialchars($_user['bio']); ?></textarea><br>
                            </div>
                        </div>
                        
                        <br><br><br><hr class="thin-line-darker" style="width:unset;"><br><br><br><br>

                        <input class="yt-uix-button yt-uix-button-default" style="position: absolute;left: 6px;bottom: 8px;" type="submit" value="Set">
                    </td>
                    <td class="right-side-customization">

                        <b>Featured Video</b>
                        <div class="customization-module" id="featuredvid" action="/d/channel_update" enctype="multipart/form-data" style="display: inline-block;float:right;position: relative;bottom: 6px;">
                        <input class="yt-uix-form-input-text" style="width: 291px;"  id="biomd" placeholder="Video ID" value="<?php echo htmlspecialchars($_user['featured']);?>" name="videoid">
                        </div><br><br><hr class="thin-line-darker" style="width:unset;">

                        <div style="position: relative;top: 7px;">
                            <b>Featured Channels</b>
                            <div class="customization-module" id="featuredvid" action="/d/channel_update" enctype="multipart/form-data" style="display: inline-block;float:right;position: relative;bottom: 6px;">
                            <input class="yt-uix-form-input-text" style="width: 291px;"  id="biomd" placeholder="Seperate by commas!" value="<?php echo htmlspecialchars($_user['featured_channels']);?>" name="featuredchannels">
                            </div>
                        </div><br><br><hr class="thin-line-darker" style="margin-top: 0px;width:unset;"><br>

                        <b>Website</b>
                        <div class="customization-module" id="featuredvid" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -7px;">
                        <input class="yt-uix-form-input-text" style="width: 291px;"  id="biomd" placeholder="Website URL" value="<?php echo htmlspecialchars($_user['website']);?>" name="website">
                            
                        </div><br><br><hr class="thin-line-darker" style="width:unset;">

                        <?php $categories = ["None", "Director", "Musician", "Comedian", "Guru", "Nonprofit"]; ?>
                        <div style="position: relative;top: 7px;padding-bottom: 6px;">
                            <b>Channel Genre</b><br>
                            <span style="font-size: 11px;" class="grey-text">This will show what type of channel you are to other users.</span>
                            <div class="customization-module" id="channellayout" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -19px;">
                                <select class="yt-uix-button yt-uix-button-default" style="position:relative;top:6px;"   name="genre">
                                    <?php foreach($categories as $category) { ?>
                                        <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div><hr class="thin-line-darker" style="width:unset;" style="width: 100%;">

                        <div style="position: relative;top: 7px;padding-bottom: 6px;">
                            <b>Transparency</b><br>
                            <span style="font-size: 11px;" class="grey-text">This will decide the visibility of ALL of your modules.</span>
                            <div class="customization-module" id="channellayout" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -19px;">
                                <select class="yt-uix-button yt-uix-button-default" style="position:relative;top:6px;"   name="transparency">
                                <?php
                                $trans = array(
                                    "1.1","1.0","0.9","0.8","0.7","0.6","0.5","0.4","0.3","0.2","0.1",
                                );
                                ?>
                                    <option value="1.0">100% (Visible)</option>
                                    <option value="0.9">90%</option>
                                    <option value="0.8">80%</option>
                                    <option value="0.7">70%</option>
                                    <option value="0.6">60%</option>
                                    <option value="0.5">50%</option>
                                    <option value="0.4">40%</option>
                                    <option value="0.3">30%</option>
                                    <option value="0.2">20%</option>
                                    <option value="0.1">10%</option>
                                </select>
                            </div>
                        </div><hr class="thin-line-darker" style="width:unset;" style="width: 100%;">


                        <b>Country</b><br>
                        <div class="customization-module" id="countryselect" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -19px;">
                            <select class="yt-uix-button yt-uix-button-default" style="position:relative;top:6px;"  id="country" name="country" value="<?php echo $_user['country']?>">
                            <?php
                            $countries = array(
                                "Select country","Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"
                            );

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
                        </div>
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
                                <img src="/s/img/creator.png">
                                <h2>Creator</h2>
                                <p>
                                    A featured video from a playlist<br>
                                    with a group of featured playlists
                                </p>
                            </div>
                            <div class="channel-layout-selector">
                                <img src="/s/img/blogger.png">
                                <h2>Blogger</h2>
                                <p>
                                    A reverse chronological list of<br>
                                    your recent uploads or a<br>
                                    featured playlist<br>
                                </p>
                            </div>
                            <div class="channel-layout-selector">
                                <img src="/s/img/network.png">
                                <h2>Network</h2>
                                <p>
                                    A featured video from a playlist <br>
                                    with a group of featured<br>
                                    channels
                                </p>
                            </div>
                            <div class="channel-layout-selector">
                                <img src="/s/img/everything.png">
                                <h2>Everything</h2>
                                <p>
                                    A featured video from a playlist<br>
                                    with a group of featured playlists<br>
                                    and channels.
                                </p><br>
                            </div>
                        </center>
                    </td>
                    </form>
                </tr>
            </table>

            <table id="misc-table" style="display:none;width: 970px;padding: 10px;">
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                <form method="post" id="miscform" action="/d/channel_update" enctype="multipart/form-data">
                    <td class="left-side-customization">
                        <b>Primary Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the text color of your channel ribbon.</span>
                        <div class="customization-module" id="primarycolor" style="float: right;position: relative;bottom: 15px;" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['primary_color']); ?>">
                        </div><br><hr class="thin-line-darker" style="width: unset !important;">
                        <b>Channel Box Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the background color of the channel info box and the channel ribbon at top.</span><br>
                        <div class="customization-module" id="channelboxcolor" style="float: right;position: relative;bottom: 30px;" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="color" id="channelboxcolorpicker" name="channelboxcolor" value="<?php echo htmlspecialchars($_user['secondary_color']); ?>">
                        </div><br><hr class="thin-line-darker" style="width: unset !important;">
                        <b>Border Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the border color of all the elements.</span><br>
                        <div class="customization-module" id="bordercolor" style="float: right;position: relative;bottom: 30px;" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="color" id="bordercolorpicker" name="bordercolor" value="<?php echo htmlspecialchars($_user['border_color']); ?>">
                        </div><br><hr class="thin-line-darker" style="width: unset !important;"><br><br><br>
                        <input class="yt-uix-button yt-uix-button-default" style="position: absolute;left: 6px;bottom: 8px;" type="submit" value="Set">
                    </td>
                    <td class="right-side-customization">
                        <b>Background Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the background of all the other boxes including the top featured area.</span><br>
                        <div class="customization-module" id="boxbackgroundcolor" style="float: right;position: relative;bottom: 30px;" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="color" id="solidcolorbackground" name="backgroundcolor" value="<?php echo htmlspecialchars($_user['third_color']); ?>">
                        </div><br><hr class="thin-line-darker">
                        <b>Text Main Color</b><br>
                        <span style="font-size: 11px;display: inline-block;width: 256px;" class="grey-text">This will change the color of the text for boxes.</span><br>
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
                    <td class="left-side-customization">
                        <b>Background Options</b> <br>
                        <span style="font-size: 11px;" class="grey-text">Choose how your background will be displayed.</span><br>
                        <div class="customization-module"  id="backgroundoptions" method="post" action="/d/channel_update" enctype="multipart/form-data">
                            <select class="yt-uix-button yt-uix-button-default" style="    position: relative;bottom: -2px;right: 4px;"   name="bgoption" id="ifyouarereadingthisYOUSUCK">
                                <option value="repeaty">Repeat - Y</option>
                                <option value="repeatx">Repeat - X</option>
                                <option value="norepeat">No Repeat</option>
                                <option value="repeatxy">Repeat - X and Y</option>
                                <option value="stretch">Stretch</option>
                                <option value="solid">Solid</option>
                            </select>
                            <div style="float: right;">
                                <input style="position: relative;bottom: -2px;" type="color" id="solidcolor" name="solidcolor" value="<?php echo htmlspecialchars($_user['2009_bgcolor']); ?>">
                            </div>
                        </div><br><br>

                        <hr class="thin-line-darker" style="width: unset;">
                        <br><br>
                        <input class="yt-uix-button yt-uix-button-default" style="position: absolute;left: 6px;bottom: 8px;" type="submit" value="Set">
                    </td>
                    <td class="right-side-customization">
                        <b>Background</b> <br>
                        <span style="font-size: 11px;" class="grey-text">Choose Image (Max file size: 10MB)</span><br>
                        <div class="customization-module"  id="backgroundimage" method="post" action="/d/channel_update" enctype="multipart/form-data">
                            <input type="file" name="backgroundbgset" id="background-upload">
                            <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                        </div><br><br> 

                        <hr class="thin-line-darker">
                    </td>
                </form>
                </tr>
            </table>
        </div>
    </div>
</div>
<script>
    const solid_color = document.querySelector("#channelboxcolorpicker");

    solid_color.addEventListener("input",(event)=>{
        $(".channel-box-description").css("background", solid_color.value);
        $("#secondary_color_thinglo").css("background", solid_color.value);
        $("#channel-top-right-ribb").css("background", solid_color.value);
        $("#welcome-to-subrocks-acc").css("border", "2px solid " + solid_color.value);
    });

    const border_color = document.querySelector("#bordercolorpicker");

    border_color.addEventListener("input",(event)=>{
        $(".channel-box-description").css("border", "1px solid" + border_color.value);
        $(".channel-box-no-bg").css("border", "1px solid" + border_color.value);
        $(".featured-video-info").css("border", "1px solid" + border_color.value);
    });

    const background_color = document.querySelector("#solidcolorbackground");

    background_color.addEventListener("input",(event)=>{
        $(".channel-box-no-bg").css("background-color", background_color.value);
        $(".featured-video-info").css("background-color", background_color.value);
        $(".benifits-outer-front").css("background-color", background_color.value);
        $(".benifits-inner-front").css("background-color", background_color.value);
        $(".www-channel-top").css("background-color", background_color.value);
        $(".right_arrow").css("border-left-color", background_color.value);
        $(".view-button .a").css("border-left-color", background_color.value);
        $(".tri").css("border-top-color", background_color.value);
        $(".tri").css("border-bottom-color", background_color.value);
        $(".tri").css("background-color", background_color.value);
        $(".a .tri").css("color", background_color.value);
    });

    const text_color = document.querySelector("#textmaincolor");

    text_color.addEventListener("input",(event)=>{
        $(".channel-box-description").css("color", text_color.value);
        $(".channel-box-no-bg").css("color", text_color.value);
        $(".www-channel-left a").css("color", text_color.value);
        $(".www-channel-right a").css("color", text_color.value);
        $(".www-channel-left a").css("color", text_color.value);
        $(".benifits-inner-front a").css("color", text_color.value);
        $(".featured-video-info a").css("color", text_color.value);
    });

    const channel_box_color = document.querySelector("#solidcolor");

    channel_box_color.addEventListener("input",(event)=>{
        $(".channel-box-description").css("color", channel_box_color.value);
        $(".thin-line").css("border-top", channel_box_color.value);
        $(".channel-box-top").css("background", channel_box_color.value);
        $(".channel-box-no-bg").css("color", channel_box_color.value);
        $(".channel-pfp").css("border-color", channel_box_color.value);
        $(".channel-pfp").css("border", "3px double " + channel_box_color.value);
        $(".comment-pfp").css("border-color", channel_box_color.value);
        $(".comment-pfp").css("border", "3px double " + channel_box_color.value);
        $(".www-channel-section").css("background", channel_box_color.value);
        $("#lower-part-channel").css("background-color", channel_box_color.value);
        $(".featured-video-info").css("background-color", channel_box_color.value);
        $("#top-channel-section").css("background-color", channel_box_color.value);
        $(".view-button").css("background-color", channel_box_color.value);
    });
</script>
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
                    $("#bio-changeme").text($("#biom").val());
                }
            } );
            e.preventDefault();
        } 
    );
</script>
<script src="/s/js/channelEdit.js"></script>
<script src="/s/js/alert.js"></script>
