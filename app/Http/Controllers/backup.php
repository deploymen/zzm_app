public function topicProgress() {
		$gameCode = \Request::input('game_code');

		$sql = " 
			SELECT m.`id` AS `main_id`, m.`name` AS `main_topic_name` ,s.`id` AS `sub_id`,s.`name` AS `sub_topic_name` ,  COUNT(DISTINCT b.`question_id`) AS `play_count`
				FROM (`t0131_game_topic_main` m, `t0132_game_topic_sub` s)
					LEFT JOIN (
	                    SELECT r.`topic_main_id` , r.`topic_sub_id`, r.`question_id`
	                    FROM `t0400_game_play` p, `t0300_game_result` r
	                    WHERE p.`id` = r.`play_id` AND p.`code` = :game_code
	                    
	                ) b ON( b.`topic_main_id`= m.`id`AND b.`topic_sub_id` = s.`id` )
						WHERE s.`topic_main_id` =  m.`id`
						AND s.`enable` = '1'
						AND m.`enable` = '1'
							GROUP BY m.`id`, s.`id` 
								ORDER BY m.`sequence` ASC, s.`sequence` ASC
		";

		$params = ['game_code'=>$gameCode];
		$result = \DB::SELECT($sql, $params);

		$answers = [];
		$prev_topic_id = '';
		for($i=0; $i<count($result); $i++){
			$r = $result[$i];
			if($r->main_id != $prev_topic_id){
				array_push($answers, [
					'id' => $r->main_id,
					'main_topic_name' => $r->main_topic_name,
					'sub_topic' => []
				]);
			}

			array_push($answers[count($answers) - 1]['sub_topic'], [
					'id' => $r->sub_id,
					'sub_topic_name' => $r->sub_topic_name,
					'play_count' => $r->play_count,
			]);


			$prev_topic_id = $r->main_id;
		}	
		return Libraries\ResponseHelper::OutputJSON('success', '' , $answers );
	}

	public function topicQuestionsPlayed($topicMainId , $topicSubId){

		$pageSize = \Request::input('page-size', '30');
		$page = \Request::input("page", '1');
		$gameCode = \Request::input('game_code');

		
		if(!$topicSubId || !$gameCode){
				return  Libraries\ResponseHelper::OutputJSON('fail' , '' , 'missing parameter');
			}

		if($topicMainId > 0){
			$topicSub = Models\TopicSub::where('id', $topicSubId)->where('topic_main_id', $topicMainId)->first();

			if(!$topicSub){
				return  Libraries\ResponseHelper::OutputJSON('fail', 'topic not found');
			}
		}else{
			$topicSub = Models\TopicSub::find($topicSubId);

			if(!$topicSub){
				return  Libraries\ResponseHelper::OutputJSON('fail', 'topic not found');
				}
		}

		$sql = "
			SELECT  r.`question_id`,  r.`target_type` , r.`topic_main_id`, r.`topic_sub_id`, q.`target_id`, COUNT(r.`id`) AS `play_count` 
				FROM `t0300_game_result` r , `t0400_game_play` p , `t0200_game_question` q
					WHERE r.`topic_sub_id` = :topic_sub_id
					AND q.`id` = r.`question_id`
					AND r.`play_id` = p.`id`
					AND p.`code` = :game_code
						GROUP BY r.`question_id` 
						ORDER BY r.`created_at` DESC
		";
			
		$params = ['game_code'=>$gameCode , 'topic_sub_id'=>$topicSubId];
		$results = \DB::SELECT($sql, $params);
		$result = [];
		

		// try {
			for($i=0; $i<count($results); $i++){
				$r = (array)$results[$i];
				$r['question'] = [];

				switch ($results[$i]->target_type) {
					case 'p01': 
							$gameQuestionp01 = Models\GameQuestionP01::where('id' ,$results[$i]->target_id )->get()->toArray();
							array_push($r['question'] , $gameQuestionp01);
					break;	

					case 'p02': 
							$gameQuestionp02 = Models\GameQuestionP02::where('id' ,$results[$i]->target_id )->get()->toArray();
							array_push($r['question'] , $gameQuestionp02);
					break;

					case 'p03':  
							$gameQuestionp03 = Models\GameQuestionP03::where('id' ,$results[$i]->target_id )->get()->toArray();
							array_push($r['question'] , $gameQuestionp03);
					break;

					case 'p04':  
							$gameQuestionp04 = Models\GameQuestionP04::where('id' ,$results[$i]->target_id )->get()->toArray();
							array_push($r['question'] , $gameQuestionp04);
					break;	

					case 'p06':
							$gameQuestionp06 = Models\GameQuestionP06::where('id' ,$results[$i]->target_id )->get()->toArray();
							array_push($r['question'] , $gameQuestionp06);
					break;
				}
				array_push($result, $r);
			}

				
			

			return  Libraries\ResponseHelper::OutputJSON('success' , '', $result);
	}		

	public function topicQuestionsHistory($questionId){
		$pageSize = \Request::input('page-size', '30');
		$page = \Request::input("page", '1');


		$gameCode = \Request::input('game_code');

		$question = Models\GameQuestion::find($questionId);
		$questions = [];

		switch($question->target_type){
			case 'p01': 
					$gameQuestion = Models\GameQuestionP01::find($question->target_id)->toArray();
					array_push($questions ,$gameQuestion);
			break;
			case 'p02': 
					$gameQuestion = Models\GameQuestionP02::find($question->target_id)->toArray();
					array_push($questions ,$gameQuestion);
			break;

			case 'p03':  
					$gameQuestion = Models\GameQuestionP03::find($question->target_id)->toArray();
					array_push($questions ,$gameQuestion);
			break;

			case 'p04':  
					$gameQuestion = Models\GameQuestionP04::find($question->target_id)->toArray();
					array_push($questions ,$gameQuestion);
			break;	

			case 'p06':
					$gameQuestion = Models\GameQuestionP06::find($question->target_id)->toArray();
					array_push($questions ,$gameQuestion);
			break;
		}

		$sql = "
			SELECT  r.`target_id` , r.`target_type`
			 FROM t0300_game_result r , t0400_game_play p
			 	WHERE r.`question_id` = :question_id
			 	AND r.`play_id` = p.`id`
			 		AND p.`code` = :game_code

		";

		$params = ['game_code'=>$gameCode , 'question_id'=>$questionId];
		$results = \DB::SELECT($sql, $params);
		$questions[0]['history'] = [];

		for($i=0; $i<count($results); $i++){

			switch ($results[$i]->target_type) {
				case 'p01': 
					$gameResult = Models\GameResultP01::find($results[$i]->target_id);
					array_push($questions[0]['history'] , $gameResult );
				break;

				case 'p02': 
					$gameResult = Models\GameResultP02::find($results[$i]->target_id);
					array_push($questions[0]['history'] , $gameResult );
				break;

				case 'p03':  
					$gameResult = Models\GameResultP03::find($results[$i]->target_id);
					array_push($questions[0]['history'] , $gameResult );
				break;

				case 'p04':  
					$gameResult = Models\GameResultP04::find($results[$i]->target_id);
					array_push($questions[0]['history'] , $gameResult );
				break;	

				case 'p06':
					$gameResult = Models\GameResultP06::find($results[$i]->target_id);
					array_push($questions[0]['history'] , $gameResult );
				break;
				}
		}

		return  Libraries\ResponseHelper::OutputJSON('success' , '', $questions);
	}