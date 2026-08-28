<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    /**
     * Marque une notification comme lue et redirige vers la page correspondante
     * (détail de la demande côté RH, liste des demandes côté employé).
     */
    public function ouvrir($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $data = $notification->data;
        $user = auth()->user();

        if ($user->role === 'rh') {
            if (!empty($data['leave_request_id'])) {
                return redirect()->route('conges.show', $data['leave_request_id']);
            }
            return redirect()->route('conges.index');
        }

        return redirect()->route('conges.mesDemandes');
    }
}