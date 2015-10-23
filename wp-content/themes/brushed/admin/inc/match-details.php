<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.01.15
 * Time: 15:20
 */
add_action('admin_head', 'admin_styles');
function admin_styles() {
    echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/admin/assets/css/jquery-ui.css" type="text/css" media="all" />';
    echo '<link rel="stylesheet" href="'.get_bloginfo('template_url').'/admin/assets/css/styles.css" type="text/css" media="all" />';
    echo '<script src="'.get_bloginfo('template_url').'/admin/assets/js/jquery-ui.min.js"></script>';
    echo '<script src="'.get_bloginfo('template_url').'/admin/assets/js/admin.js"></script>';
}
$metaBox = array(
    'id'       => 'statistic-box',
    'title'    => 'Статистика матча',
    'page'     => 'portfolio',
    'context'  => 'normal',
    'priority' => 'low'
);
add_action('admin_menu', 'liga_add_box');
function liga_add_box()
{
    global $metaBox;
    add_meta_box($metaBox['id'], $metaBox['title'], 'liga_show_box', $metaBox['page'], $metaBox['context'], $metaBox['priority']);
}

function liga_show_box()
{
    global $metaBox, $post;
    /* Инициализация */
    $teams = getTeams();
    $score = getScore($post->ID);
    $nivaId = getTeamId('Нива');
    $rivalId = ($score[0]->home_id == getTeamId('Нива')) ? $score[0]->visitor_id : $score[0]->home_id;
    $mainPlayers = getSostav($post->ID, 1);
    $subPlayers = getSostav($post->ID, 0);

    $out = '<input type="hidden" name="liga_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    $out .= '<input type="hidden" name="niva_id" value="'.$nivaId.'" />';
    $out .= '<input type="hidden" name="rival_id" value="'.$rivalId.'" />';

    /* Счет */
    $out .= '<table class="stat">';
    $out .= '<tr><td colspan="3"><h3>Счет</h3></td></tr>';
    $out .= '<tr>';
    $out .= '<td class="align-right">';
    $out .= '<select name="home_team_id">';
    $out .= '<option value="0"> - Хозяева - </option>';
    foreach ($teams as $team) {
        $selected = ($team->ID == $score[0]->home_id) ? 'selected="selected"' : '';
        $out .= '<option '.$selected.' value="'.$team->ID.'">'.$team->post_title.'</option>';
    }
    $out .= '</select>';
    $out .= '</td>';
    $out .= '<td><input type="text" name="home_goals" maxlength="2" required="" class="goals" value="'.$score[0]->home_goals.'" /> : <input type="text" required="" name="visitor_goals" maxlength="2" class="goals" value="'.$score[0]->visitor_goals.'"/></td>';
    $out .= '<td class="align-left">';
    $out .= '<select name="visitor_team_id">';
    $out .= '<option value="0"> - Гости - </option>';
    foreach ($teams as $team) {
        $selected = ($team->ID == $score[0]->visitor_id) ? 'selected="selected"' : '';
        $out .= '<option '.$selected.' value="'.$team->ID.'">'.$team->post_title.'</option>';
    }
    $out .= '</select>';
    $out .= '</td>';
    $out .= '</tr>';
    $out .= '<tr>';
    $out .= '<td>&nbsp;</td>';
    $out .= '<td><input type="text" name="home_goals_pen" maxlength="2" class="goals" value="'.$score[0]->home_goals_pen.'" /> : <input type="text" name="visitor_goals_pen" maxlength="2" class="goals" value="'.$score[0]->visitor_goals_pen.'"/><br/><small>(пенальти)</small></td>';
    $out .= '<td>&nbsp;</td>';
    $out .= '</tr>';
    $out .= '</table>';
    $out .= '<hr />';

    /* Состав */
    $out .= '<table class="stat">';
    $out .= '<tr><td colspan="3"><h3>Состав</h3></td></tr>';
    $out .= '<tr>';
    $out .= '<td style="width: 40%;">';
    $out .= '<h4>Основной состав</h4>';
    $out .= '<ul id="main-players" class="connectedSortable">';
    if ($mainPlayers)
    {
        foreach ($mainPlayers as $player)
        {
            $out .= '<li class="ui-state-highlight"><input type="hidden" name="main_players[]" value="'.$player.'">'.getPlayerName($player).'</li>';
        }
    }
    $out .= '</ul>';
    $out .= '<h4>Выходили на поле</h4>';
    $out .= '<ul id="sub-players" class="connectedSortable">';
    if ($subPlayers)
    {
        foreach ($subPlayers as $player)
        {
            $out .= '<li class="ui-state-highlight"><input type="hidden" name="sub_players[]" value="'.$player.'">'.getPlayerName($player).'</li>';
        }
    }
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '<td style="width: 20%;"><small style="display: block; margin-top: 60px;">перетащите игроков в нужную позицию</small></td>';
    $out .= '<td style="width: 40%;">';
    $out .= '<h4>Все игроки</h4>';
    $players = getPlayers();
    if ($players) {
        $out .= '<ul id="all-players" class="connectedSortable">';
        foreach ($players as $player)
        {
            if (!in_array((string)$player->ID, $mainPlayers) && !in_array((string)$player->ID, $subPlayers))
            {
                $out .= '<li class="ui-state-highlight"><input type="hidden" name="all_players" value="'.$player->ID.'">'.$player->post_title.'</li>';
            }
        }
        $out .= '</ul>';
    }
    $out .= '</td>';
    $out .= '</tr>';
    $out .= '</table>';
    $out .= '<hr />';
    /* Статистика */
    $out .= '<table class="stat">';
    $out .= '<tr><td colspan="3"><h3>Статистика</h3></td></tr>';
    $out .= '<tr class="head">';
    $out .= '<td colspan="3"><h3>Нива</h3> <h3>Соперник</h3></td>';
    $out .= '</tr>';

    /* Забитые голы */
    $out .= '<tr><td>&nbsp;</td><td><h5>Голы</h5></td><td>&nbsp;</td></tr>';
    $out .= '<tr>';
    $out .= '<td>';
    $out .= '<ul class="details">';
    $goalsScored = getGoals($post->ID, $nivaId);
    if($goalsScored)
    {
        $i = 1;
        foreach($goalsScored as $goal)
        {
            $out .= '<li class="field"><input name="goal_scored_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$goal['min'].'" /> мин. ';
            if ($players) {
                $out .= '<select name="goal_scored_item['.$i.'][player]">';
                $out .= '<option value="0"> - Выбрать игрока - </option>';
                foreach ($players as $player) {
                    $selected = ($goal['player_id'] == $player->ID) ? "selected='selected'" : "";
                    $out .= '<option '.$selected.' value="'.$player->ID.'">'.$player->post_title.'</option>';
                    $selected = '';
                }
                $out .= '</select>';
                $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
                $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a><br />';
                $checked = ($goal['is_pen'] == 1) ? "checked='checked'" : "";
                $out .= '<input '.$checked.' type="checkbox" name="goal_scored_item['.$i.'][is_penalty]" value="1"> <label for="is_pen">с пенальти</label>';
                $checked = '';
            }
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="goal_scored_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    if ($players) {
        $out .= '<select name="goal_scored_item[0][player]">';
        $out .= '<option value="0"> - Выбрать игрока - </option>';
        foreach ($players as $player) {
            $out .= '<option value="'.$player->ID.'">'.$player->post_title.'</option>';
        }
        $out .= '</select>';
        $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
        $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a><br />';
        $out .= '<input type="checkbox" name="goal_scored_item[0][is_penalty]" value="1"> <label for="is_pen">с пенальти</label>';
    }
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '<td>&nbsp;</td>';

    /* Прорущеные голы */
    $out .= '<td class="visitor">';
    $out .= '<ul class="details">';
    $goalsMissed = getGoals($post->ID, $rivalId);
    if($goalsMissed) {
        $i = 1;
        foreach ($goalsMissed as $goal) {
            $out .= '<li class="field"><input name="goal_miss_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$goal['min'].'" /> мин. ';
            $out .= '<input type="text" name="goal_miss_item['.$i.'][player]" placeholder="Фамилия (необязательно)" value="'.$goal['player_name'].'"/>';
            $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
            $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a><br/>';
            $checked = ($goal['is_pen'] == 1) ? "checked='checked'" : "";
            $out .= '<input '.$checked.' type="checkbox" name="goal_miss_item['.$i.'][is_penalty]" value="1"> <label for="is_pen">с пенальти</label>';
            $checked = '';
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="goal_miss_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    $out .= '<input type="text" name="goal_miss_item[0][player]" placeholder="Фамилия (необязательно)"/>';
    $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
    $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a><br/>';
    $out .= '<input type="checkbox" name="goal_miss_item[0][is_penalty]" value="1"> <label for="is_pen">с пенальти</label>';
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '</tr>';

    /* Автоголы Нивы */
    $out .= '<tr><td>&nbsp;</td><td><h5>Голы в свои ворота</h5></td><td>&nbsp;</td></tr>';
    $out .= '<tr>';
    $out .= '<td>';
    $out .= '<ul class="details">';
    $goalsScoredOwn = getGoalsOwn($post->ID, $nivaId);
    if($goalsScoredOwn)
    {
        $i = 1;
        foreach($goalsScoredOwn as $goal)
        {
            $out .= '<li class="field"><input name="goal_own_home_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$goal['min'].'" /> мин. ';
            if ($players) {
                $out .= '<select name="goal_own_home_item['.$i.'][player]">';
                $out .= '<option value="0"> - Выбрать игрока - </option>';
                foreach ($players as $player) {
                    $selected = ($goal['player_id'] == $player->ID) ? "selected='selected'" : "";
                    $out .= '<option '.$selected.' value="'.$player->ID.'">'.$player->post_title.'</option>';
                    $selected = '';
                }
                $out .= '</select>';
                $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
                $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a><br />';
            }
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="goal_own_home_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    if ($players) {
        $out .= '<select name="goal_own_home_item[0][player]">';
        $out .= '<option value="0"> - Выбрать игрока - </option>';
        foreach ($players as $player) {
            $out .= '<option value="'.$player->ID.'">'.$player->post_title.'</option>';
        }
        $out .= '</select>';
        $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
        $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    }
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '<td>&nbsp;</td>';

    /* Автоголы соперника */
    $out .= '<td class="visitor">';
    $out .= '<ul class="details">';
    $goalsScoredOwn = getGoalsOwn($post->ID, $rivalId);
    if($goalsScoredOwn) {
        $i = 1;
        foreach ($goalsScoredOwn as $goal) {
            $out .= '<li class="field"><input name="goal_own_visitor_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$goal['min'].'" /> мин. ';
            $out .= '<input type="text" name="goal_own_visitor_item['.$i.'][player]" placeholder="Фамилия (необязательно)" value="'.$goal['player_name'].'" />';
            $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
            $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="goal_own_visitor_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    $out .= '<input type="text" name="goal_own_visitor_item[0][player]" placeholder="Фамилия (необязательно)"/>';
    $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
    $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '</tr>';

    /* Не забитые пенальти Нивы */
    $out .= '<tr><td>&nbsp;</td><td><h5>Не забитые пенальти</h5></td><td>&nbsp;</td></tr>';
    $out .= '<tr>';
    $out .= '<td>';
    $out .= '<ul class="details">';
    $noPen = getNoPen($post->ID, $nivaId);
    if($noPen) {
        $i = 1;
        foreach ($noPen as $item) {
            $out .= '<li class="field"><input name="goal_no_pen_home_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$item['min'].'" /> мин. ';
            if ($players) {
                $out .= '<select name="goal_no_pen_home_item['.$i.'][player]">';
                $out .= '<option value="0"> - Выбрать игрока - </option>';
                foreach ($players as $player) {
                    $selected = ($item['player_id'] == $player->ID) ? "selected='selected'" : "";
                    $out .= '<option '.$selected.' value="'.$player->ID.'">'.$player->post_title.'</option>';
                    $selected = '';
                }
                $out .= '</select>';
                $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
                $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a><br />';
            }
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="goal_no_pen_home_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    if ($players) {
        $out .= '<select name="goal_no_pen_home_item[0][player]">';
        $out .= '<option value="0"> - Выбрать игрока - </option>';
        foreach ($players as $player) {
            $out .= '<option value="'.$player->ID.'">'.$player->post_title.'</option>';
        }
        $out .= '</select>';
        $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
        $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    }
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '<td>&nbsp;</td>';

    /* Не забитые пенальти соперника */
    $out .= '<td class="visitor">';
    $out .= '<ul class="details">';
    $noPen = getNoPen($post->ID, $rivalId);
    if($noPen) {
        $i = 1;
        foreach ($noPen as $item) {
            $out .= '<li class="field"><input name="goal_no_pen_visitor_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$item['min'].'" /> мин. ';
            $out .= '<input type="text" name="goal_no_pen_visitor_item['.$i.'][player]" placeholder="Фамилия (необязательно)" value="'.$item['player_name'].'" />';
            $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
            $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="goal_no_pen_visitor_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    $out .= '<input type="text" name="goal_no_pen_visitor_item[0][player]" placeholder="Фамилия (необязательно)"/>';
    $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
    $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '</tr>';

    /* Желтые карточки Нивы */
    $out .= '<tr><td>&nbsp;</td><td><h5>Желтые карточки</h5></td><td>&nbsp;</td></tr>';
    $out .= '<tr>';
    $out .= '<td>';
    $out .= '<ul class="details">';
    $yellowCards = getYellow($post->ID, $nivaId);
    if($yellowCards) {
        $i = 1;
        foreach ($yellowCards as $item) {
            $out .= '<li class="field"><input name="yellow_home_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$item['min'].'" /> мин. ';
            if ($players) {
                $out .= '<select name="yellow_home_item['.$i.'][player]">';
                $out .= '<option value="0"> - Выбрать игрока - </option>';
                foreach ($players as $player) {
                    $selected = ($item['player_id'] == $player->ID) ? "selected='selected'" : "";
                    $out .= '<option '.$selected.' value="'.$player->ID.'">'.$player->post_title.'</option>';
                    $selected = '';
                }
                $out .= '</select>';
                $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
                $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a><br />';
            }
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="yellow_home_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    if ($players) {
        $out .= '<select name="yellow_home_item[0][player]">';
        $out .= '<option value="0"> - Выбрать игрока - </option>';
        foreach ($players as $player) {
            $out .= '<option value="'.$player->ID.'">'.$player->post_title.'</option>';
        }
        $out .= '</select>';
        $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
        $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    }
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '<td>&nbsp;</td>';

    /* Желтые карточки соперника */
    $out .= '<td class="visitor">';
    $out .= '<ul class="details">';
    $yellowCards = getYellow($post->ID, $rivalId);
    if($yellowCards) {
        $i = 1;
        foreach ($yellowCards as $item) {
            $out .= '<li class="field"><input name="yellow_visitor_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$item['min'].'" /> мин. ';
            $out .= '<input type="text" name="yellow_visitor_item['.$i.'][player]" placeholder="Фамилия (необязательно)" value="'.$item['player_name'].'" />';
            $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
            $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="yellow_visitor_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    $out .= '<input type="text" name="yellow_visitor_item[0][player]" placeholder="Фамилия (необязательно)"/>';
    $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
    $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '</tr>';

    /* Красные карточки Нивы */
    $out .= '<tr><td>&nbsp;</td><td><h5>Красные карточки</h5></td><td>&nbsp;</td></tr>';
    $out .= '<tr>';
    $out .= '<td>';
    $out .= '<ul class="details">';
    $redCards = getRed($post->ID, $nivaId);
    if($redCards) {
        $i = 1;
        foreach ($redCards as $item) {
            $out .= '<li class="field"><input name="red_home_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$item['min'].'" /> мин. ';
            if ($players) {
                $out .= '<select name="red_home_item['.$i.'][player]">';
                $out .= '<option value="0"> - Выбрать игрока - </option>';
                foreach ($players as $player) {
                    $selected = ($item['player_id'] == $player->ID) ? "selected='selected'" : "";
                    $out .= '<option '.$selected.' value="'.$player->ID.'">'.$player->post_title.'</option>';
                    $selected = '';
                }
                $out .= '</select>';
                $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
                $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a><br />';
            }
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="red_home_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    if ($players) {
        $out .= '<select name="red_home_item[0][player]">';
        $out .= '<option value="0"> - Выбрать игрока - </option>';
        foreach ($players as $player) {
            $out .= '<option value="'.$player->ID.'">'.$player->post_title.'</option>';
        }
        $out .= '</select>';
        $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
        $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    }
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '<td>&nbsp;</td>';

    /* Красные карточки соперника */
    $out .= '<td class="visitor">';
    $out .= '<ul class="details">';
    $redCards = getRed($post->ID, $rivalId);
    if($redCards) {
        $i = 1;
        foreach ($redCards as $item) {
            $out .= '<li class="field"><input name="red_visitor_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$item['min'].'" /> мин. ';
            $out .= '<input type="text" name="red_visitor_item['.$i.'][player]" placeholder="Фамилия (необязательно)" value="'.$item['player_name'].'" />';
            $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
            $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="red_visitor_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    $out .= '<input type="text" name="red_visitor_item[0][player]" placeholder="Фамилия (необязательно)"/>';
    $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
    $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '</tr>';

    /* Травмы Нивы */
    $out .= '<tr><td>&nbsp;</td><td><h5>Травмы</h5></td><td>&nbsp;</td></tr>';
    $out .= '<tr>';
    $out .= '<td>';
    $out .= '<ul class="details">';
    $crash = getCrash($post->ID, $nivaId);
    if($crash) {
        $i = 1;
        foreach ($crash as $item) {
            $out .= '<li class="field"><input name="crash_home_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$item['min'].'" /> мин. ';
            if ($players) {
                $out .= '<select name="crash_home_item['.$i.'][player]">';
                $out .= '<option value="0"> - Выбрать игрока - </option>';
                foreach ($players as $player) {
                    $selected = ($item['player_id'] == $player->ID) ? "selected='selected'" : "";
                    $out .= '<option '.$selected.' value="'.$player->ID.'">'.$player->post_title.'</option>';
                    $selected = '';
                }
                $out .= '</select>';
                $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
                $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a><br />';
            }
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="crash_home_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    if ($players) {
        $out .= '<select name="crash_home_item[0][player]">';
        $out .= '<option value="0"> - Выбрать игрока - </option>';
        foreach ($players as $player) {
            $out .= '<option value="'.$player->ID.'">'.$player->post_title.'</option>';
        }
        $out .= '</select>';
        $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
        $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    }
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '<td>&nbsp;</td>';

    /* Травмы соперника */
    $out .= '<td class="visitor">';
    $out .= '<ul class="details">';
    $crash = getCrash($post->ID, $rivalId);
    if($crash) {
        $i = 1;
        foreach ($crash as $item) {
            $out .= '<li class="field"><input name="crash_visitor_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$item['min'].'" /> мин. ';
            $out .= '<input type="text" name="crash_visitor_item['.$i.'][player]" placeholder="Фамилия (необязательно)" value="'.$item['player_name'].'" />';
            $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
            $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="crash_visitor_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    $out .= '<input type="text" name="crash_visitor_item[0][player]" placeholder="Фамилия (необязательно)"/>';
    $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
    $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '</tr>';

    /* Замены */
    $out .= '<tr><td>&nbsp;</td><td><h5>Замены</h5></td><td>&nbsp;</td></tr>';
    $out .= '<tr>';
    $out .= '<td colspan="3">';
    $out .= '<ul class="details">';
    $subs = getSubs($post->ID);
    if($subs) {
        $i = 1;
        foreach ($subs as $item) {
            $out .= '<li class="field"><input name="sub_item['.$i.'][min]" type="text" maxlength="2" class="min" value="'.$item['min'].'" /> мин. ';
            /* Первый игрок */
            $out .= '<select name="sub_item['.$i.'][player1]">';
            $out .= '<option value="0"> - Выбрать игрока - </option>';
            foreach ($players as $player) {
                $selected = ($item['player1_id'] == $player->ID) ? "selected='selected'" : "";
                $out .= '<option '.$selected.' value="'.$player->ID.'">'.$player->post_title.'</option>';
                $selected = '';
            }
            $out .= '</select> &ndash; ';
            /* Второй игрок */
            $out .= '<select name="sub_item['.$i.'][player2]">';
            $out .= '<option value="0"> - Выбрать игрока - </option>';
            foreach ($players as $player) {
                $selected = ($item['player2_id'] == $player->ID) ? "selected='selected'" : "";
                $out .= '<option '.$selected.' value="'.$player->ID.'">'.$player->post_title.'</option>';
                $selected = '';
            }
            $out .= '</select>';
            $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
            $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
            $out .= '</li>';
            $i++;
        }
    }
    $out .= '<li class="field"><input name="sub_item[0][min]" type="text" maxlength="2" class="min" /> мин. ';
    if ($players) {
        /* Первый игрок */
        $out .= '<select name="sub_item[0][player1]">';
        $out .= '<option value="0"> - Выбрать игрока - </option>';
        foreach ($players as $player) {
            $out .= '<option value="'.$player->ID.'">'.$player->post_title.'</option>';
        }
        $out .= '</select> &ndash; ';
        /* Второй игрок */
        $out .= '<select name="sub_item[0][player2]">';
        $out .= '<option value="0"> - Выбрать игрока - </option>';
        foreach ($players as $player) {
            $out .= '<option value="'.$player->ID.'">'.$player->post_title.'</option>';
        }
        $out .= '</select>';
        $out .= '<a class="control add" href="javascript:;" title="добавить">добавить</a>';
        $out .= '<a class="control del" href="javascript:;" title="удалить">удалить</a>';
    }
    $out .= '</li>';
    $out .= '</ul>';
    $out .= '</td>';
    $out .= '</tr>';

    $out .= '</table>';

    echo $out;
}
add_action('save_post', 'liga_save_data');

/**
 * @param $post_id
 * @return mixed
 * Сохранение статистики
 */
function liga_save_data($post_id)
{
    global $wpdb, $metaBox;
    if (!wp_verify_nonce($_POST['liga_meta_box_nonce'], basename(__FILE__)))
    {
        return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    /* Инициализация */
    $nivaId = $_POST['niva_id'];
    $rivalId = $_POST['rival_id'];

    /* Добавление счета */
    $scoreCount = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_score WHERE match_id = $post_id" );
    if (!$scoreCount)
    {
        $wpdb->insert(
            'wp_stat_score',
            array(
                'match_id'          => $post_id,
                'home_id'           => $_POST['home_team_id'],
                'visitor_id'        => $_POST['visitor_team_id'],
                'home_goals'        => $_POST['home_goals'],
                'visitor_goals'     => $_POST['visitor_goals'],
                'home_goals_pen'    => $_POST['home_goals_pen'],
                'visitor_goals_pen' => $_POST['visitor_goals_pen'],
            ),
            array(
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d'
            )
        );
    }
    else
    {
        $wpdb->update(
            'wp_stat_score',
            array(
                'home_id'           => $_POST['home_team_id'],
                'visitor_id'        => $_POST['visitor_team_id'],
                'home_goals'        => $_POST['home_goals'],
                'visitor_goals'     => $_POST['visitor_goals'],
                'home_goals_pen'    => $_POST['home_goals_pen'],
                'visitor_goals_pen' => $_POST['visitor_goals_pen'],
            ),
            array('match_id' => $post_id),
            array(
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d'
            )
        );
    }

    /* Добавление состава */
    $playersMainCount = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_sostav WHERE match_id = $post_id AND in_start = 1" );
    if ($playersMainCount)
    {
        $wpdb->delete('wp_stat_sostav', array('match_id' => $post_id, 'in_start' => 1));
    }
    foreach($_POST['main_players'] as $player)
    {
        $wpdb->insert(
            'wp_stat_sostav',
            array(
                'match_id'          => $post_id,
                'player_id'         => $player,
                'in_start'          => 1
            ),
            array(
                '%d',
                '%d',
                '%d'
            )
        );
    }
    $playersSubCount = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_sostav WHERE match_id = $post_id AND in_start = 0" );
    if ($playersSubCount)
    {
        $wpdb->delete('wp_stat_sostav', array('match_id' => $post_id, 'in_start' => 0));
    }
    foreach($_POST['sub_players'] as $player)
    {
        $wpdb->insert(
            'wp_stat_sostav',
            array(
                'match_id'          => $post_id,
                'player_id'         => $player,
                'in_start'          => 0
            ),
            array(
                '%d',
                '%d',
                '%d'
            )
        );
    }

    /* Добавление забитых голов Нивы */
    $goalsScoredCount = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_goals WHERE match_id = $post_id AND team_id = $nivaId" );
    if ($goalsScoredCount)
    {
        $wpdb->delete('wp_stat_goals', array('match_id' => $post_id, 'team_id' => $nivaId));
    }
    foreach($_POST['goal_scored_item'] as $goal)
    {
        if ($goal['player'] != 0)
        {
            $wpdb->insert(
                'wp_stat_goals',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => $goal['player'],
                    'player_name'       => getPlayerName($goal['player']),
                    'team_id'           => $nivaId,
                    'min'               => $goal['min'],
                    'is_pen'            => $goal['is_penalty']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление пропущеных голов */
    $goalsMissCount = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_goals WHERE match_id = $post_id AND team_id = $rivalId" );
    if ($goalsMissCount)
    {
        $wpdb->delete('wp_stat_goals', array('match_id' => $post_id, 'team_id' => $rivalId));
    }
    foreach($_POST['goal_miss_item'] as $goal)
    {
        if ($goal['player'] != '')
        {
            $wpdb->insert(
                'wp_stat_goals',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => 0,
                    'player_name'       => $goal['player'],
                    'team_id'           => $rivalId,
                    'min'               => $goal['min'],
                    'is_pen'            => $goal['is_penalty']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление голов в свои ворота команды Нива */
    $goalsOwnCountNiva = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_goals_own WHERE match_id = $post_id AND team_id = $nivaId" );
    if ($goalsOwnCountNiva)
    {
        $wpdb->delete('wp_stat_goals_own', array('match_id' => $post_id, 'team_id' => $nivaId));
    }
    foreach($_POST['goal_own_home_item'] as $goal)
    {
        if ($goal['player'] != 0)
        {
            $wpdb->insert(
                'wp_stat_goals_own',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => $goal['player'],
                    'player_name'       => getPlayerName($goal['player']),
                    'team_id'           => $nivaId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление голов в свои ворота соперника */
    $goalsOwnCountRival = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_goals_own WHERE match_id = $post_id AND team_id = $rivalId" );
    if ($goalsOwnCountRival)
    {
        $wpdb->delete('wp_stat_goals_own', array('match_id' => $post_id, 'team_id' => $rivalId));
    }
    foreach($_POST['goal_own_visitor_item'] as $goal)
    {
        if ($goal['player'] != '')
        {
            $wpdb->insert(
                'wp_stat_goals_own',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => 0,
                    'player_name'       => $goal['player'],
                    'team_id'           => $rivalId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление незабитых пенальти команды Нива */
    $goalsNoPenNiva = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_goals_no_pen WHERE match_id = $post_id AND team_id = $nivaId" );
    if ($goalsNoPenNiva)
    {
        $wpdb->delete('wp_stat_goals_no_pen', array('match_id' => $post_id, 'team_id' => $nivaId));
    }
    foreach($_POST['goal_no_pen_home_item'] as $goal)
    {
        if ($goal['player'] != 0)
        {
            $wpdb->insert(
                'wp_stat_goals_no_pen',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => $goal['player'],
                    'player_name'       => getPlayerName($goal['player']),
                    'team_id'           => $nivaId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление незабитых пенальти соперника */
    $goalsNoPenRival = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_goals_no_pen WHERE match_id = $post_id AND team_id = $rivalId" );
    if ($goalsNoPenRival)
    {
        $wpdb->delete('wp_stat_goals_no_pen', array('match_id' => $post_id, 'team_id' => $rivalId));
    }
    foreach($_POST['goal_no_pen_visitor_item'] as $goal)
    {
        if ($goal['player'] != '')
        {
            $wpdb->insert(
                'wp_stat_goals_no_pen',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => 0,
                    'player_name'       => $goal['player'],
                    'team_id'           => $rivalId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление желтых карточек команды Нива */
    $goalsYellowNiva = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_yellow WHERE match_id = $post_id AND team_id = $nivaId" );
    if ($goalsYellowNiva)
    {
        $wpdb->delete('wp_stat_yellow', array('match_id' => $post_id, 'team_id' => $nivaId));
    }
    foreach($_POST['yellow_home_item'] as $goal)
    {
        if ($goal['player'] != 0)
        {
            $wpdb->insert(
                'wp_stat_yellow',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => $goal['player'],
                    'player_name'       => getPlayerName($goal['player']),
                    'team_id'           => $nivaId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление желтых карточек соперника */
    $goalsYellowRival = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_yellow WHERE match_id = $post_id AND team_id = $rivalId" );
    if ($goalsYellowRival)
    {
        $wpdb->delete('wp_stat_yellow', array('match_id' => $post_id, 'team_id' => $rivalId));
    }
    foreach($_POST['yellow_visitor_item'] as $goal)
    {
        if ($goal['player'] != '')
        {
            $wpdb->insert(
                'wp_stat_yellow',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => 0,
                    'player_name'       => $goal['player'],
                    'team_id'           => $rivalId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление красных карточек команды Нива */
    $goalsRedNiva = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_red WHERE match_id = $post_id AND team_id = $nivaId" );
    if ($goalsRedNiva)
    {
        $wpdb->delete('wp_stat_red', array('match_id' => $post_id, 'team_id' => $nivaId));
    }
    foreach($_POST['red_home_item'] as $goal)
    {
        if ($goal['player'] != 0)
        {
            $wpdb->insert(
                'wp_stat_red',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => $goal['player'],
                    'player_name'       => getPlayerName($goal['player']),
                    'team_id'           => $nivaId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление красных карточек соперника */
    $goalsRedRival = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_red WHERE match_id = $post_id AND team_id = $rivalId" );
    if ($goalsRedRival)
    {
        $wpdb->delete('wp_stat_red', array('match_id' => $post_id, 'team_id' => $rivalId));
    }
    foreach($_POST['red_visitor_item'] as $goal)
    {
        if ($goal['player'] != '')
        {
            $wpdb->insert(
                'wp_stat_red',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => 0,
                    'player_name'       => $goal['player'],
                    'team_id'           => $rivalId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление травм команды Нива */
    $crashNiva = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_crash WHERE match_id = $post_id AND team_id = $nivaId" );
    if ($crashNiva)
    {
        $wpdb->delete('wp_stat_crash', array('match_id' => $post_id, 'team_id' => $nivaId));
    }
    foreach($_POST['crash_home_item'] as $goal)
    {
        if ($goal['player'] != 0)
        {
            $wpdb->insert(
                'wp_stat_crash',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => $goal['player'],
                    'player_name'       => getPlayerName($goal['player']),
                    'team_id'           => $nivaId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Добавление травм соперника */
    $crashRival = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_crash WHERE match_id = $post_id AND team_id = $rivalId" );
    if ($crashRival)
    {
        $wpdb->delete('wp_stat_crash', array('match_id' => $post_id, 'team_id' => $rivalId));
    }
    foreach($_POST['crash_visitor_item'] as $goal)
    {
        if ($goal['player'] != '')
        {
            $wpdb->insert(
                'wp_stat_crash',
                array(
                    'match_id'          => $post_id,
                    'player_id'         => 0,
                    'player_name'       => $goal['player'],
                    'team_id'           => $rivalId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }

    /* Замены */
    $subsNiva = $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_subs WHERE match_id = $post_id" );
    if ($subsNiva)
    {
        $wpdb->delete('wp_stat_subs', array('match_id' => $post_id));
    }
    foreach($_POST['sub_item'] as $goal)
    {
        if ($goal['player1'] != 0 && $goal['player2'] != 0)
        {
            $wpdb->insert(
                'wp_stat_subs',
                array(
                    'match_id'          => $post_id,
                    'player1_id'        => $goal['player1'],
                    'player2_id'        => $goal['player2'],
                    'team_id'           => $nivaId,
                    'min'               => $goal['min']
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
        }
    }
}

/**
 * Кастомные функции
 */

/**
 * @return array
 * Выборка команд
 */
function getTeams()
{
    $args = array(
        'post_type' => 'teams',
        'posts_per_page' => -1
    );
    return get_posts($args);
}

/**
 * @param $name
 * @return mixed
 * Выборка id команды по названию
 */
function getTeamId($name)
{
    global $wpdb;
    $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='teams'", $name ));
    return $post;
}

/**
 * @return array
 * Выборка игроков
 */
function getPlayers()
{
    $args = array(
        'post_type' => 'team',
        'posts_per_page' => -1
    );
    return get_posts($args);
}

/**
 * @param $match_id
 * @return mixed
 * Выборка результатов (счет, пенальти и тд)
 */
function getScore($match_id)
{
    global $wpdb;
    $query = "SELECT * FROM wp_stat_score WHERE match_id = $match_id";
    return $wpdb->get_results($query);
}

/**
 * @param $match_id
 * @param $in_start
 * @return array
 * Выборка состава
 */
function getSostav($matchId, $inStart)
{
    global $wpdb;
    $res = array();
    $query = "SELECT player_id FROM wp_stat_sostav WHERE match_id = $matchId AND in_start = $inStart";
    $out = $wpdb->get_results($query, ARRAY_N);
    foreach ($out as $val)
    {
        array_push($res, $val[0]);
    }
    return $res;
}

/**
 * @param $id
 * @return string
 * Выборка id игрока
 */
function getPlayerName($id)
{
    $post = get_post($id);
    return $post->post_title;
}

/**
 * @param $page_title
 * @param string $output
 * @return null|WP_Post
 *
 */
function getPostByTitle($page_title, $output = OBJECT)
{
    global $wpdb;
    $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='post'", $page_title ));
    if ( $post )
        return get_post($post, $output);

    return null;
}

/**
 * @param $matchId
 * @param $teamId
 * Выборка голов (забитые и пропущеные)
 */
function getGoals($matchId, $teamId)
{
    global $wpdb;
    $query = "SELECT player_id, player_name, team_id, min, is_pen FROM wp_stat_goals WHERE match_id = $matchId AND team_id = $teamId";
    return $wpdb->get_results($query, ARRAY_A);
}

/**
 * @param $matchId
 * @param $teamId
 * @return mixed
 * Выборка автоголов (Нива и соперник)
 */
function getGoalsOwn($matchId, $teamId)
{
    global $wpdb;
    $query = "SELECT player_id, player_name, team_id, min FROM wp_stat_goals_own WHERE match_id = $matchId AND team_id = $teamId";
    return $wpdb->get_results($query, ARRAY_A);
}

/**
 * @param $matchId
 * @param $teamId
 * @return mixed
 * Выборка незабитых пенальти
 */
function getNoPen($matchId, $teamId)
{
    global $wpdb;
    $query = "SELECT player_id, player_name, team_id, min FROM wp_stat_goals_no_pen WHERE match_id = $matchId AND team_id = $teamId";
    return $wpdb->get_results($query, ARRAY_A);
}

/**
 * @param $matchId
 * @param $teamId
 * @return mixed
 * Выборка желтых карточек
 */
function getYellow($matchId, $teamId)
{
    global $wpdb;
    $query = "SELECT player_id, player_name, team_id, min FROM wp_stat_yellow WHERE match_id = $matchId AND team_id = $teamId";
    return $wpdb->get_results($query, ARRAY_A);
}

/**
 * @param $matchId
 * @param $teamId
 * @return mixed
 * Выборка красных карточек
 */
function getRed($matchId, $teamId)
{
    global $wpdb;
    $query = "SELECT player_id, player_name, team_id, min FROM wp_stat_red WHERE match_id = $matchId AND team_id = $teamId";
    return $wpdb->get_results($query, ARRAY_A);
}

/**
 * @param $matchId
 * @param $teamId
 * @return mixed
 * Выборка травм
 */
function getCrash($matchId, $teamId)
{
    global $wpdb;
    $query = "SELECT player_id, player_name, team_id, min FROM wp_stat_crash WHERE match_id = $matchId AND team_id = $teamId";
    return $wpdb->get_results($query, ARRAY_A);
}

/**
 * @param $matchId
 * @param $teamId
 * @return mixed
 * Выборка замен
 */
function getSubs($matchId)
{
    global $wpdb;
    $query = "SELECT player1_id, player2_id, min FROM wp_stat_subs WHERE match_id = $matchId";
    return $wpdb->get_results($query, ARRAY_A);
}

/**
 * @param $userId
 * @return mixed
 * выборка id игрока по связаному с ним id пользователя
 */
function getAccountId($userId)
{
    if ($userId !== 0)
    {
        global $wpdb;
        $query = "SELECT post_id FROM wp_postmeta WHERE meta_key = 'user_account' AND meta_value = $userId";
        return $wpdb->get_var($query);
    } else {
        return false;
    }
}

/**
 * @param $matchId
 * @param $userId
 * Проверка проставил ли текущий пользователь оценки для текущего матча
 */
function isUserPass($matchId, $userId)
{
    global $wpdb;
    return $wpdb->get_var( "SELECT COUNT(*) FROM wp_stat_points WHERE match_id = $matchId AND master_id = $userId" );
}

/**
 * @return mixed
 * получение ID категории Товарищеские
 */
function getFriendlyId()
{
    $term = get_term_by('slug', 'friendly', 'categories');
    return $term->term_id;
}

/**
 * @param $matchId
 * @return mixed
 * проверка, находиться ли матч в категории Товарищеские
 */
function isFriendly($matchId)
{
    global $wpdb;
    $friendlyId = getFriendlyId();
    return $wpdb->get_var( "SELECT COUNT(*) FROM wp_term_relationships WHERE object_id = $matchId AND term_taxonomy_id = $friendlyId" );
}

function isInCup($matchId, $cupId)
{
    global $wpdb;
    return $wpdb->get_var( "SELECT COUNT(*) FROM wp_term_relationships WHERE object_id = $matchId AND term_taxonomy_id = $cupId" );
}