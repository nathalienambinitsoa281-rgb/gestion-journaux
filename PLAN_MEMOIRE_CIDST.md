# DRAFITRA FANDALINANA BE TSARA: NY NY NUMÉRISATION SY NY FAMETRAHANA DRAFITRA FANDRAISAHANA NY ARCHIVAN'NY GAZETIMPANJAKANA (API REST & TOKONY)

---

## FANDRAISAHANA ANTSERATRA
### Tontolo iainana
Ny **Centre d’Information et de Documentation Scientifique et Technique (CIDST Tsimbazaza)** dia andriamanjato malagasy miandraikitra ny fitehirizana, ny fampielezana ary ny numérisation ny antontan-taratasy ofisialy amin'ny firenena, indrindra ireo **Gazetimpanjakana**. Vaky haingana, ny fitantanana ireo firafitra dia nampiasaina **an-tsoratra** betsaka:
- Fikarohana ara-batana ao anaty tetika na lafo ao anaty tranomboky.
- Tsy misy indexation mifanandray.
- Fahirana ireo mpikambana sy ireo mpampiasa ivelany mba hahatratra haingana ny fampahalalana.

### Fanoherana
Ny fanoherana lehibe nihaona:
1.  **Fahaterana ny fikarohana**: Ny fikarohana an-tsoratra dia afaka mandray minitra maromaro, na ora maromaro aza, mba hahitana gazety manokana.
2.  **Tsy ahafahana miditra amin'ny finday**: Tsy misy fomba ahafahan'ny mpampiasa miditra amin'ny angona avy amin'ny finday na ny tablet.
3.  **Tsy misy fanaraha-maso ny mpampiasa**: Tsy afaka manaraha izay nijery na nanova ireo firafitra, sy ny fitantanana ny tompon'andraikitra (Admin vs Mpampiasa tsotra).
4.  **Tsy misy rafitra fampandrika na log**: Tsy misy fanaraha-maso ny hetsika (fafana, fanovana, fampidirana gazety).

### Tanjon'ny tetikasa
Ny asantsika dia hamaha ireo fanoherana ireo amin'ny alalan'ny tranomboky web maoderina:
1.  **Fametrahana interface web mihetsiketsika**: Ho an'ny fitantanana sy ny fandraisahana ireo gazety, azo miditra avy amin'ny navigateur rehetra.
2.  **Fikarohana an-tsary (AJAX)**: Filter avy hatrany amin'ny laharana, ny mpamaky, ny ampahany, ny daty na ny famaritana.
3.  **Fitantanana ny mpampiasa sy ny zo fidirana**: Fisarahana mazava teo amin'ny **Administrateurs** (fitantanana ireo kaonty, fafana, fanakanana) ary ireo **Mpampiasa tsotra** (fampidirana, fandraisahana ireo gazety azy manokana).
4.  **Fanaraha-maso ny hetsika**: Jorinaly hetsika (suivi_operations) mba hamandreha ny fanovana, fampidirana na fafana rehetra.
5.  **Branding CIDST Tsimbazaza**: Interface mifanaraka amin'ny lohahevitra ny andriamanjato (loko manga, logo ofisialy).

---

## FANANDRAHARANA I: NY TANJON'NY FANADIKARANA SY NY FAMOKARANA NY ZAVATRA EFA MISY
---

### Tocotra I: Famaritana ny andriamanjato fandraisahana (CIDST Tsimbazaza)
#### 1.1 Tantara ny CIDST Tsimbazaza
Natsangana tamin'ny taona 1970, ny CIDST Tsimbazaza dia iray amin'ireo foibe fampahalalana ara-tsiansa sy teknika lehibe indrindra eto Madagasikara. Izy io dia miorina ao amin'ny vanim-potoana Tsimbazaza, Antananarivo, ary miara-miasa akaiky amin'ny minisitry ny Fampianarana ambony sy ny Fikarohana siantifika.

#### 1.2 Tandraikitra lehibe
Ny tandraikitra ny CIDST Tsimbazaza dia marobe:
- **Fitehirizana**: Firafitra sy fitehirizana ireo antontan-taratasy ofisialy (gazety, lalàna, didim-panjakana, didim-panjakana, sns.).
- **Fampielezana**: Fametrahana ireo antontan-taratasy ho an'ny mpikaroka, ireo mpianatra, ireo mpiasa amin'ny fanjakana ary ny besinimaro.
- **Numérisation**: Fanovana ireo antontan-taratasy ara-batana ho endrika nomerika (PDF, sary) ho an'ny fitehirizana maharitra.
- **Fikarohana sy fampahalalana**: Fanampiana ireo mpampiasa amin'ny fikarohana azy ireo amin'ny alalan'ny katalaog misy endrika.

#### 1.3 Fandraisana anatiny
Ny andriamanjato dia voarindra amin'ny departemanta maromaro:
1.  **Departemantan'ny firafitra**: Fitantanana ireo antontan-taratasy ara-batana sy nomerika.
2.  **Departemantan'ny numérisation**: Fanovana ireo antontan-taratasy ara-batana ho rakitra nomerika.
3.  **Departemantan'ny fampielezana sy ny fandraisahana**: Fandraisahana ireo mpampiasa ary valiny ireo fangatahana fanontaniana.
4.  **Departemantan'ny informatika** (am-boarina): Fitantanana ireo rafitra informatika sy ireo tranomboky web.

---

### Tocotra II: Famokarana ny zavatra efa misy sy ny Diagnostika
#### 2.1 Fomba fitantanana ireo gazety ankehitriny
Talohan'ny fametrahana ny tranomboky, ny fitantanana ireo firafitra dia nampiasaina indrindra:
- **Rakitra an-tsoratra**: Ireo gazety dia tafiditra tao anaty lafo, voasokajy araka ny daty na ny ampahany.
- **Tableur Excel**: Ny andrana vitsivitsy ny indexation amin'ny alalan'ny tableur, saingy tsy misy fandrindrana na fanamafisana.
- **Tsy misy angon-drakitra mifanandray**: Tsy misy rafitra mba hitahiry ireo métadonnées (laharana, mpamaky, daty, ampahany, sns.) amin'ny fomba misy endrika.

#### 2.2 Toetra tsara ny rafitra taloha
- **Fahalalana ara-batana ireo antontan-taratasy**: Ireo mpikambana dia manana fahalalana tsara ny toerana ara-batana ireo firafitra.
- **Fahazoana ireo antontan-taratasy tany am-boalohany**: Ireo gazety ara-batana dia voatahiry amin'ny toe-javatra tsara.

#### 2.3 Toetra ratsy sy fanakianiana
1.  **Fahaterana betsaka ny fikarohana**: Mba hahitana gazety iray, tokony ho jerena aloha ny index an-tsoratra, avy eo dia mandraisa ilay antontan-taratasy ao anaty lafo.
2.  **Fahadisoana miverimberina ataon'ny olona**: Risika hisy fanasokajana diso, fahaverezan'ny antontan-taratasy na fanaovana ampahany an'ireo fidirana ao anaty tableur.
3.  **Tsy ahafahana miditra lavitra**: Tsy afaka mandraisa ireo firafitra avy ivelan'ny tranon'ny CIDST.
4.  **Tsy misy fitantanana ny mpampiasa**: Tsy misy rafitra fidirana na tombony, ka ny olona rehetra dia afaka miditra amin'ny antontan-taratasy rehetra.
5.  **Tsy misy fanaraha-maso**: Tsy afaka fantatra izay nijery, nanova na nanafana gazety iray.
6.  **Tsy misy tahiry nomerika**: Raha simba na very ny antontan-taratasy ara-batana, dia tsy misy dika nomerika.

#### 2.4 Vahaolana naroso sy noraisina
Mba hamaha ireo fanoherana ireo, dia nisafidy fandraisana **hybride** izahay:
1.  **Front-end mihetsiketsika**: PHP tafiditra ho an'ny logika ara-biznisy, miaraka amin'ny **AJAX/Fetch API** ho an'ny fikarohana an-tsary.
2.  **Back-end sy angon-drakitra**: MySQL ho an'ny fitahirizana angona misy endrika, miaraka amin'ny fampifandraisana PDO azo antoka.
3.  **Interface mpampiasa maoderina**: CSS miaraka amin'ny **Custom Properties (variables CSS)** ho an'ny lohahevitra (manga CIDST), JavaScript vanilla ho an'ny fampiainan'ny interface (tsy misy framework mavesatra toa React na Vue, ho an'ny fahatsorana ny fitandroana).
4.  **API REST (am-boarina)**: Django REST Framework ho an'ny fidirana amin'ny finday any aoriana, miaraka amin'ny endpoints mba ahafahana maka ireo gazety ao anaty JSON.

---

## FANANDRAHARANA II: FANANDRAHARANA TEKNIKA (MERISE & UML)
---

### Tocotra III: Fandrindrana ny Data (MERISE)
Nampiasaina ny fomba MERISE izahay mba handrindrana ny angon-drakitra sy ny fomba fiasa.

#### 3.1 MCT (Modèle Conceptuel de Traitement)
Ny MCT dia mamaritra ireo fizotry ny raharaha ara-biznisy an'ny tranomboky:
1.  **Fizotra 1: Authentification sy Fitantanana ny mpampiasa**
    - Fampidirana mpampiasa vaovao (ho an'ny tsotra, Admin dia afaka manakana / manafana).
    - Fidirana (Login) miaraka amin'ny fanamarinana ireo mari-pahaizana (Admin na Mpampiasa).
    - Fivoahana (Logout) miaraka amin'ny fandringanana ny session.
2.  **Fizotra 2: Fitantanana ireo Gazety**
    - Fampidirana gazety iray (enregistrement) miaraka amin'ny upload ny PDF (tsy maintsy).
    - Fanovana gazety efa misy (Edit).
    - Fafana gazety iray (Delete, miaraka amin'ny fanamafisana).
    - Fandraisahana ny Archives Publikas (ny mpampiasa rehetra, na misy fidirana na tsia).
3.  **Fizotra 3: Fikarohana sy Filter**
    - Fikarohana an-tsary (AJAX) amin'ny alalan'ny bara fikarohana eo an-tampon'ny pejy.
    - Filter bebe kokoa amin'ny Ampahany, Daty nahazoana, na teny malaza.
4.  **Fizotra 4: Statistika sy Fanaraha-maso**
    - Fampisehoana ny isan'ny gazety rehetra, ny mpamaky, ary ny karazana hetsika.
    - Fanaraha-maso ireo hetsika nataon'ny mpampiasa (log).
    - Fanaraha-maso ireo fikasana fidirana (mahomby na tsy nahomby).

#### 3.2 MOT (Modèle Organisationnel de Traitement)
Ny MOT dia mamaritra ny anjara sy ny tombony:
| Mpanjifa               | Zo ahafahana manao                                                                 |
|-----------------------|--------------------------------------------------------------------------------------|
| **Vahiny (Tsy misy fidirana)** | Mandraisa ny Archives Publikas, mampiasa ny fikarohana, miditra amin'ny pejy fandraisahana. |
| **Mpampiasa Tsotra**  | Ny zo rehetra an'ny vahiny + mampidirana gazety, mandraisa ireo gazety azy manokana, manova / manafana ireo gazety azy manokana. |
| **Administrateur**      | Ny zo rehetra an'ny Mpampiasa Tsotra + mitantana ireo mpampiasa (manakana, manafoana, manafana, manova), mandraisa ny gazety rehetra, miditra amin'ny fanaraha-maso ireo hetsika sy ireo fikasana fidirana, manova ny logo ofisialy amin'ny tranonkala. |

#### 3.3 MLD (Modèle Logique des Données)
Ity ny firafitry ireo latabatra lehibe ao amin'ny angon-drakitra `gestion_journaux`:

1.  **`utilisateur`** (Ho an'ny mpampiasa tsotra)
    - `id_utilisateur` (INT, PK, AUTO_INCREMENT) : ID tokony ho an'ny mpampiasa.
    - `matricule` (VARCHAR 50, UNIQUE) : Login / Matricule fidirana.
    - `nom` (VARCHAR 100) : Anaran'ny vady.
    - `prenom` (VARCHAR 100) : Anaraka.
    - `mot_de_passe` (VARCHAR 255) : Teny miafina voahashy (password_hash).
    - `email` (VARCHAR 100, NULLABLE) : Adiresy mailaka (tsy maintsy).
    - `fonction` (VARCHAR 100, NULLABLE) : Asa na toeran'ny mpampiasa.
    - `date_creation` (DATETIME, DEFAULT CURRENT_TIMESTAMP) : Daty noforonina ny kaonty.
    - `est_bloque` (BOOLEAN, DEFAULT FALSE) : Mampiseho raha voakanana ny kaonty.

2.  **`admin_logiciel`** (Ho an'ny administrateurs)
    - `id_admin` (INT, PK, AUTO_INCREMENT) : ID tokony ho an'ny admin.
    - `login_admin` (VARCHAR 50, UNIQUE) : Login admin.
    - `mot_de_passe` (VARCHAR 255) : Teny miafina voahashy.
    - `date_creation` (DATETIME, DEFAULT CURRENT_TIMESTAMP) : Daty noforonina ny kaonty admin.

3.  **`journal`** (Ho an'ny gazety ofisialy / Gazetimpanjakana)
    - `id_journal` (INT, PK, AUTO_INCREMENT) : ID tokony ho an'ny gazety.
    - `matricule` (VARCHAR 50) : Laharana tokony ho an'ny gazety (matricule).
    - `partie` (VARCHAR 50) : Ampahany amin'ny gazety (part1, part2, part3, na hafa).
    - `editeur` (VARCHAR 255) : Mpamaky ny gazety.
    - `lieu_edition` (VARCHAR 255) : Toerana namoahana ny gazety.
    - `date_edition` (DATE) : Daty namoahana ny gazety.
    - `date_sortie` (DATE) : Daty navoakan'ny gazety.
    - `lieu_stockage` (VARCHAR 255) : Toerana fitahirizana ara-batana (raha misy).
    - `prix` (DECIMAL 10,2, NULLABLE) : Vidin'ny gazety amin'ny Ariary.
    - `description` (TEXT, NULLABLE) : Antsipiriany na famakafakana ny gazety.
    - `fichier_pdf` (VARCHAR 255, NULLABLE) : Lalan'ny rakitra PDF voanisy.
    - `date_reception` (DATETIME, DEFAULT CURRENT_TIMESTAMP) : Daty nahazoana / nafiditra ny gazety ao anaty tranomboky.

4.  **`periodique`** (Hametrahana mpampiasa amin'ny gazety izay nampidiriny)
    - `id_periodique` (INT, PK, AUTO_INCREMENT) : ID tokony ho an'ny firaisana.
    - `id_utilisateur` (INT, FK) : Manondro an'ny `utilisateur.id_utilisateur`.
    - `id_journal` (INT, FK) : Manondro an'ny `journal.id_journal`.

5.  **`suivi_operations`** (Ho an'ny jorinaly hetsika)
    - `id_suivi` (INT, PK, AUTO_INCREMENT) : ID tokony ho an'ny hetsika.
    - `id_utilisateur` (INT, FK, NULLABLE) : Manondro an'ny mpampiasa izay nanao ny hetsika (NULL raha Admin izy).
    - `operation` (TEXT) : Famaritana ny hetsika (ohatra: "Enregistrement Journal: 1234", "Suppression Journal: 5678").
    - `date_operation` (DATETIME, DEFAULT CURRENT_TIMESTAMP) : Daty sy ora ny hetsika.

6.  **`tentative_connexion`** (Ho an'ny fanaraha-maso ireo fikasana fidirana)
    - `id_tentative` (INT, PK, AUTO_INCREMENT) : ID tokony ho an'ny fikasana.
    - `login_tente` (VARCHAR 50) : Login nampiasaina tamin'ny fikasana.
    - `adresse_ip` (VARCHAR 50) : Adiresy IP an'ny mpampiasa.
    - `reussi` (BOOLEAN) : Mampiseho raha nahomby ny fikasana.
    - `date_tentative` (DATETIME, DEFAULT CURRENT_TIMESTAMP) : Daty sy ora ny fikasana.

#### 3.4 MPD (Modèle Physique des Données)
Ny MPD dia mifanaraka amin'ny fampiharana SQL tena izy, hita ao anaty rakitra `schema.sql` amin'ny fototry ny tetikasa. Io rakitra io dia misy ireo fanontaniana `CREATE TABLE` miaraka amin'ny fepetra ireo vahaolana foreign (FOREIGN KEY), ireo index, ary ireo sanda tsara aminy.

---

### Tocotra IV: Fandrindrana Object (UML)
Na dia mampiasa PHP tafiditra ho an'ny front-end aza izahay, dia nandraisana ny fomba fandrindrana kaody miaraka amin'ny fomba modularité, ary nanomana rafitra ho an'ny API Django.

#### 4.1 Diagramme ny fiasan'ny mpampiasa
Ny fiasan'ny mpampiasa lehibe:
- **Fidirana / Fivoahana**: Ho an'ny mpanjifa rehetra.
- **Fitantanana ireo Gazety**: Mampidirana, Manova, Manafana, Mandraisa.
- **Fikarohana**: Fikarohana tsotra na bebe kokoa.
- **Fitantanana ireo Mpampiasa**: Ho an'ny Admin ihany.
- **Statistika sy Fanaraha-maso**: Ho an'ny Admin ihany.

#### 4.2 Diagramme ny filaharana (Fikarohana an-tsary)
Ity ny filaharan'ny fikarohana AJAX:
1.  Ny mpampiasa dia manoratra caractere iray ao anaty bara fikarohana eo an-tampon'ny pejy (`globalSearch`).
2.  Ny hetsika `onkeyup` dia mandrisika ny fonction `handleRealTimeSearch(value)`.
3.  Io fonction io dia mandefa fanontaniana `Fetch API` (GET) ho an'ny `api_search.php` miaraka amin'ny sanda ny fikarohana ho parametra.
4.  Ny rakitra `api_search.php` dia manontany ny angon-drakitra MySQL miaraka amin'ny fanontaniana voaomana (mba hisorohana ny injection SQL).
5.  Ireo valiny dia averina ao anaty endrika JSON.
6.  Ny fonction JavaScript dia mandray ilay JSON, mandrafitra ireo valiny ho HTML, ary mampiseho azy ireo ao anaty div `searchResults` eo ambany ilay bara fikarohana.
7.  Raha tsindrian'ny mpampiasa valiny iray, dia averina any amin'ny pejy famaritana na any amin'ny lisitry ny gazety miaraka amin'ny filter efa voafeno.

#### 4.3 Diagramme ny Classes (API Django REST Framework)
Ho an'ny API finday, ity ireo modely (Classes) no nomanana:
1.  **`Journal`**: Modèle Django mifanaraka amin'ny latabatra `journal`.
2.  **`Utilisateur`**: Modèle mifanaraka amin'ny latabatra `utilisateur`.
3.  **`SuiviOperations`**: Modèle mifanaraka amin'ny latabatra `suivi_operations`.
4.  **`JournalSerializer`**: Sérialiseur mba hamovana ireo objet `Journal` ho JSON sy ny mifanitsy.
5.  **`JournalViewSet`**: ViewSet ho an'ny endpoints CRUD (Create, Read, Update, Delete) ireo gazety.

---

## FANANDRAHARANA III: FANAMPIHARANA SY FAMETRAHANA
---

### Tocotra V: Ny tontolo iainana famolavolana sy ireo fitaovana
#### 5.1 Ireo fitaovana sy ny teknoloji nampiasaina
| Sokajy               | Ireo fitaovana / Teknoloji                                                             |
|-----------------------|---------------------------------------------------------------------------------------|
| **Editeur kaody**      | VS Code (Visual Studio Code) miaraka amin'ny extensions PHP, CSS, ary JavaScript.       |
| **Serveur Web an-toerana**    | XAMPP (Apache + MySQL + PHP) – ho an'ny famolavolana sy ny fitsapana an-toerana.         |
| **Fiteny famolavolana** | PHP 8.x (ho an'ny front-end sy ny logika ara-biznisy), Python 3.x (ho an'ny API Django). |
| **Angon-drakitra**      | MySQL (amin'ny alalan'ny phpMyAdmin ho an'ny fitantanana an-toerana).                     |
| **Version Control**      | Git (ho an'ny fanaraha-maso ireo fanovana ny kaody).                                     |
| **Fametrahana (nomanana)**  | GitHub (ho an'ny fitahirizana ny kaody) + Railway (ho an'ny fametrahana ny tranonkala an-tserasera). |
| **Hafa**               | Poppins (Google Fonts) ho an'ny endrika sora-baventy, Unsplash ho an'ny sary tany anaty vatan-tany. |

#### 5.2 Firafitry ny tetikasa
Ity ny firafitry ireo rakitra ao amin'ny tetikasa:
```
projet DTS/
├── css/
│   └── style.css              # Feuille de style lehibe (lohahevitra manga CIDST)
├── js/
│   └── script.js              # Scripts JavaScript (fampiainan'ny interface, fikarohana AJAX)
├── img/
│   └── logo_cidst.png         # Logo ofisialy ny CIDST (tsy maintsy, azo uploadin'ny Admin)
├── uploads/
│   └── pdf/
│       ├── .gitkeep           # Rakitra mba hitazona ilay lahatahiry ao anaty Git
│       └── [rakitra PDF ireo gazety]
├── temp_sessions/             # Lahatahiry ho an'ny session PHP (noforonina ho azy)
├── cidst_api/                 # Lahatahiry ho an'ny API Django REST Framework (am-boarina)
│   ├── cidst_api/
│   ├── journals/
│   └── manage.py
├── db.php                     # Rakitra fampifandraisana amin'ny angon-drakitra (PDO)
├── index.php                  # Pejy fidirana (Login)
├── register.php               # Pejy fampidirana (Inscription)
├── home.php                   # Pejy fandraisahana (Home)
├── user_dashboard.php         # Tabilao ho an'ny Mpampiasa tsotra
├── liste_journaux.php         # Lisitry ireo gazety nampidirin'ny mpampiasa
├── edit_journal.php           # Pejy fanovana gazety iray
├── public_journals.php        # Archives Publikas (azo miditra amin'ny olona rehetra)
├── search.php                 # Pejy fikarohana bebe kokoa
├── statistiques.php           # Pejy statistika
├── liste_utilisateurs.php     # Tabilao Admin (fitantanana ireo mpampiasa)
├── edit_utilisateur.php       # Pejy fanovana mpampiasa iray
├── upload_logo.php            # Script ho an'ny upload logo ofisialy amin'ny tranonkala
├── api_search.php             # API ho an'ny fikarohana an-tsary (JSON)
├── logout.php                 # Script fivoahana
├── schema.sql                 # Schéma SQL ny angon-drakitra
├── composer.json              # Rakitra fametrahana ho an'ny Composer (dépendances PHP)
├── Procfile                   # Rakitra ho an'ny fametrahana ao anaty Railway
├── .gitignore                 # Ireo rakitra tokony hialana ao anaty Git
├── PLAN_MEMOIRE_CIDST.md      # Ity rakitra ity (Drafitra fandalina)
└── README.md                  # Torolàlana fametrahana sy fametrahana
```

---

### Tocotra VI: Fampiharana ireo fitoviana lehibe
Amin'ity tocotra ity, dia hanazontsika ireo fitoviana izay tena nampiharina ao anaty tranomboky.

#### 6.1 Interface mpampiasa (UI) sy Design
Nisafidy design **maoderina sy kely foana** izahay, miaraka amin'ny lohahevitra manga mifanaraka amin'ny branding ny CIDST Tsimbazaza. Ireo toetra lehibe ny design:
- **Loko lehibe**:
  - `--primary-blue: #1565C0`: Manga lehibe (ho an'ny bokotra, ireo rohy mihetsika, ny logo).
  - `--primary-dark-blue: #0D47A1`: Manga maizina (ho an'ny effet hover).
  - `--text-dark: #1a237e`: Manga maizina be (ho an'ny soratra, ho soloina ny mainty).
  - `--light-grey: #f0f4f8`: Volon-tany mazava manga (ho an'ny backgrounds ireo cards).
- **Typography**: Police Poppins (Google Fonts) ho an'ny famakiana mora.
- **Famantarana zavatra**: Glassmorphism (cards miaraka amin'ny effet transparent), transitions malaza (hover, click), atahorana malefaka.
- **Responsivité**: Ny tranomboky dia totally responsive (mifanaraka amin'ny finday, tablet ary ordinateur).

**Sary capture an'ny interface (Sidebar sy Top Navbar)**:
Ny sidebar dia misy ireo rohy manaraka (araka ny anjara an'ny mpampiasa):
1.  **Accueil**: Pejy fandraisahana miaraka amin'ny statistika sy ireo fomba fiasa haingana.
2.  **Archives Publikas**: Fandraisahana ireo gazety rehetra.
3.  **Tableau de bord**: Ho an'ny Mpampiasa tsotra ihany (fampidirana gazety vaovao).
4.  **Entrées récentes**: Ho an'ny Mpampiasa tsotra ihany (lisitry ireo gazety azy manokana).
5.  **Statistiques**: Graphique sy famintinana ireo angona.
6.  **RECHERCHER**: Pejy fikarohana bebe kokoa.
7.  **Utilisateurs**: Lisitry ireo mpikambana (azo miditra amin'ny olona rehetra, saingy Admin ihany no afaka manova / manafana).
8.  **Boaty any ambany (ho an'ny Mpampiasa tsotra)**:
    - **S'INSCRIRE**: Mampidirana kaonty vaovao (azo miditra ihany raha tsy Admin).
    - **Déconnexion**: Mivoaka.
9.  **Boaty any ambany (ho an'ny Vahiny / Tsy misy fidirana)**:
    - **Login**: Miditra.
    - **S'INSCRIRE**: Mampidirana.

Ny Top Navbar (bara eo an-tampony) dia misy:
- Bokotra Menu Toggle (ho an'ny sary kely, hampisehoana / manafana ny sidebar).
- Bara fikarohana an-tsary (AJAX) miaraka amin'ny sary 🔍.
- Switch ho an'ny Mode Mazava / Maizina (🌙 ☀️).
- Sélecteur fiteny (FR/EN).
- Anaran'ny mpampiasa tafiditra (miaraka amin'ny sary 👤).
- Logo ofisialy ny CIDST Tsimbazaza (na placeholder manga raha tsy misy upload).

#### 6.2 Authentification sy Fitantanana ny Session
Ny filankevitra dia tena zava-dehibe ao anaty tranomboky. Ireo fepetra nampiasaina:
- **Session azo antoka**:
  - Mampiasaina `session_start()` miaraka amin'ny lahatahiry session manokana (`temp_sessions/`) mba hisorohana ny fahadisoana permission ao amin'ny server sasany.
  - Andro 1 ny andro ny session (mba tsy hila ny mpampiasa hiverina miditra isan'andro).
- **Fanafana ny teny miafina**:
  - Ho an'ny Mpampiasa tsotra: Mampiasaina `password_hash()` (miaraka amin'ny algorithme bcrypt ho an'ny default) tamin'ny fampidirana, ary `password_verify()` tamin'ny fidirana.
  - Ho an'ny Administrateurs: Mety ihany ny rafitra fanafana. Rha vita ao anaty angon-drakitra ny teny miafina an-tsoratra (ho an'ny famindrana avy amin'ny rafitra taloha), ny tranomboky dia hahashy azy ho azy tamin'ny fidirana voalohany nahomby (auto-update security).
- **Fanaraha-maso ireo fikasana fidirana**: Ny fikasana fidirana rehetra (nahomby na tsy nahomby) dia voatahiry ao anaty latabatra `tentative_connexion` miaraka amin'ny adiresy IP an'ny mpampiasa.

#### 6.3 Fitantanana ireo Gazety (CRUD)
CRUD = Create, Read, Update, Delete (Mampidirana, Mandraisa, Manova, Manafana).

##### 6.3.1 Mampidirana gazety (Enregistrement)
- Pejy: `user_dashboard.php`
- Tsehatra tokony ho feno (tsy ny PDF): Laharana (Matricule), Ampahany, Mpamaky, Toerana namoahana, Daty namoahana, Daty navoaka, Toerana fitahirizana, Vidin'ny.
- Tsehatra tsy maintsy: Rakitra PDF (ampidirina ao anaty `uploads/pdf/`).
- Fanamarinana:
  - Eo anaty client (HTML5): Attribut `required` eo amin'ny tsehatra tokony ho feno.
  - Eo anaty serveur (PHP): Fanamarinana fa feno avokoa ny tsehatra tokony ho feno alohan'ny fampidirana ao anaty angon-drakitra.
- Fomba fiasa:
  1.  Ny mpampiasa dia mameno ny endrika ary tsindrio « ENREGISTRER LE JOURNAL ».
  2.  Raha misy PDF voa-upload, dia ampidirina ao anaty lahatahiry `uploads/pdf/` miaraka amin'ny anarana tokony ho azy (ohatra: `journal_1234_1717489200.pdf`).
  3.  Mandroso transaction PDO (mba hiantoka ny fivadiamanana ireo angona).
  4.  Ny gazety dia ampidirina ao anaty latabatra `journal`.
  5.  Firaisana dia ampidirina ao anaty latabatra `periodique` mba hametrahana ny mpampiasa amin'ny gazety.
  6.  Ny hetsika dia voatahiry ao anaty `suivi_operations`.
  7.  Ny transaction dia voamarina (commit) ary ny mpampiasa dia averina any amin'ny lisitry ny gazety (`liste_journaux.php`) miaraka amin'ny hafatra fahombiazana.

##### 6.3.2 Mandraisa ireo gazety
- **Archives Publikas** (`public_journals.php`): Mpampiasa rehetra (na misy fidirana na tsia) dia afaka mandraisa ireo gazety rehetra.
- **Lisitry ireo Gazety** (`liste_journaux.php`): Ho an'ny Mpampiasa tafiditra ihany. Izy ireo dia mahita ireo gazety azy manokana ihany. Ny Admin dia mahita ireo gazety rehetra.
- **Fikarohana an-tsary**: Amin'ny alalan'ny bara eo an-tampony, na amin'ny alalan'ny pejy fikarohana bebe kokoa (`search.php`).

##### 6.3.3 Manova gazety (Modifier)
- Pejy: `edit_journal.php`
- Ny mpampiasa iray izay nampidirina ilay gazety (na ny Admin) ihany no afaka manova azy.
- Ny rakitra PDF dia azo soloina amin'ny vaovao (ny rakitra taloha dia voafafana ao anaty server raha misy PDF vaovao voa-upload).
- Ny hetsika dia voatahiry ao anaty `suivi_operations`.

##### 6.3.4 Manafana gazety
- Bokotra: « Supprimer » (mena) eo amin'ny laharan'ny gazety ao anaty `liste_journaux.php`.
- Fanamafisana JavaScript dia takiana alohan'ny fafana.
- Raha misy rakitra PDF mifandray amin'ny gazety, dia voafafana ao anaty lahatahiry `uploads/pdf/`.
- Ny gazety dia voafafana ao anaty latabatra `journal` (ary ny firaisana ao amin'ny `periodique` dia voafafana ho azy noho ny fepetra ON DELETE CASCADE, na amin'ny alalan'ny fanontaniana manokana).
- Ny hetsika dia voatahiry ao anaty `suivi_operations`.

#### 6.4 Fikarohana an-tsary (AJAX)
Ity iray amin'ireo fitoviana lehibe ao anaty tranomboky. Ity ny fomba fiasany amin'ny antsipiriany:
1.  **Rakitra client**: `js/script.js` (fonction `handleRealTimeSearch`).
2.  **Rakitra serveur**: `api_search.php`.
3.  **Fepetra fikarohana**: Ny fanontaniana dia mikaroka ao amin'ny sehatra `matricule`, `editeur`, ary `description` ao anaty latabatra `journal`.
4.  **Filankevitra**: Ny fanontaniana SQL dia mampiasa ireo parametra voaomana (`?`) mba hisorohana ireo injection SQL.
5.  **Valiny**: Ireo valiny dia averina ao anaty JSON ary mampiseho azy ao anaty lisitra milomano eo ambany ilay bara fikarohana.

#### 6.5 Statistika sy Fanaraha-maso
- **Pejy Statistika** (`statistiques.php`):
  - Mampiseho ny isan'ny hetsika rehetra, ny isan'ny gazety, ary ny isan'ny karazana hetsika.
  - Graphika tsotra (miaraka amin'ny barra firosohana) mba hanehoana ny fizarana araka ny ampahany.
- **Tabilao Admin** (`liste_utilisateurs.php`):
  - Isan'ny mpampiasa rehetra, isan'ny gazety.
  - Fanaraha-maso ireo hetsika (hetsika farany natao).
  - Ireo fikasana fidirana (nahomby sy tsy nahomby), miaraka amin'ny adiresy IP.
  - Fepetra tranonkala: Upload logo ofisialy ny CIDST.

---

### Tocotra VII: Fitsapana sy Vokatra
#### 7.1 Fitsapana ara-biznisy
Nanao ireo fitsapana manaraka izahay mba hanamarinana ny tranomboky:
1.  **Fitsapana fampidirana sy fidirana**:
    - Famoronana kaonty Mpampiasa tsotra: OK.
    - Fidirana miaraka an'io kaonty io: OK.
    - Fivoahana: OK.
    - Fikasana fidirana miaraka amin'ny teny miafina diso: OK (fikasana voatahiry).
    - Fanakanana mpampiasa amin'ny Admin: OK.
    - Fanafoana mpampiasa amin'ny Admin: OK.
2.  **Fitsapana fitantanana ireo gazety**:
    - Fampidirana gazety (miaraka sy tsy misy PDF): OK.
    - Fanovana gazety: OK.
    - Fafana gazety: OK.
    - Fanamarinana fa ny tompony na ny Admin ihany no afaka manova / manafana: OK.
3.  **Fitsapana fikarohana**:
    - Fikarohana an-tsary amin'ny alalan'ny bara eo an-tampony: OK (valiny avy hatrany).
    - Fikarohana bebe kokoa amin'ny alalan'ny pejy `search.php`: OK.
4.  **Fitsapana responsivité**:
    - Fisehoana ao anaty finday (iPhone/Android): OK.
    - Fisehoana ao anaty tablet: OK.
    - Fisehoana ao anaty ordinateur (sary lehibe): OK.
5.  **Fitsapana filankevitra**:
    - Fikasana miditra amin'ny pejy voaroa tsy misy fidirana: OK (averina any amin'ny pejy fidirana).
    - Fikasana injection SQL: OK (ireo fanontaniana voaomana dia manakana ireo fanafihanana).
    - Fanamarinana fa voahashy ireo teny miafina: OK.

#### 7.2 Vokatra sy Fampisehoana
Ny valiny azo dia tena mahafaly:
- **Fandrosoana valiny**: Ny fikarohana an-tsary dia mamerina ireo valiny ao anaty lany 200 ms (ho an'ny angon-drakitra misy gazety 100).
- **Fahazoana**: Tsy nahita fahaverezan'ny angona nandritra ireo fitsapana fafana na fanovana.
- **Ergonomie**: Ireo mpampiasa dia nahita ny interface mora ampiasaina sy mora hahatratra.

---

## FAMARITANA BE TSARA
### Vokatra ny tetikasa
Ny tranomboky fitantanana ireo firafitry ireo gazety ofisialy dia nahafahana hamaha ny ankamaroan'ny fanoherana nihaona tamin'ny CIDST Tsimbazaza:
1.  **Fahaterana ny fikarohana**: Izay nandray minitra an-tsoratra dia mandray segondra ankehitriny noho ny fikarohana an-tsary.
2.  **Fahazoana**: Ny tranomboky dia azo miditra avy amin'ny navigateur rehetra sy ny fitaovana rehetra (ordinateur, finday, tablet).
3.  **Fanaraha-maso**: Ny hetsika rehetra dia voatahiry, ka afaka manaraka ny asan'ny mpampiasa.
4.  **Fitantanana ny zo**: Fisarahana mazava teo amin'ny Administrateurs sy ireo Mpampiasa tsotra.
5.  **Branding**: Interface mifanaraka amin'ny endrika fisainana ny CIDST (loko manga, logo ofisialy).

### Fomba hanatsarana any aoriana
Na dia miasa tsara aza ny tranomboky, azo atao ny fanatsarana marobe ho an'ny aoriana:
1.  **OCR (Optical Character Recognition)**: Fampidirana rafitra OCR mba hisintonana ho azy ny soratra avy amin'ny PDF voanisy, mba hampidirana ny votoatiny feno ireo gazety fa tsy ireo métadonnées ihany.
2.  **Haran-javatra artifisialy (IA)**: Fampiasana ny IA ho an'ny fanasokajana ho azy ireo gazety araka ny lohahevitra na ny ampahany.
3.  **Famandram-pandrindra**: Fandefasan'ny mailaka na famandram-pandrindra push amin'ny mpampiasa mba hamalaza azy ireo ireo gazety vaovao nampidirina.
4.  **Fanondrana**: Fomba ahafahana mandrindra ny lisitry ireo gazety ao anaty endrika Excel na CSV.
5.  **API REST feno**: Famitana ny API Django REST Framework mba ahafahana miditra amin'ny finday amin'ny alalan'ny fampiharana native Android/iOS.

---

## FANAMPINY
### Fanampiny 1: Schéma SQL ny Angon-drakitra
Jereo ny rakitra `schema.sql` amin'ny fototry ny tetikasa.

### Fanampiny 2: Torolàlana Fametrahana
Jereo ny rakitra `README.md` amin'ny fototry ny tetikasa.

---
*Rakitra noforonina sy novaina ho an'ny tetikasa CIDST Tsimbazaza – Mey 2026*
