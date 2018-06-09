<?php

require "../vendor/autoload.php";

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

session_start();

$app = new \Slim\App([
  'settings' => [
    'displayErrorDetails' => true
    // 'determineRouteBeforeAppMiddleware' => true
  ]
]);

require "../app/container.php";

$app->get('/', \App\Controllers\PagesUsers::class . ':connexion');

$app->post('/', \App\Controllers\PagesUsers::class . ':register_connexion');

$app->get('/admin', \App\Controllers\PagesAdmin::class . ':dashboard');

$app->post('/admin/{id}/modify', \App\Controllers\PagesAdmin::class . ':modify_user');

$app->post('/admin/{id}/reset', \App\Controllers\PagesAdmin::class . ':reset_password_user');

$app->post('/admin/{id}/delete', \App\Controllers\PagesAdmin::class . ':delete_user');

$app->post('/admin/{id}/update_site', \App\Controllers\PagesAdmin::class . ':update_site');

$app->post('/admin/{id}/delete_site', \App\Controllers\PagesAdmin::class . ':delete_site');

$app->post('/admin/new_user', \App\Controllers\PagesAdmin::class . ':new_user');

$app->post('/admin/new_site', \App\Controllers\PagesAdmin::class. ':new_site');

$app->post('/admin/new_campagne', \App\Controllers\PagesAdmin::class. ':new_campagne');

$app->get('/user/option_entreprise', \App\Controllers\PagesUsers::class . ':option_entreprise');

$app->post('/user/option_entreprise/{id}', \App\Controllers\PagesUsers::class . ':save_options');

$app->post('/user/update_avatar', \App\Controllers\PagesUsers::class . ':update_avatar');

$app->get('/dashboard', \App\Controllers\PagesDashboard::class . ':dashboard');

$app->get('/factures', \App\Controllers\PagesFactures::class . ':list_entreprise');

$app->get('/factures/{id}', \App\Controllers\PagesFactures::class . ':facture_gestion');

$app->get('/leads/{site_name}', \App\Controllers\PagesLeads::class . ':all_leads');

$app->get('/leads/{site_name}/{query}', \App\Controllers\PagesLeads::class . ':query_lead');

$app->get('/leads/{site_name}/{id}/delete', \App\Controllers\PagesLeads::class . ':delete_lead');

$app->post('/leads/update_disponibilite', \App\Controllers\PagesLeads::class . ":update_disponibilite");

$app->post('/leads/update_mult_dispo', \App\Controllers\PagesLeads::class . ":update_mult_dispo");

$app->post('/new_lead', \App\Controllers\PagesLeads::class . ':save_lead');

$app->post('/new_leads', \App\Controllers\PagesLeads::class . ':save_leads');

$app->post('/statistiques', \App\Controllers\PagesStatistiques::class . ':save_statistiques');

$app->get('/statistiques/show', \App\Controllers\PagesStatistiques::class . ":index");

$app->get('/statistiques/filter/{filter}', \App\Controllers\PagesStatistiques::class . ":filter");

$app->post('/factures', \App\Controllers\PagesFactures::class . ':save_entreprise');

$app->post('/factures/{id}', \App\Controllers\PagesFactures::class . ':update_entreprise');

$app->post('/factures/{id}/send_facture', \App\Controllers\PagesFactures::class . ':send_facture');

$app->post('/factures/{id}/{id_historique}', \App\Controllers\PagesFactures::class . ':save_paiement');

$app->delete('/factures/delete_historique/{id}', \App\Controllers\PagesFactures::class . ':delete_historique');

$app->get('/parametres', \App\Controllers\PagesUsers::class . ':user_options');

$app->post('/parametres', \App\Controllers\PagesUsers::class . ':user_options');

$app->post('/user/option_entreprise', \App\Controllers\PagesUsers::class . ':get_options');

$app->get('/user/get_color/{id_user}', \App\Controllers\PagesUsers::class . ':get_color');

$app->get('/user/get_color_scoreboard', \App\Controllers\PagesUsers::class . ':get_color_scoreboard');

$app->post('/user/set_color', \App\Controllers\PagesUsers::class . ':set_color');

$app->post('/user/set_color_scoreboard', \App\Controllers\PagesUsers::class . ':set_color_scoreboard');

$app->post('/telepro/reinject_lead', \App\Controllers\PagesTelepro::class . ':reinject_lead');

$app->post('/telepro/{id}/new_lead', \App\Controllers\PagesTelepro::class . ':new_lead');

$app->get('/telepro', \App\Controllers\PagesTelepro::class . ':index');

$app->get('/telepro/get_one_lead/{id}', \App\Controllers\PagesTelepro::class . ':get_one_lead');

$app->post('/telepro/set_one_lead', \App\Controllers\PagesTelepro::class . ':set_one_lead');

$app->post('/telepro/get_agenda', \App\Controllers\PagesTelepro::class . ':get_agenda');

$app->post('/telepro/statistiques/cant_continue', \App\Controllers\PagesTelepro::class . ':cant_continue');

$app->get('/telepro/statistiques', \App\Controllers\PagesTelepro::class . ':show_statistiques');

$app->get('/telepro/display_date/{id_telepro}', \App\Controllers\PagesTelepro::class . ':display_date');

$app->get('/telepro/display_agenda', \App\Controllers\PagesTelepro::class . ':display_agenda');

$app->get('/telepro/display_current_leads', \App\Controllers\PagesTelepro::class . ':display_current_leads');

$app->get('/telepro/display_one_lead/{id_lead}', \App\Controllers\PagesTelepro::class . ':display_one_lead');

$app->post('/telepro/get_one_lead_id', \App\Controllers\PagesTelepro::class . ':get_one_lead_id');

$app->post('/telepro/confirm_rdv', \App\Controllers\PagesTelepro::class . ':confirm_rdv');

$app->post('/telepro/archive_lead', \App\Controllers\PagesTelepro::class . ':archive_lead');

$app->post('/telepro/delete_one_lead', \App\Controllers\PagesTelepro::class . ':delete_one_lead');

$app->get('/telepro/validate_lead', \App\Controllers\PagesTelepro::class . ':validate_lead');

$app->get('/telepro/get_statistiques/{name}/{date}', \App\Controllers\PagesTelepro::class . ':get_statistiques');

$app->get('/telepro/scoreboard', \App\Controllers\PagesTelepro::class . ':get_scoreboard');

$app->get('/telepro/update_signature', \App\Controllers\PagesTelepro::class . ':update_signature_scoreboard');

$app->post('/telepro/update_signature', \App\Controllers\PagesTelepro::class . ':update_signature_telepro');

$app->get('/telepro/get_scoreboard_information/{display}', \App\Controllers\PagesTelepro::class . ':get_scoreboard_information');

$app->post('/telepro/traitement_lead', \App\Controllers\PagesTelepro::class . ':traitement_lead');

$app->post('/telepro/update_current_lead', \App\Controllers\PagesTelepro::class . ':update_current_lead');

$app->post('/telepro/update_max', \App\Controllers\PagesTelepro::class . ":update_max");

$app->post('/telepro/import_leads', \App\Controllers\PagesTelepro::class . ':import_leads');

$app->get('/archives', \App\Controllers\PagesArchives::class . ':index');

$app->get('/archives/{id_lead}', \App\Controllers\PagesArchives::class . ':view_one_lead');

$app->get('/get_commentaire/{site_name}', \App\Controllers\PagesCommentaires::class . ":get_commentaire");

$app->get('/commentaire/show', \App\Controllers\PagesCommentaires::class . ":index");

$app->post('/new_commentaire', \App\Controllers\PagesCommentaires::class . ":new_commentaire");

$app->post('/commentaire/update', \App\Controllers\PagesCommentaires::class . ":update_commentaire");

$app->get('/logout', \App\Controllers\PagesUsers::class . ':logout');

$app->run();

?>
