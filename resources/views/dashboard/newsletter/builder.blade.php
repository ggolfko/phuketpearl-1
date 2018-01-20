<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="frame">
<head>
<meta charset="utf-8"> <!-- utf-8 works for most cases -->
<meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

<!-- Web Font / @font-face : BEGIN -->
<!-- NOTE: If web fonts are not required, lines 9 - 26 can be safely removed. -->

<!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
<!--[if mso]>
	<style>
		* {
			font-family: sans-serif !important;
		}
	</style>
<![endif]-->

<!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
<!--[if !mso]><!-->
	<!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
<!--<![endif]-->

<!-- Web Font / @font-face : END -->

<!-- CSS Reset -->
<style type="text/css">

	/* What it does: Remove spaces around the email design added by some email clients. */
	/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
    html,
    body {
        margin: 0 auto !important;
        padding: 0 !important;
        height: 100% !important;
        width: 100% !important;
    }

    /* What it does: Stops email clients resizing small text. */
    * {
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
    }

    /* What is does: Centers email on Android 4.4 */
    div[style*="margin: 16px 0"] {
        margin:0 !important;
    }

    /* What it does: Stops Outlook from adding extra spacing to tables. */
    table,
    td {
        mso-table-lspace: 0pt !important;
        mso-table-rspace: 0pt !important;
    }

    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
    table {
        border-spacing: 0 !important;
        border-collapse: collapse !important;
        table-layout: fixed !important;
        Margin: 0 auto !important;
    }
    table table table {
        table-layout: auto;
    }

    /* What it does: Uses a better rendering method when resizing images in IE. */
    img {
        -ms-interpolation-mode:bicubic;
    }

    /* What it does: Overrides styles added when Yahoo's auto-senses a link. */
    .yshortcuts a {
        border-bottom: none !important;
    }

    /* What it does: A work-around for iOS meddling in triggered links. */
    .mobile-link--footer a,
    a[x-apple-data-detectors] {
        color:inherit !important;
        text-decoration: underline !important;
    }

</style>

<!-- Progressive Enhancements -->
<style>

    /* What it does: Hover styles for buttons */
    .button-td,
    .button-a {
        transition: all 100ms ease-in;
    }
    .button-td:hover,
    .button-a:hover {
        background: #555555 !important;
        border-color: #555555 !important;
    }

    /* Media Queries */
    @media screen and (max-width: 600px) {

        .email-container {
            width: 100% !important;
        }

        /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
        .fluid,
        .fluid-centered {
            max-width: 100% !important;
            height: auto !important;
            Margin-left: auto !important;
            Margin-right: auto !important;
        }
        /* And center justify these ones. */
        .fluid-centered {
            Margin-left: auto !important;
            Margin-right: auto !important;
        }

        /* What it does: Forces table cells into full-width rows. */
        .stack-column,
        .stack-column-center {
            display: block !important;
            width: 100% !important;
            max-width: 100% !important;
            direction: ltr !important;
        }
        /* And center justify these ones. */
        .stack-column-center {
            text-align: center !important;
        }

        /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
        .center-on-narrow {
            text-align: center !important;
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
            float: none !important;
        }
        table.center-on-narrow {
            display: inline-block !important;
        }

    }
</style>
<link href="/static/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css">
<link href="/static/dashboard/newsletter/builder/app.css" rel="stylesheet" type="text/css">
<script src="/static/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/static/bower_components/angular/angular.min.js"></script>
<script src="/static/bower_components/angular-sanitize/angular-sanitize.min.js"></script>
<script src="/static/bower_components/angular-nl2br/angular-nl2br.min.js"></script>
<script src="/static/dashboard/newsletter/builder/app.js"></script>

</head>
<body bgcolor="#111111" width="100%" style="Margin: 0;" ng-controller="Frame" id="Frame">
<table bgcolor="#111111" cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" style="border-collapse:collapse;"><tr><td valign="top">
    <center style="width: 100%;">

        <!-- Email Header : BEGIN -->
        <table data-table="1" align="center" width="600" class="email-container ui-block" ng-controller="Block" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)" ng-class="{'focus': focus, 'ui-hidden': !parent.blocks.section1}">
            <tr>
                <td style="padding: 20px 0; text-align: center;">
                    <div class="block-name" ng-class="{'ui-hidden':!focus}">Section 1</div>
                    <div class="block-options" ng-class="{'ui-hidden':!focus}" style="margin-right:-36px;">
                        <a href="#" ng-click="toggleBlock($event, 'section1')"><i class="ion-close"></i></a>
                    </div>
                    <table class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                        <tr>
                            <td>
                                <img ng-src="[[(parent.images.section1[0]?'/app/newsletter/'+parent.images.section1[0]+'.png':'https://placehold.it/140x70')]]" width="140" height="70" border="0" ng-hide="objectFocus">
                                <a href="#" ng-click="edit($event, 'image', 'section1', 0)" class="object-focus" ng-show="objectFocus">
                                    <img ng-src="[[(parent.images.section1[0]?'/app/newsletter/'+parent.images.section1[0]+'.png':'https://placehold.it/140x70')]]" width="140" height="70" border="0">
                                    <div class="object-focus-bg">
                                        <div class="icon"><i class="ion-image"></i></div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!-- Email Header : END -->

        <!-- Email Body : BEGIN -->
        <table data-table="2" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="600" class="email-container" style="position:relative;">

            <!-- Hero Image, Flush : BEGIN -->
            <tr class="ui-block noborder" ng-controller="Block" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)" ng-class="{'focus': focus, 'ui-hidden': !parent.blocks.section2}">
				<td style="position:relative;">
                    <div class="block-name" ng-class="{'ui-hidden':!focus}" style="color:#000;">Section 2</div>
                    <div class="block-options" ng-class="{'ui-hidden':!focus}">
                        <a href="#" ng-click="toggleBlock($event, 'section2')"><i class="ion-close"></i></a>
                    </div>
                    <table class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                        <tr>
                            <td style="padding: 0px;">
                                <img ng-src="[[(parent.images.section2[0]?'/app/newsletter/'+parent.images.section2[0]+'.png':'https://placehold.it/600x300')]]" width="100%" height="" border="0" align="center" style="width: 100%; max-width: 100%;" ng-hide="objectFocus">
                                <a href="#" ng-click="edit($event, 'image', 'section2', 0)" class="object-focus" ng-show="objectFocus">
                                    <img ng-src="[[(parent.images.section2[0]?'/app/newsletter/'+parent.images.section2[0]+'.png':'https://placehold.it/600x300')]]" width="100%" height="" border="0" align="center" style="width: 100%; max-width: 100%;">
                                    <div class="object-focus-bg">
                                        <div class="icon"><i class="ion-image"></i></div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    </table>
				</td>
            </tr>
            <!-- Hero Image, Flush : END -->

            <!-- 1 Column Text : BEGIN -->
            <tr class="ui-block noborder" ng-controller="Block" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)" ng-class="{'focus': focus, 'ui-hidden': !parent.blocks.section3}">
                <td style="position: relative; padding: 40px; text-align: center; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;">
                    <div class="block-name" ng-class="{'ui-hidden':!focus}" style="color:#000;">Section 3</div>
                    <div class="block-options" ng-class="{'ui-hidden':!focus}">
                        <a href="#" ng-click="toggleBlock($event, 'section3')"><i class="ion-close"></i></a>
                    </div>
                    <table class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                        <tr>
                            <td>
								<span ng-hide="objectFocus">
									<span ng-if="parent.text.section3[0]" ng-bind-html="(parent.text.section3[0] | nl2br)"></span>
									<span ng-if="!parent.text.section3[0]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent laoreet malesuada cursus. Maecenas scelerisque congue eros eu posuere. Praesent in felis ut velit pretium lobortis rhoncus ut&nbsp;erat.</span>
								</span>
                                <a href="#" ng-click="edit($event, 'text', 'section3', 0, 'multiple')" class="object-focus" ng-show="objectFocus" style="color: #555555;">
                                    <span>
										<span ng-if="parent.text.section3[0]" ng-bind-html="(parent.text.section3[0] | nl2br)"></span>
										<span ng-if="!parent.text.section3[0]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent laoreet malesuada cursus. Maecenas scelerisque congue eros eu posuere. Praesent in felis ut velit pretium lobortis rhoncus ut&nbsp;erat.</span>
									</span>
                                    <div class="object-focus-bg">
                                        <div class="icon"><i class="ion-edit"></i></div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    </table>
                    <br><br>
                    <!-- Button : Begin -->
                    <table cellspacing="0" cellpadding="0" border="0" align="center" style="Margin: auto;" class="object-wrapper"ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                        <tr>
                            <td style="position: relative; border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                <a href="#" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">[[(parent.buttons.section3[0].text?parent.buttons.section3[0].text:'A Button')]]</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                </a>
                                <a href="#" ng-click="edit($event, 'button', 'section3', 0)" class="object-focus-bg" ng-show="objectFocus">
                                    <div class="icon"><i class="ion-link"></i></div>
                                </a>
                            </td>
                        </tr>
                    </table>
                    <!-- Button : END -->
                </td>
            </tr>
            <!-- 1 Column Text : BEGIN -->

            <!-- Background Image with Text : BEGIN -->
            <tr class="ui-block noborder" ng-controller="Block" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)" ng-class="{'focus': focus, 'ui-hidden': !parent.blocks.section4}">
                <!-- Bulletproof Background Images c/o https://backgrounds.cm -->
                <td ng-style="{'background-image':parent.images.section4[0]?'url(/app/newsletter/'+parent.images.section4[0]+'.png)':'url(https://placehold.it/600x230/222222/666666)'}" bgcolor="#222222" valign="middle" style="text-align: center; background-position: center center !important; background-size: cover !important; position: relative;">
                    <div class="block-name" ng-class="{'ui-hidden':!focus}">Section 4</div>
                    <div class="block-options" ng-class="{'ui-hidden':!focus}">
                        <a href="#" ng-click="toggleBlock($event, 'section4')"><i class="ion-close"></i></a>
                    </div>
                    <div>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                            <tr>
                                <td valign="middle" style="text-align: center; padding: 40px; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #ffffff; position: relative;">
									<span ng-hide="objectFocus">
										<span ng-if="parent.text.section4[0]" ng-bind-html="(parent.text.section4[0] | nl2br)"></span>
										<span ng-if="!parent.text.section4[0]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent laoreet malesuada cursus. Maecenas scelerisque congue eros eu posuere. Praesent in felis ut velit pretium lobortis rhoncus ut&nbsp;erat.</span>
									</span>
                                    <div class="object-focus" ng-show="objectFocus" style="color: #ffffff; min-width: 50px;">
										<span ng-if="parent.text.section4[0]" ng-bind-html="(parent.text.section4[0] | nl2br)"></span>
										<span ng-if="!parent.text.section4[0]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent laoreet malesuada cursus. Maecenas scelerisque congue eros eu posuere. Praesent in felis ut velit pretium lobortis rhoncus ut&nbsp;erat.</span>
                                        <div class="object-focus-bg">
                                            <div class="icon">
                                                <i class="ion-edit" ng-click="edit($event, 'text', 'section4', 0, 'multiple')" style="margin-right: 5px;"></i>
                                                <i class="ion-image" ng-click="edit($event, 'image', 'section4', 0)" style="margin-left: 5px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <!-- Background Image with Text : END -->

            <!-- 2 Even Columns : BEGIN -->
            <tr class="ui-block noborder" ng-controller="Block" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)" ng-class="{'focus': focus, 'ui-hidden': !parent.blocks.section5}">
                <td align="center" valign="top" style="padding: 10px; position: relative;">
                    <div class="block-name" ng-class="{'ui-hidden':!focus}" style="color:#000; padding-top: 4px; padding-left: 20px;">Section 5</div>
                    <div class="block-options" ng-class="{'ui-hidden':!focus}">
                        <a href="#" ng-click="toggleBlock($event, 'section5')"><i class="ion-close"></i></a>
                    </div>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="padding: 10px; text-align: center; position: relative;">
                                            <img ng-src="[[(parent.images.section5[0]?'/app/newsletter/'+parent.images.section5[0]+'.png':'https://placehold.it/270')]]" width="270" height="270" border="0" class="fluid" ng-hide="objectFocus">
                                            <a href="#" ng-click="edit($event, 'image', 'section5', 0)" class="object-focus" ng-show="objectFocus" style="color: #ffffff;">
                                                <img ng-src="[[(parent.images.section5[0]?'/app/newsletter/'+parent.images.section5[0]+'.png':'https://placehold.it/270')]]" width="270" height="270" border="0" class="fluid">
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-image"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
											<span ng-hide="objectFocus">
												<span ng-if="parent.text.section5[0]" ng-bind-html="(parent.text.section5[0] | nl2br)"></span>
												<span ng-if="!parent.text.section5[0]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
											</span>
                                            <a href="#" ng-click="edit($event, 'text', 'section5', 0, 'multiple')" class="object-focus" ng-show="objectFocus" style="color: #555555;">
												<span ng-if="parent.text.section5[0]" ng-bind-html="(parent.text.section5[0] | nl2br)"></span>
												<span ng-if="!parent.text.section5[0]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-edit"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="padding: 10px; text-align: center; position: relative;">
                                            <img ng-src="[[(parent.images.section5[1]?'/app/newsletter/'+parent.images.section5[1]+'.png':'https://placehold.it/270')]]" width="270" height="270" border="0" class="fluid" ng-hide="objectFocus">
                                            <a href="#" ng-click="edit($event, 'image', 'section5', 1)" class="object-focus" ng-show="objectFocus" style="color: #ffffff;">
                                                <img ng-src="[[(parent.images.section5[1]?'/app/newsletter/'+parent.images.section5[1]+'.png':'https://placehold.it/270')]]" width="270" height="270" border="0" class="fluid">
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-image"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
											<span ng-hide="objectFocus">
												<span ng-if="parent.text.section5[1]" ng-bind-html="(parent.text.section5[1] | nl2br)"></span>
												<span ng-if="!parent.text.section5[1]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
											</span>
                                            <a href="#" ng-click="edit($event, 'text', 'section5', 1, 'multiple')" class="object-focus" ng-show="objectFocus" style="color: #555555;">
												<span ng-if="parent.text.section5[1]" ng-bind-html="(parent.text.section5[1] | nl2br)"></span>
												<span ng-if="!parent.text.section5[1]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-edit"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- 2 Even Columns : END -->

            <!-- 3 Even Columns : BEGIN -->
            <tr class="ui-block noborder" ng-controller="Block" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)" ng-class="{'focus': focus, 'ui-hidden': !parent.blocks.section6}">
                <td align="center" valign="top" style="padding: 10px; position: relative;">
                    <div class="block-name" ng-class="{'ui-hidden':!focus}" style="color:#000; padding-top: 4px; padding-left: 20px;">Section 6</div>
                    <div class="block-options" ng-class="{'ui-hidden':!focus}">
                        <a href="#" ng-click="toggleBlock($event, 'section6')"><i class="ion-close"></i></a>
                    </div>
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="padding: 10px; padding-left: 8px; text-align: center; position: relative;">
                                            <img ng-src="[[(parent.images.section6[0]?'/app/newsletter/'+parent.images.section6[0]+'.png':'https://placehold.it/170')]]" width="170" height="170" border="0" class="fluid" ng-hide="objectFocus">
                                            <a href="#" ng-click="edit($event, 'image', 'section6', 0)" class="object-focus" ng-show="objectFocus" style="color: #ffffff;">
                                                <img ng-src="[[(parent.images.section6[0]?'/app/newsletter/'+parent.images.section6[0]+'.png':'https://placehold.it/170')]]" width="170" height="170" border="0" class="fluid">
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-image"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
											<span ng-hide="objectFocus">
												<span ng-if="parent.text.section6[0]" ng-bind-html="(parent.text.section6[0] | nl2br)"></span>
												<span ng-if="!parent.text.section6[0]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
											</span>
                                            <a href="#" ng-click="edit($event, 'text', 'section6', 0, 'multiple')" class="object-focus" ng-show="objectFocus" style="color: #555555;">
												<span ng-if="parent.text.section6[0]" ng-bind-html="(parent.text.section6[0] | nl2br)"></span>
												<span ng-if="!parent.text.section6[0]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-edit"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="padding: 10px; padding-left: 8px; text-align: center; position: relative;">
                                            <img ng-src="[[(parent.images.section6[1]?'/app/newsletter/'+parent.images.section6[1]+'.png':'https://placehold.it/170')]]" width="170" height="170" border="0" class="fluid" ng-hide="objectFocus">
                                            <a href="#" ng-click="edit($event, 'image', 'section6', 1)" class="object-focus" ng-show="objectFocus" style="color: #ffffff;">
                                                <img ng-src="[[(parent.images.section6[1]?'/app/newsletter/'+parent.images.section6[1]+'.png':'https://placehold.it/170')]]" width="170" height="170" border="0" class="fluid">
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-image"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
											<span ng-hide="objectFocus">
												<span ng-if="parent.text.section6[1]" ng-bind-html="(parent.text.section6[1] | nl2br)"></span>
												<span ng-if="!parent.text.section6[1]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
											</span>
                                            <a href="#" ng-click="edit($event, 'text', 'section6', 1, 'multiple')" class="object-focus" ng-show="objectFocus" style="color: #555555;">
												<span ng-if="parent.text.section6[1]" ng-bind-html="(parent.text.section6[1] | nl2br)"></span>
												<span ng-if="!parent.text.section6[1]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-edit"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="padding: 10px; padding-left: 8px; text-align: center; position: relative;">
                                            <img ng-src="[[(parent.images.section6[2]?'/app/newsletter/'+parent.images.section6[2]+'.png':'https://placehold.it/170')]]" width="170" height="170" border="0" class="fluid" ng-hide="objectFocus">
                                            <a href="#" ng-click="edit($event, 'image', 'section6', 2)" class="object-focus" ng-show="objectFocus" style="color: #ffffff;">
                                                <img ng-src="[[(parent.images.section6[2]?'/app/newsletter/'+parent.images.section6[2]+'.png':'https://placehold.it/170')]]" width="170" height="170" border="0" class="fluid">
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-image"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
											<span ng-hide="objectFocus">
												<span ng-if="parent.text.section6[2]" ng-bind-html="(parent.text.section6[2] | nl2br)"></span>
												<span ng-if="!parent.text.section6[2]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
											</span>
                                            <a href="#" ng-click="edit($event, 'text', 'section6', 2, 'multiple')" class="object-focus" ng-show="objectFocus" style="color: #555555;">
												<span ng-if="parent.text.section6[2]" ng-bind-html="(parent.text.section6[2] | nl2br)"></span>
												<span ng-if="!parent.text.section6[2]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-edit"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- 3 Even Columns : END -->

            <!-- Thumbnail Left, Text Right : BEGIN -->
            <tr class="ui-block noborder" ng-controller="Block" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)" ng-class="{'focus': focus, 'ui-hidden': !parent.blocks.section7}">
                <td dir="ltr" align="center" valign="top" width="100%" style="padding: 10px; position: relative;">
                    <div class="block-name" ng-class="{'ui-hidden':!focus}" style="color:#000; padding-top: 2px; padding-left: 20px;">Section 7</div>
                    <div class="block-options" ng-class="{'ui-hidden':!focus}">
                        <a href="#" ng-click="toggleBlock($event, 'section7')"><i class="ion-close"></i></a>
                    </div>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td dir="ltr" valign="top" style="padding: 10px 10px;">
                                            <img ng-src="[[(parent.images.section7[0]?'/app/newsletter/'+parent.images.section7[0]+'.png':'https://placehold.it/170')]]" width="170" width="170" border="0" class="center-on-narrow" ng-hide="objectFocus">
                                            <a href="#" ng-click="edit($event, 'image', 'section7', 0)" class="object-focus" ng-show="objectFocus" style="color: #ffffff;">
                                                <img ng-src="[[(parent.images.section7[0]?'/app/newsletter/'+parent.images.section7[0]+'.png':'https://placehold.it/170')]]" width="170" width="170" border="0" class="center-on-narrow">
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-image"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td width="66.66%" class="stack-column-center" valign="top">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="top" style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 10px; text-align: left;" class="center-on-narrow">
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tr style="color:#111111;" class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                                    <td style="padding-bottom: 20px;">
                                                        <strong ng-hide="objectFocus">[[(parent.text.section7[0]?parent.text.section7[0]:'Class aptent taciti sociosqu')]]</strong>
                                                        <a href="#" ng-click="edit($event, 'text', 'section7', 0, 'single')" class="object-focus" ng-show="objectFocus" style="color: #111111;">
                                                            <strong>[[(parent.text.section7[0]?parent.text.section7[0]:'Class aptent taciti sociosqu')]]</strong>
                                                            <div class="object-focus-bg">
                                                                <div class="icon"><i class="ion-edit"></i></div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                                    <td style="padding-bottom: 23px;">
                                                        <span ng-hide="objectFocus">
															<span ng-if="parent.text.section7[1]" ng-bind-html="(parent.text.section7[1] | nl2br)"></span>
															<span ng-if="!parent.text.section7[1]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
														</span>
                                                        <a href="#" ng-click="edit($event, 'text', 'section7', 1, 'multiple')" class="object-focus" ng-show="objectFocus" style="color: #555555;">
															<span ng-if="parent.text.section7[1]" ng-bind-html="(parent.text.section7[1] | nl2br)"></span>
															<span ng-if="!parent.text.section7[1]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
                                                            <div class="object-focus-bg">
                                                                <div class="icon"><i class="ion-edit"></i></div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- Button : Begin -->
                                            <table cellspacing="0" cellpadding="0" border="0" class="center-on-narrow" style="float:left;">
                                                <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                                    <td style="position: relative; border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                                        <a href="#" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">[[(parent.buttons.section7[0].text?parent.buttons.section7[0].text:'A Button')]]</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </a>
                                                        <a href="#" ng-click="edit($event, 'button', 'section7', 0)" class="object-focus-bg" ng-show="objectFocus">
                                                            <div class="icon"><i class="ion-link"></i></div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- Button : END -->
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Thumbnail Left, Text Right : END -->

            <!-- Thumbnail Right, Text Left : BEGIN -->
            <tr class="ui-block noborder" ng-controller="Block" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)" ng-class="{'focus': focus, 'ui-hidden': !parent.blocks.section8}">
                <td dir="rtl" align="center" valign="top" width="100%" style="padding: 10px; position: relative;">
                    <div class="block-name" ng-class="{'ui-hidden':!focus}" style="color:#000; padding-top: 2px; padding-left: 20px;">Section 8</div>
                    <div class="block-options" ng-class="{'ui-hidden':!focus}">
                        <a href="#" ng-click="toggleBlock($event, 'section8')"><i class="ion-close"></i></a>
                    </div>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                        <td dir="ltr" valign="top" style="padding: 10px 10px;">
                                            <img ng-src="[[(parent.images.section8[0]?'/app/newsletter/'+parent.images.section8[0]+'.png':'https://placehold.it/170')]]" width="170" width="170" border="0" class="center-on-narrow" ng-hide="objectFocus">
                                            <a href="#" ng-click="edit($event, 'image', 'section8', 0)" class="object-focus" ng-show="objectFocus" style="color: #ffffff;">
                                                <img ng-src="[[(parent.images.section8[0]?'/app/newsletter/'+parent.images.section8[0]+'.png':'https://placehold.it/170')]]" width="170" width="170" border="0" class="center-on-narrow">
                                                <div class="object-focus-bg">
                                                    <div class="icon"><i class="ion-image"></i></div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td width="66.66%" class="stack-column-center" valign="top">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="top" style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 10px; text-align: left;" class="center-on-narrow">
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tr style="color:#111111;" class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                                    <td style="padding-bottom: 20px;">
                                                        <strong ng-hide="objectFocus">[[(parent.text.section8[0]?parent.text.section8[0]:'Class aptent taciti sociosqu')]]</strong>
                                                        <a href="#" ng-click="edit($event, 'text', 'section8', 0, 'single')" class="object-focus" ng-show="objectFocus" style="color: #111111;">
                                                            <strong>[[(parent.text.section8[0]?parent.text.section8[0]:'Class aptent taciti sociosqu')]]</strong>
                                                            <div class="object-focus-bg">
                                                                <div class="icon"><i class="ion-edit"></i></div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                                    <td style="padding-bottom: 23px;">
														<span ng-hide="objectFocus">
															<span ng-if="parent.text.section8[1]" ng-bind-html="(parent.text.section8[1] | nl2br)"></span>
															<span ng-if="!parent.text.section8[1]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
														</span>
                                                        <a href="#" ng-click="edit($event, 'text', 'section8', 1, 'multiple')" class="object-focus" ng-show="objectFocus" style="color: #555555;">
															<span ng-if="parent.text.section8[1]" ng-bind-html="(parent.text.section8[1] | nl2br)"></span>
															<span ng-if="!parent.text.section8[1]">Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</span>
                                                            <div class="object-focus-bg">
                                                                <div class="icon"><i class="ion-edit"></i></div>
                                                            </div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- Button : Begin -->
                                            <table cellspacing="0" cellpadding="0" border="0" class="center-on-narrow" style="float:left;">
                                                <tr class="object-wrapper" ng-controller="Object" ng-mouseenter="mouseenter($event)" ng-mouseleave="mouseleave($event)">
                                                    <td style="position: relative; border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                                        <a href="#" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">[[(parent.buttons.section8[0].text?parent.buttons.section8[0].text:'A Button')]]</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </a>
                                                        <a href="#" ng-click="edit($event, 'button', 'section8', 0)" class="object-focus-bg" ng-show="objectFocus">
                                                            <div class="icon"><i class="ion-link"></i></div>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- Button : END -->
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Thumbnail Right, Text Left : END -->

        </table>
        <!-- Email Body : END -->

        <!-- Email Footer : BEGIN -->
        <table data-table="3" align="center" width="600" class="email-container ui-block bg-black">
            <tr>
                <td style="padding: 20px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">
                    <div style="padding: 0px 30px;">
						&nbsp;
					</div>
                </td>
            </tr>
        </table>
        <!-- Email Footer : END -->

    </center>
</td></tr></table>
</body>
</html>
