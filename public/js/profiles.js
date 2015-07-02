// Profiles Page
function displayProfiles(){
	var profilelist = $('#profile-list');

	// $.ajaxSetup({
	//     beforeSend: function(xhr) {
	//         xhr.setRequestHeader('X-access-token', '17|da4731fec0a022b1e703ff5628c54bc5c386619e');
	//     }
	// });

	$.ajax({
		type    : 'GET',
		url     : '/api/profiles',
		dataType: 'json',
		success : function(data){
			var datal = data["data"];

			var userid = datal.list[0].user_id;
			// var classid = datal.list[0].class_id;
			var firstname = datal.list[0].first_name;
			// var lastname = datal.list[0].last_name;
			// var uemail = datal.list[0].email;
			// var avatarid = datal.list[0].avatar_id;
			// var avatarl = datal.list[0].avatar;

			var holderUserId = $('.user-id');

			// Varibles - Edit Proifle
			var namefield = $('#profile-first-name');
			var useridfield = $('.user-id');

			namefield.val(firstname);
			useridfield.text(userid);


			//Profile variables
			var profilelist = $('#profile-list');
			
			$.each( datal.list, function( i, profile ) {
			  profilelist.append('<li class="profile-item"><section class="profile-info"><p class="profile-name"><span class="first-name">'+datal.list[i].first_name+'</span> <span class="last-name">'+datal.list[i].last_name+'</span></p><div class="profile-pic-holder">'+datal.list[i].avatar+'</div><p class="profile-email"><i class="fa fa-envelope"></i> <span class="user-email">'+datal.list[i].email+'</span></p><p class="profile-code"><i class="fa fa-child"></i> <span class="user-id">'+datal.list[i].id+'</span></p><p class="profile-class-name"><i class="fa fa-users"></i> <span class="class-id">'+datal.list[i].class_id+'</span></p><a href="/user/profile-inner" class="radius button green"><i class="fa fa-pencil"></i> Details</a> <a href="/user/profiles/'+datal.list[i].id+'/edit" class="radius button green"><i class="fa fa-pencil"></i> Edit</a></section></li>');
			});


		}
	});

};

// Single Profile - Edit Inner Page
function saveProfile(){
	var editprofileform = $('#edit-profile-form');
	var btnsaveprofile = $('#btn-save-profile');

	editprofileform.submit(function(){
		var editedInfo = {

		}
	});
};


// alert('profiles');