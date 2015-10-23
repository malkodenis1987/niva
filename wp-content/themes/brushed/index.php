<?php get_header(); ?>

<!-- История команды -->
<div id="history" class="page">
    <div class="container">
        <!-- Title Page -->
        <div class="row">
            <div class="span12">
                <div class="title-page">
                    <h2 class="title">История</h2>
                    <h3 class="title-description">Сложный путь нашей команды</h3>
                </div>
            </div>
        </div>
        <!-- End Title Page -->
        <!-- History Page -->
        <div class="row">
            <div class="span12">
                <div class="entry">
                    <?php
                    $args = array(
                        'post_type' => 'page',
                        'include' => get_ID_by_slug('history')
                    );
                    $page = get_pages($args);
                    ?>
                    <?php if ($page) { ?>
                        <?php echo apply_filters('the_content', $page[0]->post_content) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Матчи -->
<div id="work" class="page-alternate">
	<div class="container">
    	<!-- Title Page -->
        <div class="row">
            <div class="span12">
                <div class="title-page">
                    <h2 class="title">
                        <?php
	                    if (vp_option('vpt_option.portfolio_h2'))
                        {
		                    echo vp_option('vpt_option.portfolio_h2');
	                    }else
	                    {
		                    echo "Матчи";
	                    }
	                    ?>
                    </h2>
                    <h3 class="title-description">
                        <?php
	                    if (vp_option('vpt_option.portfolio_h3'))
                        {
		                    echo vp_option('vpt_option.portfolio_h3');
	                    }
                        else
	                    {
		                    echo "Отчеты о матчах. Статистика. Обсуждение";
	                    }
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <!-- End Title Page -->
        
        <!-- Portfolio Projects -->
        <div class="row">
        	<div class="span3">
            	<!-- Filter -->
                <nav id="options" class="work-nav">
                    <ul id="filters" class="option-set" data-option-key="filter">
                    	<li class="type-work">
                            <?php
		                    if (vp_option('vpt_option.portfolio_work_type'))
                            {
			                    echo vp_option('vpt_option.portfolio_work_type');
		                    }
                            else
		                    {
			                    echo "Турниры";
		                    }
                            ?>
                        </li>
                        <li>
                            <a href="#filter" data-option-value="*" class="selected">
                                <?php
		                        if (vp_option('vpt_option.portfolio_all'))
                                {
			                        echo vp_option('vpt_option.portfolio_all');
		                        }
                                else
		                        {
			                        echo "Все матчи";
		                        }
                                ?>
                            </a>
                        </li>
                        <?php
                        $args = array (
                            'post_type' => 'portfolio', //your custom post type
                            'orderby' => 'name',
                            'exclude' => '1',
                            'order' => 'ASC',
                            'taxonomy' => 'categories',
                            'hide_empty' => 0 //shows empty categories
                        );
                        $categories = get_categories( $args );
                        ?>
                        <?php foreach ($categories as $category) { ?>
                            <li><a href="#filter" data-option-value=".<?php echo $category->slug; ?>"><?php echo $category->name ?></a></li>
                        <?php } ?>
                    </ul>
                    <ul>
                        <li class="type-work">Статистика</li>
                        <li><a title="Статистика команды" class="hover-wrap fancybox" href="#stat-team">Команды</a></li>
                        <li><a title="Статистика игроков" class="hover-wrap fancybox" href="#stat-player">Игроки</a></li>
                    </ul>
                </nav>
                <!-- End Filter -->
            </div>
            <div class="span9">
            	<div class="row">
                	<section id="projects">
                        <?php
                        if (vp_option('vpt_option.items_per_page'))
                        {
	                        $per_page =  vp_option('vpt_option.items_per_page');
                        }
                        else
                        {
	                        $per_page = 3000;
                        }
                        if (vp_option('vpt_option.portfolio_order'))
                        {
	                        $orderby =  vp_option('vpt_option.portfolio_order');
                        }
                        else
                        {
	                        $orderby = 'post_date';
                        }
                        if (vp_option('vpt_option.portfolio_type_order'))
                        {
	                        $order =  vp_option('vpt_option.portfolio_type_order');
                        }
                        else
                        {
	                        $order = 'DESC';
                        }
                        $args = array(
                            'posts_per_page'   => $per_page,
                            'offset'           => 0,
                            'category'         => '',
                            'orderby'          => $orderby,
                            'order'            => $order,
                            'include'          => '',
                            'exclude'          => '',
                            'meta_key'         => '',
                            'meta_value'       => '',
                            'post_type'        => 'portfolio',
                            'post_mime_type'   => '',
                            'post_parent'      => '',
                            'post_status'      => 'publish',
                            'suppress_filters' => true );
                        $posts = get_posts($args);
                        /* User configuration */
                        $currentUser = wp_get_current_user();
                        $currentAccountId = getAccountId($currentUser->ID);
                        $userInfo = get_userdata($currentUser->ID);
                        if ($userInfo) {
                            $userRole = implode(', ', $userInfo->roles);
                        }
                        ?>
                    	<ul id="thumbs">
                            <?php foreach($posts as $post) { ?>
                                <?php
                                $meta_values = get_post_meta( $post->ID, 'portfolio_metaboxes',true);
                                //Returns Array of Term Names for "my_term"
                                $term_list = wp_get_post_terms($post->ID, 'categories', array("fields" => "slugs"));
                                $video = false;
                                for ($i=0;$i<count($term_list);$i++)
                                {
                                    if (($term_list[$i] == 'video'))
                                    {
                                        $video = true;
                                        break;
                                    }
                                }
                                $group = 'gallery';
                                $img_alt = $meta_values['portfolio_textarea'];
	                            if ($meta_values['portfolio_upload'] != '')
	                            {
		                            $img_src = $meta_values['portfolio_upload'];
		                            $big_src = $meta_values['portfolio_upload'];
	                            }
                                else
                                {
		                            $img_src = get_template_directory_uri().'/img/photo.jpg';
		                            $big_src = get_template_directory_uri().'/img/photo.jpg';
	                            }
                                $fancybox = '';
	                            $span_height = '182px';
                                if ($video)
                                {
                                    $group = 'video';
                                    $img_alt = 'Video';
                                    $img_src = get_template_directory_uri().'/img/video.png';
                                    $big_src = $meta_values['portfolio_url'];
	                                $span_height = '182px';
	                                if (strrpos($big_src, 'youtube'))
	                                {
		                               $equal = strpos($big_src,'=');
		                                $id = substr($big_src, $equal+1);
		                                $img_url_part1 = 'http://img.youtube.com/vi/';
		                                $img_url_part2 = $id.'/0.jpg';
		                                $img_src = $img_url_part1.$img_url_part2;
	                                }
	                                if (strpos($big_src,'vimeo'))
	                                {
		                                $id = substr($big_src,17);
		                                $hash = wp_remote_get("http://vimeo.com/api/v2/video/$id.php");
		                                $hash = unserialize($hash['body']);
		                                $img_src = $hash[0]['thumbnail_large'];
		                                $width = '';
	                                }
                                    $fancybox = '-media';
                                }
                                ?>
                                <!-- Item Project and Filter Name -->
                                <li class="item-thumbs span3 <?php for($i=0;$i<count($term_list);$i++){echo $term_list[$i]." ";} ?>">
                                    <!-- Fancybox - Gallery Enabled - Title - Full Image -->
                                    <a class="hover-wrap fancybox<?php echo $fancybox; ?>" data-fancybox-group="<?php echo $group ?>" title="<?php echo $post->post_title; ?>" href="#match-<?php echo $post->ID ?>">
                                        <span class="overlay-img"></span>
                                        <span class="overlay-img-thumb font-icon-plus"></span>
                                    </a>
                                    <!-- Thumb Image and Description -->
                                    <img  src="<?php echo $img_src; ?>"  alt="<?php echo $img_alt; ?>">
                                    <span class="title"><?php echo $post->post_title ?></span>

                                    <!-- СТАТИСТИКА МАТЧА (Попап) -->
                                    <?php
                                    $playerNum   = 1;
                                    $score       = getScore($post->ID);
                                    $nivaId      = getTeamId('Нива');
                                    $rivalId     = ($score[0]->home_id == getTeamId('Нива')) ? $score[0]->visitor_id : $score[0]->home_id;
                                    $mainPlayers = getSostav($post->ID, 1);
                                    $subPlayers  = getSostav($post->ID, 0);
                                    $halfTime = 35;
                                    /* Голы Нивы (забитые, атоголы, незабитые пенальти) */
                                    $goalsNiva = getGoals($post->ID, $nivaId);
                                    $goalsOwnNiva = getGoalsOwn($post->ID, $nivaId);
                                    $goalsNoPenNiva = getNoPen($post->ID, $nivaId);
                                    /* Желтые карточки */
                                    $yellowNiva = getYellow($post->ID, $nivaId);
                                    /* Желтые карточки */
                                    $redNiva = getRed($post->ID, $nivaId);
                                    /* Желтые карточки */
                                    $crashNiva = getCrash($post->ID, $nivaId);
                                    /* Замены */
                                    $subsNiva = getSubs($post->ID);

                                    /* Голы Соперника (забитые, атоголы, незабитые пенальти) */
                                    $goalsRival = getGoals($post->ID, $rivalId);
                                    $goalsOwnRival = getGoalsOwn($post->ID, $rivalId);
                                    $goalsNoPenRival = getNoPen($post->ID, $rivalId);
                                    /* Желтые карточки */
                                    $yellowRival = getYellow($post->ID, $rivalId);
                                    /* Желтые карточки */
                                    $redRival = getRed($post->ID, $rivalId);
                                    /* Желтые карточки */
                                    $crashRival = getCrash($post->ID, $rivalId);
                                    $isPass = isUserPass($post->ID, $currentUser->ID);
                                    ?>
                                    <div class="match-popup" id="match-<?php echo $post->ID ?>">
                                        <div class="wrap">
                                            <h4>Статистика матча</h4>
                                            <!-- Детали -->
                                            <div class="details">
                                                <p>
                                                    <span><strong>дата: </strong><?php echo date('d.m.Y', strtotime(get_post_meta($post->ID, 'date', true))) ?></span>
                                                    <span><strong>время: </strong><?php echo get_post_meta($post->ID, 'time', true) ?></span>
                                                    <span><strong>место: </strong><?php echo get_post_meta($post->ID, 'place', true) ?> </span>
                                                </p>
                                            </div>
                                            <!-- Хронограф -->
                                            <div class="graph clearfix">
                                                <div class="clock end">&nbsp;</div>
                                                <div class="clock start">&nbsp;</div>
                                                <div class="full-time clearfix">
                                                    <div class="half">&nbsp;</div>
                                                    <!-- Первый тайм -->
                                                    <div class="time first">
                                                        <div class="inner">
                                                            <div class="dots">&nbsp;</div>
                                                            <!-- Нива -->
                                                            <div class="line home">
                                                                <?php if ($goalsNiva) { ?>
                                                                    <?php foreach($goalsNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat goal" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($goalsOwnNiva) { ?>
                                                                    <?php foreach($goalsOwnNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat goal own" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($goalsNoPenNiva) { ?>
                                                                    <?php foreach($goalsNoPenNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat goal pen-no" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($yellowNiva) { ?>
                                                                    <?php foreach($yellowNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat yc" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($redNiva) { ?>
                                                                    <?php foreach($redNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat rc" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($crashNiva) { ?>
                                                                    <?php foreach($crashNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat crash" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($subsNiva) { ?>
                                                                    <?php foreach($subsNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat sub" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player1_id']) ?> - <?php echo getPlayerName($item['player2_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                            <!-- Соперник -->
                                                            <div class="line visitor">
                                                                <?php if ($goalsRival) { ?>
                                                                    <?php foreach($goalsRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat goal" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($goalsOwnRival) { ?>
                                                                    <?php foreach($goalsOwnRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat goal own" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($goalsNoPenRival) { ?>
                                                                    <?php foreach($goalsNoPenRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat goal pen-no" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($yellowRival) { ?>
                                                                    <?php foreach($yellowRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat yc" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($redRival) { ?>
                                                                    <?php foreach($redRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat rc" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($crashRival) { ?>
                                                                    <?php foreach($crashRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] <= $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent($item['min'], $halfTime) ?>%;" class="stat crash" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Второй тайм -->
                                                    <div class="time second">
                                                        <div class="inner">
                                                            <div class="dots">&nbsp;</div>
                                                            <!-- Нива -->
                                                            <div class="line home">
                                                                <?php if ($goalsNiva) { ?>
                                                                    <?php foreach($goalsNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat goal" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($goalsOwnNiva) { ?>
                                                                    <?php foreach($goalsOwnNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat goal own" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($goalsNoPenNiva) { ?>
                                                                    <?php foreach($goalsNoPenNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat goal pen-no" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($yellowNiva) { ?>
                                                                    <?php foreach($yellowNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat yc" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($redNiva) { ?>
                                                                    <?php foreach($redNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat rc" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($crashNiva) { ?>
                                                                    <?php foreach($crashNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat crash" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($subsNiva) { ?>
                                                                    <?php foreach($subsNiva as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat sub" title="<?php echo $item['min'] ?>' <?php echo getPlayerName($item['player1_id']) ?> - <?php echo getPlayerName($item['player2_id']) ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                            <!-- Соперник -->
                                                            <div class="line visitor">
                                                                <?php if ($goalsRival) { ?>
                                                                    <?php foreach($goalsRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat goal" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($goalsOwnRival) { ?>
                                                                    <?php foreach($goalsOwnRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat goal own" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($goalsNoPenRival) { ?>
                                                                    <?php foreach($goalsNoPenRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat goal pen-no" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($yellowRival) { ?>
                                                                    <?php foreach($yellowRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat yc" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($redRival) { ?>
                                                                    <?php foreach($redRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat rc" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if ($crashRival) { ?>
                                                                    <?php foreach($crashRival as $item) { ?>
                                                                        <?php if ((int)$item['min'] > $halfTime) { ?>
                                                                            <span style="left: <?php setStatIndent((int)$item['min']-$halfTime, $halfTime) ?>%;" class="stat crash" title="<?php echo $item['min'] ?>' <?php echo $item['player_name'] ?>"><b>&nbsp;</b><sup><?php echo $item['min'] ?>'</sup></span>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Состав -->
                                            <div class="sostav">
                                                <form action="<?php echo get_bloginfo('template_url'); ?>/includes/handlers/set-statistic.php" method="post" class="ajax">
                                                    <input type="hidden" name="match_id" value="<?php echo $post->ID; ?>" />
                                                    <input type="hidden" name="master_id" value="<?php echo $currentUser->ID; ?>" />
                                                    <input type="hidden" name="master_role" value="<?php echo $userRole; ?>" />
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th colspan="2">Игрок</th>
                                                                <th>Голы</th>
                                                                <th>ЖК</th>
                                                                <th>КК</th>
                                                                <th>Замены</th>
                                                                <th>Травмы</th>
                                                                <th class="align-center">Оценка</th>
                                                                <th class="align-center">Оценка тренера</th>
                                                                <?php if (is_user_logged_in() && !$isPass) { ?>
                                                                    <th class="align-center">Рейтинг</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="10"><h6>Основной состав</h6></td>
                                                            </tr>
                                                            <!-- Основной состав -->
                                                            <?php if ($mainPlayers) { ?>
                                                                <?php foreach ($mainPlayers as $player) { ?>
                                                                    <tr <?php if ($currentAccountId == $player) echo 'class="active"'; ?>>
                                                                        <!-- Номер -->
                                                                        <td><?php echo $playerNum; ?></td>

                                                                        <!-- Фамилия -->
                                                                        <td><?php echo getPlayerName($player); ?></td>

                                                                        <!-- Голы (забитые, автоголы, не забитые пенальти) -->
                                                                        <td>
                                                                            <!-- Забитые голы -->
                                                                            <?php if ($goalsNiva) { ?>
                                                                                <?php foreach($goalsNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat goal" title="Забитый гол">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>' <?php if ($item['is_pen'] == 1) echo '(п)' ?></sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                            <!-- Автоголы -->
                                                                            <?php if ($goalsOwnNiva) { ?>
                                                                                <?php foreach($goalsOwnNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat goal own" title="Автогол">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                            <!-- Незабитые пенальти -->
                                                                            <?php if ($goalsNoPenNiva) { ?>
                                                                                <?php foreach($goalsNoPenNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat goal pen-no" title="Незабитый пенальти">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Желтые карточки -->
                                                                        <td>
                                                                            <?php if ($yellowNiva) { ?>
                                                                                <?php foreach($yellowNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat yc" title="Желтая карточка">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Красные карточки -->
                                                                        <td>
                                                                            <?php if ($redNiva) { ?>
                                                                                <?php foreach($redNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat rc" title="Красная карточка">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Замены -->
                                                                        <td>
                                                                            <?php if ($subsNiva) { ?>
                                                                                <?php foreach($subsNiva as $item) { ?>
                                                                                    <?php if ($item['player1_id'] == $player || $item['player2_id'] == $player) { ?>
                                                                                        <span class="stat sub" title="Замена">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Травмы -->
                                                                        <td>
                                                                            <?php if ($crashNiva) { ?>
                                                                                <?php foreach($crashNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat crash" title="Травма">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Оценка -->
                                                                        <td class="align-center">0</td>

                                                                        <!-- Оценка тренера -->
                                                                        <td class="align-center">0</td>

                                                                        <!-- Рейтинг -->
                                                                        <?php if (is_user_logged_in() && !$isPass) { ?>
                                                                            <td class="align-center">
                                                                                <?php if ($currentAccountId != $player) { ?>
                                                                                    <input type="hidden" name="rait[<?php echo $player; ?>]" value="0"/>
                                                                                    <div class="counter">
                                                                                        <div class="val">0</div>
                                                                                        <a class="up" href="javascript:;">+</a>
                                                                                        <a class="down" href="javascript:;">-</a>
                                                                                    </div>
                                                                                <?php } else { ?>
                                                                                    ***
                                                                                <?php } ?>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                    <?php $playerNum++; ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <tr>
                                                                <td colspan="10"><h6>Выходили на замену</h6></td>
                                                            </tr>
                                                            <!-- Выходили на замену -->
                                                            <?php if ($subPlayers) { ?>
                                                                <?php foreach ($subPlayers as $player) { ?>
                                                                    <tr <?php if ($currentAccountId == $player) echo 'class="active"'; ?>>
                                                                        <!-- Номер -->
                                                                        <td><?php echo $playerNum; ?></td>

                                                                        <!-- Фамилия -->
                                                                        <td><?php echo getPlayerName($player); ?></td>

                                                                        <!-- Голы (забитые, автоголы, не забитые пенальти) -->
                                                                        <td>
                                                                            <!-- Забитые голы -->
                                                                            <?php if ($goalsNiva) { ?>
                                                                                <?php foreach($goalsNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat goal" title="Забитый гол">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>' <?php if ($item['is_pen'] == 1) echo '(п)' ?></sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                            <!-- Автоголы -->
                                                                            <?php if ($goalsOwnNiva) { ?>
                                                                                <?php foreach($goalsOwnNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat goal own" title="Автогол">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                            <!-- Незабитые пенальти -->
                                                                            <?php if ($goalsNoPenNiva) { ?>
                                                                                <?php foreach($goalsNoPenNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat goal pen-no" title="Незабитый пенальти">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Желтые карточки -->
                                                                        <td>
                                                                            <?php if ($yellowNiva) { ?>
                                                                                <?php foreach($yellowNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat yc" title="Желтая карточка">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Красные карточки -->
                                                                        <td>
                                                                            <?php if ($redNiva) { ?>
                                                                                <?php foreach($redNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat rc" title="Красная карточка">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Замены -->
                                                                        <td>
                                                                            <?php if ($subsNiva) { ?>
                                                                                <?php foreach($subsNiva as $item) { ?>
                                                                                    <?php if ($item['player1_id'] == $player || $item['player2_id'] == $player) { ?>
                                                                                        <span class="stat sub" title="Замена">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Травмы -->
                                                                        <td>
                                                                            <?php if ($crashNiva) { ?>
                                                                                <?php foreach($crashNiva as $item) { ?>
                                                                                    <?php if ($item['player_id'] == $player) { ?>
                                                                                        <span class="stat crash" title="Травма">
                                                                                            <b>&nbsp;</b>
                                                                                            <sup><?php echo $item['min'] ?>'</sup>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </td>

                                                                        <!-- Оценка -->
                                                                        <td class="align-center">0</td>

                                                                        <!-- Оценка тренера -->
                                                                        <td class="align-center">0</td>

                                                                        <!-- Рейтинг -->
                                                                        <?php if (is_user_logged_in() && !$isPass) { ?>
                                                                            <td class="align-center">
                                                                                <?php if ($currentAccountId != $player) { ?>
                                                                                    <input type="hidden" name="rait[<?php echo $player; ?>]" value="0"/>
                                                                                    <div class="counter">
                                                                                        <div class="val">0</div>
                                                                                        <a class="up" href="javascript:;">+</a>
                                                                                        <a class="down" href="javascript:;">-</a>
                                                                                    </div>
                                                                                <?php } else { ?>
                                                                                    ***
                                                                                <?php } ?>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                    <?php $playerNum++; ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="notes clearfix">
                                                        <?php if (is_user_logged_in() && !$isPass) { ?>
                                                            <div class="form-content">
                                                                <button class="set-points" type="submit">поставить оценки</button>
                                                            </div>
                                                        <?php } ?>
                                                        <p><small>* - только зарегистрированные пользователи могут ставить оценки. Минимальная оценка - 1, максимальная оценка - 10. Если игрок не заработал на оценку - 0.</small></p>
                                                        <p><small>** - себе Вы не можете поставить оценку. Вы выделены фиолетовым цветом.</small></p>
                                                    </div>
                                                    <span class="succes-message">Оценки успешно проставлены</span>
                                                    <div class="message"></div>
                                                    <?php if (is_user_logged_in() && $isPass) { ?>
                                                        <div class="message success hard">Вы уже проставили оценки для этого матча</div>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                        	<!-- End Item Project -->
                            <?php } ?>
                        </ul>
                    </section>
            	</div>
            </div>
        </div>
        <!-- End Portfolio Projects -->
    </div>
</div>
<!-- End Our Work Section -->

<!-- Команда -->
<div id="about" class="page">
    <div class="container">
        <!-- Title Page -->
        <div class="row">
            <div class="span12">
                <div class="title-page">
                    <h2 class="title">
                        <?php
                        if (vp_option('vpt_option.team_h2'))
                        {
                            echo vp_option('vpt_option.team_h2');
                        }
                        else
                        {
                            echo "Команда";
                        }
                        ?>
                    </h2>
                    <h3 class="title-description">
                        <?php
                        if (vp_option('vpt_option.team_h3'))
                        {
                            echo vp_option('vpt_option.team_h3');
                        }
                        else
                        {
                            echo "Состав нашей команды";
                        }
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <!-- End Title Page -->
        <?php
        if (vp_option('vpt_option.team_items_per_page'))
        {
            $member_per_page =  vp_option('vpt_option.team_items_per_page');
        }
        else
        {
            $member_per_page = 9;
        }
        if (vp_option('vpt_option.team_order'))
        {
            $member_orderby =  vp_option('vpt_option.team_order');
        }
        else
        {
            $member_orderby = 'post_date';
        }
        if (vp_option('vpt_option.team_type_order'))
        {
            $member_order =  vp_option('vpt_option.team_type_order');
        }
        else
        {
            $member_order = 'ASC';
        }
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'category'         => '',
            'orderby'          => $member_orderby,
            'order'            => $member_order,
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'team',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'post_status'      => 'publish',
            'suppress_filters' => true );
        $posts = get_posts($args);
        ?>
        <!-- People -->
        <div class="row">
            <?php $divider = 1; ?>
            <?php foreach($posts as $post) { ?>
                <?php
                $meta_values = get_post_meta($post->ID, 'team_metaboxes', true);
                //Returns Array of Term Names for "my_term"
                $term_list = wp_get_post_terms($post->ID, 'functions', array("fields" => "names"));
                $vk = $meta_values['member_vk_url'];
                if ($vk)
                {
                    $vk = '<li><a target="_blank" href="'.$meta_values['member_vk_url'].'"><i class="font-icon-social-vk"></i></a></li>';
                }
                $facebook = $meta_values['member_facebook_url'];
                if ($facebook)
                {
                    $facebook = '<li><a target="_blank" href="'.$meta_values['member_facebook_url'].'"><i class="font-icon-social-facebook"></i></a></li>';
                }
                $twitter = $meta_values['member_twitter_url'];
                if ($twitter)
                {
                    $twitter = '<li><a target="_blank" href="'.$meta_values['member_twitter_url'].'"><i class="font-icon-social-twitter"></i></a></li>';
                }
                $linkedin = $meta_values['member_linkedin'];
                if ($linkedin)
                {
                    $linkedin = '<li><a target="_blank" href="'.$meta_values['member_linkedin'].'"><i class="font-icon-social-linkedin"></i></a></li>';
                }
                $googleplus = $meta_values['member_googleplus'];
                if ($googleplus)
                {
                    $googleplus = '<li><a target="_blank" href="'.$meta_values['member_googleplus'].'"><i class="font-icon-social-google-plus"></i></a></li>';
                }
                $vimeo = $meta_values['member_vimeo'];
                if ($vimeo)
                {
                    $vimeo = '<li><a target="_blank" href="'.$meta_values['member_vimeo'].'"><i class="font-icon-social-vimeo"></i></a></li>';
                }
                ?>
                <!-- Start Profile -->
                <div class="span4 profile">
                    <div class="image-wrap">
                        <div class="hover-wrap">
                            <span class="overlay-img"></span>
                            <span class="overlay-text-thumb"><?php echo $term_list[0]; ?></span>
                        </div>
                        <?php
                        $args = array(
                            'post_type' => 'attachment',
                            'numberposts' => 1,
                            'post_status' => null,
                            'post_parent' => $post->ID
                        );
                        $attachments = get_posts($args);
                        ?>
                        <?php if ( $attachments ) { ?>
                            <?php echo wp_get_attachment_image( $attachment->ID, 'team-thumb' ); ?>
                        <?php } ?>
                        <img src="<?php echo $meta_values['team_upload']; ?>" alt="<?php echo $meta_values['member_name']; ?>">
                    </div>
                    <h3 class="profile-name"><?php echo $meta_values['member_name']; ?></h3>
                    <p class="profile-description"><?php echo $meta_values['member_description']; ?></p>
                    <div class="social">
                        <ul class="social-icons">
                            <?php echo $vk.$facebook.$twitter.$linkedin.$googleplus.$vimeo; ?>
                        </ul>
                    </div>
                </div>
                <?php if ($divider === 3) { echo '<span class="span12">&nbsp;</span>'; $divider = 0; } ?>
                <?php $divider++ ?>
            <!-- End Profile -->
            <?php } ?>
        </div>
        <!-- End People -->
    </div>
</div>
<!-- End About Section -->

<!-- Календарь -->
<div id="calendar" class="page-alternate">
    <div class="container">
        <!-- Title Page -->
        <div class="row">
            <div class="span12">
                <div class="title-page">
                    <h2 class="title">Календарь</h2>
                    <h3 class="title-description">Расписания матчей и событий</h3>
                </div>
            </div>
        </div>
        <!-- End Title Page -->
        <!-- History Page -->
        <div class="row">
            <div class="span12">
                <div class="entry">
                    <?php
                    $args = array(
                        'post_type' => 'page',
                        'include' => get_ID_by_slug('calendar')
                    );
                    $page = get_pages($args);
                    ?>
                    <?php if ($page) { ?>
                        <?php echo apply_filters('the_content', $page[0]->post_content) ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Контакты -->
<div id="contact" class="page">
    <div class="container">
        <!-- Title Page -->
        <div class="row">
            <div class="span12">
                <div class="title-page">
                    <h2 class="title">
                        <?php
                        if (vp_option('vpt_option.contact_h2'))
                        {
                            echo vp_option('vpt_option.contact_h2');
                        }
                        else
                        {
                            echo "Будь с нами на связи";
                        }
                        ?>
                    </h2>
                    <h3 class="title-description">
                        <?php
                        if (vp_option('vpt_option.contact_h3'))
                        {
                            echo vp_option('vpt_option.contact_h3');
                        }
                        else
                        {
                            echo "Не стесняйся! Отправляй нам вопросы на почту.";
                        }
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <!-- End Title Page -->
        <!-- Contact Form -->
        <div class="row" <?php post_class(); ?>>
            <div class="span9">
                <form id="contact-form" class="contact-form" action="#">
                    <p class="contact-name">
                        <input id="contact_name" type="text" placeholder="Ваше имя" value="" name="name" />
                    </p>
                    <p class="contact-email">
                        <input id="contact_email" type="text" placeholder="Email" value="" name="email" />
                    </p>
                    <p class="contact-message">
                        <textarea id="contact_message" placeholder="Ваше сообщение" name="message" rows="15" cols="40"></textarea>
                    </p>
                    <input type="hidden" id="url" value="<?php echo get_template_directory_uri();?>">
                    <input type="hidden" id="email" value="<?php
                    if (vp_option('vpt_option.email_submit'))
                    {
                        echo vp_option('vpt_option.email_submit');
                    }
                    else
                    {
                        echo "email@domain.com";
                    }?>">
                    <input type="hidden" id="subject" value="<?php
                    if (vp_option('vpt_option.subject')){
                        echo vp_option('vpt_option.subject');
                    }else
                    {
                        echo "From my Site";
                    }?>">
                    <p class="contact-submit">
                        <a id="contact-submit" class="submit"  href="#">Отправить сообщение</a>
                    </p>
                    <div id="response"></div>
                </form>
            </div>
            <div class="span3">
                <div class="contact-details">
                    <h3>
                        <?php
                        if (vp_option('vpt_option.contact_details'))
                        {
                            echo vp_option('vpt_option.contact_details');
                        }
                        else
                        {
                            echo "Контактная информация";
                        }
                        ?>
                    </h3>
                    <ul>
                        <li>
                            <?php
                            if (vp_option('vpt_option.email'))
                            {
                                echo vp_option('vpt_option.email');
                            }
                            else
                            {
                                echo "malko.denis1098@gmail.com";
                            }
                            ?>
                        </li>
                        <li>
                            <?php
                            if (vp_option('vpt_option.telephone'))
                            {
                                echo vp_option('vpt_option.telephone');
                            }
                            else
                            {
                                echo "(093) 765-0767";
                            }
                            ?>
                        </li>
                        <li>
                            <?php
                            if (vp_option('vpt_option.address'))
                            {
                                echo vp_option('vpt_option.address');
                            }
                            else
                            {
                                echo "ФК Нива Чернигов
                            <br>
                            ул. Рокосовского 87/90
                            <br>
                            14000";
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Contact Form -->
    </div>
</div>
<!-- End Contact Section -->

<!-- Социальные иконки -->
<div id="social-area" class="page">
    <div class="container">
        <div class="row">
            <div class="span12">
                <nav id="social">
                    <ul>
                        <?php if (vp_option('vpt_option.twitter')){echo "<li><a href='".vp_option('vpt_option.twitter')."' title='Follow Me on Twitter' target='_blank'><span class='font-icon-social-twitter'></span></a></li>";}?>
                        <?php if (vp_option('vpt_option.dribbble')){echo "<li><a href='".vp_option('vpt_option.dribbble')."' title='Follow Me on Dribbble' target='_blank'><span class='font-icon-social-dribbble'></span></a></li>";}?>
                        <?php if (vp_option('vpt_option.forrst')){echo "<li><a href='".vp_option('vpt_option.forrst')."' title='Follow Me on Forrst' target='_blank'><span class='font-icon-social-forrst'></span></a></li>";}?>
                        <?php if (vp_option('vpt_option.behance')){echo "<li><a href='".vp_option('vpt_option.behance')."' title='Follow Me on Behance' target='_blank'><span class='font-icon-social-behance'></span></a></li>";}?>
                        <?php if (vp_option('vpt_option.facebook')){echo "<li><a href='".vp_option('vpt_option.facebook')."' title='Follow Me on Facebook' target='_blank'><span class='font-icon-social-facebook'></span></a></li>";}?>
                        <?php if (vp_option('vpt_option.google_plus')){echo "<li><a href='".vp_option('vpt_option.google_plus')."' title='Follow Me on Google Plus' target='_blank'><span class='font-icon-social-google-plus'></span></a></li>";}?>
                        <?php if (vp_option('vpt_option.linkedin')){echo "<li><a href='".vp_option('vpt_option.linkedin')."' title='Follow Me on LinkedIn' target='_blank'><span class='font-icon-social-linkedin'></span></a></li>";}?>
                        <?php if (vp_option('vpt_option.themeforest')){echo "<li><a href='".vp_option('vpt_option.themeforest')."' title='Follow Me on ThemeForest' target='_blank'><span class='font-icon-social-envato'></span></a></li>";}?>
                        <?php if (vp_option('vpt_option.zerply')){echo "<li><a href='".vp_option('vpt_option.zerply')."' title='Follow Me on Zerply' target='_blank'><span class='font-icon-social-zerply'></span></a></li>";}?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Статистика команды -->
<div id="stat-team" class="popup statistic">
    <div class="inner">
        <?php $categories = get_terms( 'categories', 'orderby=date&hide_empty=0' ); ?>
        <ul class="tabs">
            <li class="selected"><a href="#scored">Забитые голы</a></li>
            <li><a href="#missed">Пропущенные голы</a></li>
            <li><a href="#wins">Результаты игр</a></li>
        </ul>
        <div class="tab active" id="scored">
            <form action="#" method="post" class="filters clearfix">
                <h4>Фильтры</h4>
                <p>Вы можете выбрать конкретный турнир, включить или исключить товарищеские матчи в статистике, применив фильтр.</p>
                <input type="hidden" name="action" value="scored_goals"/>
                <div class="column first">
                    <p>
                        <input type="radio" name="scored_type" value="0" id="scored_all" checked=""/>
                        <label for="scored_all">Все матчи</label>
                    </p>
                    <p>
                        <input type="checkbox" name="scored_friendly" id="scored_friendly" />
                        <label for="scored_friendly">Товарищеские</label>
                    </p>
                </div>
                <?php if ($categories) { ?>
                <div class="column">
                    <p>
                        <input type="radio" name="scored_type" value="1" id="scored_by_cup"/>
                        <label for="scored_by_cup">Выбрать турнир</label>
                    </p>
                    <p>
                        <select name="scored_cup" id="scored_cup">
                            <?php foreach($categories as $category) { ?>
                                <option value="<?php echo $category->term_id ?>"><?php echo $category->name ?></option>
                            <?php } ?>
                        </select>
                    </p>
                </div>
                <?php } ?>
                <div class="column">
                    <button type="submit">показать</button>
                </div>
            </form>
        </div>
        <div class="tab" id="missed">
            <form action="#" method="post" class="filters clearfix">
                <h4>Фильтры</h4>
                <p>Вы можете выбрать конкретный турнир, включить или исключить товарищеские матчи в статистике, применив фильтр.</p>
                <input type="hidden" name="action" value="missed_goals"/>
                <div class="column first">
                    <p>
                        <input type="radio" name="scored_type" value="0" id="missed_all" checked=""/>
                        <label for="missed_all">Все матчи</label>
                    </p>
                    <p>
                        <input type="checkbox" name="scored_friendly" id="missed_friendly2" />
                        <label for="missed_friendly2">Товарищеские</label>
                    </p>
                </div>
                <?php if ($categories) { ?>
                    <div class="column">
                        <p>
                            <input type="radio" name="scored_type" value="1" id="scored_by_cup2"/>
                            <label for="scored_by_cup2">Выбрать турнир</label>
                        </p>
                        <p>
                            <select name="scored_cup" id="scored_cup2">
                                <?php foreach($categories as $category) { ?>
                                    <option value="<?php echo $category->term_id ?>"><?php echo $category->name ?></option>
                                <?php } ?>
                            </select>
                        </p>
                    </div>
                <?php } ?>
                <div class="column">
                    <button type="submit">показать</button>
                </div>
            </form>
        </div>
        <div class="tab" id="wins">
            <form action="#" method="post" class="filters clearfix">
                <h4>Фильтры</h4>
                <p>Вы можете выбрать конкретный турнир, включить или исключить товарищеские матчи в статистике, применив фильтр.</p>
                <input type="hidden" name="action" value="wins"/>
                <div class="column first">
                    <p>
                        <input type="radio" name="scored_type" value="0" id="wins_all" checked=""/>
                        <label for="wins_all">Все матчи</label>
                    </p>
                    <p>
                        <input type="checkbox" name="scored_friendly" id="missed_friendly3" />
                        <label for="missed_friendly3">Товарищеские</label>
                    </p>
                </div>
                <?php if ($categories) { ?>
                    <div class="column">
                        <p>
                            <input type="radio" name="scored_type" value="1" id="scored_by_cup3"/>
                            <label for="scored_by_cup3">Выбрать турнир</label>
                        </p>
                        <p>
                            <select name="scored_cup" id="scored_cup3">
                                <?php foreach($categories as $category) { ?>
                                    <option value="<?php echo $category->term_id ?>"><?php echo $category->name ?></option>
                                <?php } ?>
                            </select>
                        </p>
                    </div>
                <?php } ?>
                <div class="column">
                    <button type="submit">показать</button>
                </div>
            </form>
        </div>
        <div id="graph-container">
            <?php //include_once(get_template_directory() . '/includes/statistic/graph.php') ?>
            <div class="canvas-set active" id="lines">
                <canvas id="graph" height="200" width="600"></canvas>
                <p>График отображает количество забитых/пропущеных голов поминутно. По-вертикали: количество голов. По-горизонтали: минуты</p>
            </div>
            <div class="canvas-set clearfix" id="circles">
                <div class="clearfix">
                    <div class="column">
                        <canvas id="graphWA" height="200" width="200"></canvas>
                        <p>Дома/В гостях</p>
                    </div>
                    <div class="column">
                        <canvas id="graphWH" height="200" width="200"></canvas>
                        <p>Дома</p>
                    </div>
                    <div class="column">
                        <canvas id="graphWV" height="200" width="200"></canvas>
                        <p>В гостях</p>
                    </div>
                </div>
                <br/><br/>
                <p>Графики отображают соотношения побед, ничьих и поражений во всех матчах, в домашних и гостевых матчах</p>
            </div>
        </div>
    </div>
    <script>
        /* Статистика */
        jQuery(window).load(function(){
            /* инициализация опций */
            var options = {
                action: "scored_goals",
                scored_type: 0,
                scored_friendly: 0,
                scored_cup: 0
            };
            var data = getStatistic(options).split(',');
            drawGraph(data);
            /* нажатие на табы */
            jQuery('.popup .tabs A').click(function(){
                var id = jQuery(this).attr('href');
                var _this = jQuery(this);
                jQuery('.popup .tabs').find('.selected').removeClass('selected');
                jQuery('.tab:visible').fadeOut(function(){
                    jQuery(_this).parent('LI').addClass('selected')
                    jQuery(id).fadeIn();
                    /* инициализация опций */
                    var action = jQuery(id).find('INPUT[name=action]').val();
                    var isFriendly = jQuery(id).find('INPUT[name=scored_friendly]').is(':checked') ? 1 : 0;
                    var scoredType = jQuery(id).find('INPUT[name=scored_type]:checked').val();
                    var scoredCup = jQuery(id).find('SELECT[name=scored_cup]').val();
                    var options = {
                        action: action,
                        scored_type: scoredType,
                        scored_friendly: isFriendly,
                        scored_cup: scoredCup
                    };
                    /* если круговые графики побед */
                    if (action == 'wins') {
                        var data = getStatistic(options);
                        jQuery('#lines').removeClass('active');
                        jQuery('#circles').addClass('active');
                        drawCircleGraph(data);
                    /* графики зфабитых и пропущеных голов */
                    } else {
                        var data = getStatistic(options).split(',');
                        jQuery('#circles').removeClass('active');
                        jQuery('#lines').addClass('active');
                        drawGraph(data);
                    }
                });
            });

            /* нажатие на форме фильтров */
            jQuery('FORM.filters').submit(function(){
                /* инициализация опций */
                var action = jQuery(this).find('INPUT[name=action]').val();
                var isFriendly = jQuery(this).find('INPUT[name=scored_friendly]').is(':checked') ? 1 : 0;
                var scoredType = jQuery(this).find('INPUT[name=scored_type]:checked').val();
                var scoredCup = jQuery(this).find('SELECT[name=scored_cup]').val();
                var options = {
                    action: action,
                    scored_type: scoredType,
                    scored_friendly: isFriendly,
                    scored_cup: scoredCup
                };
                if (action == 'wins') {
                    var data = getStatistic(options);
                    drawCircleGraph(data);
                } else {
                    var data = getStatistic(options).split(',');
                    drawGraph(data);
                }
                return false;
            });
        });

        /* выборка статистики */
        function getStatistic(options) {
            var result;
            jQuery.ajax({
                method: "POST",
                url: '<?php echo get_template_directory_uri() . '/includes/handlers/get-statistic.php' ?>',
                async: false,
                data: options
            })
            .done(function(data){
                result = data;
            });
            return result;
        }

        /* прорисовка графа */
        function drawGraph(goals){
            var minutes = [];
            for (var i = 1; i < 76; i++) {
                if (i%5 == 0) {
                    minutes.push(i);
                } else {
                    minutes.push('');
                }
            }
            var lineChartData = {
                labels : minutes,
                datasets : [
                    {
                        label: "My First dataset",
                        fillColor : "rgba(220,220,220,0.2)",
                        strokeColor : "rgba(220,220,220,1)",
                        pointColor : "rgba(220,220,220,1)",
                        pointStrokeColor : "#fff",
                        pointHighlightFill : "#fff",
                        pointHighlightStroke : "rgba(220,220,220,1)",
                        data : goals
                    }
                ]
            }
            var ctx = document.getElementById("graph").getContext("2d");
            window.myLine = new Chart(ctx).Line(lineChartData, {
                responsive: true
            });
        }

        /* прорисовка круговых диаграм */
        function drawCircleGraph(wins) {
            var colors = {
                'win'    : '#79DB56',
                'win_h'  : '#A1E887',
                'draw'   : '#FDB45C',
                'draw_h' : '#FFC870',
                'loss'   : '#F7464A',
                'loss_h' : '#FF5A5E'
            }
            if (window.myLineWA) {
                window.myLineWA.destroy();
            }
            if (window.myLineWH) {
                window.myLineWH.destroy();
            }
            if (window.myLineWV) {
                window.myLineWV.destroy();
            }
            var data = JSON.parse(wins);
            var dataAll = [
                {value: data.home.win + data.visitor.win, color: colors.win, highlight: colors.win_h, label: "Победы"},
                {value: data.home.loss + data.visitor.loss, color: colors.loss, highlight: colors.loss, label: "Поражения"},
                {value: data.home.draw + data.visitor.draw, color: colors.draw, highlight: colors.draw_h, label: "Ничьи"}
            ]
            var dataHome = [
                {value: data.home.win, color: colors.win, highlight: colors.win_h, label: "Победы"},
                {value: data.home.loss, color: colors.loss, highlight: colors.loss_h, label: "Поражения"},
                {value: data.home.draw, color: colors.draw, highlight: colors.draw_h, label: "Ничьи"}
            ]
            var dataGuest = [
                {value: data.visitor.win, color: colors.win, highlight: colors.win_h, label: "Победы"},
                {value: data.visitor.loss, color: colors.loss, highlight: colors.loss_h, label: "Поражения"},
                {value: data.visitor.draw, color: colors.draw, highlight: colors.draw_h, label: "Ничьи"}
            ]
            var ctxWA = document.getElementById("graphWA").getContext("2d");
            var ctxWH = document.getElementById("graphWH").getContext("2d");
            var ctxWV = document.getElementById("graphWV").getContext("2d");

            window.myLineWA = new Chart(ctxWA).Doughnut(dataAll);
            window.myLineWH = new Chart(ctxWH).Doughnut(dataHome);
            window.myLineWV = new Chart(ctxWV).Doughnut(dataGuest);
        }
    </script>
</div>

<div id="stat-player" class="popup statistic">
    <div class="inner">
        <div class="tab active" id="players-stat">
            <form action="#" method="post" class="filters clearfix">
                <h4>Фильтры</h4>
                <p>Вы можете выбрать конкретный турнир, включить или исключить товарищеские матчи в статистике, применив фильтр.</p>
                <input type="hidden" name="action" value="player_stat"/>
                <div class="column first">
                    <p>
                        <input type="radio" name="scored_type" value="0" id="player_stat_all" checked=""/>
                        <label for="player_stat_all">Все матчи</label>
                    </p>
                    <p>
                        <input type="checkbox" name="scored_friendly" id="player_stat_friendly" />
                        <label for="player_stat_friendly">Товарищеские</label>
                    </p>
                </div>
                <?php if ($categories) { ?>
                    <div class="column">
                        <p>
                            <input type="radio" name="scored_type" value="1" id="player_stat_scored_by_cup"/>
                            <label for="player_stat_scored_by_cup">Выбрать турнир</label>
                        </p>
                        <p>
                            <select name="scored_cup" id="player_stat_scored_cup">
                                <?php foreach($categories as $category) { ?>
                                    <option value="<?php echo $category->term_id ?>"><?php echo $category->name ?></option>
                                <?php } ?>
                            </select>
                        </p>
                    </div>
                <?php } ?>
                <div class="column">
                    <button type="submit">показать</button>
                </div>
            </form>
            <!-- Статистика игроков -->
            <table id="statistic">
                <thead>
                    <tr>
                        <th class="align-left">Игрок</th>
                        <th>Игры</th>
                        <th>ОС</th>
                        <th>ВЗ</th>
                        <th>Голы(п)</th>
                        <th>ЖК</th>
                        <th>КК</th>
                        <th>НП</th>
                        <th>АГ</th>
                        <th>Травмы</th>
                        <th>СО</th>
                        <th>СОТ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-left">Малько Денис</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Йовенко Владимир</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Труш Евгений</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Малько Денис</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Йовенко Владимир</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Труш Евгений</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Малько Денис</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Йовенко Владимир</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Труш Евгений</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Малько Денис</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Йовенко Владимир</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                    <tr>
                        <td class="align-left">Труш Евгений</td>
                        <td>10</td>
                        <td>10</td>
                        <td>0</td>
                        <td>0</td>
                        <td>3</td>
                        <td>1</td>
                        <td>0</td>
                        <td>0</td>
                        <td>1</td>
                        <td>7.5</td>
                        <td>6.4</td>
                    </tr>
                </tbody>
            </table>
            <div class="notes">
                <p><strong>(п)</strong> - голы с пенальти</p>
                <p><strong>ОС</strong> - игр в основном составе</p>
                <p><strong>ВЗ</strong> - выходили на замену</p>
                <p><strong>ЖК</strong> - желтые карточки</p>
                <p><strong>КК</strong> - красные карточки</p>
                <p><strong>НП</strong> - незабитые пенальти</p>
                <p><strong>АГ</strong> - автоголы</p>
                <p><strong>СО</strong> - средняя оценка</p>
                <p><strong>СОТ</strong> - средняя оценка тренера</p>
            </div>
        </div>
    </div>
</div>
<!-- End Socialize -->
<?php get_footer(); ?>