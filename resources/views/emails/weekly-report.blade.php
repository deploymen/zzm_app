<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <style type="text/css">
        @media screen and (max-width: 660px) {
            table.container { width: 480px !important;}
            .headline h1 {  font-size: 22px !important; }
        }

        @media screen and (max-width: 510px) {
            table.container { width: 100% !important;}
        }
    </style>
</head>
<body bgcolor="#cccccc">
<!-- Inbox Preview -->
<div style="font-size:1px; color: #efe1b0; display: none">
    ZapZapMath Weekly Game Report. Dear parent, your child has played a total of [X] hours and [Y] minutes on
    Zap Zap Math this week over a period of [Z] days, with a total of [X] questions answered.
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#cccccc">
    <tr>
        <td>
            <!-- Weekly Report -->
<table class="container" width="640" align="center" border="0" cellspacing="0"
       cellpadding="0">
    <tr>
        <!-- beginning td tag for content row -->
        <td valign="top" bgcolor="#f5f2e5" class="content" style="padding: 30px 30px 10px 30px;
                            border-right: 1px solid #efe1b0; border-left: 1px solid #efe1b0;
                            border-top: 1px solid #efe1b0; font-family:Arial, Helvetica,
                            sans-serif; font-size: 16px; line-height:22px; color: #333333;">
            <p>
                Dear parent, your {{$coc}} has played a total of {{$hour}} hours and {{$minute}} minutes on
                Zap Zap Math this week over a period of {{$days}} days, with a total of {{$total_answered}} questions answered.
                Overall, your child got  {{$percentage}}% of the questions correct.
            </p>
            <p>
                We've provided a short overview of your child's results in the table below.
                You can view details of your child's progress
                <a href="{{$zapzapmath_portal}}" style="text-decoration: none; color: #2B91D6;"> Here (Link to detailed report)</a>.
            </p>
        </td>
    </tr>

    <tr>
        <td valign="top" class="headline" bgcolor="#ffffff" style="padding:
                            15px 20px 5px 30px; border-left: 1px solid #efe1b0; border-right: 1px solid #efe1b0;
                            font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 22px;">
            <h1 style="margin: 0 0 15px 0; font-size: 26px; font-weight: normal;
                                color: #723c7f"> Weekly Game Report</h1>
        </td>
    </tr>

    <tr>
        <td valign="top" align="center" class="avatar" bgcolor="#ffffff"
            style="padding: 10px 20px 0px 30px; border-left: 1px solid #efe1b0;
								border-bottom: 1px solid #2B91D6; border-right: 1px solid #efe1b0;
								border-top: 1px solid #2B91D6;">
            <img src="http://s3.amazonaws.com/static.zapzapmath.com/emails/testimage/avatar.png" alt="Avatar" width="156" height="158">
            <P style="text-align: center;">Dashboard Name</P>
        </td>
    </tr>

    <tr>
        <td valign="top" bgcolor="#ffffff" class="promos" style="padding: 0px 30px 5px 30px;
                            border-right:1px solid #efe1b0; border-left:1px solid #efe1b0; background-color: #ffffff;
                            font-family: Arial, Helvetica, sans-serif;">
            <table class="table-1" width="100%">
                <tr>
                    <td>
                        <p style="font-weight: bold; text-align: left; color: #333333;
                                            font-size: 21px;">School ID:
                            <em style="font-style: normal; color: #333333;">{{$school}}</em></p>
                        <p style="color: #2B91D6; text-align: left; font-size: 21px;
                                            font-weight: bold;">ZAPZAPMATHCODE:
                            <em style="font-style: normal; color: #333333;">{{$game_code}}</em>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td valign="top" bgcolor="#2B91D6" class="promos" style="padding: 0px 30px 0px 30px;
                            border-right:1px solid #efe1b0; border-left:1px solid #efe1b0; background-color: #2B91D6;
                            font-family: Arial, Helvetica, sans-serif;font-weight: bold; text-align: left; color: #ffffff;">
            <table class="grade-table" width="100%">
                <tr>
                    <td align="left" width="298" style="color: #ffffff;">Grade: {{$grade}}</td>
                    <td align="right" width="298" style="color: #ffffff;">{{$total_star}} &#9733;</td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td valign="top" bgcolor="#ffffff" class="promos" style="padding: 7px 30px 7px 30px;
                            border-right:1px solid #efe1b0; border-left:1px solid #efe1b0; background-color: #ffffff;
                            font-family: Arial, Helvetica, sans-serif;font-weight: bold; text-align: left;
                            color: #333333; border-bottom: 1px solid #2B91D6;">
            <table class="game-played-main-table" width="100%">
                <tr>
                    <td align="center">
                        <p style="color: #2B91D6; text-align: center; font-size: 21px;
                                            font-weight: bold;">LAST GAME PLAYED
                        </p>

                        <p style="color: #333333; text-align: center; font-size: 19px;
                                            font-weight: bold;">{{$last_planet_name}}</p>

                        <table width="90%" class="game-played-main-table-1">
                            <tr>
                                <td align="center" width="250">{{$last_played_time}}</td>
                                <td align="center" width="250">{{$last_played_date}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td valign="top" bgcolor="#ffffff" class="last-session" style="padding: 7px 30px 7px 30px;
                            border-right:1px solid #efe1b0; border-left:1px solid #efe1b0; background-color: #ffffff;
                            font-family: Arial, Helvetica, sans-serif;font-weight: bold; text-align: left;
                            color: #333333; border-bottom: 1px solid #2B91D6;">
            <table class="last-session-main-table" width="100%">
                <tr>
                    <td align="center">
                        <p style="color: #2B91D6; text-align: center; font-size: 21px;
                                            font-weight: bold;">LAST SESSION
                        </p>
                        <table width="100%" class="last-session-main-table-1"
                               style="margin-bottom: 10px;">
                            <tr valign="top">
                                <td width="250" align="center" style="color:#3BF42E;
                                                    font-size: 20px;">{{$accuracy}}%
                                    <br />
                                    <em style="font-style: normal; font-size: 17px;">ACCURACY</em></td>
                                <td width="250" align="center" style="color:#F49E2D;
                                                    font-size: 18px;">&#128336;
                                    <br />
                                    <em style="font-style: normal; font-size: 17px;">{{$total_played_time}} MINUTES</em></td>
                            </tr>
                        </table>

                        <table width="100%" class="last-session-main-table-2">
                            <tr>
                                <td width="250" align="center" style="color:#3BF42E;">
                                    {{$total_correct}} Correct Answer <br>
                                    <img src="https://s3.amazonaws.com/static.zapzapmath.com/emails/testimage/line.png" alt="" width="200" height="2">
                                </td>
                            </tr>
                            <tr>
                                <td width="250" align="center" style="color:#3BF42E;">
                                    {{$total_answered_last}} Attempted Questions
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td valign="top" align="center" class="avatar" bgcolor="#efe1b0"
            style="padding: 10px 20px 10px 30px; border-left: 1px solid #efe1b0;
								border-bottom: 1px solid #efe1b0; border-right: 1px solid #efe1b0;">
            <a href="{{$zapzapmath_portal}}">
                <img src="https://s3.amazonaws.com/static.zapzapmath.com/emails/testimage/btn.png" alt="View Detailed Report" width="200" height="50">
            </a>
        </td>
    </tr>
</table>
</td>
</tr>
</table>
</body>
</html>