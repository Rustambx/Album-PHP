<?require_once $_SERVER['DOCUMENT_ROOT']. '/includes/header.php'?>
<?
    $albums = DB::getAlbums();
    $rows = DB::getImages();
?>
    <a href="add.php">Добавить альбом</a>
    <div id="result_block" class="row">
            <?foreach ($albums as $album):?>
                <div class="albums">
                    <?for ($i = 0; $i < count($rows); $i++):?>
                        <?if($rows[$i]['albums_id'] == $album['id']):?>
                            <div class="column">
                                <img src="<?=$rows[$i]['image']?>" alt="Nature" width="200px" height="150px">
                            </div>
                        <?endif;?>
                    <?endfor;?>
                    <div class="phone">
                        <p>Phone: <?=substr($album['phone'], -4)?></p>
                    </div>
                </div>
                <?$last_album_id = $album['id']?>
            <?endforeach;?>
    </div>
    <div style="clear:both"></div>
    <a href="" class="loadMore" id="<?=$last_album_id?>">Показать еще</a>
<?require_once $_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'?>