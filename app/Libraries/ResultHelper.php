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
use App\Models\GameResultP00;
use App\Models\GameResultP01;
use App\Models\GameResultP02;
use App\Models\GameResultP03;
use App\Models\GameResultP06;
use App\Models\GameResultP07;
use App\Models\GameResultP08;
use App\Models\GameResultP09;
use App\Models\GameResultP10;
use App\Models\GameQuestion;
use App\Models\GameQuestionP03;
use App\Models\GameQuestionP04ChallengeSet;
use App\Models\GameSystemPlanet;
use App\Models\UserExternalId;
use App\Models\LeaderboardWorld;
use App\Models\LeaderboardSystem;
use App\Models\LeaderboardPlanet;

class ResultHelper{

	public static function ResultQuestionP00($playId){
		$answers = [];

		$sql = "
       		SELECT q0.`id` AS `question_id` ,q0.`question`, r0.`answer` , r0.`id` AS `result_id` ,r0.`correct` , q0.`difficulty`
       			FROM (`t0300_game_result` r , `t0200_game_question_p00` q0 , `t0300_game_result_p00` r0)

       				WHERE r.`target_id` = r0.`id`
       				AND r0.`target_id` = q0.`id`
       				AND r.`play_id` IN ($playId)

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
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer' => $r->answer,
						]
				]);
			}
				
			$prevQuestionId = $r->question_id;
		}

		return $answers;
	}

	public static function ResultQuestionP01($playId){
		$answers = [];

		$sql = "
       		SELECT q1.`id` AS `question_id` , q1.`question`, r1.`angle3`, r1.`angle4` , r1.`angle5` , r1.`angle6` , r1.`id` AS `result_id` ,r1.`correct` , q1.`difficulty`
       			FROM `t0300_game_result` r , `t0201_game_question_p01` q1 , `t0301_game_result_p01` r1

       				WHERE r.`target_id` = r1.`id`
       				AND r1.`target_id` = q1.`id`
       				AND r.`play_id` IN ($playId)

       				ORDER BY r.`id` ASC;
       ";

       $result = DB::select($sql);
       $prevQuestionId = 0;

       for($i=0; $i<count($result); $i++){
			$r = $result[$i];

			if($r->question_id != $prevQuestionId){
				$answer = 'Triangle = '.$r->angle3.' , Quadrilateral = '.$r->angle4.' , Pentagon = '.$r->angle5.' , Hexagon = '.$r->angle6;

				array_push($answers, [
					'question_id' => $r->question_id,
					'question' => $r->question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer' => $answer,
						]
				]);
			}
				
			$prevQuestionId = $r->question_id;
		}

		return $answers;
	}

	public static function ResultQuestionP02($playId){
		$answers = [];

       $sql = "
       		SELECT q2.`id` AS `question_id` ,q2.`question`, q2.`answer_option_1` , q2.`answer_option_2` ,q2.`answer_option_3` ,q2.`answer_option_4` ,q2.`answer_option_5` ,q2.`answer_option_6` ,q2.`difficulty` , r2.*
       			FROM `t0300_game_result` r , `t0202_game_question_p02` q2 , `t0302_game_result_p02` r2

       				WHERE r.`target_id` = r2.`id`
       				AND r2.`target_id` = q2.`id`
       				AND r.`play_id` IN ($playId)

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];

			if($r->question_id != $prevQuestionId){
				if($r->answer_1){
					$answer = $r->answer_1;
					if($r->answer_2){
						$answer = $r->answer_1.','.$r->answer_2;
						if($r->answer_3){
							$answer = $r->answer_1.','.$r->answer_2.','.$r->answer_3;
							if($r->answer_4){
								$answer = $r->answer_1.','.$r->answer_2.','.$r->answer_3.','.$r->answer_4;
								if($r->answer_5){
									$answer = $r->answer_1.','.$r->answer_2.','.$r->answer_3.','.$r->answer_4.','.$r->answer_5;
									if($r->answer_6){
										$answer = $r->answer_1.','.$r->answer_2.','.$r->answer_3.','.$r->answer_4.','.$r->answer_5.','.$r->answer_6;
									}
								}
							}
						}
					}
				}
				
				if($r->answer_option_1){
					$answer = $r->answer_option_1;
					if($r->answer_option_2){
						$question = 'Make '.$r->question.' given the following numbers '.$r->answer_option_1.','.$r->answer_option_2;
						if($r->answer_option_3){
							$question = 'Make '.$r->question.' given the following numbers '.$r->answer_option_1.','.$r->answer_option_2.','.$r->answer_option_3;
							if($r->answer_option_4){
								$question = 'Make '.$r->question.' given the following numbers '.$r->answer_option_1.','.$r->answer_option_2.','.$r->answer_option_3.','.$r->answer_option_4;
								if($r->answer_option_5){
									$question = 'Make '.$r->question.' given the following numbers '.$r->answer_option_1.','.$r->answer_option_2.','.$r->answer_option_3.','.$r->answer_option_4.','.$r->answer_option_5;
									if($r->answer_option_6){
										$question = 'Make '.$r->question.' given the following numbers '.$r->answer_option_1.','.$r->answer_option_2.','.$r->answer_option_3.','.$r->answer_option_4.','.$r->answer_option_5.','.$r->answer_option_6;
									}
								}
							}
						}
					}
				}
				
				array_push($answers, [
						'question_id' => $r->question_id,
						'question'=> $question,
						'difficulty'=>$r->difficulty,
						'result' => [
							'result_id' => $r->id,
							'correct' => $r->correct,
							'answer' => $answer,
						]
					]);
			}
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP03($playId){
		$answers = [];

		 $sql = "
       		SELECT q3.`id` AS `question_id` ,q3.`question`, r3.`answer_text` , r3.`id` AS `result_id` ,r3.`correct` , q3.`difficulty`
       			FROM (`t0300_game_result` r , `t0203_game_question_p03` q3 , `t0303_game_result_p03` r3)

       				WHERE r.`target_id` = r3.`id`
       				AND r3.`target_id` = q3.`id`
       				AND r.`play_id` IN ($playId)

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

       for($i=0; $i<count($result); $i++){
			$r = $result[$i];

			if($r->question_id != $prevQuestionId){
				
				array_push($answers, [
					'question_id' => $r->question_id,
					'question' => $r->question.' True or False?',
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->answer_text,
					]
				]);
			}
			
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP06($playId){
		$answers = [];

		 $sql = "
       		SELECT q6.`id` AS `question_id` , q6.* , r6.`id` AS `result_id` ,r6.`answer`AS `result_answer`, r6.* , q6t.*
       			FROM `t0300_game_result` r , `t0206_game_question_p06` q6 ,`t0206_game_question_p06_template` q6t, `t0306_game_result_p06` r6

       				WHERE r.`target_id` = r6.`id`
       				AND r6.`target_id` = q6.`id`
       				AND q6t.`id` = q6.`template_id`
       				AND r.`play_id` IN ($playId)

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

				$question = $part1.' '.$part2.' '.$part3;

				array_push($answers, [
					'question_id' => $r->question_id,
					'question' => $question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->result_answer,
					]
				]);
			}
		
			$prevQuestionId = $r->question_id;
		}
			return $answers;
	}

	public static function ResultQuestionP07($playId){
		$answers = [];

		 $sql = "
       		SELECT q7.`id` AS `question_id` ,q7.`left_question_1` , q7.`left_question_2` , q7.`left_question_3` , q7.`right_question_1` , q7.`right_question_2` , q7.`right_question_3` , r7.`answer` , r7.`id` AS `result_id` ,r7.`correct` , q7.`difficulty`
       			FROM `t0300_game_result` r , `t0207_game_question_p07` q7 , `t0307_game_result_p07` r7

       				WHERE r.`target_id` = r7.`id`
       				AND r7.`target_id` = q7.`id`
       				AND r.`play_id` IN ($playId)

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				$question = $r->left_question_1.$r->left_question_2.$r->left_question_3." □ ".$r->right_question_1.$r->right_question_2.$r->right_question_3;
				array_push($answers, [
					'question' => $question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP08($playId){
		$answers = [];

		 $sql = "
       		SELECT q8.`id` AS `question_id` ,q8.`param_1` , q8.`param_2` , q8.`param_3` , q8.`param_4` , q8.`param_5` , q8.`param_6` , q8.`param_7` , q8.`hexagon_path` , r8.`id` AS `result_id` , r8.`answer` ,r8.`correct` , q8.`difficulty`
       			FROM `t0300_game_result` r , `t0208_game_question_p08` q8 , `t0308_game_result_p08` r8

       				WHERE r.`target_id` = r8.`id`
       				AND r8.`target_id` = q8.`id`
       				AND r.`play_id` IN ($playId)

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
     		$question = 'The equation '.$r->param_1.$r->param_2.$r->param_3.$r->param_4.$r->param_5.$r->param_6.$r->param_7.' is jumbled.';

			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question' => $question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct' => $r->correct,
						'answer' =>$r->answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP09($playId){
		$answers = [];

		 $sql = "
       		SELECT q9.`id` AS `question_id` , r9.`answer` , r9.`id` AS `result_id` ,r9.`correct` , q9.`difficulty`
       			FROM `t0300_game_result` r , `t0209_game_question_p09` q9 , `t0309_game_result_p09
       				WHERE r.`target_id` = r9.`id`
       				AND r9.`target_id` = q9.`id`
       				AND r.`play_id` IN ( {$playId} )

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				
				array_push($answers, [
					'question' => '',
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP10($playId){
		$answers = [];

		 $sql = "
       		SELECT q10.`id` AS `question_id` , q10.`question` , r10.`answer` , r10.`id` AS `result_id` ,r10.`correct` , q10.`difficulty`
       			FROM `t0300_game_result` r , `t0210_game_question_p10` q10 , `t0310_game_result_p10` r10


       				WHERE r.`target_id` = r10.`id`
       				AND r10.`target_id` = q10.`id`
       				AND r.`play_id` IN ($playId)

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
		  $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			$thousands = floor(($r->answer % 10000)/1000);
			$hundreds = floor(($r->answer % 1000)/100);
			$tens = floor(($r->answer % 100)/10);
			$ones = floor(($r->answer % 10)/1);

			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'question'=>$r->question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=> [
							'thousands' => $thousands,
							'hundreds' => $hundreds,
							'tens' => $tens,
							'ones' => $ones,
						]
					]
				]);
			}
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP11($playId){
		$answers = [];

		 $sql = "
       		SELECT q11.`id` AS `question_id` , r11.`patty`, r11.`greens`, r11.`cheese` , r11.`id` AS `result_id` ,r11.`correct` , q11.`difficulty`
       			FROM `t0300_game_result` r , `t0211_game_question_p11` q11 , `t0311_game_result_p11`
       				WHERE r.`target_id` = r11.`id`
       				AND r11.`target_id` = q11.`id`
       				AND r.`play_id` IN ( {$playId} )

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question' => '',
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>[
							'patty' => $r->patty,
							'greens' => $r->greens,
							'cheese' => $r->cheese,
						]
					]
				]);
			}
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP12($playId){
		$answers = [];

		 $sql = "
       		SELECT q12.`id` AS `question_id` , r12.`answer`, r12.`id` AS `result_id` ,r12.`correct` , q12.`difficulty`
       			FROM `t0300_game_result` r , `t0212_game_question_p12` q12 , `t0312_game_result_p12`
       				WHERE r.`target_id` = r12.`id`
       				AND r12.`target_id` = q12.`id`
       				AND r.`play_id` IN ( {$playId} )

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				
				array_push($answers, [
					'question' => '',
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=> $r->answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP13($playId){		
		$answers = [];

		 $sql = "
       		SELECT q13.`id` AS `question_id` , r13.`answer`, r13.`id` AS `result_id` ,r13.`correct` , q13.`difficulty`
       			FROM `t0300_game_result` r , `t0213_game_question_p13` q13 , `t0313_game_result_p13`
       				WHERE r.`target_id` = r13.`id`
       				AND r13.`target_id` = q13.`id`
       				AND r.`play_id` IN ( {$playId} )

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				
				array_push($answers, [
					'question' => '',
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=> $r->answer,
					]
				]);
			}
				
			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP14($playId){
		$answers = [];

		 $sql = "
       		SELECT q14.`id` AS `question_id` , r14.`answer`, r14.`id` AS `result_id` ,r14.`correct` , q14.`difficulty`
       			FROM `t0300_game_result` r , `t0214_game_question_p14` q14 , `t0314_game_result_p14` r14

       				WHERE r.`target_id` = r14.`id`
       				AND r14.`target_id` = q14.`id`
       				AND r.`play_id` IN ( {$playId} )

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				
				array_push($answers, [
					'question' => '',
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=> $r->answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP15($playId){
		$answers = [];

		 $sql = "
       		SELECT q15.`id` AS `question_id` , q15.`question` , r15.`answer`, r15.`id` AS `result_id` ,r15.`correct` , q15.`difficulty`
       			FROM `t0300_game_result` r , `t0215_game_question_p15` q15 , `t0315_game_result_p15` r15

       				WHERE r.`target_id` = r15.`id`
       				AND r15.`target_id` = q15.`id`
       				AND r.`play_id` IN ( {$playId} )

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				
				array_push($answers, [
					'question' => $r->question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=> $r->answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP16($playId){
		$answers = [];

		 $sql = "
       		SELECT q16.`id` AS `question_id` , q16.`question` , r16.`answer`, r16.`id` AS `result_id` ,r16.`correct` , q16.`difficulty`
       			FROM `t0300_game_result` r , `t0216_game_question_p16` q16 , `t0316_game_result_p16` r16

       				WHERE r.`target_id` = r16.`id`
       				AND r16.`target_id` = q16.`id`
       				AND r.`play_id` IN ( {$playId} )

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				
				array_push($answers, [
					'question' => $r->question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=> $r->answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP17($playId){
		$answers = [];

		 $sql = "
       		SELECT q17.`id` AS `question_id` , q17.`question` , r17.`answer`, r17.`id` AS `result_id` ,r17.`correct` , q17.`difficulty`
       			FROM `t0300_game_result` r , `t0217_game_question_p17` q17 , `t0317_game_result_p17` r17

       				WHERE r.`target_id` = r17.`id`
       				AND r17.`target_id` = q17.`id`
       				AND r.`play_id` IN ( {$playId} )

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
       $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->question_id != $prevQuestionId){
				
				array_push($answers, [
					'question' => $r->question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=> $r->answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP18($playId){
		$answers = [];

		 $sql = "
       		SELECT q18.`id` AS `question_id` , q18.`question`,q18.`option_from` , r18.`answer` , r18.`id` AS `result_id` ,r18.`correct` , q18.`difficulty`
       			FROM `t0300_game_result` r , `t0218_game_question_p18` q18 , `t0318_game_result_p18` r18

       				WHERE r.`target_id` = r18.`id`
       				AND r18.`target_id` = q18.`id`
       				AND r.`play_id` IN ($playId)

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
		  $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];

			if(!$r->option_from){
				$question = "Locate ".$r->question." on the number line.";
			}else{
				$question = "Locate ".$r->question." from ".$r->option_from." on the number line.";
			}

			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'question'=> $question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$r->answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP23($playId){
		$answers = [];

		 $sql = "
       		SELECT q23.`id` AS `question_id` ,q23.`question`, r23.`answer` , r23.`id` AS `result_id` ,r23.`correct` , q23.`difficulty`
       			FROM `t0300_game_result` r , `t0223_game_question_p23` q23 , `t0323_game_result_p23` r23
	
       				WHERE r.`target_id` = r23.`id`
					AND r23.`target_id` = q23.`id`
       				AND r.`play_id` IN ({$playId})

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
		  $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			$question = "Stop the indicator at the angle ".$r->question;
			$answer = $r->answer."° from A (180 - ".$r->answer."° from B";
			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'question'=> $question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$answer
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

	public static function ResultQuestionP32($playId){
		$answers = [];

		 $sql = "
       		SELECT q32.`id` AS `question_id` ,q32.`question`,q32.`origin_x`, q32.`origin_y`,q32.`diff_x`,q32.`diff_y`, r32.`answer_x`, r32.`answer_y` , r32.`id` AS `result_id` ,r32.`correct` , q32.`difficulty`
       			FROM `t0300_game_result` r , `t0232_game_question_p32` q32 , `t0332_game_result_p32` r32
	
       				WHERE r.`target_id` = r32.`id`
					AND r32.`target_id` = q32.`id`
       				AND r.`play_id` IN ({$playId})

       				ORDER BY r.`id` ASC;
       ";
       $result = DB::select($sql);
		 $prevQuestionId = 0;

        for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			$question = "Plot the coordinate ".$r->question." when the X-axis begins at ".$r->origin_x." and the Y-axis begins at ".$r->origin_y.", the difference in X is ".$r->diff_x." and the difference in Y is ".$r->diff_y.".";
			$answer = '('.$r->answer_x.','.$r->answer_y.')';
			if($r->question_id != $prevQuestionId){
				array_push($answers, [
					'question_id' => $r->question_id,
					'question'=> $question,
					'difficulty'=>$r->difficulty,
					'result' => [
						'result_id' => $r->result_id,
						'correct'=> $r->correct,
						'answer'=>$answer,
					]
				]);
			}

			$prevQuestionId = $r->question_id;
		}
		return $answers;
	}

}



