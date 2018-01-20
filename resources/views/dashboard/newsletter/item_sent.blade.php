<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
            Margin-left: auto !important;
            Margin-right: auto !important;
            float: none !important;
        }
        table.center-on-narrow {
            display: inline-block !important;
        }

    }
.ui-hidden {display: none !important;}
</style>
</head>
<body bgcolor="#111111" width="100%" style="Margin: 0;">
<table bgcolor="#111111" cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" style="border-collapse:collapse;"><tr><td valign="top">
    <center style="width: 100%;">

        @if($draft->blocks_section1 == '1')
        <!-- Email Header : BEGIN -->
        <table align="center" width="600" class="email-container" ng-class="{'ui-hidden':!parent.blocks.section1}">
			<tr>
				<td style="padding: 20px 0; text-align: center">
                    @if($draft->images_section1_0 == '')
                        <img src="http://placehold.it/140x70" width="140" height="70" border="0">
                    @else
                        <img src="/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section1_0}}.png" width="140" height="70" border="0">
                    @endif
				</td>
			</tr>
        </table>
        <!-- Email Header : END -->
        @endif

        <!-- Email Body : BEGIN -->
        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="600" class="email-container">

            @if($draft->blocks_section2 == '1')
            <!-- Hero Image, Flush : BEGIN -->
            <tr>
				<td>
                    @if($draft->images_section2_0 == '')
					<img src="http://placehold.it/600x300" width="100%" height="" border="0" align="center" style="width: 100%; max-width: 100%;">
                    @else
                    <img src="/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section2_0}}.jpg" width="100%" height="" border="0" align="center" style="width: 100%; max-width: 100%;">
                    @endif
				</td>
            </tr>
            <!-- Hero Image, Flush : END -->
            @endif

            @if($draft->blocks_section3 == '1')
            <!-- 1 Column Text : BEGIN -->
            <tr>
                <td style="padding: 40px; text-align: center; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;">
                    @if(trim($draft->text_section3_0) == '')
                        Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent laoreet malesuada cursus. Maecenas scelerisque congue eros eu posuere. Praesent in felis ut velit pretium lobortis rhoncus ut&nbsp;erat.
                    @else
						{!! nl2br($draft->text_section3_0) !!}
                    @endif
                    <br><br>
                    <!-- Button : Begin -->
                    <table cellspacing="0" cellpadding="0" border="0" align="center" style="Margin: auto">
                        <tr>
                            <td style="border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                <a href="{!! ($draft->buttons_section3_0_link == ''?'javascript:;':$draft->buttons_section3_0_link) !!}" target="_blank" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">{!! $draft->buttons_section3_0_text !!}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                </a>
                            </td>
                        </tr>
                    </table>
                    <!-- Button : END -->
                </td>
            </tr>
            <!-- 1 Column Text : BEGIN -->
            @endif

            @if($draft->blocks_section4 == '1')
            <!-- Background Image with Text : BEGIN -->
            <tr>
                <!-- Bulletproof Background Images c/o https://backgrounds.cm -->
                @if($draft->images_section4_0 == '')
                <td bgcolor="#222222" valign="middle" style="text-align: center; background-position: center center !important; background-size: cover !important; background-image: url('http://placehold.it/600x230/222222/666666')">
                @else
                <td bgcolor="#222222" valign="middle" style="text-align: center; background-position: center center !important; background-size: cover !important; background-image: url('/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section4_0}}.jpg')">
                @endif
                    <div>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td valign="middle" style="text-align: center; padding: 40px; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #ffffff;">
                                    @if(trim($draft->text_section4_0) == '')
                                        Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent laoreet malesuada cursus. Maecenas scelerisque congue eros eu posuere. Praesent in felis ut velit pretium lobortis rhoncus ut&nbsp;erat.
                                    @else
										{!! nl2br($draft->text_section4_0) !!}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <!-- Background Image with Text : END -->
            @endif

            @if($draft->blocks_section5 == '1')
            <!-- 2 Even Columns : BEGIN -->
            <tr>
                <td align="center" valign="top" style="padding: 10px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding: 10px; text-align: center">
                                            @if($draft->images_section5_0 == '')
                                            <img src="http://placehold.it/270" width="270" height="270" border="0" class="fluid">
                                            @else
                                            <img src="/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section5_0}}.jpg" width="270" height="270" border="0" class="fluid">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            @if(trim($draft->text_section5_0) == '')
                                                Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                                            @else
												{!! nl2br($draft->text_section5_0) !!}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding: 10px; text-align: center">
                                            @if($draft->images_section5_1 == '')
                                            <img src="http://placehold.it/270" width="270" height="270" border="0" class="fluid">
                                            @else
                                            <img src="/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section5_1}}.jpg" width="270" height="270" border="0" class="fluid">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            @if(trim($draft->text_section5_1) == '')
                                                Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                                            @else
												{!! nl2br($draft->text_section5_1) !!}
                                            @endif
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
            @endif

            @if($draft->blocks_section6 == '1')
            <!-- 3 Even Columns : BEGIN -->
            <tr>
                <td align="center" valign="top" style="padding: 10px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding: 10px; text-align: center">
                                            @if($draft->images_section6_0 == '')
                                            <img src="http://placehold.it/170" width="170" height="170" border="0" class="fluid">
                                            @else
                                            <img src="/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section6_0}}.jpg" width="170" height="170" border="0" class="fluid">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            @if(trim($draft->text_section6_0) == '')
                                                Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                                            @else
												{!! nl2br($draft->text_section6_0) !!}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding: 10px; text-align: center">
                                            @if($draft->images_section6_1 == '')
                                            <img src="http://placehold.it/170" width="170" height="170" border="0" class="fluid">
                                            @else
                                            <img src="/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section6_1}}.jpg" width="170" height="170" border="0" class="fluid">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            @if(trim($draft->text_section6_1) == '')
                                                Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                                            @else
												{!! nl2br($draft->text_section6_1) !!}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding: 10px; text-align: center">
                                            @if($draft->images_section6_2 == '')
                                            <img src="http://placehold.it/170" width="170" height="170" border="0" class="fluid">
                                            @else
                                            <img src="/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section6_2}}.jpg" width="170" height="170" border="0" class="fluid">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            @if(trim($draft->text_section6_2) == '')
                                                Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                                            @else
												{!! nl2br($draft->text_section6_2) !!}
                                            @endif
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
            @endif

            @if($draft->blocks_section7 == '1')
            <!-- Thumbnail Left, Text Right : BEGIN -->
            <tr>
                <td dir="ltr" align="center" valign="top" width="100%" style="padding: 10px;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="top" style="padding: 10px 10px;">
                                            @if($draft->images_section7_0 == '')
                                            <img src="http://placehold.it/170" width="170" width="170" border="0" class="center-on-narrow">
                                            @else
                                            <img src="/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section7_0}}.jpg" width="170" width="170" border="0" class="center-on-narrow">
                                            @endif
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
                                            @if(trim($draft->text_section7_0) == '')
                                                <strong style="color:#111111;">Class aptent taciti sociosqu</strong>
                                            @else
                                                <strong style="color:#111111;">{!! $draft->text_section7_0 !!}</strong>
                                            @endif
                                            <br><br>
                                            @if(trim($draft->text_section7_1) == '')
                                                Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                                            @else
                                                {!! nl2br($draft->text_section7_1) !!}
                                            @endif
                                            <br><br>
                                            <!-- Button : Begin -->
                                            <table cellspacing="0" cellpadding="0" border="0" class="center-on-narrow" style="float:left;">
                                                <tr>
                                                    <td style="border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                                        <a href="{!! ($draft->buttons_section7_0_link == ''?'javascript:;':$draft->buttons_section7_0_link) !!}" target="_blank" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
						                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">{!! $draft->buttons_section7_0_text !!}</span>&nbsp;&nbsp;&nbsp;&nbsp;
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
            @endif

            @if($draft->blocks_section8 == '1')
            <!-- Thumbnail Right, Text Left : BEGIN -->
            <tr>
                <td dir="rtl" align="center" valign="top" width="100%" style="padding: 10px;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center" valign="top">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="top" style="padding: 10px 10px;">
                                            @if($draft->images_section8_0 == '')
                                            <img src="http://placehold.it/170" width="170" width="170" border="0" class="center-on-narrow">
                                            @else
                                            <img src="/app/newsletter/draft/{{$draft->draftid}}/{{$draft->images_section8_0}}.jpg" width="170" width="170" border="0" class="center-on-narrow">
                                            @endif
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
                                            @if(trim($draft->text_section8_0) == '')
                                                <strong style="color:#111111;">Class aptent taciti sociosqu</strong>
                                            @else
                                                <strong style="color:#111111;">{!! $draft->text_section8_0 !!}</strong>
                                            @endif
                                            <br><br>
                                            @if(trim($draft->text_section8_1) == '')
                                                Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                                            @else
												{!! nl2br($draft->text_section8_1) !!}
                                            @endif
                                            <br><br>
                                            <!-- Button : Begin -->
                                            <table cellspacing="0" cellpadding="0" border="0" class="center-on-narrow" style="float:left;">
                                                <tr>
                                                    <td style="border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                                        <a href="{!! ($draft->buttons_section8_0_link == ''?'javascript:;':$draft->buttons_section8_0_link) !!}" target="_blank" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
						                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">{!! $draft->buttons_section8_0_text !!}</span>&nbsp;&nbsp;&nbsp;&nbsp;
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
            @endif

        </table>
        <!-- Email Body : END -->

        @if($draft->blocks_section9 == '1')
        <!-- Email Footer : BEGIN -->
        <table align="center" width="600" class="email-container">
            <tr>
                <td style="padding: 20px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">
                    <div style="padding: 0px 30px;">
						&nbsp;
					</div>
                </td>
            </tr>
        </table>
        <!-- Email Footer : END -->
        @endif

    </center>
</td></tr></table>
</body>
</html>
