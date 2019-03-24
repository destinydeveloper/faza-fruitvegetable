<?php

namespace App\Helpers;

use App\User;
use App\Models\Notification as NotificationModel;

class Notification {
    public function get($user = null, $limit = null, $skip = null)
    {
        if ($user == null) $user = Auth()->user()->id;

        // $notif = User::findOrFail($user)->notification;
        $notif = NotificationModel::whereUserId(Auth()->user()->id);
        $getNotif = $notif->orderBy('id', 'desc');
        if (!$limit == null)  $getNotif->take($limit);
        if (!$skip == null)  $getNotif->skip($skip);
        $getNotif = $getNotif->get();
        
        if ($getNotif->count() != 0 && $getNotif[0]->read == 0) $set_read = $notif->update(['read' => 1]);
        

        return $getNotif;
    }

    public function getNotReadCount($user = null)
    {
        if ($user == null) $user = Auth()->user()->id;
        $notif = NotificationModel::whereUserId(Auth()->user()->id)
                    ->whereRead(0);
        return $notif->count();
    }
    
    
    public function make($title = '', $content = '', $id_user = null, $url, $type = 'info')
    {
        if ($id_user == null) $id_user = Auth()->user()->id;

        return NotificationModel::create([
            'title'     => $title,
            'content'   => $content,
            'user_id'   => $id_user,
            'type'      => $type,
            'url'      => $url,
        ]);
    }

    public function stack($title = '', $content = '', $id_user = null, $url, $type = 'info')
    {
        if ($id_user == null) $id_user = Auth()->user()->id;

        NotificationModel::whereUserId($id_user)
            ->whereTitle($title)->delete();

        return $this->make($title, $content, $id_user, $url, $type);
    }
}