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
                <a class="www-header-item" href="#" onclick="selectTable('#pictures-table');">
                    <button class="yt-uix-button yt-uix-button-default" style="margin-left: 0px;">Main</button>
                </a>
                <a class="www-header-item" href="#" style='display:none;' onclick="selectTable('#misc-table');">
                    <button class="yt-uix-button yt-uix-button-default">Colors</button>
                </a>
                <a class="www-header-item" href="#" onclick="selectTable('#bg-table');">
                    <button class="yt-uix-button yt-uix-button-default">Background</button>
                </a>
                <a class="www-header-item" href="#" onclick="selectTable('#layout-table');">
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
                        <div class="customization-module" id="pfp" action="/d/channel_update" enctype="multipart/form-data">
                            <input style="width: 169px;position: relative;top: 10px;" type="file" name="pfpset" id="avatar-upload">
                            <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                        </div><br><br>
                        <img src="/dynamic/pfp/<?php echo $_user['pfp']; ?>" style="width:100px;height:100px;"><br>
                        <?php if($_user['pfp'] != "default.png") { ?>
                            <a href="/get/remove_profile_pic">Remove Profile Picture</a><br>
                        <?php } ?>
                        <br><hr class="thin-line-darker" style="width:unset;">
                        <b style="position: relative;top: 11px;">Video Page Banner</b>
                        <div class="customization-module" id="watchbanner" action="/d/channel_update" enctype="multipart/form-data" style="display: inline-block;float:right;">
                            <input style="width: 169px;position: relative;top: 10px;" type="file" name="videopagebanner" id="avatar-upload">
                            <!--<button class="yt-uix-button yt-uix-button-default" id="av-uplod">Select File</button>-->
                        </div><br>                   
                        <?php if(!empty($_user['subbutton'])) { ?>
                            <a href="/get/remove_watch_banner">Remove Watch Page Banner</a><br>
                        <?php } ?><br><hr class="thin-line-darker" style="width:unset;">

                        <b>Custom CSS</b><br>
                        
                        <div class="customization-module" id="bio" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -15px;">
                            <span style="font-size: 11px;" class="grey-text">Prefix every image url() with //images.weserv.nl/?url=</span><br>    
                            <textarea class="yt-uix-form-input-text"  style="width: 288px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biomd" placeholder="Custom CSS" name="css"><?php echo htmlspecialchars($_user['css']); ?></textarea><br><br>
                        </div><br><br>
                        <input class="yt-uix-button yt-uix-button-default" style="position: absolute;left: 6px;bottom: 8px;" type="submit" value="Set">
                    </td>
                    <td class="right-side-customization">
                        <b>Bio</b><br>
                        <div class="customization-module" id="bio" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -15px;">
                            <textarea class="yt-uix-form-input-text" style="width: 344px;padding: 0px;background-color:white;border: 1px solid #d3d3d3;" id="biom" placeholder="Bio" name="bio"><?php echo htmlspecialchars($_user['bio']); ?></textarea><br>
                        </div><br><br><br><hr class="thin-line-darker" style="width:unset;">

                        <b>Featured Video</b>
                        <div class="customization-module" id="featuredvid" action="/d/channel_update" enctype="multipart/form-data" style="display: inline-block;float:right;position: relative;bottom: 6px;">
                        <input class="yt-uix-form-input-text" style="width: 291px;"  id="biomd" placeholder="Video ID" value="<?php echo htmlspecialchars($_user['featured']);?>" name="videoid">
                        </div><br><br><hr class="thin-line-darker" style="width:unset;">

                        <b>Featured Channels</b>
                        <div class="customization-module" id="featuredvid" action="/d/channel_update" enctype="multipart/form-data" style="display: inline-block;float:right;position: relative;bottom: 6px;">
                        <input class="yt-uix-form-input-text" style="width: 291px;"  id="biomd" placeholder="Seperate by commas!" value="<?php echo htmlspecialchars($_user['featured_channels']);?>" name="featuredchannels">
                        </div><br><br><hr class="thin-line-darker" style="width:unset;">

                        <b>Website</b>
                        <div class="customization-module" id="featuredvid" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -7px;">
                        <input class="yt-uix-form-input-text" style="width: 291px;"  id="biomd" placeholder="Website URL" value="<?php echo htmlspecialchars($_user['website']);?>" name="website">
                            
                        </div><br><br><hr class="thin-line-darker" style="width:unset;">

                        <?php $categories = ["None", "Director", "Musician", "Comedian", "Guru", "Nonprofit"]; ?>
                        <b>Channel Genre</b><br>
                        <span style="font-size: 11px;" class="grey-text">This will show what type of channel you are to other users.</span>
                        <div class="customization-module" id="channellayout" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -19px;">
                            <select class="yt-uix-button yt-uix-button-default" style="position:relative;top:6px;"   name="genre">
                                <?php foreach($categories as $category) { ?>
                                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                <?php } ?>
                            </select>
                            
                        </div><br><hr class="thin-line-darker" style="width:unset;" style="width: 100%;">


                        <b>Transparency</b><br>
                        <span style="font-size: 11px;" class="grey-text">This will decide the visibility of ALL of your modules.</span>
                        <div class="customization-module" id="channellayout" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -19px;">
                            <select class="yt-uix-button yt-uix-button-default" style="position:relative;top:6px;"   name="transparency">
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
                            
                        </div><br><hr class="thin-line-darker" style="width:unset;" style="width: 100%;">


                        <b>Country</b><br>
                        <div class="customization-module" id="countryselect" action="/d/channel_update" enctype="multipart/form-data" style="float: right;position: relative;top: -19px;">
                            <select class="yt-uix-button yt-uix-button-default" style="position:relative;top:6px;"  id="country" name="country" value="<?php echo $_user['country']?>">
                            <option value="Afganistan">Afghanistan</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bonaire">Bonaire</option>
                            <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                            <option value="Brunei">Brunei</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Canary Islands">Canary Islands</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Channel Islands">Channel Islands</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos Island">Cocos Island</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote DIvoire">Cote DIvoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Curaco">Curacao</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="East Timor">East Timor</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands">Falkland Islands</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Ter">French Southern Ter</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Great Britain">Great Britain</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Hawaii">Hawaii</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="India">India</option>
                            <option value="Iran">Iran</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea North">Korea North</option>
                            <option value="Korea Sout">Korea South</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Laos">Laos</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libya">Libya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macau">Macau</option>
                            <option value="Macedonia">Macedonia</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Midway Islands">Midway Islands</option>
                            <option value="Moldova">Moldova</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Nambia">Nambia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherland Antilles">Netherland Antilles</option>
                            <option value="Netherlands">Netherlands (Holland, Europe)</option>
                            <option value="Nevis">Nevis</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau Island">Palau Island</option>
                            <option value="Palestine">Palestine</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Phillipines">Philippines</option>
                            <option value="Pitcairn Island">Pitcairn Island</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Republic of Montenegro">Republic of Montenegro</option>
                            <option value="Republic of Serbia">Republic of Serbia</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russia">Russia</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="St Barthelemy">St Barthelemy</option>
                            <option value="St Eustatius">St Eustatius</option>
                            <option value="St Helena">St Helena</option>
                            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                            <option value="St Lucia">St Lucia</option>
                            <option value="St Maarten">St Maarten</option>
                            <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                            <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                            <option value="Saipan">Saipan</option>
                            <option value="Samoa">Samoa</option>
                            <option value="Samoa American">Samoa American</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syria">Syria</option>
                            <option value="Tahiti">Tahiti</option>
                            <option value="Taiwan">Taiwan</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania">Tanzania</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Erimates">United Arab Emirates</option>
                            <option value="United States of America">United States of America</option>
                            <option value="Uraguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Vatican City State">Vatican City State</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Vietnam">Vietnam</option>
                            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                            <option value="Wake Island">Wake Island</option>
                            <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zaire">Zaire</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>
                            </select>
                        
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
                            <select class="yt-uix-button yt-uix-button-default" style="position:relative;bottom:-3px;"   name="bgoption" id="ifyouarereadingthisYOUSUCK">
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
<script type="text/javascript">
<?php 
// script for the drop down value(its messy ik)
// https://stackoverflow.com/questions/3030604/php-pre-select-drop-down-option
?>
var dropDownList = document.getElementById('countryselect');
dropDownList.options[value="<?php echo $_user['country']; ?>"].select = "selected";
</script>
