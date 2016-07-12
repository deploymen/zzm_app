<html>
<head>
Dear parent/teacher, 
<br>
<br>
<table style="border-collapse:collapse; width: 100%; border: 1px solid black;">
	<tr>
		<td style="border:1px solid black;">ID</td>
		<td style="border:1px solid black;">First Name</td>
		<td style="border:1px solid black;">Game Code</td>
		<td style="border:1px solid black;">Days</td>
		<td style="border:1px solid black;">Times</td>
		<td style="border:1px solid black;">Total Answerd</td>
		<td style="border:1px solid black;">Percentage</td>

	</tr>
@for($i = 0; $i < count($results); $i++)
	<tr>
	    <td style="border:1px solid black;">{{$results[$i]->profile_id}}</td>
	    <td style="border:1px solid black;">{{$results[$i]->first_name}}</td>
	    <td style="border:1px solid black;">{{$results[$i]->code}}</td>
	    <td style="border:1px solid black;">{{$results[$i]->days}}</td>
	    <td style="border:1px solid black;">{{$results[$i]->total_played}}</td>
	    <td style="border:1px solid black;">{{$results[$i]->total_answered}}</td>
	    <td style="border:1px solid black;">{{intval($results[$i]->percentage)}}%</td>
	</tr>
@endfor
</table>
<br>
<br>
Zap Zap Math Team<br>
{{$zzm_url}}<br>
{{$social_media_links}}
</html>