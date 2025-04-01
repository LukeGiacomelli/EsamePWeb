<?php
session_start();

header('Content-Type: application/json');
$alerts = [];

if (isset($_SESSION['login_error'])) {
    switch ($_SESSION['login_error']) {
        case 'no_account':
            $alerts[] = [
                'icon' => 'error',
                'title' => 'Account non trovato',
                'text' => 'Le credenziali inserite risultano errate. Per favore, riprova.'
            ];
            break;
        case 'not_approved':
            $alerts[] = [
                'icon' => 'info',
                'title' => 'Account in attesa di approvazione',
                'text' => 'Il tuo account deve ancora essere approvato dall\'amministratore.'
            ];
            break;
        case 'blocked':
            $alerts[] = [
                'icon' => 'warning',
                'title' => 'Account bloccato',
                'text' => 'Il tuo account è stato bloccato. Contatta l\'amministratore per assistenza.'
            ];
            break;
    }
    // Puliamo il messaggio dalla sessione per evitare ripetizioni
    unset($_SESSION['login_error']);
}
if(isset($_SESSION['success_message'])){
    $alerts[] = [
        'icon' => 'success',
        'title' => 'Successo',
        'text' => $_SESSION['success_message']
    ];
    unset($_SESSION['success_message']);
} 
elseif (isset($_SESSION['error_message'])){
    $alerts[] = [
        'icon' => 'error',
        'title' => 'Errore nella modifica',
        'text' => $_SESSION['error_message']
    ];
    unset($_SESSION['error_message']);
}

echo json_encode($alerts);
exit;
?>