<?php

namespace nzrylmz;

class EventManager {
    // Aksiyonlara bağlı işlevlerin saklanacağı dizi
    private static $actions = [];

    // Bir aksiyona işlev eklemek (add_action işlevine benzer)
    public static function add_action($action_name, $callback, $priority = 10) {
        // Aksiyon adı için dizi başlat
        if (!isset(self::$actions[$action_name])) {
            self::$actions[$action_name] = [];
        }

        // İşlevi ve önceliği ekle
        self::$actions[$action_name][] = ['callback' => $callback, 'priority' => $priority];

        // Öncelik sırasına göre işlevleri sırala
        usort(self::$actions[$action_name], function ($a, $b) {
            return $a['priority'] - $b['priority'];
        });
    }

    // Bir aksiyonu tetiklemek (do_action işlevine benzer)
    // İlk parametre, varsayılan değeri alacak ve sonrasında her işlevin döndürdüğü değer ile değiştirilecek
    public static function do_action($action_name, $value = null, ...$params) {
        if (isset(self::$actions[$action_name])) {
            // Tüm callback'leri sırayla çalıştır, önceki işlevin döndürdüğü değeri sonraki işlevin parametrelerine ver
            foreach (self::$actions[$action_name] as $action) {
                // İlk parametre olarak bir önceki dönen değeri geçiriyoruz
                $value = call_user_func_array($action['callback'], array_merge([$value], $params));
            }
        }
        return $value;
    }
}
