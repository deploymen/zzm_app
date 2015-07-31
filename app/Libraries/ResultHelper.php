<?php namespace App\Libraries;

use App;
use Exception;
use Config;
use Request;
use DB;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\EmailHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\DatabaseUtilHelper;
use App\Libraries\ZapZapQuestionHelper;
use App\Libraries\ApiProfileHelper;


use App\Models;
use App\Models\GameProfile;
use App\Models\GamePlay;
use App\Models\GameCode;
use App\Models\GameSystem;
use App\Models\GamePlanet;
use App\Models\UserMap;
use App\Models\GameResult;
use App\Models\GameResultP01;
use App\Models\GameResultP02;
use App\Models\GameResultP03;
use App\Models\GameResultP06;
use App\Models\GameResultP07;
use App\Models\GameQuestion;
use App\Models\GameQuestionP03;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;
use App\Models\LeaderboardWorld;
use App\Models\LeaderboardSystem;
use App\Models\LeaderboardPlanet;

class ResultHelper{

	public static function ResultQuestionP01($playId){
		$answers = [];

		$sql = "
       		SELECT q1.`id` AS `question_id` , q1.* , r1.`id` AS `result_id` , r1.* , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
       			FROM (`t0300_game_result` r , `t0201_game_question_p01` q1 , `t0301_game_result_p01` r1)

       			LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
				LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )

       				WHERE r.`target_id` = r1.`id`
       				AND r1.`target_id` = q1.`id`
       				AND r.`play_id` = {$playId}

       				ORDER BY r.`id` ASC;
       ";

       $result = DB::select($sql);
       $prevQuestionId = 0;

       for($i=0; $i<count($result); $i++){
			$r = $result[$i];

			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'question' => $r->question,
					'question_angle3' => $r->question_angle3,
					'question_angle4' => $r->question_angle4,
					'question_angle5' => $r->question_angle5,
					'question_angle6' => $r->question_angle6,
					'answer_angle3' => $r->answer_angle3,
					'answer_angle4' => $r->answer_angle4,
					'answer_angle5' => $r->answer_angle5,
					'answer_angle6' => $r->answer_angle6,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'angle3'=>$r->angle3,
						'angle4'=>$r->angle4,
						'angle5'=>$r->angle5,
						'angle6'=>$r->angle6,
						],
					'subjects' => []
				]);
			}
				array_push($answers[count($answers)-1]['subjects'] ,[
					'subject_code' => $r->subject_code,
					'subject_name' => $r->name,
					'description' => $r->description
				]);
				
			$prevQuestionId = $r->question_id;
		}

		return $answers;

	}
	public static function ResultQuestionP02($playId){
		$answers = [];

       $sql = "
       		SELECT q2.`id` AS `question_id` ,q2.`question`, q2.`answer_option_1` , q2.`answer_option_2` ,q2.`answer_option_3` ,q2.`answer_option_4` ,q2.`answer_option_5` ,q2.`answer_option_6` ,q2.`difficulty` , r2.*, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
       			FROM (`t0300_game_result` r , `t0202_game_question_p02` q2 , `t0302_game_result_p02` r2)

       				LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
					LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )

       				WHERE r.`target_id` = r2.`id`
       				AND r2.`target_id` = q2.`id`
       				AND r.`play_id` = {$playId}

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];

			if($r->question_id != $prevQuestionId){
				array_push($answers, [
						'question_id' => $r->question_id,
						'question'=>$r->question,
						'answer_option_1'=>$r->answer_option_1,
						'answer_option_2'=>$r->answer_option_2,
						'answer_option_3'=>$r->answer_option_3,
						'answer_option_4'=>$r->answer_option_4,
						'answer_option_5'=>$r->answer_option_5,
						'answer_option_6'=>$r->answer_option_6,
						'difficulty'=>$r->difficulty,
						'result' => [
							'result_id' => $r->id,
							'correct' => $r->correct,
							'answer_1' => $r->answer_1,
							'answer_2' => $r->answer_2,
							'answer_3' => $r->answer_3,
							'answer_4' => $r->answer_4,
							'answer_5' => $r->answer_5,
							'answer_6' => $r->answer_6
						],
						'subjects' => []
						]);
			}
			array_push($answers[count($answers)-1]['subjects'] ,[
					'subject_code' => $r->subject_code,
					'subject_name' => $r->name,
					'description' => $r->description
				]);
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP03($playId){
		$answers = [];

		 $sql = "
       		SELECT q3.`id` AS `question_id` ,q3.`answer` AS `question_answer`,  q3.* , r3.`id` AS `result_id` , r3.* , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
       			FROM (`t0300_game_result` r , `t0203_game_question_p03` q3 , `t0303_game_result_p03` r3)

       			LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
				LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )

       				WHERE r.`target_id` = r3.`id`
       				AND r3.`target_id` = q3.`id`
       				AND r.`play_id` = {$playId}

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

       for($i=0; $i<count($result); $i++){
			$r = $result[$i];

			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'question' => $r->question,
					'correct_answer' => $r->question_answer,
					'answer_option_1' => $r->answer_option_1,
					'answer_option_2' => $r->answer_option_2,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->question_answer,
					],
					'subjects' => []
				]);
			}
			array_push($answers[count($answers)-1]['subjects'] ,[
					'subject_code' => $r->subject_code,
					'subject_name' => $r->name,
					'description' => $r->description
				]);
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP06($playId){
		$answers = [];

		 $sql = "
       		SELECT q6.`id` AS `question_id` , q6.* , r6.`id` AS `result_id` ,r6.`answer`AS `question_answer`, r6.* , q6t.*, IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
       			FROM (`t0300_game_result` r , `t0206_game_question_p06` q6 ,`t0206_game_question_p06_template` q6t, `t0306_game_result_p06` r6)

       			LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
				LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )
       				WHERE r.`target_id` = r6.`id`
       				AND r6.`target_id` = q6.`id`
       				AND q6t.`id` = q6.`template_id`
       				AND r.`play_id` = {$playId}

       				ORDER BY r.`id` ASC;

       ";
       $result = DB::select($sql);

       $prevQuestionId = 0;

       for($i=0; $i<count($result); $i++){
			$r = $result[$i];

				$part1 =  str_replace("@1", $r->tpl_param_1, $r->part_1);
				$part1 =  str_replace("@2", $r->tpl_param_2, $part1);
				$part1 =  str_replace("@3", $r->tpl_param_3, $part1);

				$part2 =  str_replace("@1", $r->tpl_param_1, $r->part_2);
				$part2 =  str_replace("@2", $r->tpl_param_2, $part2);
				$part2 =  str_replace("@3", $r->tpl_param_3, $part2);

				$part3 =  str_replace("@1", $r->tpl_param_1, $r->part_3);
				$part3 =  str_replace("@2", $r->tpl_param_2, $part3);
				$part3 =  str_replace("@3", $r->tpl_param_3, $part3);

				$expression =  str_replace("@1", $r->tpl_param_1, $r->expression);
				$expression =  str_replace("@2", $r->tpl_param_2, $expression);
				$expression =  str_replace("@3", $r->tpl_param_3, $expression);

			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'param_1' => $r->game_param_1,
					'param_2' => $r->game_param_2,
					'param_3' => $r->game_param_3,
					'p1_object' => $r->game_param_4,
					'p2_object' => $r->game_param_5,
					'p3_object' => $r->game_param_6,
					'setting' => $r->game_param_7,
					'part_1' => $part1,
					'part_2' => $part2,
					'part_3' => $part3,
					'expression' => $expression,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->question_answer,
					],
					'subjects' => []
				]);
			}
			array_push($answers[count($answers)-1]['subjects'] ,[
						'subject_code' => $r->subject_code,
						'subject_name' => $r->name,
						'description' => $r->description
			]);
				
			$prevQuestionId = $r->question_id;
			return $answers;
		}
	}
	public static function ResultQuestionP07($playId){
		$answers = [];

		 $sql = "
       		SELECT q7.`id` AS `question_id` , q7.`answer` AS `question_answer` ,q7.* , r7.`id` AS `result_id` , r7.* , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
       			FROM (`t0300_game_result` r , `t0207_game_question_p07` q7 , `t0307_game_result_p07` r7)

       			LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
				LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )

       				WHERE r.`target_id` = r7.`id`
       				AND r7.`target_id` = q7.`id`
       				AND r.`play_id` = {$playId}

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'left_question_1'=>$r->left_question_1,
					'left_question_2'=>$r->left_question_2,
					'left_question_3'=>$r->left_question_3,
					'correct_answer'=> $r->question_answer,
					'right_question_1'=>$r->right_question_1,
					'right_question_2'=>$r->right_question_2,
					'right_question_3'=>$r->right_question_3,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->question_answer,
					],
					'subjects' => []
				]);
			}

			array_push($answers[count($answers)-1]['subjects'] ,[
					'subject_code' => $r->subject_code,
					'subject_name' => $r->name,
					'description' => $r->description
				]);
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}
	public static function ResultQuestionP10($playId){
		$answers = [];

		 $sql = "
       		SELECT q10.`id` AS `question_id` , q10.`answer` AS `question_answer` ,q10.* , r10.`id` AS `result_id` , r10.* , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
       			FROM (`t0300_game_result` r , `t0210_game_question_p10` q10 , `t0310_game_result_p10` r10)

       			LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
				LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )

       				WHERE r.`target_id` = r10.`id`
       				AND r.`target_id` = q10.`id`
       				AND r.`play_id` = {$playId}

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
		  $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'question'=>$r->question,
					'start_1'=>$r->start_1,
					'start_10'=>$r->start_10,
					'start_100'=> $r->start_100,
					'start_1000'=>$r->start_1000,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->question_answer,
					],
					'subjects' => []
				]);
			}

			array_push($answers[count($answers)-1]['subjects'] ,[
					'subject_code' => $r->subject_code,
					'subject_name' => $r->name,
					'description' => $r->description
				]);
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP18($playId){
		$answers = [];

		 $sql = "
       		SELECT q18.`id` AS `question_id` , q18.`answer` AS `question_answer` ,q18.* , r18.`id` AS `result_id` , r18.* , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
       			FROM (`t0300_game_result` r , `t0218_game_question_p18` q18 , `t0318_game_result_p18` r18)

       			LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
				LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )

       				WHERE r.`target_id` = r18.`id`
       				AND r.`target_id` = q18.`id`
       				AND r.`play_id` = {$playId}

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
		  $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'question'=>$r->question,
					'answer'=>$r->answer,
					'option_from'=>$r->option_from,
					'option_until_total'=> $r->option_until_total,
					'ruler_type'=>$r->ruler_type,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->question_answer,
					],
					'subjects' => []
				]);
			}

			array_push($answers[count($answers)-1]['subjects'] ,[
					'subject_code' => $r->subject_code,
					'subject_name' => $r->name,
					'description' => $r->description
				]);
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP23($playId){
		$answers = [];

		 $sql = "
       		SELECT q23.`id` AS `question_id` , q23.`answer` AS `question_answer` ,q23.* , r23.`id` AS `result_id` , r23.* , IFNULL(s.`subject_code`, 0) AS `subject_code` , s.`name` ,s.`description`
       			FROM (`t0300_game_result` r , `t0223_game_question_p23` q23 , `t0323_game_result_p23` r23)

       			LEFT JOIN `t0132_game_question_subject` qs ON (qs.`question_id` =r.`question_id`)
				LEFT JOIN `t0131_game_subject` s ON(qs.`subject_id` = s.`id`  )

       				WHERE r.`target_id` = r23.`id`
       				AND r.`target_id` = q18.`id`
       				AND r.`play_id` = {$playId}

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
		  $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'question'=>$r->question,
					'answer'=>$r->answer,
					'plan'=>$r->plan,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->question_answer,
					],
					'subjects' => []
				]);
			}

			array_push($answers[count($answers)-1]['subjects'] ,[
					'subject_code' => $r->subject_code,
					'subject_name' => $r->name,
					'description' => $r->description
				]);
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}


}



