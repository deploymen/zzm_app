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
	        xat =xhr.setRequestHeader('X-access-token', '1|d32755e3e1094c423bed5ca68803c2c08ca1e50b');
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
									'<p class="profile-last-seen">Has not played yet</p>',
								'</div>',
								'<div class="small-2 columns">',
									'<a href="javascript:void(0);" title="Proficiency is based on the average score of all games played." class="info-icon">i<span class="profile-tooltip"><p>Proficiency is based on the average score of all games played.</p></span></a>',
								'</div>',
							'</div>',

							'<div class="profile-item-group no-padding cf">',
								'<div class="small-12 columns progress-section ps2">',
									'<div class="small-12 columns">',
										'<div class="small-12 columns">',
											'<span class="blue-heading-small">Best score</span>',
										'</div>',
										'<div class="small-12 columns">',
											'<p class="profile-subject-name truncate">',allVars.datal.list[i].best_score,'</p>',
										'</div>',
									'</div>',
									'<div class="small-12 columns">',
										'<div class="small-12 columns">',
											'<span class="blue-heading-small">Weakest score</span>',
										'</div>',
										'<div class="small-12 columns">',
											'<p class="profile-subject-name truncate">',allVars.datal.list[i].weak_score,'</p>',
										'</div>',
									'</div>',
								'</div>',
							'</div>',

							'<p class="profile-upgrade-cta"><a href="/user/profiles/',allVars.datal.list[i].user_id,'/results" class="">See detailed reports!</a></p>',
							'<a href="/user/profiles/',allVars.datal.list[i].user_id,'/edit" class="btn-profile-edit">Edit</a>',
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





// Single Profile - Edit Inner Page
var editprofileform = $('#edit-profile-form');
var btnsaveprofile = $('#btn-save-profile');
var profilefirstname = $('#profile-first-name');
var profilelastinitial = $('#profile-last-initial');
var profilecity = $('#profile-city');
var profileschool = $('#profile-school');
var btnchangesok = $('#btn-changes-ok');

function saveProfile(){

	var modalprofilesaved = $('#profilesaved');

	var editedInfo = {
		first_name : profilefirstname.val(),
		last_name  : profilelastinitial.val(),
		school     : profileschool.val(),
		city       : profilecity.val(),
		id         : allVars.datal.list[0].id,
		email      : allVars.datal.list[0].email
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
			// window.location = "/user/profiles";
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
	window.location = "/user/profiles";
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
		email        : allVars.datal.list[0].email,
		nickname1    : allVars.datal.list[0].nickname1,
		nickname2    : allVars.datal.list[0].nickname2,
	}

	$.ajaxSetup({
	    beforeSend: function(data) {
	        allVars.datal = data["data"];
	    }
	});

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
			// console.log(newprofileinfo.email);
			// console.log(newprofileinfo.nickname1);
			// console.log(newprofileinfo.nickname2);
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
	var profiletodelete = {
		id    : allVars.datal.list[0].id
	}

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


})(jQuery, this, this.document);