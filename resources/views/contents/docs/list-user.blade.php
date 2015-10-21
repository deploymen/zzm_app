@extends('layouts.master-docs', ['sidebar_item' => 'list-user'])

@section('breadcrumb')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">USER API</div>
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

<div class="row">
    <div class="col-lg-12">
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
                    <td>/api/profiles <span class="badge badge-warning">hot</span></td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-profile-get" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>POST</td>
                    <td>/api/profiles</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-profile-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>PUT</td>
                    <td>/api/profiles/{profile_id}</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-profile-put" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>DELETE</td>
                    <td>/api/profiles/{id}</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-profile-delete" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                
                <tr>
                    <td>5.</td>
                    <td>GET</td>
                    <td>/api/class</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-class-get" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>POST</td>
                    <td>/api/class</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-class-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td>PUT</td>
                    <td>/api/class/{id}</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-class-put" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>8.</td>
                    <td>DELETE</td>
                    <td>/api/class/{id}</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-class-delete" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>9.</td>
                    <td>POST</td>
                    <td>/api/class/{id}/profile</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-class-profile-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>10.</td>
                    <td>PUT</td>
                    <td>/api/class/{id}/profile</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-class-profile-put" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr> 
                  <tr>
                    <td>11.</td>
                    <td>GET</td>
                    <td>/api/profiles/{id} </td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-profile-get-one-profile" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                  <tr>
                    <td>12.</td>
                    <td>PUT</td>
                    <td>/api/game/profiles/</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-game-profile-put" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>13.</td>
                    <td>POST</td>
                    <td>/api/game-code/anonymous</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-anonymous-game-code-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                 <tr>
                    <td>14.</td>
                    <td>POST</td>
                    <td>/api/game/verify-code</td>
                    <td>This api is for game landing screen. It trigger when user key in game code to proceed. Api will return profile_transfer=1 if there's anonymous game history, expect game client will prompt user to do profile transfer(PT) or not.</td>
                    <td align="center"><a href="/docs/api.user-verify-code-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                 <tr>
                    <td>15.</td>
                    <td>POST</td>
                    <td>/api/game/profile-transfer</td>
                    <td>This api is to execute Profile Transfer(PT). By calling this, anonymous play history will transfer to provided game code. And it is no undo-able api to recover this, take note.</td>
                    <td align="center"><a href="/docs/api.user-profile-transfer-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                  <tr>
                    <td>16.</td>
                    <td>GET</td>
                    <td>/api/profiles/report/profile-details</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-report-profile-details-get" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                  <tr>
                    <td>17.</td>
                    <td>GET</td>
                    <td>/api/profiles/result/only-system</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-profiles-result-only-system-get" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                  <tr>
                    <td>18.</td>
                    <td>GET</td>
                    <td>/api/profiles/result/only-planet</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-profiles-result-only-planet-get" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                  <tr>
                    <td>19.</td>
                    <td>GET</td>
                    <td>/api/profiles/result/only-play</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-profiles-result-only-play-get" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                  <tr>
                    <td>20.</td>
                    <td>GET</td>
                    <td>/api/profiles/result/only-questions</td>
                    <td></td>
                    <td align="center"><a href="/docs/api.user-profiles-result-only-questions-get" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>

@stop