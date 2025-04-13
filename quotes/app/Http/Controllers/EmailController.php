<?php

namespace App\Http\Controllers;

use App\Mail\MessageRecived;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $title = 'Assessoria Barceló - Accés a la plataforma';
        $body = '
        <p>Benvingut/da a la plataforma de l\'Assessoria Barceló.</p>
        <p> Ja pots accedir a la plataforma amb les dades amb les que vas registrar-te.</p>
        <p>Si tens qualsevol dubte o problema, no dubtis en contactar-nos.</p>

        <p>Salutacions, <br> L\'equip de l\'Assessoria Barceló</p>
        <img src="" alt="Assessoria Barceló" width="100" height="100">
        ';

        Mail::to('emmacardosa01@gmail.com')->send(new MessageRecived($title, $body));

        return "Email sent successfully!";
    }
}