<?php

/*
		<title><?php echo $__server->page_embeds->page_title; ?></title>
		<meta property="og:title" content="<?php echo $__server->page_embeds->page_title; ?>" />
		<meta property="og:url" content="<?php echo $__server->page_embeds->page_url; ?>" />
		<meta property="og:description" content="<?php echo $__server->page_embeds->page_description; ?>" />
		<meta property="og:image" content="<?php echo $__server->page_embeds->page_image; ?>" />
        <script>
            var yt = yt || {};yt.timing = yt.timing || {};yt.timing.tick = function(label, opt_time) {var timer = yt.timing['timer'] || {};if(opt_time) {timer[label] = opt_time;}else {timer[label] = new Date().getTime();}yt.timing['timer'] = timer;};yt.timing.info = function(label, value) {var info_args = yt.timing['info_args'] || {};info_args[label] = value;yt.timing['info_args'] = info_args;};yt.timing.info('e', "904821,919006,922401,920704,912806,913419,913546,913556,919349,919351,925109,919003,920201,912706");if (document.webkitVisibilityState == 'prerender') {document.addEventListener('webkitvisibilitychange', function() {yt.timing.tick('start');}, false);}yt.timing.tick('start');yt.timing.info('li','0');try {yt.timing['srt'] = window.gtbExternal && window.gtbExternal.pageT() ||window.external && window.external.pageT;} catch(e) {}if (window.chrome && window.chrome.csi) {yt.timing['srt'] = Math.floor(window.chrome.csi().pageT);}if (window.msPerformance && window.msPerformance.timing) {yt.timing['srt'] = window.msPerformance.timing.responseStart - window.msPerformance.timing.navigationStart;}    
        </script>
        <link id="www-core-css" rel="stylesheet" href="/yt/cssbin/www-core-vfluMRDnk.css">
        <link rel="stylesheet" href="/yt/cssbin/www-guide-vflx0V5Tq.css">
        <script>
            if (window.yt.timing) {yt.timing.tick("ct");}    
        </script>


        currently unused
*/
 
/**
* @Auther: bhief
* @Version: 1.0
* @Added Base
*
* Use this to make the head tags for every page
*
**/
class head_helper {
    public $tags;
    public $embeds;

    function add(object $dom) {
        $this->tags::append($dom);
    }

    function add_embed(object $embed) {
        $this->embeds::append($embed);
    }

    function build() {
        return $this->tags;
    }

    function build_embeds() {
        return $this->embeds;
    }
}

?>