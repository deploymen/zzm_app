@extends('layouts.master-docs', ['sidebar_item' => 'list-user'])

@section('content')
<table class="hover">
    <thead>
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
            <td class="url">GET</td>
            <td class="url">/api/1.0/profiles <span class="label alert">hot</span></td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-profile-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>2.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/profiles</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-profile-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>3.</td>
            <td class="url">PUT</td>
            <td class="url">/api/1.0/profiles/{profile_id}</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-profile-put"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>4.</td>
            <td class="url">DELETE</td>
            <td class="url">/api/1.0/profiles/{id}</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-profile-delete"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>

        <tr>
            <td>5.</td>
            <td class="url">GET</td>
            <td class="url">/api/1.0/class</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-class-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>6.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/class</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-class-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>7.</td>
            <td class="url">PUT</td>
            <td class="url">/api/1.0/class/{id}</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-class-put"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>8.</td>
            <td class="url">DELETE</td>
            <td class="url">/api/1.0/class/{id}</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-class-delete"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>9.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/class/{id}/profile</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-class-profile-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>10.</td>
            <td class="url">PUT</td>
            <td class="url">/api/1.0/class/{id}/profile</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-class-profile-put"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> 
        <tr>
            <td>11.</td>
            <td class="url">GET</td>
            <td class="url">/api/1.0/profiles/{id} </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-profile-get-one-profile"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>12.</td>
            <td class="url">PUT</td>
            <td class="url">/api/1.0/game/profiles/</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-game-profile-put"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>13.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/game-code/anonymous</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-anonymous-game-code-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>14.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/game/verify-code</td>
            <td>This api is for game landing screen. It trigger when user key in game code to proceed. Api will return profile_transfer=1 if there's anonymous game history, expect game client will prompt user to do profile transfer(PT) or not.</td>
            <td align="center"><a href="/api/docs/api.user-verify-code-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>15.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/game/profile-transfer</td>
            <td>This api is to execute Profile Transfer(PT). By calling this, anonymous play history will transfer to provided game code. And it is no undo-able api to recover this, take note.</td>
            <td align="center"><a href="/api/docs/api.user-profile-transfer-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>16.</td>
            <td class="url">GET</td>
            <td class="url">/api/1.0/profiles/report/profile-details</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-report-profile-details-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>17.</td>
            <td class="url">GET</td>
            <td class="url">/api/1.0/profiles/result/only-system</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-profiles-result-only-system-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>18.</td>
            <td class="url">GET</td>
            <td class="url">/api/1.0/profiles/result/only-planet</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-profiles-result-only-planet-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>19.</td>
            <td class="url">GET</td>
            <td class="url">/api/1.0/profiles/result/only-play</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-profiles-result-only-play-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>20.</td>
            <td class="url">GET</td>
            <td class="url">/api/1.0/profiles/result/only-questions</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.user-profiles-result-only-questions-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>

    </tbody>
</table>
@stop