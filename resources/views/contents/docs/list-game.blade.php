@extends('layouts.master-docs', ['sidebar_item' => 'list-game'])

@section('breadcrumb')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">GAME API</div>
    </div>
    <div class="clearfix"></div>
</div>
<!--END TITLE & BREADCRUMB PAGE-->
@stop

@section('css_include')

@stop

@section('js_include')

@stop

@section('content')

<table class="table table-bordered table-striped table-condensed cf">
    <thead class="cf">
        <tr>
            <th width="30">#</th>
            <th width="80">Method</th>
            <th width="370">Path</th>
            <th>Description</th>
            <th width="30">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1.</td>
            <td>POST</td>
            <td>/api/1.0/game/map/system</td>
            <td>
            </td>
            <td align="center"><a href="/api/docs/api.game-map-system-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>2.</td>
            <td>POST</td>
            <td>/api/1.0/game/map/system/{id}/planets</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.game-map-system-worksheets-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>GET</td>
            <td>/api/1.0/set/nick </td>
            <td>Allow game client to retrieve a set of predefine nicknames and avatars.</td>
            <td align="center"><a href="/api/docs/api.game-profile-nick-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>4.</td>
            <td>POST</td>
            <td>/api/1.0/game/verify-code</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.game-profile-verify-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> 
        <tr>
            <td>5.</td>
            <td>GET</td>
            <td>/api/1.0/game/user-map</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.game-user-map-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> 
        <!--  <tr>
            <td>6.</td>
            <td>GET</td>
            <td>/api/1.0/game/leaderboard/world</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.game-leaderboard-world-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> 
         <tr>
            <td>7.</td>
            <td>GET</td>
            <td>/api/1.0/game/leaderboard/system/{system_id}</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.game-leaderboard-system-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>  -->
        <tr>
            <td>6.</td>
            <td>GET</td>
            <td>/api/1.0/game/leaderboard/planet/{planet_id}</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.game-leaderboard-planet-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> 
        <tr>
            <td>7.</td>
            <td>GET</td>
            <td>/api/version</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.version-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> 
    </tbody>
</table>

<p>Game Request</p>
<table class="table table-bordered table-striped table-condensed cf">
    <thead class="cf">
        <tr>
            <th width="30">#</th>
            <th width="80">Method</th>
            <th width="370">Path</th>
            <th>Description</th>
            <th width="30">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/150/request </td>
            <td>p01 (Sushi Star: Sushimetry 3)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p01-150"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> 
        <tr>
            <td>2.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/103/request </td>
            <td>p02 (Space Taxi)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p02-103"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/106/request </td>
            <td>p02 (Space Taxi 2)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p02-106"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>4.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/115/request </td>
            <td>p02 (Space Taxi 3)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p02-115"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>5.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/166/request </td>
            <td>p03-t (The Big Showdown)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p03-166"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>6.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/102/request </td>
            <td>p03-t (The 'Correct' Collector)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p03-102"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>7.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/141/request </td>
            <td>p03-i (The 'Correct' Collector 2)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p03-141"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>8.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/155/request </td>
            <td>p06 (Word Games 10)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p06-155"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>9.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/104/request </td>
            <td>p06 (Word Games)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p06-104"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>10.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/114/request </td>
            <td>p07 (More or Less?)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p07-114"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>11.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/105/request </td>
            <td>p10 (Tap Ten)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p10-105"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>11.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/123/request </td>
            <td>p10 (Tap Hundred)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p10-123"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>11.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/131/request </td>
            <td>p10 (Tap Thousand)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p10-131"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>12.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/129/request </td>
            <td>p18 (Engine Engine Number Line)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p18-129"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>13.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/185/request </td>
            <td>p23 (Angle Align)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p23-185"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>14.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/225/request </td>
            <td>p32 (Coordinate Game)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p32-225"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>15.</td>
            <td>GET </td>
            <td>/api/1.0/game/play/228/request </td>
            <td>p00 (Multiplayer Game)</td>
            <td align="center"><a href="/api/docs/api.game-play-request-get-p00-228"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> 
    </tbody>
</table>

<p>Game Result Submit</p>
<table class="table table-bordered table-striped table-condensed cf">
    <thead class="cf">
        <tr>
            <th width="30">#</th>
            <th width="80">Method</th>
            <th width="370">Path</th>
            <th>Description</th>
            <th width="30">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/150/result </td>
            <td>p01</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p01"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>2.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/103/result </td>
            <td>p02</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p02"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/166/result </td>
            <td>p03</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p03"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>

        <tr>
            <td>5.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/155/result </td>
            <td>p06</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p06"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>6.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/114/result </td>
            <td>p07</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p07"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>7.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/105/result </td>
            <td>p10</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p10"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>8.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/129/result </td>
            <td>p18</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p18"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>9.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/185/result </td>
            <td>p23</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p23"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>10.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/225/result </td>
            <td>p32</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p32"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>11.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/228/result </td>
            <td>p00</td>
            <td align="center"><a href="/api/docs/api.game-play-result-post-p00"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>12.</td>
            <td>POST</td>
            <td>/api/1.0/game/play/push-result </td>
            <td>offline</td>
            <td align="center"><a href="/api/docs/api-game-play-result-offline-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
    </tbody>
</table>

<p>Game Result History</p>
<table class="table table-bordered table-striped table-condensed cf">
    <thead class="cf">
        <tr>
            <th width="30">#</th>
            <th width="80">Method</th>
            <th width="370">Path</th>
            <th>Description</th>
            <th width="30">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1.</td>
            <td>GET</td>
            <td>/api/1.0/game/result/system-planet/progress</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.game-result-progress-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> 
        <tr>
            <td>2.</td>
            <td>GET</td>
            <td>/api/1.0/game/result/system-planet/play/planet/{planet_id}</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.game-result-play-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
    </tbody>
</table>

@stop