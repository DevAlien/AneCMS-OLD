Dev-Framework

Languages:
./lang/name_of_language_in_ISO_6392-2_ALPHA-2/
http://it.wikipedia.org/wiki/ISO_639-2

DataBase:
dev_general
=>language, vedi punto Languages
=>status, 1=aperto, 0=chiuso
=>title, titolo del sito
=>descr, Descrizione sito
=>skin, nome della skin
=>default_module, nome del modulo di default

dev_users
=>id, id utente
=>username, username utente
=>email, email utente
=>password, passowrd in md5 dell'utente
=>language, vedi punto Languages
=>skin, nome della skin
=>groups, nome del gruppo
=>status, 0=>bannato,1=>da attivare, 2=>attivato, 5=>Administrator gli altri da definire

modules
type = 1 attivo
type = 0 disattivo