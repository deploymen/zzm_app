@extends('layouts.master-docs', ['sidebar_item' => 'list-general'])

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
            <td class="url">POST</td>
            <td class="url">/api/1.0/auth/sign-up <span class="label alert">hot</span></td>
            <td>For user to sign up(register)</td>
            <td align="center"><a href="/api/docs/api.auth-sign-up-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>2.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/auth/sign-in <span class="label alert">hot</span></td>
            <td>For user to sign in with username(email) & password</td>
            <td align="center"><a href="/api/docs/api.auth-sign-in-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>3.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/auth/connect/facebook</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.auth-connect-facebook-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>4.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/auth/connect/google</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.auth-connect-google-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>5.</td>
            <td class="url">GET</td>
            <td class="url">/api/1.0/auth/activate/{secret_key} <span class="label">system use</span> </td>
            <td>This is link to activate user account. User will get this link after sign up.</td>
            <td align="center"><a href="/api/docs/api.auth-activate-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>6.</td>
            <td class="url">PUT</td>
            <td class="url">/api/1.0/auth/forgot-password <span class="label alert">hot</span></td>
            <td>Takes email to send reset-password link for user by email</td>
            <td align="center"><a href="/api/docs/api.auth-forgot-password-put"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>7.</td>
            <td class="url">PUT</td>
            <td class="url">/api/1.0/auth/reset-password <span class="label alert">hot</span></td>
            <td>Reset Password</td>
            <td align="center"><a href="/api/docs/api.auth-reset-password-put"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>8.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/auth/invite-parent</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.auth-invite-parent-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>9.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/auth/check</td>
            <td>For client side to check an access token's status. Normally only web client use it.</td>
            <td align="center"><a href="/api/docs/api.auth-check-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>10.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/auth/change-password</td>
            <td>Change password</td>
            <td align="center"><a href="/api/docs/api.auth-change-password-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>11.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/worksheets</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.auth-worksheets-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>12.</td>
            <td class="url">POST</td>
            <td class="url">/api/1.0/launch-notification</td>
            <td></td>
            <td align="center"><a href="/api/docs/api.auth-launch-notification-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
    </tbody>
</table>
@stop