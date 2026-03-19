<?php

function rai_admin_page() {
    if (isset($_POST['rai_save'])) {
        $clean_content = stripslashes($_POST['rai_ads_content']);
        update_option('rai_ads_content', $clean_content);
        echo '<div class="updated"><p>Ogłoszenia zostały pomyślnie zapisane!</p></div>';
    }

    if (isset($_POST['rai_reset_stats'])) {
        update_option('rai_ads_stats', []);
        echo '<div class="updated"><p>Statystyki zostały zresetowane do zera.</p></div>';
    }

    $ads_raw = get_option('rai_ads_content', '');
    $stats = get_option('rai_ads_stats', []);
    $ads_array = explode('---', $ads_raw);

    ?>
    <div class="wrap">
        <h1>Zarządzaj Ogłoszeniami i Statystykami</h1>

        <hr>

            <h2>Aktualne Statystyki</h2>
            <p>Poniżej znajdziesz dane dotyczące wydajności Twoich losowych ogłoszeń.</p>
            
            <table class="wp-list-table widefat fixed striped" style="margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Treść ogłoszenia</th>
                        <th style="width: 120px;">Wyświetlenia</th>
                        <th style="width: 120px;">Kliknięcia</th>
                        <th style="width: 100px;">CTR (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ads_array) && $ads_array[0] !== ''): ?>
                        <?php foreach($ads_array as $id => $ad): 
                            $v = $stats[$id]['views'] ?? 0;
                            $c = $stats[$id]['clicks'] ?? 0;
                            $ctr = $v ? round(($c / $v) * 100, 2) : 0;
                        ?>
                        <tr>
                            <td><strong>#<?php echo $id; ?></strong></td>
                            <td>
                                <code style="background: #f0f0f0; padding: 3px 6px; border-radius: 3px;">
                                    <?php echo esc_html(substr(strip_tags($ad), 0, 80)); ?>...
                                </code>
                            </td>
                            <td><span class="dashicons dashicons-visibility"></span> <?php echo $v; ?></td>
                            <td><span class="dashicons dashicons-awards"></span> <?php echo $c; ?></td>
                            <td>
                                <strong style="color: <?php echo ($ctr > 0) ? '#28a745' : '#666'; ?>;">
                                    <?php echo $ctr; ?>%
                                </strong>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 20px;">
                                Brak ogłoszeń do wyświetlenia. Dodaj je w formularzu poniżej.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        <hr>

        <form method="post" action="">
            <h2>Edytuj treści ogłoszeń (HTML)</h2>
            <p class="description">
                Wklej poniżej kody HTML swoich ogłoszeń. 
                <strong>Ważne:</strong> Każde ogłoszenie musi być oddzielone od poprzedniego znakami ---.
            </p>
            
            <div style="margin: 15px 0;">
                <textarea name="rai_ads_content" rows="15" cols="80" 
                    style="width:100%; font-family: 'Courier New', Courier, monospace; font-size: 14px; padding: 15px; border-radius: 5px; border: 1px solid #ccc;"><?php echo esc_textarea($ads_raw); ?></textarea>
            </div>

            <p class="submit">
                <input type="submit" name="rai_save" class="button button-primary button-large" value="Zapisz wszystkie ogłoszenia">
                
                <input type="submit" name="rai_reset_stats" class="button button-secondary button-large" 
                    value="Resetuj wszystkie statystyki" 
                    style="margin-left: 10px;"
                    onclick="return confirm('Czy na pewno chcesz wyczyścić wszystkie liczniki wyświetleń i kliknięć? Te dane zostaną utracone bezpowrotnie.');">
            </p>
        </form>

        <div style="margin-top: 40px; padding: 20px; background: #fff; border: 1px solid #ccd0d4; border-left: 4px solid #007cba;">
            <h3 style="margin-top: 0;">Pomoc techniczna</h3>
            <ul>
                <li>Użyj shortcode <code>[losowe_ogloszenie]</code> w dowolnym miejscu posta, aby ręcznie wstawić reklamę.</li>
            </ul>
        </div>
    </div>
    <?php
}