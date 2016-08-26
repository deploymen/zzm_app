<?php namespace App\Models\Results;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\GameQuestion;
class StudentIdChange extends AbstractGameResult {

	public $table = 't0111_student_id_change';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $fillable = ['user_id', 'profile_id', 'student_id' ];
	protected $hidden = [];

	public static function checkStudentId($params){
		$userId = $params['user_id'];
		$profileId = $params['profile_id'];
		$studentId = $params['student_id'];

		$sql = "
			SELECT b.`to_student_id` 
				FROM `t0111_student_id_change` a
				LEFT JOIN `t0111_student_id_change` b ON b.`user_id` = :userId AND b.`profile_id` = :profileId
					WHERE a.`user_id` = :userId
					AND a.`profile_id` = :profileId
					AND a.`from_student_id` = :studentId
					AND a.`to_student_id` = b.`from_student_id`
					AND b.`to_student_id` IS NULL

		";
	}
}