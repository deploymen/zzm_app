@extends('layouts.master-docs', ['sidebar_item' => 'list-general'])

@section('breadcrumb')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">AUTH API</div>
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
                    <td>POST</td>
                    <td>/api/auth/sign-up <span class="badge badge-warning">hot</span></td>
                    <td>For user to sign up(register)</td>
                    <td align="center"><a href="/api/docs/api.auth-sign-up-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>POST</td>
                    <td>/api/auth/sign-in <span class="badge badge-warning">hot</span></td>
                    <td>For user to sign in with username(email) & password</td>
                    <td align="center"><a href="/api/docs/api.auth-sign-in-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>POST</td>
                    <td>/api/auth/connect/facebook</td>
                    <td></td>
                    <td align="center"><a href="/api/docs/api.auth-connect-facebook-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>POST</td>
                    <td>/api/auth/connect/google</td>
                    <td></td>
                    <td align="center"><a href="/api/docs/api.auth-connect-google-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>GET</td>
                    <td>/api/auth/activate/{secret_key} <span class="badge badge-info">system use</span> </td>
                    <td>This is link to activate user account. User will get this link after sign up.</td>
                    <td align="center"><a href="/api/docs/api.auth-activate-get" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>PUT</td>
                    <td>/api/auth/forgot-password <span class="badge badge-warning">hot</span></td>
                    <td>Takes email to send reset-password link for user by email</td>
                    <td align="center"><a href="/api/docs/api.auth-forgot-password-put" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td>PUT</td>
                    <td>/api/auth/reset-password <span class="badge badge-warning">hot</span></td>
                    <td>Reset Password</td>
                    <td align="center"><a href="/api/docs/api.auth-reset-password-put" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>8.</td>
                    <td>POST</td>
                    <td>/api/auth/invite-parent</td>
                    <td></td>
                    <td align="center"><a href="/api/docs/api.auth-invite-parent-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>9.</td>
                    <td>POST</td>
                    <td>/api/auth/check</td>
                    <td>For client side to check an access token's status. Normally only web client use it.</td>
                    <td align="center"><a href="/api/docs/api.auth-check-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>10.</td>
                    <td>POST</td>
                    <td>/api/auth/change-password</td>
                    <td>Change password</td>
                    <td align="center"><a href="/api/docs/api.auth-change-password-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
                <tr>
                    <td>11.</td>
                    <td>POST</td>
                    <td>/api/worksheets</td>
                    <td></td>
                    <td align="center"><a href="/api/docs/api.auth-worksheets-post" target="_blank"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@stop