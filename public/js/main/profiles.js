//Global Variables

var profilelist = $('#profile-list');

function allVars(){
	var  datal;
	var xat;

	$.ajax({
		type    : 'GET',
		url     : '/api/profiles',
		dataType: 'json',
		success : function(data){
			datal = data["data"];
		}
	});

	$.ajaxSetup({
	    beforeSend: function(xhr) {
	        xat =xhr.setRequestHeader('X-access-token', '15|988d09d3d9af03b0abc9d97fb5f709cb77e422f6');
	    }
	});

	return datal;
};
allVars();
//console.log(allVars.datal);



// Profiles Page
function displayProfiles(){

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	        // console.log(allVars.xat);
	    }
	});



	$.ajax({
		type    : 'GET',
		url     : '/api/profiles',
		dataType: 'json',
		success : function(data){
			allVars.datal = data["data"];
			// console.log(allVars.datal);

			//Profile variables
			var profilelist = $('#profile-list');

			var profilesArray = [];
			
			$.each( allVars.datal.list, function( i, profile ) {
				profilesArray.push([
					'<div class="profile-item">',
						'<section class="profile-info">',
							'<div class="profile-pic-holder">',
								'<img src="/assets/main/img/avatars/',allVars.datal.list[i].avatar.filename,'" alt="Avatar 3">',
							'</div>',
							'<div class="profile-item-group cf">',
								'<p class="profile-nickname">',
									'<span class="first-name">',allVars.datal.list[i].nick_name1.name,' </span>',
									'<span class="first-name">',allVars.datal.list[i].nick_name2.name,'</span>',
								'</p>',
								'<p class="profile-name">',
									'<span class="first-name">',allVars.datal.list[i].first_name,'</span>',' ',
									'<span class="last-name">',allVars.datal.list[i].last_name,'</span>',
								'</p>',
							'</div>',

							'<div class="profile-item-group cf">',
								'<p class="profile-school-name truncate">',allVars.datal.list[i].school,'</p>',
								'<div class="small-12 columns">',
									'<p class="profile-code bold"><span class="blue-header">Player ID</span> <span class="user-id">',allVars.datal.list[i].game_code.code,'</span></p>',
								'</div>',
							'</div>',

							'<div class="profile-item-group cf">',
								'<div class="small-4 columns">',
									'<p class="profile-proficiency">',
										'<span class="blue-header bold">Last Played</span>',
									'</p>',
								'</div>',
								'<div class="small-6 columns">',
									'<p class="profile-last-seen">',(allVars.datal.last_played === null)?allVars.datal.last_played:'has not played yet','</p>',
								'</div>',
								'<div class="small-2 columns">',
									'<a href="javascript:void(0);" title="Proficiency is based on the average score of all games played." class="info-icon">i<span class="profile-tooltip"><p>Last Played shows the last time this child played Zap Zap Math.</p></span></a>',
								'</div>',
							'</div>',

							'<div class="profile-item-group no-padding cf">',
								'<div class="small-12 columns progress-section ps2">',
									'<div class="small-12 columns">',
										'<div class="small-12 columns">',
											'<span class="blue-heading-small">Best score</span>',
										'</div>',
										'<div class="small-12 columns">',
											'<a class="profile-subject-name truncate" href="/user/profiles/',allVars.datal.list[i].id,'/results?play_id=',(allVars.datal.list[i].best_score.length > 0)?allVars.datal.list[i].best_score[0].play_id:'no data available','&profile_id=',allVars.datal.list[i].id,'">',(allVars.datal.list[i].best_score.length > 0)?allVars.datal.list[i].best_score[0].description:'no data available','</a><br/>',
	                                        '<a class="profile-subject-name truncate" href="/user/profiles/',allVars.datal.list[i].id,'/results?play_id=',(allVars.datal.list[i].best_score.length > 1)?allVars.datal.list[i].best_score[1].play_id:'no data available','&profile_id=',allVars.datal.list[i].id,'">',(allVars.datal.list[i].best_score.length > 1)?allVars.datal.list[i].best_score[1].description:'no data available','</a><br/>',
	                                        '<a class="profile-subject-name truncate" href="/user/profiles/',allVars.datal.list[i].id,'/results?play_id=',(allVars.datal.list[i].best_score.length > 2)?allVars.datal.list[i].best_score[2].play_id:'no data available','&profile_id=',allVars.datal.list[i].id,'">',(allVars.datal.list[i].best_score.length > 2)?allVars.datal.list[i].best_score[2].description:'no data available','</a><br/>',
										'</div>',
									'</div>',
									'<div class="small-12 columns">',
										'<div class="small-12 columns">',
											'<span class="blue-heading-small">Weakest score</span>',
										'</div>',
										'<div class="small-12 columns">',
											'<a class="profile-subject-name truncate" href="/user/profiles/',allVars.datal.list[i].id,'/results?play_id=',(allVars.datal.list[i].weak_score.length > 0)?allVars.datal.list[i].weak_score[0].play_id:'no data available','&profile_id=',allVars.datal.list[i].id,'">',(allVars.datal.list[i].weak_score.length > 0)?allVars.datal.list[i].weak_score[0].description:'no data available','</a><br/>',
	                                        '<a class="profile-subject-name truncate" href="/user/profiles/',allVars.datal.list[i].id,'/results?play_id=',(allVars.datal.list[i].weak_score.length > 1)?allVars.datal.list[i].weak_score[1].play_id:'no data available','&profile_id=',allVars.datal.list[i].id,'">',(allVars.datal.list[i].weak_score.length > 1)?allVars.datal.list[i].weak_score[1].description:'no data available','</a><br/>',
	                                        '<a class="profile-subject-name truncate" href="/user/profiles/',allVars.datal.list[i].id,'/results?play_id=',(allVars.datal.list[i].weak_score.length > 2)?allVars.datal.list[i].weak_score[2].play_id:'no data available','&profile_id=',allVars.datal.list[i].id,'">',(allVars.datal.list[i].weak_score.length > 2)?allVars.datal.list[i].weak_score[2].description:'no data available','</a><br/>',
										'</div>',
									'</div>',
								'</div>',
							'</div>',

							'<p class="profile-upgrade-cta"><a href="/user/profiles/',allVars.datal.list[i].id,'/results" class="">See detailed reports!</a></p>',
							'<a href="/user/profiles/',allVars.datal.list[i].id,'/edit" class="btn-profile-edit">Edit</a>',
						'</section>',
					'</div>'
				].join(''));				
			});

		// profilesArray.push([
		// 	'<div class="profile-item add-button"><section class="profile-info"><div class="add-plus-box"><i class="fa fa-plus"></i></div><p class="">Create a Student Profile</p><a href="javascript:void(0);" data-reveal-id="addProfileModal" class="" id="btn-show-profile-form" class="btn-show-profile-form"></a></section></div>'
		// ].join());


		profilelist.html(profilesArray.join(''));
		}
	});

};





// Single Profile - Edit Inner Page
var editprofileform = $('#edit-profile-form');
var btnsaveprofile = $('#btn-save-profile');
var profilefirstname = $('#profile-first-name');
var profilelastinitial = $('#profile-last-initial');
var profilecity = $('#profile-city');
var profileid = $('#profile-id');
var profileschool = $('#profile-school');
var btnchangesok = $('#btn-changes-ok');
var editselectage = $('#profile-age-edit');
var editselectgrade = $('#profile-grade-edit');

function saveProfile(){

	var modalprofilesaved = $('#profilesaved');

	var editedInfo = {
		first_name : profilefirstname.val(),
		last_name  : profilelastinitial.val(),
		school     : profileschool.val(),
		city       : profilecity.val(),
		id         : profileid.val(),
		age        : editselectage.children('option').filter(':selected').val(),
		grade      : editselectgrade.children('option').filter(':selected').val()
	}

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	    }
	});

	$.ajax({
		type    : 'PUT',
		dataType: 'json',
		url     : '/api/profiles/'+editedInfo.id+'/edit',
		data    : editedInfo,
		success : function(data){
			//window.location = "/user/profiles";
			modalprofilesaved.foundation('reveal', 'open');
		},
		error   : function(data){
			// window.location = "/user/profiles";	
		}
	});



};

btnsaveprofile.click(function(){
	saveProfile();
});

btnchangesok.click(function(){
	location.reload();
});

// Add Profile
var createbtn = $('#btn-create-profile');
var btnnewprofile = $('#btn-show-profile-form');
var addprofilemodal = $('#addProfileModal');
var newprofileform = $('#new-profile-form');

function createNewProfile(){
	var addbtn = $('#btn-add-new-profile');
	var newfirstname = $('#new-first-name');
	var newlastname = $('#new-last-name');
	var newschool = $('#new-school');
	var newcity = $('#new-city');
	var profileemail = $('#profile-email');
	var profilenickname1 = $('#profile-nickname1');
	var profilenickname2 = $('#profile-nickname2');
	var profileavatar = $('#profile-avatar-id');

	var newprofileinfo = {
		first_name   : newfirstname.val(),
		last_name    : newlastname.val(),
		school       : newschool.val(),
		city         : newcity.val(),
		email        : 'marypoppins@nanny.com',
		age        	 : editselectage.children('option').filter(':selected').val(),
		grade     	 : editselectgrade.children('option').filter(':selected').val()
	}

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	    }
	});

	$.ajax({
		type     : 'POST',
		dataType : 'json',
		url      : '/api/profiles',
		data     : newprofileinfo,
		success  : function(data){
			var status = data['status'];
			var message = data['message'];
			//location.reload();
			if(status === 'fail' && message === 'missing parameters'){
				alert('Missing Parameters');
			} else {
				addprofilemodal.foundation('reveal', 'close');
				location.reload();
			}
			
		},
		error    : function(){
			console.log('fail');
		}
	});
};

createbtn.click(function(){
	console.log(newprofileform);
	// newprofileform.on('valid.fndtn.abide', function(){
	// 	createNewProfile();
	// });
	createNewProfile();
});

btnnewprofile.on('click', function() {
    addprofilemodal.foundation('reveal', 'open');
    return false;
    //console.log('add new profile');
});


// End of Add Profile

// Delete Profile
var btndeleteprofile = $('#btn-delete-profile');
var btndeleteok = $('#btn-delete-ok');
var btndeltecancel = $('#btn-delete-cancel');
var modalprofiledeleted = $('#profiledelete');
var modalcannotdelete = $('#cannotdelete');
var btncannotdelete = $('#btn-cannot-delete');

function deleteProfile(){
	var deleteconfirm = $('#profiledelete');

	var profiletodelete = {
		id    : profileid.val()
	}

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	    }
	});

	$.ajax({
		type     : 'DELETE',
		dataType : 'json',
		url      : '/api/profiles/'+profiletodelete.id,
		data     : profiletodelete,
		success  : function(data){
			var status = data['status'];
			var message = data['message'];
			console.log(profiletodelete.id);
			if(status === 'fail' && message === 'at least once profile in account'){
				console.log('You cannot delete the last profile.');
				modalcannotdelete.foundation('reveal', 'open');

				btncannotdelete.click(function(){
					modalcannotdelete.foundation('reveal', 'close');
				});
			} else if(status === 'fail' && message === 'profile not found') {
				window.location = "/user/profiles";
			} else {
				window.location = "/user/profiles";
			}
		}
	});
};

btndeleteprofile.click(function(){
	modalprofiledeleted.foundation('reveal', 'open');
});

btndeltecancel.click(function(){
	modalprofiledeleted.foundation('reveal', 'close');
});

btndeleteok.click(function(){
	deleteProfile();
});


(function($, window, document, undefined){
	if (top.location.pathname === '/user/profiles'){
		//displayProfiles();
	};

	//$(document).foundation('abide', 'reflow');

})(jQuery, this, this.document);