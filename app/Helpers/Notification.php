<?php

namespace App\Helpers;

use App\User;

class Notification {
    public function get($user = null)
    {
        if ($user == null) $user = Auth()->user()->id;

        $notif = User::findOrFail($user)->notification;

        return $notif;
    }
    
    public function make($title = '', $content = '', $id_user = null, $url, $type = 'info')
    {
        return \App\Models\Notification::create([
            'title'     => $title,
            'content'   => $content,
            'user_id'   => $id_user,
            'type'      => $type,
            'url'      => $url,
        ]);
    }
}