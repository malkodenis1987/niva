<?php
/**
 * Class for statistic
 */

class Statistic
{
    public $masterId;
    public $masterRole;
    public $matchId;
    public $wins = array(
        'home' => array(
            'win'  => 0,
            'draw' => 0,
            'loss' => 0
        ),
        'visitor' => array(
            'win'  => 0,
            'draw' => 0,
            'loss' => 0
        )
    );

    /**
     * @param $data
     * @return $this
     * установка статистики
     */
    public function setStat($data)
    {
        global $wpdb;
        $this->masterId = $data['master_id'];
        $this->masterRole = $data['master_role'];
        $this->matchId = $data['match_id'];

        if ($this->isUserPass())
        {
            $this->setErrors(array(23 => 'You have already set points'));
            return $this;
        }
        if ($data['rait'])
        {
            foreach ($data['rait'] as $key => $val)
            {
                if ($val > 0 && $val <= 10)
                {
                    $wpdb->insert(
                        'wp_stat_points',
                        array(
                            'match_id'    => $this->matchId,
                            'player_id'   => $key,
                            'master_id'   => $this->masterId,
                            'master_role' => $this->masterRole,
                            'point'       => $val
                        ),
                        array(
                            '%d',
                            '%d',
                            '%d',
                            '%s',
                            '%d'
                        )
                    );
                }
            }
        }
    }

    /**
     * @param $data
     * @return string
     * Выборка забиты и пропущеных голов
     */
    public function getScoredStat($data)
    {
        global $wpdb;
        $tmpGoals = $resGoals = array();
        $nivaId = getTeamId('Нива');

        if ($data['action'] == 'missed_goals')
            $query = "SELECT match_id, min FROM wp_stat_goals WHERE team_id != $nivaId";
        else
            $query = "SELECT match_id, min FROM wp_stat_goals WHERE team_id = $nivaId";

        $allGoals = $wpdb->get_results($query);

        foreach($allGoals as $goal)
        {
            /* все матчи ВКЛЮЧАЯ товарищеские */
            if ($data['scored_type'] == 0 && $data['scored_friendly'] == 1)
            {
                array_push($tmpGoals, $goal->min);
            }
            /* только определенный турнир */
            elseif($data['scored_type'] == 1)
            {
                if (isInCup($goal->match_id, $data['scored_cup'])) {
                    array_push($tmpGoals, $goal->min);
                }
            }
            /* все матчи КРОМЕ товарищеских */
            else
            {
                if (!isFriendly($goal->match_id)) {
                    array_push($tmpGoals, $goal->min);
                }
            }
        }
        $goals = array_count_values($tmpGoals);
        for($i = 1; $i < 76; $i++)
        {
            if ($goals[$i])
                array_push($resGoals, $goals[$i]);
            else
                array_push($resGoals, 0);
        }
        return implode(",", $resGoals);
    }

    /**
     * @param $data
     * выборка побед-ничьих-поражений
     */
    public function getWinsStat($data)
    {
        global $wpdb;
        $query = "SELECT * FROM wp_stat_score";
        $allWins = $wpdb->get_results($query);

        foreach($allWins as $win)
        {
            /* все матчи ВКЛЮЧАЯ товарищеские */
            if ($data['scored_type'] == 0 && $data['scored_friendly'] == 1)
            {
                $this->addWins($win);
            }
            /* только определенный турнир */
            elseif($data['scored_type'] == 1)
            {
                if (isInCup($win->match_id, $data['scored_cup'])) {
                    $this->addWins($win);
                }
            }
            /* все матчи КРОМЕ товарищеских */
            else
            {
                if (!isFriendly($win->match_id)) {
                    $this->addWins($win);
                }
            }
        }
        return json_encode(unserialize(serialize($this->wins)));
    }

    /**
     * @param $win
     * добавление побед-ничьих-поражений в массив
     */
    protected function addWins($win)
    {
        $nivaId = getTeamId('Нива');

        /* домашние матчи */
        if ($win->home_id == $nivaId)
        {
            /* если пенальти */
            if ($win->home_goals_pen != '0' && $win->visitor_goals_pen != '0')
            {
                if ($win->home_goals_pen > $win->visitor_goals_pen)
                {
                    $this->wins['home']['win']++;
                }
                else
                {
                    $this->wins['home']['loss']++;
                }
            }
            /* есле НЕ пенальти */
            else
            {
                /* победа */
                if ($win->home_goals > $win->visitor_goals)
                    $this->wins['home']['win']++;
                /* ничья */
                if ($win->home_goals == $win->visitor_goals)
                    $this->wins['home']['draw']++;
                /* поражение */
                if ($win->home_goals < $win->visitor_goals)
                    $this->wins['home']['loss']++;
            }
        }
        /* домашние матчи */
        if ($win->home_id != $nivaId)
        {
            /* если пенальти */
            if ($win->home_goals_pen != '0' && $win->visitor_goals_pen != '0')
            {
                if ($win->home_goals_pen < $win->visitor_goals_pen)
                {
                    $this->wins['visitor']['win']++;
                }
                else
                {
                    $this->wins['visitor']['loss']++;
                }
            }
            /* есле НЕ пенальти */
            else
            {
                /* победа */
                if ($win->home_goals < $win->visitor_goals)
                    $this->wins['visitor']['win']++;
                /* ничья */
                if ($win->home_goals == $win->visitor_goals)
                    $this->wins['visitor']['draw']++;
                /* поражение */
                if ($win->home_goals > $win->visitor_goals)
                    $this->wins['visitor']['loss']++;
            }
        }
    }

    /**
     * @return mixed
     * проставил ли пользователь оценки
     */
    protected function isUserPass()
    {
        global $wpdb;
        return $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_points WHERE match_id = $this->matchId AND master_id = $this->masterId" );
    }

    /**
     * Adding errors
     *
     * @param string $error
     */
    protected function setErrors($error)
    {
        foreach($error as $key => $val)
        {
            $this->errors[$key] = $val;
        }
    }
}