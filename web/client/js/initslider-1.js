jQuery(document).ready(function(){

    var scripts = document.getElementsByTagName("script");

    var jsFolder = "";

    for (var i= 0; i< scripts.length; i++)

    {

        if( scripts[i].src && scripts[i].src.match(/initslider-1\.js/i))

            jsFolder = scripts[i].src.substr(0, scripts[i].src.lastIndexOf("/") + 1);

    }

    jQuery("#amazingslider-1").amazingslider({

        jsfolder:jsFolder,

        width:513,

        height:292,

        skinsfoldername:"../js",

        loadimageondemand:false,

        watermarktextcss:"font:12px Arial,Tahoma,Helvetica,sans-serif;color:#333;padding:2px 4px;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;background-color:#fff;opacity:0.9;filter:alpha(opacity=90);",

        watermarkstyle:"text",

        enabletouchswipe:true,

        fullscreen:false,

        autoplayvideo:false,

        addmargin:true,

        watermarklinkcss:"text-decoration:none;font:12px Arial,Tahoma,Helvetica,sans-serif;color:#333;",

        watermarktext:"amazingslider.com",

        watermarklink:"http://amazingslider.com?source=watermark",

        randomplay:false,

        isresponsive:true,

        pauseonmouseover:false,

        playvideoonclickthumb:true,

        showwatermark:false,

        slideinterval:5000,

        watermarkpositioncss:"display:block;position:absolute;bottom:4px;right:4px;",

        watermarkimage:"",

        fullwidth:false,

        transitiononfirstslide:false,

        watermarktarget:"_blank",

        scalemode:"fill",

        loop:0,

        autoplay:false,

        navplayvideoimage:"play-32-32-0.png",

        navpreviewheight:60,

        timerheight:2,

        descriptioncssresponsive:"font-size:12px;",

        shownumbering:false,

        skin:"Events",

        addgooglefonts:false,

        navshowplaypause:true,

        navshowplayvideo:false,

        navshowplaypausestandalonemarginx:8,

        navshowplaypausestandalonemarginy:8,

        navbuttonradius:0,

        navpreviewposition:"top",

        navradius:0,

        showshadow:false,

        navfeaturedarrowimagewidth:16,

        navpreviewwidth:120,

        googlefonts:"",

        textpositionmarginright:24,

        textautohide:true,

        navthumbnavigationarrowimagewidth:17,

        navthumbtitlehovercss:"text-decoration:underline;",

        texteffectresponsivesize:600,

        navcolor:"#999999",

        arrowwidth:32,

        texteffecteasing:"easeOutCubic",

        texteffect:"slide",

        navspacing:10,

        playvideoimage:"playvideo-64-64-0.png",

        ribbonimage:"ribbon_topleft-0.png",

        navwidth:122,

        navheight:91,

        arrowimage:"arrows-32-32-0.png",

        timeropacity:0.6,

        titlecssresponsive:"font-size:12px;",

        navthumbnavigationarrowimage:"carouselarrows-32-32-0.png",

        navshowplaypausestandalone:true,

        texteffect1:"slide",

        navpreviewbordercolor:"#ffffff",

        ribbonposition:"topleft",

        navthumbdescriptioncss:"display:block;position:relative;padding:2px 4px;text-align:left;font:normal 12px Arial,Helvetica,sans-serif;color:#333;",

        arrowstyle:"none",

        navthumbtitleheight:18,

        textpositionmargintop:24,

        navswitchonmouseover:false,

        navarrowimage:"navarrows-28-28-0.png",

        arrowtop:50,

        textstyle:"none",

        playvideoimageheight:64,

        navfonthighlightcolor:"#666666",

        showbackgroundimage:false,

        navpreviewborder:4,

        navshowplaypausestandaloneheight:48,

        shadowcolor:"#aaaaaa",

        navbuttonshowbgimage:true,

        navbuttonbgimage:"navbuttonbgimage-28-28-0.png",

        navthumbnavigationarrowimageheight:48,

        textbgcss:"display:none;",

        textpositiondynamic:"bottomleft",

        navpreviewarrowwidth:16,

        navdirection:"horizontal",

        navshowpreviewontouch:false,

        bottomshadowimagewidth:96,

        showtimer:false,

        playvideoimagewidth:64,

        navshowpreview:false,

        navmarginy:20,

        navmarginx:16,

        navfeaturedarrowimage:"featuredarrow-16-8-0.png",

        showribbon:false,

        navstyle:"thumbnails",

        textpositionmarginleft:24,

        descriptioncss:"display:block; position:relative; font:12px \"Lucida Sans Unicode\",\"Lucida Grande\",sans-serif,Arial; color:#fff; margin-top:8px;",

        navplaypauseimage:"navplaypause-48-48-0.png",

        backgroundimagetop:-10,

        timercolor:"#ffffff",

        numberingformat:"%NUM/%TOTAL ",

        navfontsize:12,

        navhighlightcolor:"#333333",

        texteffectdelay1:1000,

        navimage:"bullet-24-24-5.png",

        texteffectduration1:600,

        navshowplaypausestandaloneautohide:true,

        navbuttoncolor:"",

        navshowarrow:false,

        texteffectslidedirection:"left",

        navshowfeaturedarrow:false,

        lightboxbarheight:48,

        titlecss:"display:block; position:relative; font:bold 14px \"Lucida Sans Unicode\",\"Lucida Grande\",sans-serif,Arial; color:#fff;",

        ribbonimagey:0,

        ribbonimagex:0,

        texteffectslidedistance1:120,

        navshowplaypausestandaloneposition:"bottomright",

        navshowbuttons:false,

        arrowhideonmouseleave:1000,

        navshowplaypausestandalonewidth:48,

        navfeaturedarrowimageheight:8,

        navopacity:1.0,

        backgroundimagewidth:120,

        bordercolor:"#ffffff",

        navthumbtitlewidth:120,

        texteffectseparate:false,

        arrowheight:32,

        arrowmargin:8,

        texteffectduration:600,

        bottomshadowimage:"bottomshadow-110-95-4.png",

        border:0,

        timerposition:"bottom",

        navfontcolor:"#333333",

        navthumbnavigationstyle:"arrow",

        borderradius:0,

        navbuttonhighlightcolor:"",

        textpositionstatic:"bottom",

        navthumbstyle:"imageonly",

        texteffecteasing1:"easeOutCubic",

        textcss:"display:block; padding:12px; text-align:left;",

        navbordercolor:"#ffffff",

        navpreviewarrowheight:8,

        navpreviewarrowimage:"previewarrow-16-8-0.png",

        showbottomshadow:false,

        texteffectslidedistance:30,

        texteffectdelay:500,

        textpositionmarginstatic:0,

        backgroundimage:"",

        navposition:"bottom",

        texteffectslidedirection1:"right",

        navborder:0,

        textformat:"Bottom left",

        bottomshadowimagetop:95,

        texteffectresponsive:true,

        shadowsize:5,

        navthumbtitlecss:"display:block;position:relative;padding:2px 4px;text-align:center;font:bold 12px Arial,Helvetica,sans-serif;color:#333;",

        textpositionmarginbottom:24,

        ribbonmarginy:0,

        ribbonmarginx:0,

        slide: {

            duration:1000,

            easing:"easeOutCubic",

            checked:true,

            effectdirection:0

        },

        transition:"slide",

        isfullscreen:false,

        textformat: {



        }

    });

});