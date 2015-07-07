//Global Variables
// var allVars = (function(){
// 	var  datal;
// 	var xat;

// 	$.ajax({
// 		type    : 'GET',
// 		url     : '/api/profiles',
// 		dataType: 'json',
// 		success : function(data){
// 			datal = data["data"];
// 		}
// 	});

// 	$.ajaxSetup({
// 	    beforeSend: function(xhr) {
// 	        xat =xhr.setRequestHeader('X-access-token', '1|92b943b0ff3ffe4ff943f448d30eb5a0ff7ef7e9');
// 	    }
// 	});
// });
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
	        xat =xhr.setRequestHeader('X-access-token', '1|92b943b0ff3ffe4ff943f448d30eb5a0ff7ef7e9');
	    }
	});
};
allVars();

// Profiles Page
function displayProfiles(){

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	    }
	});

	$.ajax({
		type    : 'GET',
		url     : '/api/profiles',
		dataType: 'json',
		success : function(data){
			allVars.datal = data["data"];

			//Profile variables
			var profilelist = $('#profile-list');

			var profilesArray = [];
			
			$.each( allVars.datal, function( i, profile ) {
				profilesArray.push([
					'<div class="profile-item">',
						'<section class="profile-info">',
							'<div class="profile-pic-holder">',
								'<img src="/assets/main/img/avatars/avatar',allVars.datal[0].avatar_id,'.png" alt="Avatar 3">',
							'</div>',
							'<div class="profile-item-group cf">',
								'<p class="profile-nickname">',
									'<span class="first-name">',allVars.datal[0].nickname1,'</span>',
									'<span class="first-name">nickname2</span>',
								'</p>',
								'<p class="profile-name">',
									'<span class="first-name">',allVars.datal[0].first_name,'</span>',' ',
									'<span class="last-name">',allVars.datal[0].last_name,'</span>',
								'</p>',
							'</div>',

							'<div class="profile-item-group cf">',
								'<p class="profile-school-name truncate">',allVars.datal[0].school,'</p>',
								'<div class="small-5 columns">',
									'<p class="profile-class-name bold"><span class="blue-header">Class ID:</span> <span class="class-id">',allVars.datal[0].class_id,'</span></p>',
								'</div>',

								'<div class="small-7 columns">',
									'<p class="profile-code bold"><span class="blue-header">Player ID</span> <span class="user-id">game code</span></p>',
								'</div>',
							'</div>',

							'<div class="profile-item-group cf">',
								'<div class="small-4 columns">',
									'<p class="profile-proficiency">',
										'<span class="blue-header bold">Proficiency</span>',
									'</p>',
								'</div>',
								'<div class="small-6 columns">',
									'<span class="star-group big">',
										'<i class="fa fa-star"></i>',
										'<i class="fa fa-star"></i>',
										'<i class="fa fa-star"></i>',
										'<i class="fa fa-star"></i>',
										'<i class="fa fa-star"></i>',
									'</span>',
								'</div>',
								'<div class="small-2 columns">',
									'<span onclick="itooltip('+i+')" id="info-icon-'+i+'" class="info-icon">i<span id="profile-tooltip-'+i+'" class="profile-tooltip"><i class="fa fa-caret-down"></i><p>Proficiency is based on the average score of all games played</p></span></span>',
								'</div>',
							'</div>',

							'<div class="profile-item-group no-padding cf">',
								'<div class="small-5 columns progress-section ps1">',
									'<p class="profile-percentage text-center">100%</p>',
									'<p class="change-class-button">',
										'Grade 2 Progress <i class="fa fa-chevron-down"></i>',
									'</p>',
								'</div>',
								'<div class="small-7 columns progress-section ps2">',
									'<div class="small-12 columns">',
										'<div class="small-12 columns">',
											'<span class="blue-heading-small">Best score</span>',
											'<span class="star-group small right">',
												'<i class="fa fa-star"></i>',
												'<i class="fa fa-star"></i>',
												'<i class="fa fa-star"></i>',
												'<i class="fa fa-star"></i>',
												'<i class="fa fa-star"></i>',
											'</span>',
										'</div>',
										'<div class="small-12 columns">',
											'<p class="profile-subject-name truncate">Geometry (F01)</p>',
										'</div>',
									'</div>',
									'<div class="small-12 columns">',
										'<div class="small-12 columns">',
											'<span class="blue-heading-small">Weakest score</span>',
											'<span class="star-group small right">',
												'<i class="fa fa-star"></i>',
												'<i class="fa fa-star"></i>',
												'<i class="fa fa-star"></i>',
												'<i class="fa fa-star"></i>',
												'<i class="fa fa-star"></i>',
											'</span>',
										'</div>',
										'<div class="small-12 columns">',
											'<p class="profile-subject-name truncate">Fraction Basics (G01)</p>',
										'</div>',
									'</div>',
								'</div>',
							'</div>',

							'<p class="profile-upgrade-cta"><a href="/user/profiles/id/results" class="">Upgrade</a> for detailed reports!</p>',
							'<a href="/user/profiles/',allVars.datal[0].id,'/edit" class="btn-profile-edit">Edit</a>',
						'</section>',
					'</div>'
				].join(''));
			});

		profilesArray.push([
			'<div class="profile-item add-button"><section class="profile-info"><div class="add-plus-box"><i class="fa fa-plus"></i></div><p class="">Create a Student Profile</p><a href="javascript:void(0);" data-reveal-id="addProfileModal" class="" id="btn-show-profile-form" class="btn-show-profile-form"></a></section></div>'
		].join());

		profilelist.html(profilesArray.join(''));
		}
	});

};

// Tooltips
// $(staticAncestors).on(eventName, dynamicChild, function() {});
function itooltip(i){
	var profilelist = $('#profile-list');
	var tooltiptrigger = $('#info-icon-'+i);
	var profiletooltip = $('#profile-tooltip-'+i);
	$('.profile-tooltip').fadeOut('fast');
	//$(this).find(profiletooltip).show('slow');
	profiletooltip.stop().fadeIn('fast');

	// profilelist.on( 'click',tooltiptrigger, function() {
	// 	$(this).find(profiletooltip).show('slow');
	// });
	// profiletooltip.each(function(){
	//     $(this).click(function(){

	//        $("div.content").hide();

	//       profiletooltip.toggleClass('showit');

	//     });
	// });
};




// Single Profile - Edit Inner Page
var editprofileform = $('#edit-profile-form');
var btnsaveprofile = $('#btn-save-profile');
var profilefirstname = $('#profile-first-name');
var profilelastinitial = $('#profile-last-initial');
var profilecity = $('#profile-city');
var profileschool = $('#profile-school');

function saveProfile(){
	var id = VARS.id;
	var email = VARS.id;

	var editedInfo = {
		first_name : profilefirstname.val(),
		last_name  : profilelastinitial.val(),
		school     : profileschool.val(),
		city       : profilecity.val(),
		id         : VARS.id,
		email      : VARS.email
	}

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	    }
	});

	$.ajax({
		type    : 'PUT',
		dataType: 'json',
		url     : '/api/profiles/'+id+'/edit',
		data    : editedInfo,
		success : function(data){
			alert('Your changes have been successfully changed');
			window.location = "/user/profiles";
		},
		error   : function(data){
			// window.location = "/user/profiles";	
		}
	});



};

btnsaveprofile.click(function(){
	saveProfile();
});

// Add Profile
var createbtn = $('#btn-create-profile');

function createNewProfile(){
	var addbtn = $('#btn-add-new-profile');
	var newfirstname = $('#new-first-name');
	var newlastname = $('#new-last-name');
	var newschool = $('#new-school');
	var newcity = $('#new-city');
	var addprofilemodal = $('#addProfileModal');


	var newprofileinfo = {
		first_name   : newfirstname.val(),
		last_name    : newlastname.val(),
		school       : newschool.val(),
		city         : newcity.val(),
		email        : 'obiwan@jediacademy.com',
		nickname1    : 1,
		nickname2    : 2,
	}

	$.ajax({
		type     : 'POST',
		dataType : 'json',
		url      : '/api/profiles',
		data     : newprofileinfo,
		beforeSend: function(xat) {
	        allVars.xat;
	    },
		success  : function(data){
			addprofilemodal.foundation('reveal', 'close');
			location.reload();
		}
	});
};

createbtn.click(function(){
	createNewProfile();
});
// End of Add Profile

// Delete Profile
var btndeleteprofile = $('#btn-delete-profile');

function deleteProfile(){
	var id = VARS.id;

	$.ajaxSetup({
	    beforeSend: function(xat) {
	        allVars.xat;
	    }
	});

	$.ajax({
		type     : 'DELETE',
		dataType : 'json',
		url      : '/api/profiles/'+id,
		data     : id,
		complete  : function(data){
			console.log("complete");
			confirm("Sure you want to delete?");
			window.location = "/user/profiles";
		}
	});
};

btndeleteprofile.click(function(){
	if(confirm("Sure you want to delete?") === true){
		deleteProfile();
		window.location = "/user/profiles";
	}
});

//pre-fill profile avatar
// function prefillAvatar(){
// 	var avatarholder = $('.avatar-holder');
// 	var avatarfile = allVars.datal.list[i].avatar.filename;

// 	$.ajax({
// 		type    : 'GET',
// 		url     : '/api/profiles',
// 		dataType: 'json',
// 		success : function(data){
// 			allVars.datal = data["data"];
// 		}
// 	});

// 	avatarholder.append('<img src="/assets/main/img/avatars/'+avatarfile+'" alt="">');
// };
// prefillAvatar();

(function($, window, document, undefined){
	if (top.location.pathname === '/user/profiles'){
		displayProfiles();
	};

	// itooltip();
	$(document).foundation('tooltip', 'reflow');

})(jQuery, this, this.document);