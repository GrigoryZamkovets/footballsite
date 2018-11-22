<?php
    $db = connectDB( $config['db']['server'],
        $config['db']['name'],
        $config['db']['username'],
        $config['db']['password'] );

    //get id of rows of the table advertizing cards
    $query = $db->query(" SELECT `id` FROM `advertizing_cards` ");
    $id_rows = $query->fetchAll(PDO::FETCH_ASSOC);

    // transform and get $where_id
    for ($i = 1; $i <= 4; $i++) {
        shuffle($id_rows);
        $random_id[] = array_pop($id_rows);
    }

    for ($i = 0; $i < count($random_id); $i++) {
        $random_id[$i] = $random_id[$i]['id'];
    }

    $where_id = implode(", ", $random_id);

    //get our 4 advertizing cards
    $query = $db->query(" SELECT * FROM `advertizing_cards`
                                                        WHERE `id` IN ($where_id)
                                                        ORDER BY `date` DESC, `id` DESC ");
    $advertizing_cards = $query->fetchAll(PDO::FETCH_ASSOC);
    $advertizing_cards = array_reverse($advertizing_cards);

    closeDB();
?>

<!--                write all our advertizing cards-->
<?php foreach ($advertizing_cards as $advertizing_card): ?>
    <div class="card mb-4 col-sm-6 col-md-12 col-xl-3 bg-secondary">
        <img class="card-img-top"
             src="/images/advertizing_images/<?=$advertizing_card['image']?>"
             alt="Card image <?=$advertizing_card['id']?>">
        <div class="card-body">
            <h5 class="card-title"><?=$advertizing_card['title']?></h5>
            <p class="card-text">
                <?=$advertizing_card['text']?>
            </p>
            <a href="<?=$advertizing_card['link']?>"
               class="btn btn-primary"
               target="_blank">
                Read about it &raquo;
            </a>
        </div>
    </div>
<?php endforeach; ?>
