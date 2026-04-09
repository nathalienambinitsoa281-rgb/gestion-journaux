# TOROLALANA AMPIASANA NY TRANONKALA (GESTION DES JOURNAUX)

Ity tahirin-kevitra ity dia manazava ny dingana rehetra tokony hataonao mba hampandehanana ity tranonkala ity.

## 1. Ireo fitaovana ilaina (Prérequis)
Mba hampandehanana ny tetikasa dia mila ireto ianao:
*   **XAMPP**: Mba hampandehanana ny serveur Apache (ho an'ny PHP).
*   **PostgreSQL (pgAdmin)**: Mba hitahirizana ny angon-drakitra (Base de données).

## 2. Fanomanana ny Base de Données (PostgreSQL)
1.  Sokafy ny **pgAdmin**.
2.  Mamorona Base de données vaovao:
    *   Havanana amin'ny "Databases" -> Create -> Database.
    *   Anarana: `gestion_journaux` (izay no ao amin'ny `db.php`).
3.  Rehefa tafiditra ao amin'ny `gestion_journaux` ianao:
    *   Havanana amin'ilay database -> Query Tool.
    *   Adikao ao ny mivaky rehetra ao amin'ny fichier **[schema.sql](file:///d:/projet%20DTS/schema.sql)**.
    *   Tsindrio ny bokotra "Execute" (f9) mba hamoronana ireo table rehetra.

## 3. Fanomanana ny Tetikasa ao amin'ny XAMPP
1.  Apetraho ao amin'ny lahatahiry (dossier) `C:\xampp\htdocs\` ny folder misy ny tetikasanao (ohatra: `C:\xampp\htdocs\projet_dts\`).
2.  Sokafy ny **XAMPP Control Panel** ary atombohy (Start) ny **Apache**.
    *   *Fanamarihana*: Tsy mila manomboka MySQL ianao satria PostgreSQL no ampiasaina.

## 4. Fampifandraisana ny PHP sy PostgreSQL
Sokafy ny fichier **[db.php](file:///d:/projet%20DTS/db.php)** ary hamarino ireto:
*   `$dbname = 'gestion_journaux'`: Hamarino raha mitovy amin'ny anarana noforoninao ao amin'ny pgAdmin.
*   `$user = 'postgres'`: Ny login-nao ao amin'ny pgAdmin.
*   `$password = 'root'`: Ny mots de passe-nao ao amin'ny pgAdmin (ovay raha hafa ny anao).

## 5. Fampiasana ny Tranonkala
Sokafy ny browser (Chrome, Firefox, sns) dia soraty: `localhost/anaran_ny_folder_nao/index.php`.

### A. Ny Admin (Mpitantana)
*   **Login**: `cidst92`
*   **Mots de passe**: `na19jo2004`
*   **Azony atao**:
    *   Mahita ny mpampiasa rehetra.
    *   Afaka manakana (`bloquer`) na mamafa (`suprimer`) mpampiasa.
    *   Afaka manaraka ny asa nataon'ny mpampiasa tsirairay.
    *   Mahita ny olona rehetra nanandrana niditra (tentatives de connexion).

### B. Ny Utilisateur (Mpampiasa)
1.  **Fisoratana anarana**: Tsindrio ny "Misorata anarana eto" ao amin'ny pejy fidirana.
2.  **Fidirana**: Ampiasao ny CIN sy ny mots de passe noforoninao.
3.  **Fandraketana Journal**:
    *   Fenoy ny takelaka (formulaire): Partie, Editeur, sns.
    *   Ny daty sy ora nandraisana dia mandeha ho azy (à jours).
4.  **Lisitry ny Journal**: Hita eo ambany ny tantaran'ny journal rehetra voarakitra.

## 7. Fampakarana amin'ny GitHub sy Railway (Hébergement)

### A. GitHub
1.  Mamorona kaonty ao amin'ny [github.com](https://github.com).
2.  Mamorona "New Repository" (ohatra: `gestion-journaux`).
3.  Ampakaro ny fichiers rehetra (ankoatry ny `schema.sql` raha tianao hanafina azy, fa tsara raha apetraka ihany).
    *   Azonao ampiasaina ny **GitHub Desktop** na ny terminal:
        ```bash
        git init
        git add .
        git commit -m "First commit"
        git remote add origin https://github.com/ny-anaranao/gestion-journaux.git
        git push -u origin main
        ```

### B. Railway
1.  Mamorona kaonty ao amin'ny [railway.app](https://railway.app) (mampiasa GitHub).
2.  **Mamorona Database PostgreSQL**:
    *   Tsindrio ny "New Project" -> "Provision PostgreSQL".
    *   Rehefa mivoaka ny database dia alao ny "Connection URL".
3.  **Mampifandray ny PHP**:
    *   Ao amin'ny Railway, ampidiro ireo "Variables" (Environnement):
        *   `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`.
    *   Ovay kely ny [db.php](file:///d:/projet%20DTS/db.php) mba hamaky ireo variables ireo (na ampiasao mivantana ny URL avy amin'ny Railway).
4.  **Deploy ny Code**:
    *   "New Project" -> "Deploy from GitHub repo" -> Safidio ilay repository teo.
    *   Railway dia hanolotra URL (ohatra: `gestion-journaux.up.railway.app`).

---
*Fanamarihana: Rehefa mampiasa Railway ianao dia mila mamorona ireo table indray ao amin'ny database vaovao noforonin'ny Railway mampiasa ny [schema.sql](file:///d:/projet%20DTS/schema.sql).*
